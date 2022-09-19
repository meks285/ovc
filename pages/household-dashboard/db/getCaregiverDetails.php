<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

$caregiverid = $_POST['caregiverid'];

$query = "SELECT 
  `id`,
  `beneficiaryid`,
  `enrollmentid`,
  `hhuniqueid`,
  `firstname`,
  `surname`,
  `dateofenrollment`,
  `dob`,
  `currentage`,
  `sex`,
  `phonenumber`,
  `baselinehivstatus`,
  `dateofbaselinehivstatus`,
  `currenthivstatus`,
  `dateofcurrenthivstatus`,
  `enrolledontreatment`,
  `dateenrolledontreatment`,
  `hivtreatmentfacility`,
  `occupation`,
  `educationlevel`,
  `currentenrollmentstatus`,
  `dateofcurrentenrollmentstatus`,
  `maritalstatus`,
  `iscaregiver`,
  `comfortabletodisclosememberhivstatus`,
  `markedfordelete`,
  `datecreated`,
  `lastmodifieddate`,
  `recordedby`,
  `beneficiaryrole`,
  `beneficiarytype`,
  `treatmentid`,
  `legacyid` 
FROM
  `adulthouseholdmember` WHERE beneficiaryid='$caregiverid'";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) >= 1){
die(json_encode(['beneficiaryid' => $row['beneficiaryid'],
                'id' =>$row['id'],
                 'status'=> 'success'
]));
}
else{
    die(json_encode(['status' => 'no_rows']));
}

?>