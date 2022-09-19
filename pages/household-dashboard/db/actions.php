<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

if($_POST['function']=='provideService'){
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
elseif($_POST['function']=='updateBeneficiaryStatus'){
    $id = $_POST['id'];
    $sql = "SELECT * FROM beneficiarystatusupdate WHERE beneficiaryid = (SELECT beneficiaryid FROM adulthouseholdmember WHERE id='$id') ORDER BY id DESC LIMIT 1";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
            'hh_unique_num' => $row['hh_unique_num'],
            'beneficiaryid' => $row['beneficiaryid'],
            'surname' => $row['surname'],
            'firstname' => $row['firstname'],
            'sex' => $row['sex'],
            'dob' => $row['dob'],
            'phonenumber' => $row['phonenumber'],
            'enrollmentdate' => $row['enrollmentdate'],
            'maritalstatus' => $row['maritalstatus'],
            'occupation' => $row['occupation'],
            'hiv_status' => $row['hiv_status'],
            'datehivstatus' => $row['datehivstatus'],
            'enrolledontreatment' => $row['enrolledontreatment'],
            'artstartdate' => $row['artstartdate'],
            'enrollmentstatus' => $row['enrollmentstatus'],
            'facilityenrolled' => $row['facilityenrolled'],
            'treatment_art_no' => $row['treatment_art_no'],
            'beneficiarytype' => $row['beneficiarytype'],
            'status'=> 'success']));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
elseif($_POST['function']=='accessToEmergencyFund'){
    $id = $_POST['id'];
    $sql = "SELECT * FROM adulthouseholdmember WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
            'id' => $row['id'],
            'beneficiaryid' => $row['beneficiaryid'],
            'status'=> 'success']));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
elseif($_POST['function']=='referralForm'){
    $id = $_POST['id'];
    $sql = "SELECT * FROM adulthouseholdmember WHERE id='$id'";
    $result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        die(json_encode([
            'id' => $row['id'],
            'beneficiaryid' => $row['beneficiaryid'],
            'status'=> 'success']));
    }
    else{
        die(json_encode(['status' => 'error_data']));
    }
}
else{
    die(json_encode(['status' => 'failure']));
}
?>