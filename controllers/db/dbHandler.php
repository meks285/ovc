<?php
$server = "localhost";
$port = 3306;
$username = "ovcapin_root";
$password = "Nu66et%%Apin";
$dbname = "ovcapin_db";

// Create connection
try{
   $conn = new PDO("mysql:host=$server:$port;dbname=$dbname","$username","$password");
   $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   $conn_status="success";
}catch(PDOException $e){
   $conn_status="fail";
}
?>