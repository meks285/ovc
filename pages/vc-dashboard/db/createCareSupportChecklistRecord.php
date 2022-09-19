<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$question1 = $_POST['question1'];
$responseQuestion1 = $_POST['responseQuestion1'];
$artfacility = $_POST['artfacility'];
$lastdrugpickupdate = $_POST['lastdrugpickupdate'];
$currentregimen = $_POST['currentregimen'];
$refillduration = $_POST['refillduration'];
$nextappointmentdate = $_POST['nextappointmentdate'];
$question2 = $_POST['question2'];
$responseQuestion2 = $_POST['responseQuestion2'];
$missedarvreason = $_POST['missedarvreason'];
$question3 = $_POST['question3'];
$responseQuestion3 = $_POST['responseQuestion3'];
$question4 = $_POST['question4'];
$responseQuestion4 = $_POST['responseQuestion4'];
$question5 = $_POST['question5'];
$responseQuestion5 = $_POST['responseQuestion5'];
$lastviralloadsampledate = $_POST['lastviralloadsampledate'];
$question6 = $_POST['question6'];
$responseQuestion6 = $_POST['responseQuestion6'];
$viralloadtestresult = $_POST['viralloadtestresult'];
$viralloadtestresultdate = $_POST['viralloadtestresultdate'];
$whyviralloadnotdone = $_POST['whyviralloadnotdone'];
$question7 = $_POST['question7'];
$responseQuestion7 = $_POST['responseQuestion7'];
$question8 = $_POST['question8'];
$responseQuestion8 = $_POST['responseQuestion8'];
$question9 = $_POST['question9'];
$responseQuestion9 = $_POST['responseQuestion9'];
$viralloadresultaftereac = $_POST['viralloadresultaftereac'];
$question10 = $_POST['question10'];
$responseQuestion10 = $_POST['responseQuestion10'];
$question11 = $_POST['question11'];
$responseQuestion11 = $_POST['responseQuestion11'];
$question12 = $_POST['question12'];
$responseQuestion12 = $_POST['responseQuestion12'];
$question13 = $_POST['question13'];
$responseQuestion13 = $_POST['responseQuestion13'];
$question14 = $_POST['question14'];
$responseQuestion14 = $_POST['responseQuestion14'];
$question15 = $_POST['question15'];
$responseQuestion15 = $_POST['responseQuestion15'];
$tbreferraldate = $_POST['tbreferraldate'];
$serviceprovidername = $_POST['serviceprovidername'];
$serviceproviderdesignation = $_POST['serviceproviderdesignation'];
$serviceproviderphone = $_POST['serviceproviderphone'];
$datesigned = $_POST['datesigned'];
$hh_unique_num = $_POST['hh_unique_num'];
$vc_unique_id = $_POST['vc_unique_id'];

if($conn_status=="success"){
    try{
            $stmt = $conn->prepare("INSERT INTO `caresupportchecklist` (
  `vc_unique_id`,
  `hh_unique_num`,
  `question1`,
  `responseQuestion1`,
  `artfacility`,
  `lastdrugpickupdate`,
  `currentregimen`,
  `refillduration`,
  `nextappointmentdate`,
  `question2`,
  `responseQuestion2`,
  `missedarvreason`,
  `question3`,
  `responseQuestion3`,
  `question4`,
  `responseQuestion4`,
  `question5`,
  `responseQuestion5`,
  `question6`,
  `responseQuestion6`,
  `lastviralloadsampledate`,
  `viralloadtestresult`,
  `viralloadtestresultdate`,
  `whyviralloadnotdone`,
  `question7`,
  `responseQuestion7`,
  `question8`,
  `responseQuestion8`,
  `question9`,
  `responseQuestion9`,
  `viralloadresultaftereac`,
  `question10`,
  `responseQuestion10`,
  `question11`,
  `responseQuestion11`,
  `question12`,
  `responseQuestion12`,
  `question13`,
  `responseQuestion13`,
  `question14`,
  `responseQuestion14`,
  `question15`,
  `responseQuestion15`,
  `serviceprovidername`,
  `serviceproviderdesignation`,
  `serviceproviderphone`,
  `datesigned`
) 
VALUES
  (:vc_unique_id,:hh_unique_num,:question1,:responseQuestion1,:artfacility,:lastdrugpickupdate,:currentregimen,:refillduration,:nextappointmentdate,:question2,:responseQuestion2,:missedarvreason,:question3,:responseQuestion3,:question4,:responseQuestion4,:question5,:responseQuestion5,:question6,:responseQuestion6,:lastviralloadsampledate,:viralloadtestresult,:viralloadtestresultdate,:whyviralloadnotdone,:question7,:responseQuestion7,:question8,:responseQuestion8,:question9,:responseQuestion9,:viralloadresultaftereac,:question10,:responseQuestion10,:question11,:responseQuestion11,:question12,:responseQuestion12,:question13,:responseQuestion13,:question14,:responseQuestion14,:question15,:responseQuestion15,:serviceprovidername,:serviceproviderdesignation,:serviceproviderphone,:datesigned)");           
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt->bindParam(':vc_unique_id', $vc_unique_id);           
              $stmt->bindParam(':hh_unique_num', $hh_unique_num);           
              $stmt->bindParam(':question1', $question1);           
              $stmt->bindParam(':responseQuestion1', $responseQuestion1);           
              $stmt->bindParam(':artfacility', $artfacility);           
              $stmt->bindParam(':lastdrugpickupdate', $lastdrugpickupdate);           
              $stmt->bindParam(':currentregimen', $currentregimen);           
              $stmt->bindParam(':refillduration', $refillduration);           
              $stmt->bindParam(':nextappointmentdate', $nextappointmentdate);           
              $stmt->bindParam(':question2', $question2);           
              $stmt->bindParam(':responseQuestion2', $responseQuestion2);           
              $stmt->bindParam(':missedarvreason', $missedarvreason);           
              $stmt->bindParam(':question3', $question3);           
              $stmt->bindParam(':responseQuestion3', $responseQuestion3);           
              $stmt->bindParam(':question4', $question4);           
              $stmt->bindParam(':responseQuestion4', $responseQuestion4);           
              $stmt->bindParam(':question5', $question5);           
              $stmt->bindParam(':responseQuestion5', $responseQuestion5);           
              $stmt->bindParam(':question6', $question6);           
              $stmt->bindParam(':responseQuestion6', $responseQuestion6);           
              $stmt->bindParam(':lastviralloadsampledate', $lastviralloadsampledate);           
              $stmt->bindParam(':viralloadtestresult', $viralloadtestresult);           
              $stmt->bindParam(':viralloadtestresultdate', $viralloadtestresultdate);           
              $stmt->bindParam(':whyviralloadnotdone', $whyviralloadnotdone);           
              $stmt->bindParam(':question7', $question7);           
              $stmt->bindParam(':responseQuestion7', $responseQuestion7);           
              $stmt->bindParam(':question8', $question8);           
              $stmt->bindParam(':responseQuestion8', $responseQuestion8);           
              $stmt->bindParam(':question9', $question9);           
              $stmt->bindParam(':responseQuestion9', $responseQuestion9);           
              $stmt->bindParam(':viralloadresultaftereac', $viralloadresultaftereac);           
              $stmt->bindParam(':question10', $question10);           
              $stmt->bindParam(':responseQuestion10', $responseQuestion10);           
              $stmt->bindParam(':question11', $question11);           
              $stmt->bindParam(':responseQuestion11', $responseQuestion11);           
              $stmt->bindParam(':question12', $question12);           
              $stmt->bindParam(':responseQuestion12', $responseQuestion12);           
              $stmt->bindParam(':question13', $question13);           
              $stmt->bindParam(':responseQuestion13', $responseQuestion13);           
              $stmt->bindParam(':question14', $question14);           
              $stmt->bindParam(':responseQuestion14', $responseQuestion14);           
              $stmt->bindParam(':question15', $question15);           
              $stmt->bindParam(':responseQuestion15', $responseQuestion15);           
              $stmt->bindParam(':serviceprovidername', $serviceprovidername);           
              $stmt->bindParam(':serviceproviderdesignation', $serviceproviderdesignation);           
              $stmt->bindParam(':serviceproviderphone', $serviceproviderphone);           
              $stmt->bindParam(':datesigned', $datesigned);           

            $stmt->execute();
            $recordsinserted = $stmt->rowCount();
            if($recordsinserted >= 1){
              die(json_encode(['status' => 'success']));
            }
            else{
                die(json_encode(['status' => 'failure']));
            }  
    }
    catch(PDOException $e){
                die(json_encode(['status' => $e->getMessage()]));
        
    }    

}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>