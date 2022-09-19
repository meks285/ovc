<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$vc_unique_id = $_POST['vc_unique_id'];
$referral_date = $_POST['referral_date'];


if($conn_status=="success"){

            $stmt = $conn->prepare("DELETE 
            FROM
              `referralform` 
            WHERE `vc_unique_id` = '$vc_unique_id' AND referral_date='$referral_date'");
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