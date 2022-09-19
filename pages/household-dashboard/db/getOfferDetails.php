<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

$treatment_art_no = $_POST['treatment_art_no'];

$query = "SELECT 
  `id`,
  `treatment_art_no`,
  `artstartdate`,
  `clientname`,
  `facilityname`,
  `consentQuestion1`,
  `responseQuestion1`,
  `consentQuestion2`,
  `responseQuestion2`,
  `phonenumberOfferForm`,
  `caregiver_name`,
  `caregiver_signature`,
  `caregiver_date`,
  `facility_staff_name`,
  `facility_staff_signature`,
  `facility_staff_date`,
  `reg_date` 
FROM
  `ovcoffer` 
WHERE treatment_art_no='$treatment_art_no'";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) >= 1){
die(json_encode(['treatment_art_no' => $row['treatment_art_no'],
                'artstartdate' =>$row['artstartdate'],
                'clientname' =>$row['clientname'],
                'facilityname' => $row['facilityname'],
                'caregiver_name' => $row['caregiver_name'],
                'occupation' => $row['occupation'],
                 'caregiver_signature' => $row['caregiver_signature'],
                 'caregiver_date' =>$row['caregiver_date'],
                 'status'=> 'success'
]));
}
else{
    die(json_encode(['status' => 'no_rows']));
}

?>