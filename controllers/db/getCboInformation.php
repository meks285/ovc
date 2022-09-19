<?php
## Database configuration
require_once("./dbHandler_mysqli.php");

$cbo_id = $_POST['cbo_id'];
$sql = "SELECT 
uniqueid AS `id`,
`cbo_name`,
`cbo_code`,
`address` as cbo_details,
`datecreated` as reg_date 
FROM
`cbo`  WHERE cbo_code='$cbo_id'";
$result =  mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) == 1){
    die(json_encode([
                        'cbo_name' => $row['cbo_name'],
                        'status'=> 'success'
                    ]));
}
else{
    die(json_encode(['status' => 'error_data']));
}
?>
