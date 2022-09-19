<?php
require_once("../../../controllers/db/dbHandler.php");

##SET Variables
$state = $_POST['state'];
$lga=$_POST['lga'];
$cbo_code=$_POST['cbo_code'];
$username = $_POST['username'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email = $_POST['email'];
$phonenumber=$_POST['phonenumber'];
$role=$_POST['role'];
$password = $_POST['password'];

if($conn_status=="success"){
        ## Check if CBO has been registered
        $stmt = $conn->prepare("SELECT id from user_tab where username='$username' OR email='$email' or mobilephone='$phonenumber'");
        $stmt->execute();
        $recordsSelected = $stmt->rowCount();
        if($recordsSelected == 0){
            $stmt = $conn->prepare("INSERT INTO `ovc`.`user_tab` (
                `username`,
                `p_word`,
                `state`,
                `lga`,
                `email`,
                `mobilephone`,
                `surname`,
                `othernames`,
                `u_category`,
                `cbo_name`
              ) 
              VALUES
                (
                  '$username',
                  MD5('$password'),
                  '$state',
                  '$lga',
                  '$email',
                  '$phonenumber',
                  '$lastname',
                  '$firstname',
                  '$role',
                  '$cbo_code'
                )");
            $stmt->execute();
            $recordsinserted = $stmt->rowCount();
            if($recordsinserted >= 1){
              die(json_encode(['status' => 'success']));
            }
            else{
                die(json_encode(['status' => 'failure']));
            }        
        }
        else{
            die(json_encode(['status' => 'exists']));
        }        


}
else{
    die(json_encode(['status' => 'connect_fail']));
}
?>