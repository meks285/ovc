<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

if(isset($_GET['state'])){
	$state = $_GET['state'];
	$sql = "SELECT DISTINCT lga FROM state_lga_ward WHERE state='$state' order by lga asc";
	$result = mysqli_query($conn, $sql);
		echo "<option disabled selected>Select LGA</option>";
	while($row = mysqli_fetch_assoc($result)){
		echo "<option value='" . $row['lga'] . "'>" . $row['lga'] ."</option>";
	}
}
elseif(isset($_GET['lga'])){
	$lga = $_GET['lga'];
	$sql = "SELECT DISTINCT ward as ward FROM state_lga_ward WHERE lga='$lga' order by ward asc";
	$result = mysqli_query($conn, $sql);
		echo "<option disabled selected>Select Ward</option>";
	while($row = mysqli_fetch_assoc($result)){
		echo "<option value='" . $row['ward'] . "'>" . $row['ward'] ."</option>";
	}
}
else{
	echo "<option disabled selected>Select</option>";
}

 
?>