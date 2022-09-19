<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$enrollmentid =  $_POST['enrollmentid'];
$beneficiaryid = $_POST['beneficiaryid'];
$hhuniqueid =  $_POST['hhuniqueid'];
$firstname =  $_POST['firstname'];
$surname =  $_POST['surname'];
if(!isset($_POST['dateofenrollment']) || $_POST['dateofenrollment']==''){$dateofenrollment=NULL;}else{$dateofenrollment=$_POST['dateofenrollment'];};
$dob =  $_POST['dob'];
$sex =  $_POST['sex'];
$phonenumber =  $_POST['phonenumber'];
$currenthivstatus =  $_POST['currenthivstatus'];
if(!isset($_POST['dateofcurrenthivstatus']) || $_POST['dateofcurrenthivstatus']==''){$dateofcurrenthivstatus=NULL;}else{$dateofcurrenthivstatus=$_POST['dateofcurrenthivstatus'];};
$enrolledontreatment =  $_POST['enrolledontreatment'];
if(!isset($_POST['dateenrolledontreatment']) || $_POST['dateenrolledontreatment']==''){$dateenrolledontreatment=NULL;}else{$dateenrolledontreatment=$_POST['dateenrolledontreatment'];};
$hivtreatmentfacility =  $_POST['hivtreatmentfacility'];
$occupation =  $_POST['occupation'];
$currentenrollmentstatus =  $_POST['currentenrollmentstatus'];
if(!isset($_POST['dateofcurrentenrollmentstatus']) || $_POST['dateofcurrentenrollmentstatus']==''){$dateofcurrentenrollmentstatus=NULL;}else{$dateofcurrentenrollmentstatus=$_POST['dateofcurrentenrollmentstatus'];};
$maritalstatus =  $_POST['maritalstatus'];
$iscaregiver =  $_POST['iscaregiver'];
$beneficiarytype =  $_POST['beneficiarytype'];
$treatmentid =  $_POST['treatmentid'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT beneficiaryid from adulthouseholdmember where beneficiaryid='$beneficiaryid'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
       if($recordsSelected == 0){
try{
##Define INSERT
$stmt = "INSERT INTO `adulthouseholdmember` (`beneficiaryid`,`enrollmentid`,`hhuniqueid`,`firstname`,`surname`,`dateofenrollment`,`dob`,`sex`,`phonenumber`,`currenthivstatus`,`dateofcurrenthivstatus`,`enrolledontreatment`,`dateenrolledontreatment`,`hivtreatmentfacility`,`occupation`,`currentenrollmentstatus`,`dateofcurrentenrollmentstatus`,`maritalstatus`,`iscaregiver`,`beneficiarytype`,`treatmentid`) VALUES(:beneficiaryid,:enrollmentid,:hhuniqueid,:firstname,:surname,:dateofenrollment,:dob,:sex,:phonenumber,:currenthivstatus,:dateofcurrenthivstatus, :enrolledontreatment,:dateenrolledontreatment,:hivtreatmentfacility,:occupation,:currentenrollmentstatus,:dateofcurrentenrollmentstatus,:maritalstatus,:iscaregiver,:beneficiarytype, :treatmentid)";            
$stmt = $conn->prepare($stmt);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt->bindParam(':beneficiaryid', $beneficiaryid);           
              $stmt->bindParam(':enrollmentid', $enrollmentid);           
              $stmt->bindParam(':hhuniqueid', $hhuniqueid);           
              $stmt->bindParam(':firstname', $firstname);           
              $stmt->bindParam(':surname', $surname);           
              $stmt->bindParam(':dateofenrollment', $dateofenrollment);           
              $stmt->bindParam(':dob', $dob);           
              $stmt->bindParam(':sex', $sex);           
              $stmt->bindParam(':phonenumber', $phonenumber);           
              $stmt->bindParam(':currenthivstatus', $currenthivstatus);           
              $stmt->bindParam(':dateofcurrenthivstatus', $dateofcurrenthivstatus);           
              $stmt->bindParam(':enrolledontreatment', $enrolledontreatment);           
              $stmt->bindParam(':dateenrolledontreatment', $dateenrolledontreatment);           
              $stmt->bindParam(':hivtreatmentfacility', $hivtreatmentfacility);           
              $stmt->bindParam(':occupation', $occupation);           
              $stmt->bindParam(':currentenrollmentstatus', $currentenrollmentstatus);           
              $stmt->bindParam(':dateofcurrentenrollmentstatus', $dateofcurrentenrollmentstatus);           
              $stmt->bindParam(':maritalstatus', $maritalstatus);           
              $stmt->bindParam(':iscaregiver', $iscaregiver);           
              $stmt->bindParam(':beneficiarytype', $beneficiarytype);           
              $stmt->bindParam(':treatmentid', $treatmentid);  
            $stmt->execute();
$recordsinserted = $stmt->rowCount();     
            if($recordsinserted >= 1){

try{
##Define INSERT
$stmt = "INSERT INTO beneficiarystatusupdate (hh_unique_num,beneficiaryid,surname,firstname,sex,dob,phonenumber,enrollmentdate,maritalstatus,occupation,hiv_status,datehivstatus,enrolledontreatment,artstartdate,enrollmentstatus,facilityenrolled,treatment_art_no,beneficiarytype) VALUES  (:hh_unique_num,:beneficiaryid,:surname,:firstname,:sex,:dob,:phonenumber,:enrollmentdate,:maritalstatus,:occupation,:hiv_status,:datehivstatus,:enrolledontreatment,:artstartdate,:enrollmentstatus,:facilityenrolled,:treatment_art_no,:beneficiarytype)";            
$stmt = $conn->prepare($stmt);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt->bindParam(':beneficiaryid', $beneficiaryid);           
              $stmt->bindParam(':hh_unique_num', $hhuniqueid);           
              $stmt->bindParam(':firstname', $firstname);           
              $stmt->bindParam(':surname', $surname);           
              $stmt->bindParam(':enrollmentdate', $dateofenrollment);           
              $stmt->bindParam(':dob', $dob);           
              $stmt->bindParam(':sex', $sex);           
              $stmt->bindParam(':phonenumber', $phonenumber);           
              $stmt->bindParam(':hiv_status', $currenthivstatus);           
              $stmt->bindParam(':datehivstatus', $dateofcurrenthivstatus);           
              $stmt->bindParam(':enrolledontreatment', $enrolledontreatment);           
              $stmt->bindParam(':artstartdate', $dateenrolledontreatment);           
              $stmt->bindParam(':facilityenrolled', $hivtreatmentfacility);           
              $stmt->bindParam(':occupation', $occupation);           
              $stmt->bindParam(':enrollmentstatus', $currentenrollmentstatus);               
              $stmt->bindParam(':maritalstatus', $maritalstatus);                 
              $stmt->bindParam(':beneficiarytype', $beneficiarytype);           
              $stmt->bindParam(':treatment_art_no', $treatmentid);  
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
                die(json_encode(['status' => 'failure']));
                } 
    
}   
catch(PDOException $e){
            die(json_encode(['status' => $e->getMessage()]));
    
}

       }
       else{
try{
##Define INSERT
$stmt = "INSERT INTO beneficiarystatusupdate (hh_unique_num,beneficiaryid,surname,firstname,sex,dob,phonenumber,enrollmentdate,maritalstatus,occupation,hiv_status,datehivstatus,enrolledontreatment,artstartdate,enrollmentstatus,facilityenrolled,treatment_art_no,beneficiarytype) VALUES  (:hh_unique_num,:beneficiaryid,:surname,:firstname,:sex,:dob,:phonenumber,:enrollmentdate,:maritalstatus,:occupation,:hiv_status,:datehivstatus,:enrolledontreatment,:artstartdate,:enrollmentstatus,:facilityenrolled,:treatment_art_no,:beneficiarytype)";            
$stmt = $conn->prepare($stmt);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt->bindParam(':beneficiaryid', $beneficiaryid);           
              $stmt->bindParam(':hh_unique_num', $hhuniqueid);           
              $stmt->bindParam(':firstname', $firstname);           
              $stmt->bindParam(':surname', $surname);           
              $stmt->bindParam(':enrollmentdate', $dateofenrollment);           
              $stmt->bindParam(':dob', $dob);           
              $stmt->bindParam(':sex', $sex);           
              $stmt->bindParam(':phonenumber', $phonenumber);           
              $stmt->bindParam(':hiv_status', $currenthivstatus);           
              $stmt->bindParam(':datehivstatus', $dateofcurrenthivstatus);           
              $stmt->bindParam(':enrolledontreatment', $enrolledontreatment);           
              $stmt->bindParam(':artstartdate', $dateenrolledontreatment);           
              $stmt->bindParam(':facilityenrolled', $hivtreatmentfacility);           
              $stmt->bindParam(':occupation', $occupation);           
              $stmt->bindParam(':enrollmentstatus', $currentenrollmentstatus);               
              $stmt->bindParam(':maritalstatus', $maritalstatus);                 
              $stmt->bindParam(':beneficiarytype', $beneficiarytype);           
              $stmt->bindParam(':treatment_art_no', $treatmentid);  
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

}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>