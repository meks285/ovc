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
$cbo_code = $_GET['cbo_code'];
## Search 
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (cbo_name like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from user_tab where cbo_name='$cbo_code'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from user_tab where cbo_name='$cbo_code' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT u.id, u.username,u.state,u.lga,u.email,u.surname,u.othernames,u.u_category AS role,u.privilege AS privilege,c.cbo_name AS cbo_name,u.status
FROM user_tab u JOIN cbo c
ON(u.cbo_name=c.cbo_code)
where u.cbo_name='$cbo_code' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT u.id, u.username,u.state,u.lga,u.email,u.surname,u.othernames,u.u_category AS role,u.privilege AS privilege,c.cbo_name AS cbo_name,u.status
FROM user_tab u JOIN cbo c
ON(u.cbo_name=c.cbo_code)
where u.cbo_name='$cbo_code' ";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $username = $row['username'];
    $data_id = $row['id'];
    $status = $row['status'];
    if($status==1){
         $data[] = array(
           "status"=>"<a style='font-weight: 500; color: green' href='#' >ACTIVE</a>",
           "username"=>"<a style='font-weight: 500' href='#'>".$username."</a>",
           "state"=>$row['state'],
            "lga"=>$row['lga'],
            "email"=>$row['email'],
            "surname"=>$row['surname'],
            "othernames"=>$row['othernames'],
            "role"=>$row['role'],
            "rights"=>$row['privilege'],
            "cbo_name"=>$row['cbo_name'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' href='#' onclick='deactivateRecipient(".$data_id.")'>Deactivate</a>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' href='#' style='background-color: red' onclick='deleteUser(".$data_id.")'>Delete User</a>
            </div>
          </div>"    
         );         
    }
    else{
         $data[] = array(
           "status"=>"<a style='font-weight: 500; color: read' href='#' >DISABLED</a>",
           "username"=>"<a style='font-weight: 500' href='#'>".$username."</a>",
           "state"=>$row['state'],
            "lga"=>$row['lga'],
            "email"=>$row['email'],
            "surname"=>$row['surname'],
            "othernames"=>$row['othernames'],
            "role"=>$row['role'],
            "rights"=>$row['privilege'],
            "cbo_name"=>$row['cbo_name'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' href='#' onclick='activateRecipient(".$data_id.")'>Activate</a>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' style='background-color: red' href='#'  onclick='deleteUser(".$data_id.")'>Delete User</a>
              
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
