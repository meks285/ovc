<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$serviceQuestion1 = $_POST['serviceQuestion1'];
$serviceQuestion2=$_POST['serviceQuestion2'];
$serviceQuestion3=$_POST['serviceQuestion3'];
$serviceQuestion4=$_POST['serviceQuestion4'];
$responseQuestion1=$_POST['responseQuestion1'];
$responseQuestion2=$_POST['responseQuestion2'];
$responseQuestion3=$_POST['responseQuestion3'];
$responseQuestion4=$_POST['responseQuestion4'];
$responseQuestion3_other=$_POST['responseQuestion3_other'];
$responseQuestion4_other=$_POST['responseQuestion4_other'];
$service_date=$_POST['service_date'];
$hh_unique_num=$_POST['hh_unique_num'];
$unique_id=$_POST['unique_id'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT id from checklist_accesstoemergencyfunds where hh_unique_num='$hh_unique_num' AND service_date='$service_date'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `checklist_accesstoemergencyfunds` (
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
                `service_date`
              ) 
              VALUES
                (
                  '$hh_unique_num',
                  '$unique_id',
                  '$serviceQuestion1',
                  '$responseQuestion1',
                  '$serviceQuestion2',
                  '$responseQuestion2',
                  '$serviceQuestion3',
                  '$responseQuestion3',
                  '$serviceQuestion4',
                  '$responseQuestion4',
                  '$responseQuestion3_other',
                  '$responseQuestion4_other',
                  '$service_date'
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