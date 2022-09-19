<?php
session_start();
include './dbHandler.php';
// Define $myusername and $mypassword
$myusername=$_POST['email'];
$mypassword=$_POST['password'];

// To protect MySQL injection (more detail about MySQL injection)
// $myusername = stripslashes(strtolower($myusername));
// $mypassword = stripslashes($mypassword);
// $myusername = mysqli_real_escape_string($conn,$myusername);
// $mypassword = mysqli_real_escape_string($conn,$mypassword);

if (!empty($myusername) && !empty($mypassword)) {
    if($conn_status=="success"){
        $stmt = $conn->prepare("SELECT 
        u.`id`,
        u.`username`,
        u.`p_word`,
        u.`state`,
        u.`lga`,
        u.`email`,
        u.`mobilephone`,
        u.`capture_ts`,
        u.`date_reg`,
        u.`surname`,
        u.`othernames`,
        u.`facility`,
        u.`u_category`,
        u.`privilege`,
        u.`cbo_name` 
      FROM
        `user_tab` u JOIN cbo c ON(c.cbo_code=u.cbo_name)  WHERE u.email='$myusername' and u.p_word=md5('$mypassword') and u.status=1");
        $stmt->execute();  
        $recordCount = $stmt->rowCount();  
        if($recordCount == 1){
            $loginData = $stmt->fetchAll();
            foreach($loginData as $row){
                $_SESSION['surname'] = $row['surname'];
                $_SESSION['othernames'] = $row['othernames'];
                $_SESSION['state'] = $row['state'];
                $_SESSION['lga'] = $row['lga'];
                $_SESSION['cbo_name'] = $row['cbo_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['u_category'];
                $_SESSION['privilege'] = $row['privilege'];
        
            header("location:../../");            
        }
        }
        else {
            die(header("location:../../login.php?loginFailed=true&reason=password"));
        }
    }
    else{
        die(json_encode(['status' => 'connect_fail']));
    }
}
?>