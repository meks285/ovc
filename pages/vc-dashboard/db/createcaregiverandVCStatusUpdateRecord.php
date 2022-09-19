<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$unique_id = $_POST['unique_id'];
$hiv_status = $_POST['hiv_status'];
$date_hivstatus = $_POST['date_hivstatus'];
$enrolledontreatment = $_POST['enrolledontreatment'];
$facilityenrolled = $_POST['facilityenrolled'];
$artstartdate = $_POST['artstartdate'];
$treatment_art_no = $_POST['treatment_art_no'];
$childhasbirthcertificate = $_POST['childhasbirthcertificate'];
$childinschool = $_POST['childinschool'];
$schoolname = $_POST['schoolname'];
$schoolgrade = $_POST['schoolgrade'];
$childonvocationaltraining = $_POST['childonvocationaltraining'];
$vocationalinstitute = $_POST['vocationalinstitute'];
$caregivername = $_POST['caregivername'];
$enrollmentstatus = $_POST['enrollmentstatus'];
$enrollmentstatus_date = $_POST['enrollmentstatus_date'];

if($conn_status=="success"){
            $stmt = $conn->prepare("INSERT INTO `ovcstatusupdate` (
                      `unique_id`,
                      `hiv_status`,
                      `date_hivstatus`,
                      `enrolledontreatment`,
                      `facilityenrolled`,
                      `artstartdate`,
                      `treatment_art_no`,
                      `childhasbirthcertificate`,
                      `childinschool`,
                      `schoolname`,
                      `schoolgrade`,
                      `childonvocationaltraining`,
                      `vocationalinstitute`,
                      `caregivername`,
                      `enrollmentstatus`,
                      `enrollmentstatus_date`
                    ) 
                    VALUES
                      (:unique_id,:hiv_status,:date_hivstatus,:enrolledontreatment,:facilityenrolled,:artstartdate,:treatment_art_no,:childhasbirthcertificate,:childinschool,:schoolname,:schoolgrade,:childonvocationaltraining,:vocationalinstitute,:caregivername,:enrollmentstatus,:enrollmentstatus_date)");
            
              $stmt->bindParam(':unique_id', $unique_id);           
              $stmt->bindParam(':hiv_status', $hiv_status);           
              $stmt->bindParam(':date_hivstatus', $date_hivstatus);           
              $stmt->bindParam(':enrolledontreatment', $enrolledontreatment);           
              $stmt->bindParam(':facilityenrolled', $facilityenrolled);           
              $stmt->bindParam(':artstartdate', $artstartdate);           
              $stmt->bindParam(':treatment_art_no', $treatment_art_no);           
              $stmt->bindParam(':childhasbirthcertificate', $childhasbirthcertificate);           
              $stmt->bindParam(':childinschool', $childinschool);           
              $stmt->bindParam(':schoolname', $schoolname);           
              $stmt->bindParam(':schoolgrade', $schoolgrade);           
              $stmt->bindParam(':childonvocationaltraining', $childonvocationaltraining);           
              $stmt->bindParam(':vocationalinstitute', $vocationalinstitute);           
              $stmt->bindParam(':caregivername', $caregivername);           
              $stmt->bindParam(':enrollmentstatus', $enrollmentstatus);           
              $stmt->bindParam(':enrollmentstatus_date', $enrollmentstatus_date);           

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