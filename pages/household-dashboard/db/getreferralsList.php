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
$hh_unique_num = $_GET['hh_unique_num'];
## Search 
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (hh_unique_num like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from referralform where hh_unique_num='$hh_unique_num'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from referralform where hh_unique_num='$hh_unique_num' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT 
    `id`,
    `hh_unique_num`,
    `vc_unique_id`,
    `referring_organization`,
    `receiving_organization`,
    `reservicereferred`,
    `organization_providingreferral`,
    `service_provided`,
    `service_completed`,
    `followup_needed`,
    `followup_date`,
    `referral_status`,
    `referral_date`,
    `referral_receiver`,
    `referral_receiver_designation`,
    `referral_receiver_phonenumber`,
    `referral_receiver_email`,
    `reg_date` 
  FROM
    `referralform` where hh_unique_num='$hh_unique_num' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT 
    `id`,
    `hh_unique_num`,
    `vc_unique_id`,
    `referring_organization`,
    `receiving_organization`,
    `reservicereferred`,
    `organization_providingreferral`,
    `service_provided`,
    `service_completed`,
    `followup_needed`,
    `followup_date`,
    `referral_status`,
    `referral_date`,
    `referral_receiver`,
    `referral_receiver_designation`,
    `referral_receiver_phonenumber`,
    `referral_receiver_email`,
    `reg_date` 
  FROM
    `referralform` where hh_unique_num='$hh_unique_num' order by reg_date desc";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data_id = $row['id'];
    $vc_unique_id = $row['vc_unique_id'];
    $referral_date = $row['referral_date'];
    $combine_id_date = $vc_unique_id.",".$referral_date;
         $data[] = array(
           "vc_unique_id"=>"<a style='font-weight: 500' href='#'>".$vc_unique_id."</a>",
           "referring_organization"=>$row['referring_organization'],
            "receiving_organization"=>$row['receiving_organization'],
            "reservicereferred"=>$row['reservicereferred'],
            "service_provided"=>$row['service_provided'],
            "service_completed"=>$row['service_completed'],
            "followup_needed"=>$row['followup_needed'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: white; color:red' href='#' onclick=\"openReferralsChecklist('$vc_unique_id','$referral_date')\">Open Checklist</a>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick=\"deleteReferralsChecklist('$combine_id_date')\">Delete Checklist</a>
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
