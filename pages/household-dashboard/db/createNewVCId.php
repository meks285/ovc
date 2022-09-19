<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$householdUniqueId = $_POST['householdUniqueId'];

if($conn_status=="success"){
        ## Check if HouseHold Exists has been registered, If YES get the number of VC in the Household
        $stmt = $conn->prepare("SELECT hh_unique_num,hh_num_children from hh_vulnerability_assessment where hh_unique_num='$householdUniqueId'");
        $stmt->execute();
        $HHrecordsSelected = $stmt->rowCount();
        if($HHrecordsSelected == 1){
      //HouseHold Exists; Get the total number of already existing VC in the HouseHold and
        $hh_data = $stmt->fetchAll();
        foreach($hh_data as $row){
            $hh_num_children = $row['hh_num_children'];
        }
      //GET the total number of current VC registered for the HH
      $stmt = $conn->prepare("SELECT vc_unique_id from vcenrollment where hh_unique_num='$householdUniqueId'");
      $stmt->execute();
      $vcRecordsSelected = $stmt->rowCount();
    // check if it matches With the number of VC in the HH, if Yes return (vc_maxed_out), If NO, add a new VC HH
            if($vcRecordsSelected < $hh_num_children){
                $vcRecordsSelected++;
                die(json_encode(['status' => 'success','vc_id' => $vcRecordsSelected]));
            }
            else{
                die(json_encode(['status' => 'vc_maxed_out']));
            }
        }
        else{
            die(json_encode(['status' => 'no_rows']));
        }  
}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>