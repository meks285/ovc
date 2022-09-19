<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$assessmentdate = $_POST['assessmentdate'];
$weight=$_POST['weight'];
$height=$_POST['height'];
$bmi=$_POST['bmi'];
$oedema=$_POST['oedema'];
$muac=$_POST['muac'];
$Question1=$_POST['Question1'];
$responseQuestion1=$_POST['responseQuestion1'];
$Question2=$_POST['Question2'];
$responseQuestion2=$_POST['responseQuestion2'];
$Question3=$_POST['Question3'];
$responseQuestion3=$_POST['responseQuestion3'];
$Question4=$_POST['Question4'];
$responseQuestion4=$_POST['responseQuestion4'];
$Question5=$_POST['Question5'];
$responseQuestion5=$_POST['responseQuestion5'];
$Question6=$_POST['Question6'];
$responseQuestion6=$_POST['responseQuestion6'];
$Question7=$_POST['Question7'];
$responseQuestion7=$_POST['responseQuestion7'];
$Question8=$_POST['Question8'];
$responseQuestion8=$_POST['responseQuestion8'];
$Question9=$_POST['Question9'];
$responseQuestion9=$_POST['responseQuestion9'];
$Question10=$_POST['Question10'];
$responseQuestion10=$_POST['responseQuestion10'];
$Question11=$_POST['Question11'];
$responseQuestion11=$_POST['responseQuestion11'];
$responseQuestion12=$_POST['responseQuestion12'];
$Question13=$_POST['Question13'];
$Question12=$_POST['Question12'];
$responseQuestion13=$_POST['responseQuestion13'];
$serviceprovider=$_POST['serviceprovider'];
$serviceprovisiondate=$_POST['serviceprovisiondate'];
$conditionaffecting_nutrition=$_POST['conditionaffecting_nutrition'];
$referral=$_POST['referral'];
$hh_unique_num=$_POST['hh_unique_num'];
$vc_unique_id=$_POST['vc_unique_id'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT vc_unique_id from nutritionalassessment where vc_unique_id='$vc_unique_id' AND assessmentdate='$assessmentdate'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `nutritionalassessment` (
                `hh_unique_num`,
                `vc_unique_id`,
                `assessmentdate`,
                `weight`,
                `height`,
                `bmi`,
                `oedema`,
                `muac`,
                `Question1`,
                `responseQuestion1`,
                `Question2`,
                `responseQuestion2`,
                `Question3`,
                `responseQuestion3`,
                `Question4`,
                `responseQuestion4`,
                `Question5`,
                `responseQuestion5`,
                `Question6`,
                `responseQuestion6`,
                `Question7`,
                `responseQuestion7`,
                `Question8`,
                `responseQuestion8`,
                `Question9`,
                `responseQuestion9`,
                `Question10`,
                `responseQuestion10`,
                `Question11`,
                `responseQuestion11`,
                `Question12`,
                `responseQuestion12`,
                `Question13`,
                `responseQuestion13`,
                `conditionaffecting_nutrition`,
                `referral`,
                `serviceprovider`,
                `serviceprovisiondate`
              ) 
              VALUES
                (
                  '$hh_unique_num',
                  '$vc_unique_id',
                  '$assessmentdate',
                  '$weight',
                  '$height',
                  '$bmi',
                  '$oedema',
                  '$muac',
                  '$Question1',
                  '$responseQuestion1',
                  '$Question2',
                  '$responseQuestion2',
                  '$Question3',
                  '$responseQuestion3',
                  '$Question4',
                  '$responseQuestion4',
                  '$Question5',
                  '$responseQuestion5',
                  '$Question6',
                  '$responseQuestion6',
                  '$Question7',
                  '$responseQuestion7',
                  '$Question8',
                  '$responseQuestion8',
                  '$Question9',
                  '$responseQuestion9',
                  '$Question10',
                  '$responseQuestion10',
                  '$Question11',
                  '$responseQuestion11',
                  '$Question12',
                  '$responseQuestion12',
                  '$Question13',
                  '$responseQuestion13',
                  '$conditionaffecting_nutrition',
                  '$referral',
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