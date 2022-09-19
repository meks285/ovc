<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$treatment_art_no=$_POST['treatment_art_no'];
$artstartdate = $_POST['artstartdate'];
$clientname = $_POST['clientname'];
$facilityname = $_POST['facilityname'];
$consentQuestion1 = $_POST['consentQuestion1'];
$responseQuestion1 = $_POST['responseQuestion1'];
$consentQuestion2 = $_POST['consentQuestion2'];
$responseQuestion2 = $_POST['responseQuestion2'];
$phonenumberOfferForm = $_POST['phonenumberOfferForm'];
$caregiver_name = $_POST['caregiver_name'];
$caregiver_signature = $_POST['caregiver_signature'];
$caregiver_date = $_POST['caregiver_date'];
$facility_staff_name = $_POST['facility_staff_name'];
$facility_staff_signature = $_POST['facility_staff_signature'];
$facility_staff_date = $_POST['facility_staff_date'];
$stateofresidence = $_POST['stateofresidence'];
$lgaofresidence = $_POST['lgaofresidence'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT id from ovcoffer where treatment_art_no='$treatment_art_no'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `ovcoffer` (
              `treatment_art_no`,
              `artstartdate`,
              `clientname`,
              `facilityname`,
              `consentQuestion1`,
              `responseQuestion1`,
              `consentQuestion2`,
              `responseQuestion2`,
              `phonenumberOfferForm`,
              `caregiver_name`,
              `caregiver_signature`,
              `caregiver_date`,
              `facility_staff_name`,
              `facility_staff_signature`,
              `facility_staff_date`,
              `stateofresidence`,
              `lgaofresidence`
            ) 
            VALUES
              (:treatment_art_no,:artstartdate,:clientname,:facilityname,:consentQuestion1,:responseQuestion1,:consentQuestion2,:responseQuestion2,:phonenumberOfferForm,:caregiver_name,:caregiver_signature,:caregiver_date,:facility_staff_name,:facility_staff_signature,:facility_staff_date,:stateofresidence,:lgaofresidence)");
              $stmt->bindParam(':treatment_art_no', $treatment_art_no);
              $stmt->bindParam(':artstartdate', $artstartdate);
              $stmt->bindParam(':clientname', $clientname);
              $stmt->bindParam(':facilityname', $facilityname);
              $stmt->bindParam(':consentQuestion1', $consentQuestion1);
              $stmt->bindParam(':responseQuestion1', $responseQuestion1);
              $stmt->bindParam(':consentQuestion2', $consentQuestion2);
              $stmt->bindParam(':responseQuestion2', $responseQuestion2);
              $stmt->bindParam(':phonenumberOfferForm', $phonenumberOfferForm);
              $stmt->bindParam(':caregiver_name', $caregiver_name);
              $stmt->bindParam(':caregiver_signature', $caregiver_signature);
              $stmt->bindParam(':caregiver_date', $caregiver_date);
              $stmt->bindParam(':facility_staff_name', $facility_staff_name);
              $stmt->bindParam(':facility_staff_signature', $facility_staff_signature);
              $stmt->bindParam(':facility_staff_date', $facility_staff_date);
              $stmt->bindParam(':stateofresidence', $stateofresidence);
              $stmt->bindParam(':lgaofresidence', $lgaofresidence);

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