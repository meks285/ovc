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
    $searchQuery = " and (unique_id like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from services_provided where hh_unique_num='$householdUniqueId'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from services_provided where hh_unique_num='$householdUniqueId' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT service_date, unique_id, COUNT(DISTINCT domain) total_domain, COUNT(service_provided) total_services
    FROM services_provided
    where hh_unique_num='$householdUniqueId' AND category='VC'
    GROUP BY service_date, unique_id
    ORDER BY service_date DESC AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT service_date, unique_id, COUNT(DISTINCT domain) total_domain, COUNT(service_provided) total_services
    FROM services_provided
    where hh_unique_num='$householdUniqueId' AND category='VC'
    GROUP BY service_date, unique_id
    ORDER BY service_date DESC";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $vc_unique_id = $row['unique_id'];
        $data[] = array(
            "vc_unique_id"=>$vc_unique_id,
            "service_date"=>$row['service_date'],
             "total_domain"=>$row['total_domain'],
             "total_services"=>$row['total_services']
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
