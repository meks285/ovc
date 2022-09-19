<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$domain = $_POST['domain'];
$service_provided=$_POST['service'];
$unique_id=$_POST['unique_id'];
$service_date=$_POST['service_date'];
$category=$_POST['category'];
$hh_unique_num=$_POST['householdUniqueId'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT id from services_provided where domain='$domain' AND service_provided='$service_provided' AND service_date='$service_date' AND unique_id='$unique_id'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `services_provided` (
                `service_date`,
                `hh_unique_num`,
                `unique_id`,
                `category`,
                `domain`,
                `service_provided`
              ) 
              VALUES
                (
                  '$service_date',
                  '$hh_unique_num',
                  '$unique_id',
                  '$category',
                  '$domain',
                  '$service_provided'
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