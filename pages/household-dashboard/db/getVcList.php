<?php
## Database configuration
require_once("../../../controllers/db/dbHandler_mysqli.php");

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$searchArray = array();
$householdUniqueId = $_GET['householdUniqueId'];
## Search 
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (vc_unique_id like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from vcenrollment where hh_unique_num='$householdUniqueId'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from vcenrollment where hh_unique_num='$householdUniqueId' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT 
vcenrollment.`id`,
vcenrollment.`enrollment_date`,
vcenrollment.`hh_unique_num`,
vcenrollment.`vc_unique_id`,
vcenrollment.`vc_count`,
vcenrollment.`surname`,
vcenrollment.`othernames`,
CONCAT(vcenrollment.surname,' ',vcenrollment.othernames) AS name,
vcenrollment.`gender`,
vcenrollment.`dob`,
ROUND(DATEDIFF(CURDATE(),vcenrollment.DOB)/365,1) AS age,
vcenrollment.`enrollmentstream`,
vcenrollment.`enrollmentstreambasedon`,
vcenrollment.`hiv_status`,
vcenrollment.`birthcertificate`,
vcenrollment.`childinschool`,
vcenrollment.`caregiver`,
vcenrollment.`caregiverrelationshiptochild`,
vcenrollment.`reg_date`,
vcenrollment.`upd_date` ,b.status
FROM
`vcenrollment` JOIN (SELECT 
vcenrollment.`id`,
vcenrollment.`enrollment_date`,
vcenrollment.`hh_unique_num`,
vcenrollment.`vc_unique_id`,
vcenrollment.`vc_count`,
vcenrollment.`surname`,
vcenrollment.`othernames`,
CONCAT(vcenrollment.surname,' ',vcenrollment.othernames) AS name,
vcenrollment.`gender`,
vcenrollment.`dob`,
ROUND(DATEDIFF(CURDATE(),vcenrollment.DOB)/365,1) AS age,
vcenrollment.`enrollmentstream`,
vcenrollment.`enrollmentstreambasedon`,
vcenrollment.`hiv_status`,
vcenrollment.`birthcertificate`,
vcenrollment.`childinschool`,
vcenrollment.`caregiver`,
vcenrollment.`caregiverrelationshiptochild`,
vcenrollment.`reg_date`,
vcenrollment.`upd_date` ,b.status
FROM
`vcenrollment` LEFT JOIN beneficiarystatus_update b
ON vcenrollment.`vc_unique_id`=b.`vc_unique_id` AND vcenrollment.hh_unique_num='$householdUniqueId' ) b
ON vcenrollment.`vc_unique_id`=b.`vc_unique_id` AND vcenrollment.hh_unique_num='$householdUniqueId' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT 
vcenrollment.`id`,
vcenrollment.`enrollment_date`,
vcenrollment.`hh_unique_num`,
vcenrollment.`vc_unique_id`,
vcenrollment.`vc_count`,
vcenrollment.`surname`,
vcenrollment.`othernames`,
CONCAT(vcenrollment.surname,' ',vcenrollment.othernames) AS name,
vcenrollment.`gender`,
vcenrollment.`dob`,
ROUND(DATEDIFF(CURDATE(),vcenrollment.DOB)/365,1) AS age,
vcenrollment.`enrollmentstream`,
vcenrollment.`enrollmentstreambasedon`,
vcenrollment.`hiv_status`,
vcenrollment.`birthcertificate`,
vcenrollment.`childinschool`,
vcenrollment.`caregiver`,
vcenrollment.`caregiverrelationshiptochild`,
vcenrollment.`reg_date`,
vcenrollment.`upd_date` ,b.status
FROM
`vcenrollment` JOIN (SELECT 
vcenrollment.`id`,
vcenrollment.`enrollment_date`,
vcenrollment.`hh_unique_num`,
vcenrollment.`vc_unique_id`,
vcenrollment.`vc_count`,
vcenrollment.`surname`,
vcenrollment.`othernames`,
CONCAT(vcenrollment.surname,' ',vcenrollment.othernames) AS name,
vcenrollment.`gender`,
vcenrollment.`dob`,
ROUND(DATEDIFF(CURDATE(),vcenrollment.DOB)/365,1) AS age,
vcenrollment.`enrollmentstream`,
vcenrollment.`enrollmentstreambasedon`,
vcenrollment.`hiv_status`,
vcenrollment.`birthcertificate`,
vcenrollment.`childinschool`,
vcenrollment.`caregiver`,
vcenrollment.`caregiverrelationshiptochild`,
vcenrollment.`reg_date`,
vcenrollment.`upd_date` ,b.status
FROM
`vcenrollment` LEFT JOIN beneficiarystatus_update b
ON vcenrollment.`vc_unique_id`=b.`vc_unique_id` AND vcenrollment.hh_unique_num='$householdUniqueId' ) b
ON vcenrollment.`vc_unique_id`=b.`vc_unique_id` AND vcenrollment.hh_unique_num='$householdUniqueId'";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data_id = $row['id'];
    $vc_unique_id = $row['vc_unique_id'];
    $status = $row['status'];
    if($status == ''){
      $data[] = array(
         "vc_unique_id"=>"<a style='font-weight: 500' href='#'>".$vc_unique_id."</a>",
         "name"=>$row['name'],
          "enrollment_date"=>$row['enrollment_date'],
          "gender"=>$row['gender'],
          "age"=>$row['age'],
          "status"=>"Active",
          "enrollmentstream"=>$row['enrollmentstream'],
          "action"=>"<div class='btn-group'>
          <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
          <div class='dropdown-menu'>
          <a class='dropdown-item' href='../vc-dashboard?data_id=".$vc_unique_id."&query_id=".$data_id."'>Open/View</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item' data-toggle='modal' onclick='provideService(".$data_id.")' data-target='#newServicesForm' data-whatever='@mdo' href='#'>Provide OVC Services</a>
          <div class='dropdown-divider'></div>
        <a class='dropdown-item' data-toggle='modal' onclick='beneficiaryStatusUpdate(".$data_id.")' data-target='#beneficiaryStatusUpdateForm' data-whatever='@mdo' href='#'>Beneficiary Status Update</a>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick='deleteRecipient(".$data_id.")'>Delete VC</a>
          </div>
        </div>"    
       ); 
  }
    else{
      $data[] = array(
         "vc_unique_id"=>"<a style='font-weight: 500' href='#'>".$vc_unique_id."</a>",
         "name"=>$row['name'],
          "enrollment_date"=>$row['enrollment_date'],
          "gender"=>$row['gender'],
          "age"=>$row['age'],
          "status"=>$row['status'],
          "enrollmentstream"=>$row['enrollmentstream'],
          "action"=>"<div class='btn-group'>
          <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
          <div class='dropdown-menu'>
          <a class='dropdown-item' href='../vc-dashboard?data_id=".$vc_unique_id."&query_id=".$data_id."'>Open/View</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item' data-toggle='modal' onclick='provideService(".$data_id.")' data-target='#newServicesForm' data-whatever='@mdo' href='#'>Provide OVC Services</a>
          <div class='dropdown-divider'></div>
        <a class='dropdown-item' data-toggle='modal' onclick='beneficiaryStatusUpdate(".$data_id.")' data-target='#beneficiaryStatusUpdateForm' data-whatever='@mdo' href='#'>Beneficiary Status Update</a>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick='deleteRecipient(".$data_id.")'>Delete VC</a>
          </div>
        </div>"    
       ); 
  }
    }


## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>
