<?php
require_once("../../../controllers/db/dbHandler.php");

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$searchArray = array();
$cbo_code = $_GET['cbo_code'];

## Search 
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (cbo_code like '%".$searchValue."%' or 
    unique_number like '%".$searchValue."%' or 
    hh_unique_num like'%".$searchValue."%' or 
    state like'%".$searchValue."%' or 
    lga like'%".$searchValue."%' or 
    ward like'%".$searchValue."%') ";
 }

## Total number of records without filtering
$stmt = $conn->prepare("select count(*) as allcount from hh_vulnerability_assessment where cbo_code='$cbo_code'");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("select count(*) as allcount from hh_vulnerability_assessment where cbo_code='$cbo_code' AND 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT 
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
`hh_num_people`
FROM
`hh_vulnerability_assessment`  where cbo_code='$cbo_code' ".$searchQuery." ORDER BY ID DESC LIMIT :limit,:offset");

// Bind values
foreach($searchArray as $key=>$search){
   $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$patientRecords = $stmt->fetchAll();

$data = array();
   foreach($patientRecords as $row){
    $data_id = $row['id'];
    $hh_unique_num = $row['hh_unique_num'];
         $data[] = array(
           "hh_unique_num"=>"<a style='font-weight: 500' href='#'>".$hh_unique_num."</a>",
           "state"=>$row['state'],
            "lga"=>$row['lga'],
            "ward"=>$row['ward'],
            "date_of_assessment"=>$row['date_of_assessment'],
            "address"=>$row['address'],
            "hh_num_children"=>$row['hh_num_children'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
              <a class='dropdown-item' href='../household-dashboard?data_id=".$hh_unique_num."&query_id=".$data_id."'>Open/View</a>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' href='#' onclick='deactivateRecipient(".$data_id.")'>Deactivate</a>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' style='background-color: red; color:#ffffff' href='#' onclick='deleteRecipient(".$data_id.")'>Delete Household</a>
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
