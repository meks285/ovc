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
    $searchQuery = " and (hhuniqueid like '%".$searchValue."%') ";
 }


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from adulthouseholdmember where hhuniqueid='$householdUniqueId'");
$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from adulthouseholdmember where hhuniqueid='$householdUniqueId' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
//$totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

## Fetch records
if(isset($searchValue) && $searchValue != ''){
    $empQuery = "SELECT 
  `id`,
  `beneficiaryid`,
  `enrollmentid`,
  `hhuniqueid`,
  `firstname`,
  `surname`,
  `dateofenrollment`,
  `dob`,
  `currentage`,
  `sex`,
  `phonenumber`,
  `baselinehivstatus`,
  `dateofbaselinehivstatus`,
  `currenthivstatus`,
  `dateofcurrenthivstatus`,
  `enrolledontreatment`,
  `dateenrolledontreatment`,
  `hivtreatmentfacility`,
  `occupation`,
  `educationlevel`,
  `currentenrollmentstatus`,
  `dateofcurrentenrollmentstatus`,
  `maritalstatus`,
  `iscaregiver`,
  `comfortabletodisclosememberhivstatus`,
  `markedfordelete`,
  `datecreated`,
  `lastmodifieddate`,
  `recordedby`,
  `beneficiaryrole`,
  `beneficiarytype`,
  `treatmentid`,
  `legacyid` 
FROM
  `adulthouseholdmember`  where hhuniqueid='$householdUniqueId' AND 1 ".$searchQuery;
}
else{
    $empQuery = "SELECT 
  `id`,
  `beneficiaryid`,
  `enrollmentid`,
  `hhuniqueid`,
  `firstname`,
  `surname`,
  `dateofenrollment`,
  `dob`,
  `currentage`,
  `sex`,
  `phonenumber`,
  `baselinehivstatus`,
  `dateofbaselinehivstatus`,
  `currenthivstatus`,
  `dateofcurrenthivstatus`,
  `enrolledontreatment`,
  `dateenrolledontreatment`,
  `hivtreatmentfacility`,
  `occupation`,
  `educationlevel`,
  `currentenrollmentstatus`,
  `dateofcurrentenrollmentstatus`,
  `maritalstatus`,
  `iscaregiver`,
  `comfortabletodisclosememberhivstatus`,
  `markedfordelete`,
  `datecreated`,
  `lastmodifieddate`,
  `recordedby`,
  `beneficiaryrole`,
  `beneficiarytype`,
  `treatmentid`,
  `legacyid` 
FROM
  `adulthouseholdmember` where hhuniqueid='$householdUniqueId'";
}
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data_id = $row['id'];
    $hhuniqueid = $row['hhuniqueid'];
         $data[] = array(
           "hhuniqueid"=>"<a style='font-weight: 500' href='#'>".$hhuniqueid."</a>",
           "beneficiary_id"=>$row['beneficiaryid'],
            "firstname"=>$row['firstname'],
            "surname"=>$row['surname'],
            "dateofenrollment"=>$row['dateofenrollment'],
            "currenthivstatus"=>$row['currenthivstatus'],
            "beneficiarytype"=>$row['beneficiarytype'],
            "action"=>"<div class='btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
            <div class='dropdown-menu'>
              <a class='dropdown-item' data-toggle='modal' onclick='updateBeneficiaryStatus(".$data_id.")' data-target='#updateCaregiverStatusFormModal' data-whatever='@mdo' href='#'>Update Beneficiary Status</a>
              <a class='dropdown-item' data-toggle='modal' onclick='accessToEmergencyFund(".$data_id.")' href='#'>Access to Emergency Form</a>
              <a class='dropdown-item' data-toggle='modal' onclick='referralForm(".$data_id.")' href='#'>Referral Form</a>
              <div class='dropdown-divider'></div>

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
