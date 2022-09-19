<?php
ob_start();
session_start();

$surname = $_SESSION['surname'];
$othernames = $_SESSION['othernames'];
$state = $_SESSION['state'];
$lga = $_SESSION['lga'];
$cbo_name = $_SESSION['cbo_name'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$current_page = 'household_vulenerability_assessment_form';
if(!isset($email) || !isset($cbo_name)){
    session_destroy();
    die(header("location:../../login.php?loginFailed=true&reason=session_timeout"));
}
if($role=='Owner'){
    $isOwner=true;
}
else{
    $isOwner=false;
}
/* This will give an error. Note the output
 * above, which is before the header() call */
 include_once("../../controllers/db/dbHandler_mysqli.php");
 include '../../controllers/version.php';

?>
<!doctype html>
<html lang="en">
<head>
  	<title>User Setup | OVC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/style.css">
		<link rel="stylesheet" href="./css/styles.css">
<!-- Toastify -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>		
<script src="./js/loadStates.js"></script>		
<script src="./js/functions.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
                <li class="active"><a href="#"><span style="font-weight: 600;">User Setup</span></a></li>
                <?php
                    if($isOwner){
                        echo '<li><a href="#">Domain Setup</a></li>';
                        echo '<li><a href="#">Organisation Unit</a></li>';
                        echo '<li><a href="../cbo-setup">CBO Project Setup</a></li>';
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
			<hr/>
				<span style="font-size: 12px"><i><?php echo $email.'/'.$role; ?></i></span>
	        </ul>


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

			<h2 class="mb-4">User Setup</h2>
			<hr/>
			<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
				<!-- Page Information starts here -->
				<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger">Provide User Information </div>								
							<div class="row">
								<div class="col-md-6">
								<div class="form-group first" style="margin-left: 5px;">
									<label>State<span class="required">*</span></label>
									<select id="state" name="state" class="form-select" style="width: 100%">
										<?php
										$sql = "SELECT DISTINCT state FROM state_lga_ward where state='$state' ORDER BY state ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option selected value="<?php echo $row['state'] ?>"><?php echo $row['state'] ?></option>
									<?php } ?>
									</select>
									<div class="text-danger" id="state_label"></div>
								</div>    
								</div>
								<div class="col-md-6">
									<div class="form-group first" style="margin-right: 5px;">
									<label>Local Government<span class="required">*</span></label>
									<select name="lga" id="lga" class="selectpicker form-select w-100 border border-gray" multiple data-live-search="true" style="width: 100%">
										<?php
										$sql = "SELECT DISTINCT lga FROM state_lga_ward where state='$state' ORDER BY lga ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['lga'] ?>"><?php echo $row['lga'] ?></option>
									<?php } ?>									    
									</select>
									<div class="text-danger" id="lga_label"></div> 
									</div>    
									</div>
							  </div>
							  <div class="row">
								<div class="col-md-6">
									<div class="form-group first" style="margin-left: 5px;">
									<label>CBO<span class="required">*</span></label>
									<select name="cbo_code" id="cbo_code" class="form-select" style="width: 100%">
									<option disabled selected>Select CBO</option>
										<?php
										$sql = "SELECT DISTINCT cbo_code FROM cbo where cbo_code='$cbo_name' ORDER BY cbo_code ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['cbo_code'] ?>"><?php echo $row['cbo_code'] ?></option>
									<?php } ?>									
									</select>
									<div class="text-danger" id="cbo_code_label"></div>
									</div>    
								</div>
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Username<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="username" id="username" class="form-control" />
									<div class="text-danger" id="username_label"></div>
									</div>
								</div>									
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group first" style="margin-left: 5px;">
									<label>First Name<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="firstname" id="firstname" class="form-control" />
									<div class="text-danger" id="firstname_label"></div>
									</div>    
								</div>
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Last Name<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="lastname" id="lastname" class="form-control" />
									<div class="text-danger" id="lastname_label"></div>
									</div>
								</div>									
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group first" style="margin-left: 5px;">
									<label>email<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="email" id="email" class="form-control" />
									<div class="text-danger" id="email_chk_label"></div>
									</div>    
								</div>
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Phonenumber<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="phonenumber" id="phonenumber" class="form-control" />
									<div class="text-danger" id="phonenumber_label"></div>
									</div>
								</div>									
							</div>
							<div class="row">
							<div class="col-md-6">             
							<div class="form-group last mb-3" style="margin-right: 5px; margin-left: 5px">
								<label>User Role<span class="required">*</span></label>
								<select name="role" id="role" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='user_role' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>								
								<div class="text-danger" id="role_label"></div>
							</div>
							</div> 							
							<div class="col-md-6">             
							<div class="form-group last mb-3" style="margin-right: 5px; margin-left: 5px">
								<label>Rights & Privileges<span class="required">*</span></label>
								<select name="privilege" id="privilege" class="selectpicker form-select w-100 border border-gray" multiple data-live-search="true"  style="width: 100%">
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='rights_privileges' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>								
								<div class="text-danger" id="privilege_label"></div>
							</div>
							</div> 							
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group first" style="margin-left: 5px;">
									<label>Password<span class="required">*</span></label>
									<input autocomplete="off" type="password" name="password" id="password" class="form-control border border-gray" />
									<div class="text-danger" id="password_label"></div>
									</div>    
								</div>
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Repeat Password<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="password" name="rpt_password" id="rpt_password" class="form-control border border-gray" />
									<div class="text-danger" id="rpt_password_chk_label"></div>
									</div>
								</div>									
							</div>
							</div>
							  <button type="submit" id="buttonSubmit" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>
				
				
				
				</div>		  </div>
</div>

    <script src="../../js/popper.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/main.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>	
  </body>
</html>