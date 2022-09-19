<?php
require_once("../../../controllers/db/dbHandler_mysqli.php");

$hh_unique_num = $_POST['householdUniqueId'];

$query = "SELECT 
`id`,
`cbo_code`,
`date_of_assessment`,
`state`,
`lga`,
`ward`,
`community`,
`unique_number`,
`hh_unique_num`,
`address`,
`hh_num_children`,
`hh_num_people`,
`surname`,
`firstname`,
`gender`,
`dob`,
`phonenumber`,
`marital_status`,
`occupation`,
`hiv_status`,
`reviewedby`,
`accessedby`,
`date_accessed`,
`reviewdate`,
`total_yes`,
`total_no`,
`total_na` 
FROM
`hh_vulnerability_assessment`  WHERE hh_unique_num='$hh_unique_num'";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) >= 1){
die(json_encode(['marital_status' => $row['marital_status'],
                'date_of_assessment' =>$row['date_of_assessment'],
                'phonenumber' =>$row['phonenumber'],
                'state' => $row['state'],
                'dob' => $row['dob'],
                'occupation' => $row['occupation'],
                 'hh_unique_num' => $row['hh_unique_num'],
                 'lga' =>$row['lga'],
                 'ward' => $row['ward'],
                 'community' => $row['community'],
                 'hh_num_children' => $row['hh_num_children'],
                 'surname' => $row['surname'],
                 'firstname' => $row['firstname'],
                 'gender' => $row['gender'],
                 'cbo_code' => $row['cbo_code'],
                 'status'=> 'success'
]));
}
else{
    die(json_encode(['status' => 'no_rows']));
}

?>