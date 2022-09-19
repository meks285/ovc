<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

$vc_unique_id = $_POST['vcUniqueId'];

$query = "SELECT 
  o.`id`,
  o.`unique_id`,
  o.`hiv_status`,
  o.`date_hivstatus`,
  o.`enrolledontreatment`,
  o.`facilityenrolled`,
  o.`artstartdate`,
  o.`treatment_art_no`,
  o.`childhasbirthcertificate`,
  o.`childinschool`,
  o.`schoolname`,
  o.`schoolgrade`,
  o.`childonvocationaltraining`,
  o.`vocationalinstitute`,
  o.`caregivername`,
  o.`enrollmentstatus`,
  o.`enrollmentstatus_date`,
  o.`reg_date` , CONCAT(v.surname,' ',v.othernames) AS name,
  v.`gender`,
  v.`dob`,ROUND(DATEDIFF(CURDATE(),v.DOB)/365,1) AS age
FROM
  `ovcstatusupdate` o JOIN vcenrollment v ON (o.`unique_id`=v.`vc_unique_id`) WHERE unique_id='$vc_unique_id' ORDER BY id DESC LIMIT 1";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) >= 1){
die(json_encode(['vc_unique_id' => $row['unique_id'],
                'hiv_status' =>$row['hiv_status'],
                'date_hivstatus' =>$row['date_hivstatus'],
                'enrolledontreatment' => $row['enrolledontreatment'],
                'facilityenrolled' => $row['facilityenrolled'],
                'artstartdate' => $row['artstartdate'],
                 'treatment_art_no' => $row['treatment_art_no'],
                 'childhasbirthcertificate' =>$row['childhasbirthcertificate'],
                 'childinschool' => $row['childinschool'],
                 'schoolname' => $row['schoolname'],
                 'schoolgrade' => $row['schoolgrade'],
                 'childonvocationaltraining' => $row['childonvocationaltraining'],
                 'vocationalinstitute' => $row['vocationalinstitute'],
                 'caregivername' => $row['caregivername'],
                 'enrollmentstatus' => $row['enrollmentstatus'],
                 'enrollmentstatus_date' => $row['enrollmentstatus_date'],
                 'name' => $row['name'],
                 'gender' => $row['gender'],
                 'age' => $row['age'],
                 'status'=> 'success'
]));
}
else{
    die(json_encode(['status' => 'no_rows']));
}

?>