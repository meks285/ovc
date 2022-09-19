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
$sel = mysqli_query($conn,"select count(*) as allcount from communitybased_riskassessment where vc_unique_id='$vc_unique_id'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from communitybased_riskassessment where vc_unique_id='$vc_unique_id' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT id,vc_unique_id,respondent_childrelationship,childhivstatusknowledge,childhivstatus_paeds, 
    CONCAT(mainQuestion1,' ',subQuestion1_1,': ',subQuestionResponse1_1, '. ',subQuestion2_1,': ',subQuestionResponse2_1) AS Question1,
    CONCAT(mainQuestion2,' ',subQuestion1_2,': ',subQuestionResponse1_2, '. ',subQuestion2_2,': ',subQuestionResponse2_2) AS Question2,
    CONCAT(mainQuestion3,' ',subQuestion1_3,': ',subQuestionResponse1_3, '. ',subQuestion2_3,': ',subQuestionResponse2_3) AS Question3,
    reg_date assessmentDate
    FROM
      `communitybased_riskassessment` where vc_unique_id='$vc_unique_id' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT id,vc_unique_id,respondent_childrelationship,childhivstatusknowledge,childhivstatus_paeds, 
    CONCAT(mainQuestion1,' ',subQuestion1_1,': ',subQuestionResponse1_1, '. ',subQuestion2_1,': ',subQuestionResponse2_1) AS Question1,
    CONCAT(mainQuestion2,' ',subQuestion1_2,': ',subQuestionResponse1_2, '. ',subQuestion2_2,': ',subQuestionResponse2_2) AS Question2,
    CONCAT(mainQuestion3,' ',subQuestion1_3,': ',subQuestionResponse1_3, '. ',subQuestion2_3,': ',subQuestionResponse2_3) AS Question3,
    reg_date assessmentDate
    FROM
      `communitybased_riskassessment` where vc_unique_id='$vc_unique_id' order by reg_date desc";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data_id = $row['id'];
    $vc_unique_id = $row['vc_unique_id'];
         $data[] = array(
           "vc_unique_id"=>"<a style='font-weight: 500' href='#'>".$vc_unique_id."</a>",
           "respondent_childrelationship"=>$row['respondent_childrelationship'],
            "childhivstatusknowledge"=>$row['childhivstatusknowledge'],
            "childhivstatus_paeds"=>$row['childhivstatus_paeds'],
            "Question1"=>$row['Question1'],
            "Question2"=>$row['Question2'],
            "Question3"=>$row['Question3'],
            "assessmentDate"=>$row['assessmentDate'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: white; color: red' href='#' onclick='openHivRiskAssessment(".$data_id.")'>Open Assessment</a>
            <div class='dropdown-divider'></div>
            <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick='deleteCandSChecklist(".$data_id.")'>Delete Assessement</a>
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
