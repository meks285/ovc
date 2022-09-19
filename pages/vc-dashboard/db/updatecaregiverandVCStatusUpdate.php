<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$id = $_POST['id'];
$hiv_status = $_POST['hiv_status'];
$dateoftest = $_POST['dateoftest'];
$birth_certificate = $_POST['birth_certificate'];
$child_in_school = $_POST['child_in_school'];
$child_on_vocational_training = $_POST['child_on_vocational_training'];
$service_provider = $_POST['service_provider'];
$service_date = $_POST['service_date'];

if($conn_status=="success"){

            $stmt = $conn->prepare("UPDATE 
            `caregiverandvcstatus` 
          SET
            `hiv_status` = '$hiv_status',
            `dateoftest` = '$dateoftest',
            `birth_certificate` = '$birth_certificate',
            `child_in_school` = '$child_in_school',
            `child_on_vocational_training` = '$child_on_vocational_training',
            `service_provider` = '$service_provider',
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