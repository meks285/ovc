<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

if(isset($_GET['state'])){
	$state = $_GET['state'];
	$sql = "SELECT ouname as lga FROM organizationunit WHERE parentid = (SELECT uid FROM organizationunit WHERE ouname='$state')";
	$result = mysqli_query($conn, $sql);
		echo "<option disabled selected>Select LGA</option>";
	while($row = mysqli_fetch_assoc($result)){
		echo "<option value='" . $row['lga'] . "'>" . $row['lga'] ."</option>";
	}
}
elseif(isset($_GET['lga'])){
	$lga = $_GET['lga'];
	$sql = "SELECT ouname AS ward FROM organizationunit WHERE parentid = (SELECT uid FROM organizationunit WHERE ouname='$lga')";
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