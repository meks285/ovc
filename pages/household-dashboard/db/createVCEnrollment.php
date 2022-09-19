<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$enrollment_date = $_POST['enrollment_date'];
$hh_unique_num = $_POST['hh_unique_num'];
$vc_unique_id = $_POST['vc_unique_id'];
$vc_count = $_POST['vc_count'];
$surname = $_POST['surname'];
$othernames = $_POST['othernames'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$enrollmentstream = $_POST['enrollmentstream'];
$enrollmentstreambasedon = $_POST['enrollmentstreambasedon'];
$hiv_status = $_POST['hiv_status'];
$birthcertificate = $_POST['birthcertificate'];
$childinschool = $_POST['childinschool'];
$caregiverrelationshiptochild = $_POST['caregiverrelationshiptochild'];
$caregiver = $_POST['caregiver'];

$enrollment_setting = $_POST['enrollment_setting'];
$treatment_art_no = $_POST['treatment_art_no'];
$datehivstatus = $_POST['datehivstatus'];
$enrolledontreatment = $_POST['enrolledontreatment'];
$artstartdate = $_POST['artstartdate'];
$facilityenrolled = $_POST['facilityenrolled'];
$schoolname = $_POST['schoolname'];
$schoolgrade = $_POST['schoolgrade'];
$childonvocationaltraining = $_POST['childonvocationaltraining'];
$vocationalinstitute = $_POST['vocationalinstitute'];
$enrollment_status='ACTIVE';
if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT vc_unique_id from vcenrollment where vc_unique_id='$vc_unique_id'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `vcenrollment` (
                  `enrollment_setting`,
                  `treatment_art_no`,
                  `enrollment_date`,
                  `hh_unique_num`,
                  `vc_unique_id`,
                  `vc_count`,
                  `surname`,
                  `othernames`,
                  `gender`,
                  `dob`,
                  `enrollmentstream`,
                  `enrollmentstreambasedon`,
                  `hiv_status`,
                  `datehivstatus`,
                  `enrolledontreatment`,
                  `facilityenrolled`,
                  `artstartdate`,
                  `birthcertificate`,
                  `childinschool`,
                  `schoolname`,
                  `schoolgrade`,
                  `childonvocationaltraining`,
                  `vocationalinstitute`,
                  `caregiver`,
                  `caregiverrelationshiptochild`
                ) 
                VALUES
                  (:enrollment_setting,:treatment_art_no,:enrollment_date,:hh_unique_num,:vc_unique_id,:vc_count,:surname,:othernames,:gender,:dob,:enrollmentstream,:enrollmentstreambasedon,:hiv_status,:datehivstatus,:enrolledontreatment,:facilityenrolled,:artstartdate,:birthcertificate,:childinschool,:schoolname,:schoolgrade,:childonvocationaltraining,:vocationalinstitute,:caregiver,:caregiverrelationshiptochild)");

              $stmt->bindParam(':enrollment_setting', $enrollment_setting);           
              $stmt->bindParam(':treatment_art_no', $treatment_art_no);           
              $stmt->bindParam(':enrollment_date', $enrollment_date);           
              $stmt->bindParam(':hh_unique_num', $hh_unique_num);           
              $stmt->bindParam(':vc_unique_id', $vc_unique_id);           
              $stmt->bindParam(':vc_count', $vc_count);           
              $stmt->bindParam(':surname', $surname);           
              $stmt->bindParam(':othernames', $othernames);           
              $stmt->bindParam(':gender', $gender);           
              $stmt->bindParam(':dob', $dob);           
              $stmt->bindParam(':enrollmentstream', $enrollmentstream);           
              $stmt->bindParam(':enrollmentstreambasedon', $enrollmentstreambasedon);           
              $stmt->bindParam(':hiv_status', $hiv_status);           
              $stmt->bindParam(':datehivstatus', $datehivstatus);           
              $stmt->bindParam(':enrolledontreatment', $enrolledontreatment);           
              $stmt->bindParam(':facilityenrolled', $facilityenrolled);           
              $stmt->bindParam(':artstartdate', $artstartdate);           
              $stmt->bindParam(':birthcertificate', $birthcertificate);           
              $stmt->bindParam(':childinschool', $childinschool);           
              $stmt->bindParam(':schoolname', $schoolname);           
              $stmt->bindParam(':schoolgrade', $schoolgrade);           
              $stmt->bindParam(':childonvocationaltraining', $childonvocationaltraining);           
              $stmt->bindParam(':vocationalinstitute', $vocationalinstitute);           
              $stmt->bindParam(':caregiver', $caregiver);           
              $stmt->bindParam(':caregiverrelationshiptochild', $caregiverrelationshiptochild);           
             
            $stmt->execute();
            $recordsinserted = $stmt->rowCount();
            if($recordsinserted >= 1){
            $stmt = $conn->prepare("insert into `ovcstatusupdate` (
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

              $stmt->bindParam(':unique_id', $vc_unique_id);           
              $stmt->bindParam(':hiv_status', $hiv_status);           
              $stmt->bindParam(':date_hivstatus', $datehivstatus);           
              $stmt->bindParam(':enrolledontreatment', $enrolledontreatment);           
              $stmt->bindParam(':facilityenrolled', $facilityenrolled);           
              $stmt->bindParam(':artstartdate', $artstartdate);           
              $stmt->bindParam(':treatment_art_no', $treatment_art_no);           
              $stmt->bindParam(':childhasbirthcertificate', $birthcertificate);           
              $stmt->bindParam(':childinschool', $childinschool);           
              $stmt->bindParam(':schoolname', $schoolname);           
              $stmt->bindParam(':schoolgrade', $schoolgrade);           
              $stmt->bindParam(':childonvocationaltraining', $childonvocationaltraining);           
              $stmt->bindParam(':vocationalinstitute', $vocationalinstitute);           
              $stmt->bindParam(':caregivername', $caregiver);           
              $stmt->bindParam(':enrollmentstatus', $enrollment_status);           
              $stmt->bindParam(':enrollmentstatus_date', $enrollment_date);                   
             
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