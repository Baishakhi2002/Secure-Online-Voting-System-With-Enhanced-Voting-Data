<?php
include 'db_connection.php';
session_start();
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
	<h2 class="heading">Voting area</h2>
	<br>
	<form method="POST">
		<div class="form-group form">
			<h4>Key 2</h4>
			<input type="text" class="form-control" name="key2" placeholder="enter the second key">
			<br><br>		
			<button type="submit" name="submit" class="vote_submit btn btn-primary">Submit</button>
		</div>
	</form>

		<?php
		if(isset($_POST['submit'])) {
			$id = $_SESSION['id'];
			$k2 = $_POST['key2'];

			$sql = mysqli_query($con,"SELECT * FROM `admin` WHERE `v_id`='$id'");
			$row = mysqli_fetch_array($sql);
			$v_id = $row['v_id'];
			$key2 = $row['key2'];

			if(($id==$v_id)&&($k2==$key2)) {
				echo "<script>window.location.href='vote.php'</script>";
			}
			else {
				echo "<script>alert('Invalid credentials')</script>";
			}
		}
	?>
</body>
</html>