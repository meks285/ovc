<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$id = $_POST['id'];
$responseQuestion1 = $_POST['responseQuestion1'];
$responseQuestion2 = $_POST['responseQuestion2'];
$responseQuestion3 = $_POST['responseQuestion3'];
$responseQuestion4 = $_POST['responseQuestion4'];
$responseQuestion3_other = $_POST['responseQuestion3_other'];
$responseQuestion4_other = $_POST['responseQuestion4_other'];
$service_date = $_POST['service_date'];

if($conn_status=="success"){

            $stmt = $conn->prepare("UPDATE 
            `checklist_accesstoemergencyfunds` 
          SET
            `responseQuestion1` = '$responseQuestion1',
            `responseQuestion2` = '$responseQuestion2',
            `responseQuestion3` = '$responseQuestion3',
            `responseQuestion4` = '$responseQuestion4',
            `responseQuestion3_other` = '$responseQuestion3_other',
            `responseQuestion4_other` = '$responseQuestion4_other',
            `service_date` = '$service_date'
          WHERE `id` = '$id'");
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
    die(json_encode(['status' => 'connect_fail']));
}
?>