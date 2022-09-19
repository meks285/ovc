<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$vc_unique_id = $_POST['vc_unique_id'];
$hh_unique_num = $_POST['hh_unique_num'];
$consentQuestion1 = $_POST['consentQuestion1'];
$consentQuestion2 = $_POST['consentQuestion2'];
$consentQuestion3 = $_POST['consentQuestion3'];
$consentQuestion4 = $_POST['consentQuestion4'];
$consentQuestion5 = $_POST['consentQuestion5'];
$responseQuestion1 = $_POST['responseQuestion1'];
$responseQuestion2 = $_POST['responseQuestion2'];
$responseQuestion3 = $_POST['responseQuestion3'];
$responseQuestion4 = $_POST['responseQuestion4'];
$responseQuestion5 = $_POST['responseQuestion5'];
$beneficiaryonart = $_POST['beneficiaryonart'];
$service_date = $_POST['service_date'];

if($conn_status=="success"){

            $stmt = $conn->prepare("INSERT INTO `caresupportchecklist` (
                `vc_unique_id`,
                `hh_unique_num`,
                `consentQuestion1`,
                `responseQuestion1`,
                `consentQuestion2`,
                `responseQuestion2`,
                `consentQuestion3`,
                `responseQuestion3`,
                `consentQuestion4`,
                `responseQuestion4`,
                `consentQuestion5`,
                `responseQuestion5`,
                `beneficiaryonart`,
                `service_date`
              ) 
              VALUES
                (
                  '$vc_unique_id',
                  '$hh_unique_num',
                  '$consentQuestion1',
                  '$responseQuestion1',
                  '$consentQuestion2',
                  '$responseQuestion2',
                  '$consentQuestion3',
                  '$responseQuestion3',
                  '$consentQuestion4',
                  '$responseQuestion4',
                  '$consentQuestion5',
                  '$responseQuestion5',
                  '$beneficiaryonart',
                  '$service_date'
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
    die(json_encode(['status' => 'connect_fail']));
}
?>