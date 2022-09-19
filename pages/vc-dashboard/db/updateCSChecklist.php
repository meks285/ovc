<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$id = $_POST['id'];
$responseQuestion1 = $_POST['responseQuestion1'];
$responseQuestion2 = $_POST['responseQuestion2'];
$responseQuestion3 = $_POST['responseQuestion3'];
$responseQuestion4 = $_POST['responseQuestion4'];
$responseQuestion5 = $_POST['responseQuestion5'];
$beneficiaryonart = $_POST['beneficiaryonart'];
$service_date = $_POST['service_date'];

if($conn_status=="success"){

            $stmt = $conn->prepare("UPDATE `caresupportchecklist` 
          SET
            `responseQuestion1` = '$responseQuestion1',
            `responseQuestion2` = '$responseQuestion2',
            `responseQuestion3` = '$responseQuestion3',
            `responseQuestion4` = '$responseQuestion4',
            `responseQuestion5` = '$responseQuestion5',
            `beneficiaryonart` = '$beneficiaryonart',
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