<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$householdUniqueId = $_POST['householdUniqueId'];

if($conn_status=="success"){
        ## Check if HouseHold Exists has been registered, If YES get the number of VC in the Household
        $stmt = $conn->prepare("SELECT hh_unique_num from consent where hh_unique_num='$householdUniqueId'");
        $stmt->execute();
        $HHrecordsSelected = $stmt->rowCount();
        if($HHrecordsSelected == 1){
            die(json_encode(['status' => 'consent_maxed_out']));
        }
        else{
            die(json_encode(['status' => 'success']));
        }  
}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>