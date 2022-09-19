<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$id = $_POST['id'];
$assessmentdate = $_POST['assessmentdate'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$bmi = $_POST['bmi'];
$oedema = $_POST['oedema'];
$muac = $_POST['muac'];
$responseQuestion1 = $_POST['responseQuestion1'];
$responseQuestion2 = $_POST['responseQuestion2'];
$responseQuestion3 = $_POST['responseQuestion3'];
$responseQuestion4 = $_POST['responseQuestion4'];
$responseQuestion5 = $_POST['responseQuestion5'];
$responseQuestion6 = $_POST['responseQuestion6'];
$responseQuestion7 = $_POST['responseQuestion7'];
$responseQuestion8 = $_POST['responseQuestion8'];
$responseQuestion9 = $_POST['responseQuestion9'];
$responseQuestion10 = $_POST['responseQuestion10'];
$responseQuestion11 = $_POST['responseQuestion11'];
$responseQuestion12 = $_POST['responseQuestion12'];
$responseQuestion13 = $_POST['responseQuestion13'];
$serviceprovider = $_POST['serviceprovider'];
$serviceprovisiondate = $_POST['serviceprovisiondate'];
$conditionaffecting_nutrition = $_POST['conditionaffecting_nutrition'];
$referral = $_POST['referral'];

if($conn_status=="success"){

            $stmt = $conn->prepare("UPDATE 
            `nutritionalassessment` 
          SET
            `assessmentdate` = '$assessmentdate',
            `weight` = '$weight',
            `height` = '$height',
            `bmi` = '$bmi',
            `oedema` = '$oedema',
            `muac` = '$muac',
            `responseQuestion1` = '$responseQuestion1',
            `responseQuestion2` = '$responseQuestion2',
            `responseQuestion3` = '$responseQuestion3',
            `responseQuestion4` = '$responseQuestion4',
            `responseQuestion5` = '$responseQuestion5',
            `responseQuestion6` = '$responseQuestion6',
            `responseQuestion7` = '$responseQuestion7',
            `responseQuestion8` = '$responseQuestion8',
            `responseQuestion9` = '$responseQuestion9',
            `responseQuestion10` = '$responseQuestion10',
            `responseQuestion11` = '$responseQuestion11',
            `responseQuestion12` = '$responseQuestion12',
            `responseQuestion13` = '$responseQuestion13',
            `conditionaffecting_nutrition` = '$conditionaffecting_nutrition',
            `referral` = '$referral',
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