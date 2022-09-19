<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

$hh_unique_num = $_POST['householdUniqueId'];

$query = "SELECT 
  `beneficiaryid`
FROM
  `adulthouseholdmember`   WHERE hhuniqueid='$hh_unique_num' order by id desc LIMIT 1";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) >= 1){
die(json_encode(['beneficiaryid' => $row['beneficiaryid'],'status'=> 'success']));
}
else{
    die(json_encode(['beneficiaryid' => $hh_unique_num,'status' => 'no_rows']));
}

?>