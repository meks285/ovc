<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$householdUniqueId = $_POST['householdUniqueId'];

if($conn_status=="success"){
        ## Check if this Household has an existing Consent Form Filled
        $stmt = $conn->prepare("SELECT hh_unique_num from consent where hh_unique_num='$householdUniqueId'");
        $stmt->execute();
        $HHrecordsSelected = $stmt->rowCount();
        if($HHrecordsSelected == 1){
            die(json_encode(['status' => 'consentExists']));
        }
        else{
            die(json_encode(['status' => 'no_consent']));
        }  
}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>