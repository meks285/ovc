<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$referring_organization = $_POST['referring_organization'];
$receiving_organization=$_POST['receiving_organization'];
$reservicereferred=$_POST['reservicereferred'];
$organization_providingreferral = $_POST['organization_providingreferral'];
$service_provided=$_POST['service_provided'];
$service_completed=$_POST['service_completed'];
$followup_needed = $_POST['followup_needed'];
//$followup_date=$_POST['followup_date'];
if($_POST['followup_date']==''){$followup_date=NULL;}else{$followup_date=$_POST['followup_date'];}
$referral_status=$_POST['referral_status'];
$referral_date=$_POST['referral_date'];
$referral_receiver = $_POST['referral_receiver'];
$referral_receiver_designation=$_POST['referral_receiver_designation'];
$referral_receiver_phonenumber=$_POST['referral_receiver_phonenumber'];
$vc_unique_id = $_POST['vc_unique_id'];
$hh_unique_num=$_POST['hh_unique_num'];
$referral_receiver_email=$_POST['referral_receiver_email'];
$referral_date=$_POST['referral_date'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT vc_unique_id from referralform where vc_unique_id='$vc_unique_id' AND service_provided='$service_provided' AND referral_date='$referral_date'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
try{
$stmt = "INSERT INTO referralform (hh_unique_num,vc_unique_id,referring_organization,receiving_organization,reservicereferred,organization_providingreferral,service_provided,service_completed,followup_needed,followup_date,referral_status,referral_date,referral_receiver,referral_receiver_designation,referral_receiver_phonenumber,referral_receiver_email) VALUES (:hh_unique_num,:vc_unique_id,:referring_organization,:receiving_organization,:reservicereferred,:organization_providingreferral,:service_provided,:service_completed,:followup_needed,:followup_date,:referral_status,:referral_date,:referral_receiver,:referral_receiver_designation,:referral_receiver_phonenumber,:referral_receiver_email)";            

$stmt = $conn->prepare($stmt);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt->bindParam(':hh_unique_num', $hh_unique_num);           
              $stmt->bindParam(':vc_unique_id', $vc_unique_id);           
              $stmt->bindParam(':referring_organization', $referring_organization);           
              $stmt->bindParam(':receiving_organization', $receiving_organization);           
              $stmt->bindParam(':reservicereferred', $reservicereferred);           
              $stmt->bindParam(':organization_providingreferral', $organization_providingreferral);           
              $stmt->bindParam(':service_provided', $service_provided);           
              $stmt->bindParam(':service_completed', $service_completed);           
              $stmt->bindParam(':followup_needed', $followup_needed);           
              $stmt->bindParam(':followup_date', $followup_date);           
              $stmt->bindParam(':referral_status', $referral_status);           
              $stmt->bindParam(':referral_date', $referral_date);           
              $stmt->bindParam(':referral_receiver', $referral_receiver);           
              $stmt->bindParam(':referral_receiver_designation', $referral_receiver_designation);           
              $stmt->bindParam(':referral_receiver_phonenumber', $referral_receiver_phonenumber);               
              $stmt->bindParam(':referral_receiver_email', $referral_receiver_email);                 
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
            die(json_encode(['status' => 'exists']));
        } 
}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>