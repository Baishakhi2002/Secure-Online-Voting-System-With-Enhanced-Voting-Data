<?php
include_once('db_connection.php');

if(isset($_POST['submit'])) {
    // Using prepared statements to prevent SQL injection attacks.
    $voter_id = $_POST['c_v_id'];
    $f_name = $_POST['fname'];
    $l_name = $_POST['lname'];

    $sql = mysqli_query($con,"SELECT * FROM `voter_personal_details` WHERE `v_id`=$voter_id");
    $stmt=mysqli_fetch_array($sql);
    $v_id = $stmt['v_id'];
    $v_fname = $stmt['v_fname'];
    $v_lname = $stmt['v_lname'];
    $_SESSION['id'] = $stmt['v_id'];
    
    if (($voter_id==$v_id)&&($f_name==$v_fname)&&($l_name==$v_lname)) {
    $stmt = $con->prepare("INSERT INTO `candidate` (`c_v_id`,`c_fname`,`c_lname`,`c_photo`,`c_party_name`,`c_party_symbol`,`c_plain_value`,`c_total_votes`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $party_name = $_POST['party_name'];

    $photo_up=$_FILES['photo_up']['name'];
    $tmp_name=$_FILES['photo_up']['tmp_name'];
    $pathToUpload = 'upload/'.$photo_up;
    move_uploaded_file($tmp_name, $pathToUpload);

    $symbol_up=$_FILES['symbol_up']['name'];
    $tmp_name=$_FILES['symbol_up']['tmp_name'];
    $pathToSymbolUp = 'upload/'.$symbol_up;
    move_uploaded_file($tmp_name, $pathToSymbolUp);

    $param1 = rand(11, 100);
    $param2 = 0;
    $stmt->bind_param("issssssi", $voter_id, $fname, $lname, $photo_up, $party_name, $symbol_up, $param1, $param2);

    $result = $stmt->execute();

    if($result) {
        echo "<h2 class='result'>Registration successful</h2>";
    }
    else {
        echo "<script>alert('Registration failed')</script>";
    }
    }
    else {
        echo "<script>alert('Voter ID Already Register')</script>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">  
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
    <h2 class="heading">Candidate Register</h2>
    <br>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group form">
        <input type="text" class="form-control" name="c_v_id" placeholder="Enter The Voter ID">
            <br><br>
            <input type="text" class="form-control" name="fname" placeholder="Enter The First Name">
            <br><br>
            <input type="text" class="form-control" name="lname" placeholder="Enter The Last Name">
            <br><br>
            <p>Upload Your Photo</p>
            <input type="file" name="photo_up">
            <br><br>
            <input type="text" class="form-control" name="party_name" placeholder="Enter The Party Name">
            <br><br>
            <p>Upload Your Party Symbol</p>
            <input type="file" name="symbol_up">
            <br><br>	
            <button type="submit" name="submit" class="cand_reg btn btn-primary">Register</button><br><br>
        </div>
    </form>

</body>
</html>
