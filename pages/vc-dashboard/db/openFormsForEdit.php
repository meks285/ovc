<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

## Open Care and Support Checklist Form For Update

if($_POST['function']=='openCandSChecklist'){
    $id = $_POST['id'];
    $sql = "SELECT 
    `id`,
    `vc_unique_id`,
    `hh_unique_num`,
    `consentQuestion1`,
    `responseQuestion1`,
    `consentQuestion2`,
    `responseQuestion2`,
    `consentQuestion3`,
    `responseQuestion3`,
    `consentQuestion4`,
    `responseQuestion4`,
    `consentQuestion5`,
    `responseQuestion5`,
    `beneficiaryonart`,
    `service_date`,
    `reg_date` 
  FROM
    `caresupportchecklist` WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'id' => $row['id'],
                            'vc_unique_id' => $row['vc_unique_id'],
                            'hh_unique_num' => $row['hh_unique_num'],
                            'consentQuestion1' => $row['consentQuestion1'],
                            'responseQuestion1' => $row['responseQuestion1'],
                            'consentQuestion2' => $row['consentQuestion2'],
                            'responseQuestion2' => $row['responseQuestion2'],
                            'consentQuestion3' => $row['consentQuestion3'],
                            'responseQuestion3' => $row['responseQuestion3'],
                            'consentQuestion4' => $row['consentQuestion4'],
                            'responseQuestion4' => $row['responseQuestion4'],
                            'consentQuestion5' => $row['consentQuestion5'],
                            'responseQuestion5' => $row['responseQuestion5'],
                            'beneficiaryonart' => $row['beneficiaryonart'],
                            'service_date' => $row['service_date'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
## Open Caregiver & VC status update Checklist Form For Update
elseif($_POST['function']=='openCaregiverVcStatus'){
    $id = $_POST['id'];
    $sql = "SELECT 
    `id`,
    `hh_member_category`,
    `vc_unique_id`,
    `hh_unique_num`,
    `hiv_status`,
    `dateoftest`,
    `birth_certificate`,
    `child_in_school`,
    `child_on_vocational_training`,
    `service_provider`,
    `service_date`,
    `reg_date` 
  FROM
    `caregiverandvcstatus` WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'id' => $row['id'],
                            'hh_member_category' => $row['hh_member_category'],
                            'vc_unique_id' => $row['vc_unique_id'],
                            'hh_unique_num' => $row['hh_unique_num'],
                            'hiv_status' => $row['hiv_status'],
                            'dateoftest' => $row['dateoftest'],
                            'birth_certificate' => $row['birth_certificate'],
                            'child_in_school' => $row['child_in_school'],
                            'child_on_vocational_training' => $row['child_on_vocational_training'],
                            'service_provider' => $row['service_provider'],
                            'service_date' => $row['service_date'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
## Open Caregiver Access to Emergency funds Checklist Form For Update
elseif($_POST['function']=='openCaregiverAccessEmergency'){
    $id = $_POST['id'];
    $sql = "SELECT 
    `id`,
    `hh_unique_num`,
    `unique_id`,
    `serviceQuestion1`,
    `responseQuestion1`,
    `serviceQuestion2`,
    `responseQuestion2`,
    `serviceQuestion3`,
    `responseQuestion3`,
    `serviceQuestion4`,
    `responseQuestion4`,
    `responseQuestion3_other`,
    `responseQuestion4_other`,
    `service_date`,
    `reg_date` 
  FROM
    `checklist_accesstoemergencyfunds` WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'id' => $row['id'],
                            'vc_unique_id' => $row['unique_id'],
                            'hh_unique_num' => $row['hh_unique_num'],
                            'serviceQuestion1' => $row['serviceQuestion1'],
                            'responseQuestion1' => $row['responseQuestion1'],
                            'serviceQuestion2' => $row['serviceQuestion2'],
                            'responseQuestion2' => $row['responseQuestion2'],
                            'serviceQuestion3' => $row['serviceQuestion3'],
                            'responseQuestion3' => $row['responseQuestion3'],
                            'responseQuestion4' => $row['responseQuestion4'],
                            'serviceQuestion4' => $row['serviceQuestion4'],
                            'responseQuestion3_other' => $row['responseQuestion3_other'],
                            'responseQuestion4_other' => $row['responseQuestion4_other'],
                            'service_date' => $row['service_date'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
## Open Referrals Checklist Form For Update
elseif($_POST['function']=='openReferralsChecklist'){
    $id = $_POST['id'];
    $date = $_POST['referral_date'];
    $sql = "SELECT 
    `vc_unique_id`,
      `referral_date`,
      MAX(`referring_organization`) referring_organization,
      MAX(`receiving_organization`) receiving_organization,
      MAX(`reservicereferred`) reservicereferred,
      MAX(`organization_providingreferral`) organization_providingreferral,
      GROUP_CONCAT(`service_provided`) service_provided,
      GROUP_CONCAT(`service_completed`) service_completed,
      GROUP_CONCAT(`followup_needed`) followup_needed,
      GROUP_CONCAT(`followup_date`) followup_date,
      MAX(`referral_status`) referral_status,
      MAX(`referral_receiver`) referral_receiver,
      MAX(`referral_receiver_designation`) referral_receiver_designation,
      MAX(`referral_receiver_phonenumber`) referral_receiver_phonenumber,
      MAX(`referral_receiver_email`) referral_receiver_email
    FROM
      `referralform` WHERE vc_unique_id='$id' AND referral_date='$date'
    GROUP BY vc_unique_id";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'vc_unique_id' => $row['vc_unique_id'],
                            'referring_organization' => $row['referring_organization'],
                            'receiving_organization' => $row['receiving_organization'],
                            'reservicereferred' => $row['reservicereferred'],
                            'organization_providingreferral' => $row['organization_providingreferral'],
                            'service_provided' => $row['service_provided'],
                            'service_completed' => $row['service_completed'],
                            'followup_needed' => $row['followup_needed'],
                            'followup_date' => $row['followup_date'],
                            'referral_status' => $row['referral_status'],
                            'referral_date' => $row['referral_date'],
                            'referral_receiver' => $row['referral_receiver'],
                            'referral_receiver_designation' => $row['referral_receiver_designation'],
                            'referral_receiver_phonenumber' => $row['referral_receiver_phonenumber'],
                            'referral_receiver_email' => $row['referral_receiver_email'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
## Open Child Education Performance Assessment Form For Update
elseif($_POST['function']=='openChildEducationAssessment'){
    $id = $_POST['id'];
    $sql = "SELECT 
    `id`,
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
    `teacher_date`,
    `reg_date` 
  FROM
    `childeducationperformanceassessment` WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'id' => $row['id'],
                            'vc_unique_id' => $row['vc_unique_id'],
                            'hh_unique_num' => $row['hh_unique_num'],
                            'responseQuestion1' => $row['responseQuestion1'],
                            'responseQuestion2' => $row['responseQuestion2'],
                            'responseQuestion3' => $row['responseQuestion3'],
                            'responseQuestion4' => $row['responseQuestion4'],
                            'responseQuestion5' => $row['responseQuestion5'],
                            'responseQuestion6' => $row['responseQuestion6'],
                            'responseQuestion7' => $row['responseQuestion7'],
                            'responseQuestion8' => $row['responseQuestion8'],
                            'cso_staffname' => $row['cso_staffname'],
                            'cso_date' => $row['cso_date'],
                            'teacher_name' => $row['teacher_name'],
                            'teacher_date' => $row['teacher_date'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
## Open Community based HIV risk Assessment Form For Update
elseif($_POST['function']=='openHivRiskAssessment'){
    $id = $_POST['id'];
    $sql = "SELECT 
    `id`,
    `vc_unique_id`,
    `hh_unique_num`,
    `respondent_childrelationship`,
    `childhivstatusknowledge`,
    `childhivstatus_paeds`,
    `subQuestionResponse1_1`,
    `subQuestionResponse2_1`,
    `subQuestionResponse1_2`,
    `subQuestionResponse2_2`,
    `subQuestionResponse1_3`,
    `subQuestionResponse2_3`,
    `QuestionResponse4`,
    `subQuestionResponse1_5`,
    `subQuestionResponse2_5`,
    `subQuestionResponse1_6`,
    `subQuestionResponse2_6`,
    `QuestionResponse7`,
    `QuestionResponse8`,
    `QuestionResponse9`,
    `childatrisk`,
    `serviceprovider`,
    `serviceprovisiondate`,
    `reg_date` 
  FROM
    `communitybased_riskassessment` WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'id' => $row['id'],
                            'vc_unique_id' => $row['vc_unique_id'],
                            'hh_unique_num' => $row['hh_unique_num'],
                            'respondent_childrelationship' => $row['respondent_childrelationship'],
                            'childhivstatusknowledge' => $row['childhivstatusknowledge'],
                            'childhivstatus_paeds' => $row['childhivstatus_paeds'],
                            'subQuestionResponse1_1' => $row['subQuestionResponse1_1'],
                            'subQuestionResponse2_1' => $row['subQuestionResponse2_1'],
                            'subQuestionResponse1_2' => $row['subQuestionResponse1_2'],
                            'subQuestionResponse2_2' => $row['subQuestionResponse2_2'],
                            'subQuestionResponse1_3' => $row['subQuestionResponse1_3'],
                            'subQuestionResponse2_3' => $row['subQuestionResponse2_3'],
                            'QuestionResponse4' => $row['QuestionResponse4'],
                            'subQuestionResponse1_5' => $row['subQuestionResponse1_5'],
                            'subQuestionResponse2_5' => $row['subQuestionResponse2_5'],
                            'subQuestionResponse1_6' => $row['subQuestionResponse1_6'],
                            'subQuestionResponse2_6' => $row['subQuestionResponse2_6'],
                            'QuestionResponse7' => $row['QuestionResponse7'],
                            'QuestionResponse8' => $row['QuestionResponse8'],
                            'QuestionResponse9' => $row['QuestionResponse9'],
                            'childatrisk' => $row['childatrisk'],
                            'serviceprovider' => $row['serviceprovider'],
                            'serviceprovisiondate' => $row['serviceprovisiondate'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
## Open Nutritional Assessment Form For Update
elseif($_POST['function']=='openNutritionalAssessment'){
    $id = $_POST['id'];
    $sql = "SELECT 
    `id`,
    `hh_unique_num`,
    `vc_unique_id`,
    `assessmentdate`,
    `weight`,
    `height`,
    `bmi`,
    `oedema`,
    `muac`,
    `responseQuestion1`,
    `responseQuestion2`,
    `responseQuestion3`,
    `responseQuestion4`,
    `responseQuestion5`,
    `responseQuestion6`,
    `responseQuestion7`,
    `responseQuestion8`,
    `responseQuestion9`,
    `responseQuestion10`,
    `responseQuestion11`,
    `responseQuestion12`,
    `responseQuestion13`,
    `conditionaffecting_nutrition`,
    `referral`,
    `serviceprovider`,
    `serviceprovisiondate`
  FROM
    `nutritionalassessment` WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
                            'id' => $row['id'],
                            'vc_unique_id' => $row['vc_unique_id'],
                            'hh_unique_num' => $row['hh_unique_num'],
                            'assessmentdate' => $row['assessmentdate'],
                            'weight' => $row['weight'],
                            'height' => $row['height'],
                            'bmi' => $row['bmi'],
                            'oedema' => $row['oedema'],
                            'muac' => $row['muac'],
                            'responseQuestion1' => $row['responseQuestion1'],
                            'responseQuestion2' => $row['responseQuestion2'],
                            'responseQuestion3' => $row['responseQuestion3'],
                            'responseQuestion4' => $row['responseQuestion4'],
                            'responseQuestion5' => $row['responseQuestion5'],
                            'responseQuestion6' => $row['responseQuestion6'],
                            'responseQuestion7' => $row['responseQuestion7'],
                            'responseQuestion8' => $row['responseQuestion8'],
                            'responseQuestion9' => $row['responseQuestion9'],
                            'responseQuestion10' => $row['responseQuestion10'],
                            'responseQuestion11' => $row['responseQuestion11'],
                            'responseQuestion12' => $row['responseQuestion12'],
                            'responseQuestion13' => $row['responseQuestion13'],
                            'conditionaffecting_nutrition' => $row['conditionaffecting_nutrition'],
                            'referral' => $row['referral'],
                            'serviceprovider' => $row['serviceprovider'],
                            'serviceprovisiondate' => $row['serviceprovisiondate'],
                            'status'=> 'success'
                        ]));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
elseif($_POST['function']=='provideStatusUpdate'){
    $id = $_POST['id'];
    $sql = "SELECT vc_unique_id FROM vcenrollment WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode(['vc_unique_id' => $row['vc_unique_id'],'status'=> 'success']));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
else{
    die(json_encode(['status' => 'failure']));
}
?>