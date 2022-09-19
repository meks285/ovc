<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

$vc_unique_id = $_POST['vcUniqueId'];

$query = "SELECT 
vc.`id`,
vc.`enrollment_date`,
vc.`hh_unique_num`,
vc.`vc_unique_id`,
vc.`surname`,
vc.`othernames`,
CONCAT(vc.surname,' ',vc.othernames) AS name,
vc.`gender`,
vc.`dob`,
ROUND(DATEDIFF(CURDATE(),vc.DOB)/365,1) AS age,
vc.`enrollmentstream`,
vc.`enrollmentstreambasedon`,
u.`hiv_status`,
u.`date_hivstatus`,
u.`enrolledontreatment`,
u.`facilityenrolled`,
u.`artstartdate`,
u.`childhasbirthcertificate`,
u.`childinschool`,
u.`schoolname`,
u.`schoolgrade`,
u.`caregivername`,
u.`childonvocationaltraining`,
u.`vocationalinstitute`,u.enrollmentstatus status
FROM
`vcenrollment` vc JOIN ovcstatusupdate u
ON vc.`vc_unique_id`=u.`unique_id`  WHERE vc.vc_unique_id='$vc_unique_id' ORDER BY u.id DESC LIMIT 1";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) >= 1){
die(json_encode(['enrollment_date' => $row['enrollment_date'],
                'hh_unique_num' =>$row['hh_unique_num'],
                'vc_unique_id' =>$row['vc_unique_id'],
                'name' => $row['name'],
                'gender' => $row['gender'],
                'dob' => $row['dob'],
                 'age' => $row['age'],
                 'enrollmentstream' =>$row['enrollmentstream'],
                 'enrollmentstreambasedon' => $row['enrollmentstreambasedon'],
                 'hiv_status' => $row['hiv_status'],
                 'datehivstatus' => $row['date_hivstatus'],
                 'enrolledontreatment' => $row['enrolledontreatment'],
                 'facilityenrolled' => $row['facilityenrolled'],
                 'artstartdate' => $row['artstartdate'],
                 'schoolname' => $row['schoolname'],
                 'schoolgrade' => $row['schoolgrade'],
                 'birthcertificate' => $row['childhasbirthcertificate'],
                 'childinschool' => $row['childinschool'],
                 'vocationalinstitute' => $row['vocationalinstitute'],
                 'childonvocationaltraining' => $row['childonvocationaltraining'],
                 'caregiver' => $row['caregivername'],
                 'vc_status' => $row['status'],
                 'status'=> 'success'
]));
}
else{
    die(json_encode(['status' => 'no_rows']));
}

?>