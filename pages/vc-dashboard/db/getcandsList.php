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
$vc_unique_id = $_GET['vc_unique_id'];
## Search 
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (vc_unique_id like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from caresupportchecklist where vc_unique_id='$vc_unique_id'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from caresupportchecklist where vc_unique_id='$vc_unique_id' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT 
    `id`,
    `vc_unique_id`,
    `hh_unique_num`,
    (CASE WHEN responseQuestion1 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion2 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion3 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion4 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion5 = 'Yes' THEN 1 ELSE 0 END) total_yes,
    (CASE WHEN responseQuestion1 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion2 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion3 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion4 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion5 = 'No' THEN 1 ELSE 0 END) total_no,
    (CASE WHEN responseQuestion1 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion2 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion3 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion4 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion5 != '' THEN 1 ELSE 0 END) total_questions,
    `service_date`,
    `reg_date` 
  FROM
  `caresupportchecklist`   where vc_unique_id='$vc_unique_id' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT 
    `id`,
    `vc_unique_id`,
    `hh_unique_num`,
    (CASE WHEN responseQuestion1 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion2 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion3 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion4 = 'Yes' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion5 = 'Yes' THEN 1 ELSE 0 END) total_yes,
    (CASE WHEN responseQuestion1 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion2 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion3 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion4 = 'No' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion5 = 'No' THEN 1 ELSE 0 END) total_no,
    (CASE WHEN responseQuestion1 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion2 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion3 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion4 != '' THEN 1 ELSE 0 END +
    CASE WHEN responseQuestion5 != '' THEN 1 ELSE 0 END) total_questions,
    beneficiaryonart,
    `service_date`,
    `reg_date` 
  FROM
  `caresupportchecklist` where vc_unique_id='$vc_unique_id' order by reg_date desc";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data_id = $row['id'];
    $vc_unique_id = $row['vc_unique_id'];
         $data[] = array(
           "vc_unique_id"=>"<a style='font-weight: 500' href='#'>".$vc_unique_id."</a>",
           "hh_unique_num"=>$row['hh_unique_num'],
            "total_yes"=>$row['total_yes'],
            "total_no"=>$row['total_no'],
            "total_questions"=>$row['total_questions'],
            "service_date"=>$row['service_date'],
            "beneficiaryonart"=>$row['beneficiaryonart'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: #ffffff; color:red' href='#' onclick='editCandSChecklist(".$data_id.")'>Open Checklist</a>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick='deleteCandSChecklist(".$data_id.")'>Delete Checklist</a>
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
