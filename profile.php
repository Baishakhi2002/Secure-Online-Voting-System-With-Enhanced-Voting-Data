<?php 
include 'db_connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM `voter_personal_details` WHERE `v_email`=?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
$v_id = $row['v_id'];

$k_d_sql = "SELECT * FROM `admin` WHERE v_id= ?";
$k_d_stmt = mysqli_prepare($con, $k_d_sql);
mysqli_stmt_bind_param($k_d_stmt, "i", $v_id);
mysqli_stmt_execute($k_d_stmt);
$k_d_row = mysqli_fetch_array(mysqli_stmt_get_result($k_d_stmt));

if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h2>Secure Online Voting</h2>
    </div>
    <div class="tab">
      <button class="tablinks"><a href="index.php">Home</a></button>
      <button class="tablinks"><a href="candidates.php">Candidates</a></button>
      <button class="tablinks"><a href="candidates_register.php">Candidates register</a></button>
      <button class="tablinks"><a href="voter_login.php">Voters</a></button>
      <button class="tablinks"><a href="voters_register.php">Voters register</a></button>
      <button class="tablinks"><a href="voting_login.php">Voting section</a></button>
      <button class="tablinks"><a href="admin_login.php">Admin section</a></button>
      <button class="tablinks"><a href="results.php">Results</a></button>
    </div>

    <u><h2 class="heading">My Profile</h2></u>
    <br>
    <img class="img" src="upload/<?php echo $row['v_photo']; ?>" height="170" width="170">
    <br><br>
    <u><h3 class="det_heading">Personal Details</h3></u>
    <h4 class="details">Voter ID : <?php echo $row['v_id'];?></h4>
    <h4 class="details">Name : <?php echo $row['v_fname']." ".$row['v_lname'];?> </h4>
    <h4 class="details">Date of Birth : <?php echo $row['v_dob'];?></h4> 
    <h4 class="details">Mobile No : <?php echo $row['v_mobile'];?></h4>
    <h4 class="details">Email ID : <?php echo $row['v_email'];?></h4>
    <br><br>
    <u><h3 class="det_heading">Address</h3></u>
    <h4 class="details">Address : <?php echo $row['v_address'];?></h4>
    <h4 class="details">City : <?php echo $row['v_city'];?></h4>
    <h4 class="details">District : <?php echo $row['v_district'];?></h4>
    <h4 class="details">State : <?php echo $row['v_state'];?></h4>
    <h4 class="details">Country : <?php echo $row['v_country'];?></h4>
    <br><br>
    <u><h3 class="det_heading">Documents</h3></u>
    <h4 class="details">Aadhar No : <?php echo $row['v_aadhar'];?></h4>
    <img class="img2" src="upload/<?php echo $row['upload_aadhar']; ?>">
    <h4 class="details">Pan No : <?php echo $row['v_pan'];?></h4>
    <img class="img2" src="upload/<?php echo $row['upload_pan']; ?>">
    <br><br>
    <u><h3 class="det_heading">Key Details</h3></u>
    <h4 class="details">KEY 1 : <?php echo $k_d_row['key1'];?></h4>
    <h4 class="details">KEY 2 : <?php echo $k_d_row['key2'];?> </h4>
    <br><br><br>
    <form method="post" action="">
        <button type="submit" class="btn-primary" name="logout">Logout</button>
    </form>
</body>
</html>
