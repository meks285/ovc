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
    $searchQuery = " and (hh_unique_num like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from consent where hh_unique_num='$householdUniqueId'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from consent where hh_unique_num='$householdUniqueId' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT 
    `id`,
    `hh_unique_num`,
    `caregiver`,
    `community`,
    `ward`,
    `lga`,
    `state`,
    `ip`,
    `cbo_code`,
    `supporting_ip`,
    `donor`,
    `consentQuestion1`,
    `responseQuestion1`,
    `consentQuestion2`,
    `responseQuestion2`,
    `consentQuestion3`,
    `responseQuestion3`,
    `consentQuestion4`,
    `responseQuestion4`,
    `consentQuestion5`,
    `responseQuestion5`,
    `hh_caregiver_signature`,
    `hh_caregiver_phone`,
    `hh_caregiver_sign_date`,
    `household_witness`,
    `hh_witness_signature`,
    `hh_witness_phone`,
    `hh_witness_sign_date`,
    `reg_date` 
    FROM
    `consent` where hh_unique_num='$householdUniqueId' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT 
    `id`,
    `hh_unique_num`,
    `caregiver`,
    `community`,
    `ward`,
    `lga`,
    `state`,
    `ip`,
    `cbo_code`,
    `supporting_ip`,
    `donor`,
    `consentQuestion1`,
    `responseQuestion1`,
    `consentQuestion2`,
    `responseQuestion2`,
    `consentQuestion3`,
    `responseQuestion3`,
    `consentQuestion4`,
    `responseQuestion4`,
    `consentQuestion5`,
    `responseQuestion5`,
    `hh_caregiver_signature`,
    `hh_caregiver_phone`,
    `hh_caregiver_sign_date`,
    `household_witness`,
    `hh_witness_signature`,
    `hh_witness_phone`,
    `hh_witness_sign_date`,
    `reg_date` 
    FROM
    `consent` where hh_unique_num='$householdUniqueId'";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data_id = $row['id'];
    $hh_unique_num = $row['hh_unique_num'];
         $data[] = array(
           "hh_unique_num"=>"<a style='font-weight: 500' href='#'>".$hh_unique_num."</a>",
           "caregiver"=>$row['caregiver'],
            "ip"=>$row['ip'],
            "cbo_code"=>$row['cbo_code'],
            "donor"=>$row['donor'],
            "household_witness"=>$row['household_witness'],
            "hh_caregiver_sign_date"=>$row['hh_caregiver_sign_date'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
              <a class='dropdown-item' data-toggle='modal' onclick='provideService(".$data_id.")' data-target='#newServicesForm' data-whatever='@mdo' href='#'>View Consent</a>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick='deleteRecipient(".$data_id.")'>Delete Consent</a>
            </div>
          </div>"    
         ); 
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
