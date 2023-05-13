<?php
include 'db_connection.php';
session_start();
$ciphertext = urldecode($_GET['ciphertext']);
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
	<br><br><br><br><br><br>
	<h3 class="exit">Thank you for voting.</h3><br>
	<h3 class="exit">Your encrypted vote is <?php echo $ciphertext;?></h3>

</body>
</html>