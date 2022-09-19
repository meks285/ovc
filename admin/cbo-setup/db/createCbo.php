<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$cbo_name = $_POST['cbo_name'];
$cbo_code=$_POST['cbo_code'];
$cbo_details=$_POST['cbo_details'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT cbo_code from cbo where cbo_name='$cbo_name' OR cbo_code='$cbo_code'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `cbo` (
                `cbo_name`,
                `cbo_code`,
                `cbo_details`
              ) 
              VALUES
                (
                  '$cbo_name',
                  '$cbo_code',
                  '$cbo_details'
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