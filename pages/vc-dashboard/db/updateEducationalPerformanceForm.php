<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$id = $_POST['id'];
$responseQuestion1 = $_POST['responseQuestion1'];
$responseQuestion2 = $_POST['responseQuestion2'];
$responseQuestion3 = $_POST['responseQuestion3'];
$responseQuestion4 = $_POST['responseQuestion4'];
$responseQuestion5 = $_POST['responseQuestion5'];
$responseQuestion6 = $_POST['responseQuestion6'];
$responseQuestion7 = $_POST['responseQuestion7'];
$responseQuestion8 = $_POST['responseQuestion8'];
$cso_staffname = $_POST['cso_staffname'];
$cso_date = $_POST['cso_date'];
$teacher_name = $_POST['teacher_name'];
$teacher_date = $_POST['teacher_date'];

if($conn_status=="success"){

            $stmt = $conn->prepare("UPDATE 
            `childeducationperformanceassessment` 
          SET
            `responseQuestion1` = '$responseQuestion1',
            `responseQuestion2` = '$responseQuestion2',
            `responseQuestion3` = '$responseQuestion3',
            `responseQuestion4` = '$responseQuestion4',
            `responseQuestion5` = '$responseQuestion5',
            `responseQuestion6` = '$responseQuestion6',
            `responseQuestion7` = '$responseQuestion7',
            `responseQuestion8` = '$responseQuestion8',
            `cso_staffname` = '$cso_staffname',
            `cso_date` = '$cso_date',
            `teacher_name` = '$teacher_name',
            `teacher_date` = '$teacher_date'
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