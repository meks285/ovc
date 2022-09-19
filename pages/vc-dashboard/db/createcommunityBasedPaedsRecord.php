<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$respondent_childrelationship = $_POST['respondent_childrelationship'];
$childhivstatusknowledge=$_POST['childhivstatusknowledge'];
$childhivstatus_paeds=$_POST['childhivstatus_paeds'];
$mainQuestion1=$_POST['mainQuestion1'];
$mainQuestion2=$_POST['mainQuestion2'];
$mainQuestion3=$_POST['mainQuestion3'];
$mainQuestion5=$_POST['mainQuestion5'];
$mainQuestion6=$_POST['mainQuestion6'];

$subQuestion1_1=$_POST['subQuestion1_1'];
$subQuestion2_1=$_POST['subQuestion2_1'];
$subQuestion1_2=$_POST['subQuestion1_2'];
$subQuestion2_2=$_POST['subQuestion2_2'];
$subQuestion1_3=$_POST['subQuestion1_3'];
$subQuestion2_3=$_POST['subQuestion2_3'];
$subQuestion1_5=$_POST['subQuestion1_5'];
$subQuestion2_5=$_POST['subQuestion2_5'];
$subQuestion1_6=$_POST['subQuestion1_6'];
$subQuestion2_6=$_POST['subQuestion2_6'];

$Question7=$_POST['Question7'];
$Question8=$_POST['Question8'];
$Question9=$_POST['Question9'];
$Question4=$_POST['Question4'];
$subQuestionResponse1_1=$_POST['subQuestionResponse1_1'];
$subQuestionResponse2_1=$_POST['subQuestionResponse2_1'];
$subQuestionResponse1_2=$_POST['subQuestionResponse1_2'];
$subQuestionResponse2_2=$_POST['subQuestionResponse2_2'];
$subQuestionResponse1_3=$_POST['subQuestionResponse1_3'];
$subQuestionResponse2_3=$_POST['subQuestionResponse2_3'];
$subQuestionResponse1_5=$_POST['subQuestionResponse1_5'];
$subQuestionResponse2_5=$_POST['subQuestionResponse2_5'];
$subQuestionResponse1_6=$_POST['subQuestionResponse1_6'];
$subQuestionResponse2_6=$_POST['subQuestionResponse2_6'];
$QuestionResponse4=$_POST['QuestionResponse4'];
$QuestionResponse7=$_POST['QuestionResponse7'];
$QuestionResponse8=$_POST['QuestionResponse8'];
$QuestionResponse9=$_POST['QuestionResponse9'];
$hh_unique_num=$_POST['hh_unique_num'];
$vc_unique_id=$_POST['vc_unique_id'];
$childatrisk=$_POST['childatrisk'];
$serviceprovider=$_POST['serviceprovider'];
$serviceprovisiondate=$_POST['serviceprovisiondate'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT vc_unique_id from communitybased_riskassessment where vc_unique_id='$vc_unique_id' AND serviceprovisiondate='$serviceprovisiondate'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `communitybased_riskassessment` (
              `vc_unique_id`,
              `hh_unique_num`,
              `respondent_childrelationship`,
              `childhivstatusknowledge`,
              `childhivstatus_paeds`,
              `mainQuestion1`,
              `subQuestion1_1`,
              `subQuestionResponse1_1`,
              `subQuestion2_1`,
              `subQuestionResponse2_1`,
              `mainQuestion2`,
              `subQuestion1_2`,
              `subQuestionResponse1_2`,
              `subQuestion2_2`,
              `subQuestionResponse2_2`,
              `mainQuestion3`,
              `subQuestion1_3`,
              `subQuestionResponse1_3`,
              `subQuestion2_3`,
              `subQuestionResponse2_3`,
              `Question4`,
              `QuestionResponse4`,
              `mainQuestion5`,
              `subQuestion1_5`,
              `subQuestionResponse1_5`,
              `subQuestion2_5`,
              `subQuestionResponse2_5`,
              `mainQuestion6`,
              `subQuestion1_6`,
              `subQuestionResponse1_6`,
              `subQuestion2_6`,
              `subQuestionResponse2_6`,
              `Question7`,
              `QuestionResponse7`,
              `Question8`,
              `QuestionResponse8`,
              `Question9`,
              `QuestionResponse9`,
              `childatrisk`,
              `serviceprovider`,
              `serviceprovisiondate`
            ) 
            VALUES
              (
                '$vc_unique_id',
                '$hh_unique_num',
                '$respondent_childrelationship',
                '$childhivstatusknowledge',
                '$childhivstatus_paeds',
                '$mainQuestion1',
                '$subQuestion1_1',
                '$subQuestionResponse1_1',
                '$subQuestion2_1',
                '$subQuestionResponse2_1',
                '$mainQuestion2',
                '$subQuestion1_2',
                '$subQuestionResponse1_2',
                '$subQuestion2_2',
                '$subQuestionResponse2_2',
                '$mainQuestion3',
                '$subQuestion1_3',
                '$subQuestionResponse1_3',
                '$subQuestion2_3',
                '$subQuestionResponse2_3',
                '$Question4',
                '$QuestionResponse4',
                '$mainQuestion5',
                '$subQuestion1_5',
                '$subQuestionResponse1_5',
                '$subQuestion2_5',
                '$subQuestionResponse2_5',
                '$mainQuestion6',
                '$subQuestion1_6',
                '$subQuestionResponse1_6',
                '$subQuestion2_6',
                '$subQuestionResponse2_6',
                '$Question7',
                '$QuestionResponse7',
                '$Question8',
                '$QuestionResponse8',
                '$Question9',
                '$QuestionResponse9',
                '$childatrisk',
                '$serviceprovider',
                '$serviceprovisiondate'
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