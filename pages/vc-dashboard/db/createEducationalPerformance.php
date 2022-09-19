<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$question1 = $_POST['question1'];
$responseQuestion1 = $_POST['responseQuestion1'];
$question2 = $_POST['question2'];
$responseQuestion2 = $_POST['responseQuestion2'];
$question3 = $_POST['question3'];
$responseQuestion3 = $_POST['responseQuestion3'];
$question4 = $_POST['question4'];
$responseQuestion4 = $_POST['responseQuestion4'];
$question5 = $_POST['question5'];
$responseQuestion5 = $_POST['responseQuestion5'];
$question6 = $_POST['question6'];
$responseQuestion6 = $_POST['responseQuestion6'];
$question7 = $_POST['question7'];
$responseQuestion7 = $_POST['responseQuestion7'];
$question8 = $_POST['question8'];
$responseQuestion8 = $_POST['responseQuestion8'];
$vc_unique_id = $_POST['vc_unique_id'];
$hh_unique_num = $_POST['hh_unique_num'];
$cso_staffname = $_POST['cso_staffname'];
$cso_date = $_POST['cso_date'];
$teacher_name = $_POST['teacher_name'];
$teacher_date = $_POST['teacher_date'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT vc_unique_id from childeducationperformanceassessment where vc_unique_id='$vc_unique_id' AND (cso_date='$cso_date' OR teacher_date='$teacher_date')");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `childeducationperformanceassessment` (
                `hh_unique_num`,
                `vc_unique_id`,
                `question1`,
                `responseQuestion1`,
                `question2`,
                `responseQuestion2`,
                `question3`,
                `responseQuestion3`,
                `question4`,
                `responseQuestion4`,
                `question5`,
                `responseQuestion5`,
                `question6`,
                `responseQuestion6`,
                `question7`,
                `responseQuestion7`,
                `question8`,
                `responseQuestion8`,
                `cso_staffname`,
                `cso_date`,
                `teacher_name`,
                `teacher_date`
              ) 
              VALUES
                (
                  '$hh_unique_num',
                  '$vc_unique_id',
                  '$question1',
                  '$responseQuestion1',
                  '$question2',
                  '$responseQuestion2',
                  '$question3',
                  '$responseQuestion3',
                  '$question4',
                  '$responseQuestion4',
                  '$question5',
                  '$responseQuestion5',
                  '$question6',
                  '$responseQuestion6',
                  '$question7',
                  '$responseQuestion7',
                  '$question8',
                  '$responseQuestion8',
                  '$cso_staffname',
                  '$cso_date',
                  '$teacher_name',
                  '$teacher_date'
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