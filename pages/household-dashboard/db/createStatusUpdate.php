<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$hh_unique_num = $_POST['hh_unique_id'];
$vc_unique_id = $_POST['vc_unique_id'];
$date = $_POST['date'];
$update_status = $_POST['updateStatus'];

if($conn_status=="success"){
        ## Check if HH has been registered
        $stmt = $conn->prepare("SELECT vc_unique_id from beneficiarystatus_update where status='$update_status'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `beneficiarystatus_update` (
                `hh_unique_num`,
                `vc_unique_id`,
                `STATUS`,
                `DATE`
              ) 
              VALUES
                (
                  '$hh_unique_num',
                  '$vc_unique_id',
                  '$update_status',
                  '$date'
                )");
            $stmt->execute();
            $recordsinserted = $stmt->rowCount();
            if($recordsinserted >= 1){
              die(json_encode(['status' => 'success']));
            }
            else{
                die(json_encode(['status' => 'failure']));
            }        
        }
        else{
            die(json_encode(['status' => 'exists']));
        }        


}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>