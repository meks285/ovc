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
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value
$service_date = $_POST['service_date'];
$unique_id = $_POST['vc_unique_id'];
## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (unique_id like '%".$searchValue."%') ";
}


## Total number of records without filtering
$sel = mysqli_query($conn,"SELECT count(*) as allcount FROM services_provided WHERE service_date='$service_date' AND unique_id='$unique_id'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"SELECT count(*) as allcount FROM services_provided WHERE service_date='$service_date' AND unique_id='$unique_id' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT service_date,unique_id, domain, GROUP_CONCAT(service_provided SEPARATOR '; ') services
                    FROM services_provided
                    WHERE service_date='$service_date' AND unique_id='$unique_id' 
                    GROUP BY service_date,unique_id, domain AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT service_date,unique_id, domain, GROUP_CONCAT(service_provided SEPARATOR '; ') services
    FROM services_provided
    WHERE service_date='$service_date' AND unique_id='$unique_id' 
    GROUP BY service_date,unique_id, domain";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
        $data[] = array(
            "service_date"=>$row['service_date'],
            "unique_id"=>$row['unique_id'],
            "domain"=>$row['domain'],
            "services"=>$row['services']
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
