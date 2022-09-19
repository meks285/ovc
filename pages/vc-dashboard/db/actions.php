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
else{
    die(json_encode(['status' => 'failure']));
}
?>