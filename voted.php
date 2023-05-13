<?php
require_once 'db_connection.php';
require_once 'rsa_util.php';
session_start();

// Sanitize user input and retrieve candidate ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("Invalid candidate ID");
}

// Use prepared statement with bound parameter
$stmt = $con->prepare("SELECT c_plain_value, c_total_votes FROM candidate WHERE `c_id` = ?");
$stmt->bind_param("i", $id); // bind $id variable as integer parameter
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$plain_val = $row['c_plain_value'];
$total = $row['c_total_votes'];
$stmt->close();

// Fetch voter information
$user_id = $_SESSION['id'];

// Use prepared statement with bound parameter
$stmt = $con->prepare("SELECT v_id, key1, key2 FROM admin WHERE `v_id` = ?");
$stmt->bind_param("i", $user_id); // bind $user_id variable as integer parameter
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$key1 = $row['key1'];
$key2 = $row['key2'];
$voter_id = $row['v_id'];
$stmt->close();


$keys = generateRSAKeys($key1, $key2);

$ciphertext = rsaEncrypt($plain_val, $keys['e'], $keys['n']);
// Decrypt ciphertext using RSA
$decrypt = rsaDecrypt($ciphertext, $keys['d'], $keys['n']);

if($plain_val == $decrypt){
    $total = $total+1;
}

// Update admin table with new values
$stmt = $con->prepare("UPDATE admin SET v_n=?, v_e=?, v_d=?, v_cipher=? WHERE `v_id` = ?");
$stmt->bind_param("ssssi", $keys['n'], $keys['e'], $decrypt, $ciphertext, $voter_id);
if (!$stmt->execute()) {
    die("Error updating admin table: " . mysqli_error($con));
}
$stmt->close();

// Update candidate table with total votes
$stmt = $con->prepare("UPDATE candidate SET c_total_votes=? WHERE `c_id` = ?");
$stmt->bind_param("ii", $total, $id);
if (!$stmt->execute()) {
    die("Error updating candidate table: " . mysqli_error($con));
}
$stmt->close();

// Redirect to exit page
header('Location: exit.php?ciphertext=' . urlencode($ciphertext));
exit();
?>