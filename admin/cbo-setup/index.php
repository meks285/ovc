<?php
ob_start();
session_start();

$surname = $_SESSION['surname'];
$othernames = $_SESSION['othernames'];
$state = $_SESSION['state'];
$lga = $_SESSION['lga'];
$cbo_name = $_SESSION['cbo_name'];
$email = $_SESSION['email'];
$current_page = 'household_vulenerability_assessment_form';
$role = $_SESSION['role'];

if(!isset($email) || !isset($cbo_name)){
    session_destroy();
    die(header("location:../../login.php?loginFailed=true&reason=session_timeout"));
}
/* This will give an error. Note the output
 * above, which is before the header() call */
 include_once("../../controllers/db/dbHandler_mysqli.php");
 include '../../controllers/version.php';
?>
<!doctype html>
<html lang="en">
<head>
  	<title>CBO Project Setup | OVC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/style.css">
		<link rel="stylesheet" href="./css/styles.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>		
<script src="./js/functions.js"></script>		
</head>
<body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
				<div class="p-4 pt-5">
		  		<h1 style="margin-bottom: 0px;"><a href="index.html" class="logo">eOVC</a></h1>
				<span style="font-size: 12px"><i>Electronic Platform for Orphans and Vulnerable Children.</i></span>
				<hr/>

	        <ul class="list-unstyled components mb-5">
	          <li>
	              <a href="../../">Home</a>
	          </li>
	          <li>
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">HouseHold</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
					<li>
						<a href="../../pages/household-list">HouseHold List</a>
					</li>
					<li>
						<a href="../../pages/household-vulnerability-assessment">New HouseHold Vulnerability Assessment</a>
					</li>
				</ul>
	          </li>			  
			  <li>
              <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span style="font-weight: 600;">Administration</span></a>
              <ul class="list-unstyled" id="adminSubmenu">
                <li><a href="../user-setup">User Setup</a></li>
                <?php
                    if($isOwner){
                        echo '<li><a href="#">Domain Setup</a></li>';
                        echo '<li><a href="#">Organisation Unit</a></li>';
                        echo '<li class="Active"><a href="../cbo-setup">CBO Project Setup</a></li>';
                    }   
                    else if($role=='System Administrator' || $privilege=='Admin'){
                        echo '<li><a href="../../admin/users-list">Users List</a></li>';                        
                        echo '<li><a href="../../admin/wards">Wards</a></li>';                        
                        echo '<li><a href="../../admin/schools">Schools</a></li>';                        
                    }                         
                ?>
              </ul>
	          </li>
	          <li>
              <a class="btn btn-primary" href="https://ovc.apin.org.ng/?rr=sign-out">Sign-Out</a>
	          </li>
	        </ul>
			<hr/>
				<span style="font-size: 12px"><i><?php echo $email.'/'.$role; ?></i></span>
				<hr/>

<!-- 	        <div class="mb-5">
						<h3 class="h6">Subscribe for newsletter</h3>
						<form action="#" class="colorlib-subscribe-form">
	            <div class="form-group d-flex">
	            	<div class="icon"><span class="icon-paper-plane"></span></div>
	              <input type="text" class="form-control" placeholder="Enter Email Address">
	            </div>
	          </form>
					</div> -->

	        <div class="footer">
	        	<p>
					<a href="https://apin.org.ng" target="_blank">APIN</a>   &copy;<script>document.write(new Date().getFullYear());</script>
				</p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
		<div id="content" class="p-4 p-md-5 pt-5">

			<h2 class="mb-4">CBO Project Setup</h2>
			<hr/>
			<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
				<!-- Page Information starts here -->
				<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger">CBO Details</div>	
							  <div class="row">
							  <div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Name<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cbo_name" id="cbo_name" class="form-control" />
									<div class="text-danger" id="cbo_name_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>CBO Code<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cbo_code" id="cbo_code" class="form-control" />
									<div class="text-danger" id="cbo_code_label"></div>
									</div>
								</div>									
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
									<label>Other Details<span class="required">*</span></label>
									<textarea name="cbo_details" id="cbo_details" class="form-select" style="width: 100%"></textarea>
									<div class="text-danger" id="cbo_details_label"></div>
									</div>    
								</div>								
							</div>
							</div>
							  <button type="submit" id="buttonSubmit" class="btn px-5 btn-primary" style="margin-top: 5px">Submit</button>
							</form>
						  </div>
						</div>
					  </div>			
				</div>		  
			</div>
</div>

    <script src="../../js/popper.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/main.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  </body>
</html>