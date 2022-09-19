<?php 
ob_start();
$host="localhost"; // Host name
$username="ovcapin_root"; // Mysql username
$password="Nu66et%%Apin"; // Mysql password
$db_name="ovcapin_db"; // Database name

// Connect to server and select databse.
$conn=mysqli_connect("$host","$username","$password","$db_name");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect: " . mysqli_connect_error();
  }
?>