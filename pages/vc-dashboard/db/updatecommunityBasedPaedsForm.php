<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$id = $_POST['id'];
$respondent_childrelationship = $_POST['respondent_childrelationship'];
$childhivstatusknowledge = $_POST['childhivstatusknowledge'];
$childhivstatus_paeds = $_POST['childhivstatus_paeds'];
$subQuestionResponse1_1 = $_POST['subQuestionResponse1_1'];
$subQuestionResponse2_1 = $_POST['subQuestionResponse2_1'];
$subQuestionResponse1_2 = $_POST['subQuestionResponse1_2'];
$subQuestionResponse2_2 = $_POST['subQuestionResponse2_2'];
$subQuestionResponse1_3 = $_POST['subQuestionResponse1_3'];
$subQuestionResponse2_3 = $_POST['subQuestionResponse2_3'];
$QuestionResponse4 = $_POST['QuestionResponse4'];
$subQuestionResponse1_5 = $_POST['subQuestionResponse1_5'];
$subQuestionResponse2_5 = $_POST['subQuestionResponse2_5'];
$subQuestionResponse1_6 = $_POST['subQuestionResponse1_6'];
$subQuestionResponse2_6 = $_POST['subQuestionResponse2_6'];
$QuestionResponse7 = $_POST['QuestionResponse7'];
$QuestionResponse8 = $_POST['QuestionResponse8'];
$QuestionResponse9 = $_POST['QuestionResponse9'];
$childatrisk = $_POST['childatrisk'];
$serviceprovider = $_POST['serviceprovider'];
$serviceprovisiondate = $_POST['serviceprovisiondate'];

if($conn_status=="success"){

            $stmt = $conn->prepare("UPDATE 
            `communitybased_riskassessment` 
          SET
            `respondent_childrelationship` = '$respondent_childrelationship',
            `childhivstatusknowledge` = '$childhivstatusknowledge',
            `childhivstatus_paeds` = '$childhivstatus_paeds',
            `subQuestionResponse1_1` = '$subQuestionResponse1_1',
            `subQuestionResponse2_1` = '$subQuestionResponse2_1',
            `subQuestionResponse1_2` = '$subQuestionResponse1_2',
            `subQuestionResponse2_2` = '$subQuestionResponse2_2',
            `subQuestionResponse1_3` = '$subQuestionResponse1_3',
            `subQuestionResponse2_3` = '$subQuestionResponse2_3',
            `QuestionResponse4` = '$QuestionResponse4',
            `subQuestionResponse1_5` = '$subQuestionResponse1_5',
            `subQuestionResponse2_5` = '$subQuestionResponse2_5',
            `subQuestionResponse1_6` = '$subQuestionResponse1_6',
            `subQuestionResponse2_6` = '$subQuestionResponse2_6',
            `QuestionResponse7` = '$QuestionResponse7',
            `QuestionResponse8` = '$QuestionResponse8',
            `QuestionResponse9` = '$QuestionResponse9',
            `childatrisk` = '$childatrisk',
            `serviceprovider` = '$serviceprovider',
            `serviceprovisiondate` = '$serviceprovisiondate'
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