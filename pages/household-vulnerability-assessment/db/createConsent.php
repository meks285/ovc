<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$hh_unique_id = $_POST['hh_unique_id'];
$community = $_POST['community'];
$ward = $_POST['ward'];
$lga = $_POST['lga'];
$state = $_POST['state'];
$ip = $_POST['ip'];
$cbo_code = $_POST['cbo_code'];
$supporting_ip = $_POST['supporting_ip'];
$donor = $_POST['donor'];
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
$household_caregiver = $_POST['household_caregiver'];
$hh_caregiver_signature = $_POST['hh_caregiver_signature'];
$hh_caregiver_phone = $_POST['hh_caregiver_phone'];
$hh_caregiver_sign_date = $_POST['hh_caregiver_sign_date'];
$household_witness = $_POST['household_witness'];
$hh_witness_signature = $_POST['hh_witness_signature'];
$hh_witness_phone = $_POST['hh_witness_phone'];
$hh_witness_sign_date = $_POST['hh_witness_sign_date'];

if($conn_status=="success"){
        ## Check if HH has been registered
        $stmt = $conn->prepare("SELECT hh_unique_num from consent where hh_unique_num='$hh_unique_id'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `consent` (
                `hh_unique_num`,
                `caregiver`,
                `community`,
                `ward`,
                `lga`,
                `state`,
                `ip`,
                `cbo_code`,
                `supporting_ip`,
                `donor`,
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
                `hh_caregiver_signature`,
                `hh_caregiver_phone`,
                `hh_caregiver_sign_date`,
                `household_witness`,
                `hh_witness_signature`,
                `hh_witness_phone`,
                `hh_witness_sign_date`
              ) 
              VALUES
                (
                  '$hh_unique_id',
                  '$household_caregiver',
                  '$community',
                  '$ward',
                  '$lga',
                  '$state',
                  '$ip',
                  '$cbo_code',
                  '$supporting_ip',
                  '$donor',
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
                  '$hh_caregiver_signature',
                  '$hh_caregiver_phone',
                  '$hh_caregiver_sign_date',
                  '$household_witness',
                  '$hh_witness_signature',
                  '$hh_witness_phone',
                  '$hh_witness_sign_date'
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