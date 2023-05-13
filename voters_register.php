<?php

include 'db_connection.php';

if(isset($_POST['submit'])) {
    $aadhar = $_POST['aadhar'];
    $pan = $_POST['pan'];
    
    $sql = mysqli_query($con,"SELECT * FROM `voter_personal_details`");
    $stmt=mysqli_fetch_array($sql);
    $ch_aadhar = $stmt['v_aadhar'];
    $ch_pan = $stmt['v_pan'];
    
    if (($ch_aadhar===$aadhar)){
        echo "<script>alert('Aadhar Already Register')</script>";
    }
    elseif (($ch_pan===$pan)){
        echo "<script>alert('PAN Already Register')</script>";
    }
    else {
    
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $dob = $_POST['dob'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $state = $_POST['state'];
            $country = $_POST['country'];

            $aadhar_up=$_FILES['aadhar_up']['name'];
            $tmp_name=$_FILES['aadhar_up']['tmp_name'];
            move_uploaded_file($tmp_name,"upload/".$aadhar_up);

            $pan_up=$_FILES['pan_up']['name'];
            $tmp_name=$_FILES['pan_up']['tmp_name'];
            move_uploaded_file($tmp_name,"upload/".$pan_up);

            $photo_up=$_FILES['photo_up']['name'];
            $tmp_name=$_FILES['photo_up']['tmp_name'];
            move_uploaded_file($tmp_name,"upload/".$photo_up);


            $stmt = $con->prepare("INSERT INTO `voter_personal_details` (`v_fname`,`v_lname`,`v_dob`,`v_mobile`,`v_email`,`v_address`,`v_city`,`v_district`,`v_state`,`v_country`,`v_aadhar`,`v_pan`,`upload_aadhar`,`upload_pan`,`v_photo`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssssssss", $fname, $lname, $dob, $mobile, $email, $address, $city, $district, $state, $country, $aadhar, $pan, $aadhar_up, $pan_up, $photo_up);
        
            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful')</script>";
                $key1 = array(rand(65537, 2464069));
                $key2 = array(rand(50993, 2464069));
                $v_id = mysqli_insert_id($con);
                $key1_string = implode('', $key1);
                $key2_string = implode('', $key2);
                $insert2 = mysqli_query($con,"INSERT INTO `admin` (`v_id`,`key1`,`key2`,`v_d`,`v_cipher`) VALUES ('$v_id','$key1_string','$key2_string',0,0)");
            } 
            else {
                echo "<script>alert('Registration Failed')</script>";
            }
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
    <h2 class="heading">Voter Register</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group form">
        <h4>Personal Details</h4>
        <input type="text" class="form-control" name="fname" placeholder="Enter The First Name">
        <br><br>
        <input type="text" class="form-control" name="lname" placeholder="Enter The Last Name">
        <br><br>
        <input type="text" class="form-control" name="dob" placeholder="Enter The Date of Birth (dd-mm-yyyy)">
        <br><br>
        <input type="text" class="form-control" name="mobile" placeholder="Enter The Mobile No">
        <br><br>
        <input type="text" class="form-control" name="email" placeholder="Enter The Email ID">
        <br><br>

        <h4>Address</h4>
        <textarea name="address" class="form-control" placeholder="Enter The Address" rows="6"></textarea>
        <br><br>
        <input type="text" class="form-control" name="city" placeholder="Enter The City">
        <br><br>
        <input type="text" class="form-control" name="district" placeholder="Enter The District">
        <br><br>
        <input type="text" class="form-control" name="state" placeholder="Enter The State">
        <br><br>
        <input type="text" class="form-control" name="country" placeholder="Enter The Country">
        <br><br>

        <h4>Documents</h4>
        <input type="text" class="form-control" name="aadhar" placeholder="Enter The Aadhar No">
        <br><br>
        <input type="text" class="form-control" name="pan" placeholder="Enter The Pan No">
        <br><br>
        <p>Upload Aadhar Card</p>
        <input type="file" name="aadhar_up">
        <br><br>
        <p>Upload Pan Card</p>
        <input type="file" name="pan_up">
        <br><br>
        <p>Upload Your Photo</p>
        <input type="file" name="photo_up">
        <br><br>		
        <button type="submit" name="submit" class="btn btn-primary cand_reg">Register</button><br><br>
        </div>
    </form>

</body>
</html>