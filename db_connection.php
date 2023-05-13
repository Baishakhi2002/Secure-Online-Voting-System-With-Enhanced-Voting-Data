<?php
require_once('db_connection.php');
$con = new mysqli("localhost","root","","eci");
if ($con->connect_errno) {
    die("Failed to connect to MySQL: " . $con->connect_error);
}
?>