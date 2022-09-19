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
$privilege = $_SESSION['privilege'];
$current_page = 'household_dashboard';
$data_id = $_GET['data_id'];
$query_id= $_GET['query_id'];
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
 $sql = "SELECT hh_unique_num FROM hh_vulnerability_assessment WHERE hh_unique_num ='$data_id' and id='$query_id'";
 $result = mysqli_query($conn, $sql);
 $rows = mysqli_num_rows($result);
 if($rows == 0){
	echo '<script>alert("Not Permitted!")</script>';
    die(header("location:../../login.php?loginFailed=true&reason=forbidden"));
 }
 else{
	$householdUniqueId = $data_id;
 }
?>
<!doctype html>
<html lang="en">
<head>
  	<title>Household Dashboard | OVC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/style.css">
		<link rel="stylesheet" href="./css/styles.css">

<!-- Toastify Library -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Datatable CSS -->
<link href='https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

<!-- Datatable Responsive CSS -->
<link href='https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css' rel='stylesheet' type='text/css'>
<!-- Style CSS -->
<!-- <link href='../../assets/css/style.bundle.css' rel='stylesheet' type='text/css'> -->

<!-- Datatable JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<!-- Datatable Responsive JS -->
<script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>	
<!-- Inhouse JS -->
<script src="./js/householddashboard.js"></script>
<script src="./js/vclist.js"></script>
<script src="./js/vcServicesBreakdown.js"></script>
<script src="./js/actions.js"></script>
<script src="./js/consentform.js"></script>
<script src="./js/consentList.js"></script>
<script src="./js/caregiverList.js"></script>
<script src="./js/beneficiaryStatusUpdate.js"></script>
<script src="./js/caregiversForm.js"></script>
<script src="./js/loadStates.js"></script>
<script src="./js/caregiverAccessEmergencyList.js"></script>
<script src="../../controllers/handler/treatment_no_chk.js"></script>
<script src="./js/referralFunctions.js"></script>
<script src="./js/referralsList.js"></script>
<script>
    householdUniqueId = "<?php echo $householdUniqueId; ?>";
    privilege = "<?php echo $privilege; ?>";
</script>
<!-- Favicon -->
<link rel="shortcut icon" href="../../assets/media/logos/favicon.ico" />
<style type='text/css'>
    td.details-control{
        text-align: center;
        color: forestgreen !important;
        cursor: pointer;
    }
    tr.shown td.details-control{
        text-align: center;
        color: red !important;
    }
    i.details-control{
        color: forestgreen !important;
    }
</style>	
</head>
<body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="menuHidden">
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
	          <li class="active">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle"><span style="font-weight: 600;">HouseHold<span style="font-size: 10px;" class="btn btn-primary">Dashboard</span></span></a>
	            <ul class="list-unstyled" id="homeSubmenu">
					<li>
						<a href="../household-list">HouseHold List</a>
					</li>
					<li>
						<a href="../household-vulnerability-assessment">New HouseHold Vulnerability Assessment</a>
					</li>
				</ul>
	          </li>			
			  <li>
              <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Administration</a>
              <ul class="collapse list-unstyled" id="adminSubmenu">
                <li><a href="../../admin/user-setup">User Setup</a></li>
                <?php
                    if($isOwner){
                        echo '<li><a href="#">Domain Setup</a></li>';
                        echo '<li><a href="#">Organisation Unit</a></li>';
                        echo '<li><a href="../cbo-setup">CBO Project Setup</a></li>';
                    }     
                    else if($role=='System Administrator' || $privilege=='Admin'){
                        echo '<li><a href="../../admin/users-list">Users List</a></li>';                        
                        echo '<li><a href="../../admin/wards">Wards</a></li>';                        
                        echo '<li><a href="../../admin/Schools">Schools</a></li>';                        
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

			<h2 class="mb-4">HouseHold Dashboard: <span class="btn btn-primary"><?php echo $householdUniqueId; ?></span></h2>
			<hr/>
			<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">

<div class="row">
<div class="col-md-4">             
		<div class="card text-white bg-danger mb-3" style="width: 100%;">
		<div class="card-header">HouseHold Details</div>
		<div class="card-body">
			<!-- <h5 class="card-title">Primary card title</h5> -->
			<p class="card-text"><span style="font-weight: 600;">HouseHold ID: </span><span style="color: white;" id="hh_id"></span></p>
			<span style="font-weight: 600;">Address: </span><span style="color: white;" id="address"></span><br/>
			<span style="font-weight: 600;">State: </span><span style="color: white;" id="state"></span>
			<span style="font-weight: 600;">LGA: </span><span style="color: white;" id="lga"></span><br/>
			<span style="font-weight: 600;">Ward: </span><span style="color: white;" id="ward"></span>
			<span style="font-weight: 600;">Community: </span><span style="color: white;" id="community"></span><br/>
			<span style="font-weight: 600;">Assessment Date: </span><span style="color: white;" id="assessdate"></span>
			</p>
			<hr/>
			<p class="card-text"><span style="font-weight: 600;">HouseHold Caregiver: </span><span style="color: white;" id="caregiver"></span><br/>
			<span style="font-weight: 600;">Phonenumber: </span><span style="color: white;" id="phonenumber"></span><br/>
			<span style="font-weight: 600;">Sex: </span><span style="color: white;" id="sex"></span>
			<span style="font-weight: 600;">Age: </span><span style="color: white;" id="age"></span><br/>
			<span style="font-weight: 600;">Marital Status: </span><span style="color: white;" id="marital_status"></span>
			<span style="font-weight: 600;">Occupation: </span><span style="color: white;" id="occupation"></span>
			</p>
		</div>
		</div>
	</div>
	<div class="col-md-8">             
	<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white">VULNERABLE CHILDREN<button type="button" id="addVC" style="margin-left: 5px" class="btn btn-primary" data-toggle="modal" data-target="#newVcModal" data-whatever="@mdo">Add VC</button></div>
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='vcListTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>Actions</th>
									<th>VC Unique ID</th>
									<th>Name</th>
									<th>EnrollDate</th>
									<th>Gender</th>
									<th>Age</th>
									<th>EnrollmentStream</th>
									<th>Status</th>
								</tr>
								</thead>
							</table>
				</div>
			<!--end::Content-->
		</div>
		</div>
	</div>
</div>
<div class="row">
<div class="col-md-12">   
<div id="accordion">	      
<div class="card text-black bg-info mb-3" style="width: 100%;">
		<div class="card-header text-white"  id="caregiverListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecaregiverListTable" aria-expanded="false" aria-controls="collapsecaregiverListTable">
		CAREGIVERS/ADULT HH MEMBERS </button>
		<div class='btn-group'>
          <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span style='margin-right: 15px'>Actions</span></button>
          <div class='dropdown-menu'>
          <a class='dropdown-item' id='newCaregiverLaunchModalButton' data-toggle='modal' data-target='#newCaregiverFormModal' data-whatever='@mdo' href='#'>New</a>
          <div class='dropdown-divider'></div>

          </div>
        </div></div>
		<div id="collapsecaregiverListTable" class="collapse" aria-labelledby="caregiverListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='caregiverTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th></th>
									<th>HouseHold ID</th>
									<th>Beneficiary ID</th>
									<th>Surname</th>
									<th>First name</th>
									<th>Date of Enrollment</th>
									<th>HIV Status</th>
									<th>Beneficiary Type</th>
								</tr>
								</thead>
							</table>
				</div>
			<!--end::Content-->
		</div>
</div>
		</div>   
</div> 
</div>
</div>	
<div class="row">
<div class="col-md-12">   
<div id="accordion">	      
<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white"  id="consentFormListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentFormListTable" aria-expanded="false" aria-controls="collapseconsentFormListTable">
		CONSENT FORM </button>
		<button type="button" id="addConsent" class="btn btn-primary" style="margin-left: 5px" data-toggle="modal" data-target="#newConsentFormModal" data-whatever="@mdo">ADD CONSENT</button></div>
		<div id="collapseconsentFormListTable" class="collapse" aria-labelledby="consentFormListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='hhConsentTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>HouseHold ID</th>
									<th>Caregiver</th>
									<th>IP</th>
									<th>CBO</th>
									<th>Donor</th>
									<th>Witness</th>
									<th>Date</th>
									<th></th>
								</tr>
								</thead>
							</table>
				</div>
			<!--end::Content-->
		</div>
</div>
		</div>   
</div> 
</div>
</div>	
<div class="row">
<div class="col-md-12">  
<div id="accordion">
<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white" id="servicesListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseservicesListTable" aria-expanded="true" aria-controls="collapseservicesListTable">
		OVC SERVICES (service form) 
								</button>
			
		</div>
		<div id="collapseservicesListTable" class="collapse" aria-labelledby="servicesListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='vcServicesTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th></th>
									<th>VC Unique ID</th>
									<th>Service Date</th>
									<th>Total Domains</th>
									<th>Total Services</th>
								</tr>
								</thead>
							</table>
				</div>
			<!--end::Content-->
		</div>
</div>
		</div>  
</div>  
</div>
</div>				
<div class="row">
<div class="col-md-12">  
<div id="accordion">
<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white" id="caregiverAccessEmergencyListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecaregiverAccessEmergencyListTable" aria-expanded="true" aria-controls="collapsecaregiverAccessEmergencyListTable">
		Caregiver Access To Emergency Fund
		</button>
			
		</div>
		<div id="collapsecaregiverAccessEmergencyListTable" class="collapse show" aria-labelledby="caregiverAccessEmergencyListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='caregiverAccessEmergencyTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>Household ID</th>
									<th>Unique ID</th>
									<th>Date</th>
									<th>Question</th>
									<th>Answer</th>
									<th></th>
								</tr>
								</thead>
							</table>
				</div>
			<!--end::Content-->
		</div>
</div>
		</div>  
</div>  
</div>
</div>				
<div class="row">
<div class="col-md-12">  
<div id="accordion">
<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white" id="referralsListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsereferralsListTable" aria-expanded="true" aria-controls="collapsereferralsListTable">
		Referrals
		</button>
			
		</div>
		<div id="collapsereferralsListTable" class="collapse show" aria-labelledby="referralsListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='referralsTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th></th>
									<th>Unique ID</th>
									<th>Referring Org</th>
									<th>Receiving Org</th>
									<th>Services</th>
									<th>Service Provided</th>
									<th>Service Completed?</th>
									<th>Follow Needed?</th>
								</tr>
								</thead>
							</table>
				</div>
			<!--end::Content-->
		</div>
</div>
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
<!-- NEW VULNERABLE CHILDREN MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newVcModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header">New VC Enrollment<button id="modalExitButton" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="enrollmentSettings">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseenrollmentSettings" aria-expanded="true" aria-controls="collapseenrollmentSettings">
								Enrollment Settings 
								</button>
							</h5>
							</div>	
							<div id="collapseenrollmentSettings" class="collapse show" aria-labelledby="enrollmentSettings" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Client Enrollment Setting<span class="required">*</span></label>
									<select name="enrollment_setting" id="enrollment_setting" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Enrollment_settings' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>
									<div class="text-danger" id="enrollment_setting_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6" id="div_enrollSetting_artno">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Treatment/ART No. (PEPID)<span class="required">*</span></label>
									<input  oninput="this.value = this.value.toUpperCase()" autocomplete="off" type="text" name="treatment_art_no" id="treatment_art_no" class="form-control" disabled/>
									<div class="text-danger" id="treatment_art_no_label"></div> 
								  </div>    
								</div>
							</div>
						</div>					
						</div>							    
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="generalInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsegeneralInformation" aria-expanded="true" aria-controls="collapsegeneralInformation">
								General Information 
								</button>
							</h5>
							</div>	
							<div id="collapsegeneralInformation" class="collapse" aria-labelledby="generalInformation" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date of Enrollment<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="enrollment_date" id="enrollment_date" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="enrollment_date_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>VC Unique ID<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="vc_unique_id" id="vc_unique_id" class="form-control" readonly/>
									<div class="text-danger" id="vc_unique_id_label"></div> 
								  </div>    
								</div>
							</div>
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Childs' Surname<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="surname" id="surname" class="form-control" />
									<div class="text-danger" id="surname_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Other Names<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="othernames" id="othernames" class="form-control" />
									<div class="text-danger" id="othernames_label"></div> 
								  </div>    
								</div>
							</div>
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Gender(sex)<span class="required">*</span><span class="required"></span></label>
									<select name="gender" id="gender" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Gender' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="gender_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of Birth<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="dob" id="dob" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="dob_label"></div>
									</div>
								</div>									
							</div>	
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="enrollmentStreams">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseenrollmentStreams" aria-expanded="false" aria-controls="collapseenrollmentStreams">
								Enrollment Streams
								</button>
							</h5>
							</div>	
							<div id="collapseenrollmentStreams" class="collapse" aria-labelledby="enrollmentStreams" data-parent="#accordion">
							<table class="table table-bordered" style="border: 1; width: 100%;">  
								<tr>  
									<td colspan="2">Select Enrollment Stream:</td>  
								</tr>  
								<tr>  
									<td>1. Child living with HIV (CLHIV)<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child living with HIV (CLHIV)"></td>  
									<td>2. HIV Exposed Infants (HEI)<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="HIV Exposed Infants (HEI)"></td>  
								</tr>  
								<tr>  
									<td>3. Child living with an HIV Positive Adult<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child living with an HIV Positive Adult"></td>  
									<td>4. Child at risk or have experienced sexual violence or any other form of violence;<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child at risk or have experienced sexual violence or any other form of violence"></td>  
								</tr>  
								<tr>  
									<td>5. Teenage mother<input style="margin-left: 5px" type="checkbox" name="enrollmentstream[]" value="Teenage mother"></td>  
									<td>6. Children in need of alternative family care<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children in need of alternative family care"></td>  
								</tr>  
								<tr>  
									<td>7. Children living on the street (exploited almajiri, nomadic, militants)<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children living on the street (exploited almajiri, nomadic, militants)"></td>  
									<td>8. Children in conflict with law<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children in conflict with law"></td>  
								</tr>  
								<tr>  
									<td>9. Children of KP;<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children of KP"></td>  
									<td>10. Child orphaned by AIDS<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child orphaned by AIDS"></td>  
								</tr>  
								<tr>  
									<td>11. Child living in a child Headed Household<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child living in a child Headed Household"></td>  
									<td>12. Child especially adolescent females at risk of transactional sex<input style="margin-left: 5px" type="checkbox" name="enrollmentstream[]" value="Child especially adolescent females at risk of transactional sex"></td>  
								</tr>  
								<tr>  
									<td>13. Socially excluded children<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Socially excluded children"></td>  
									<td>14. Children with disabilities<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children with disabilities"></td>  
								</tr>  
								<tr>  
									<td>15. Children trafficked/in exploitative labour<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children trafficked/in exploitative labour"></td>  
									<td>16. Children affected by armed conflict<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children affected by armed conflict"></td>  
								</tr>  
								<tr>  
									<td>17. Siblings of CLHIV<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Siblings of CLHIV"></td>  
									<div class="text-danger" id="enrollmentstream_label"></div>
									<td>
										<div class="form-group last mb-3" style="margin-right: 10px" >
											<label>Indicate on which stream enrollment is based<span class="required">*</span><span class="required"></span></label>
											<input autocomplete="off" type="number" name="enrollmentstreambasedon" id="enrollmentstreambasedon" class="form-control" />
											<div class="text-danger" id="enrollmentstreambasedon_label"></div>
										</div>
									</td>  
								</tr>  
							</table> 							
						</div>
						</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="childsHIVStatus">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsechildsHIVStatus" aria-expanded="false" aria-controls="collapsechildsHIVStatus">
								Childs HIV Status
								</button>
							</h5>
							</div>	
							<div id="collapsechildsHIVStatus" class="collapse" aria-labelledby="childsHIVStatus" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>HIV Status<span class="required">*</span><span class="required"></span></label>
									<select name="childhiv_status" id="childhiv_status" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='hiv_status' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="childhiv_status_label"></div>
									</div>
								</div>										
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" id="div_datehivstatus">
									<label>Date of HIV Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="childdatehivstatus" id="childdatehivstatus" class="form-control"/>								
									<div class="text-danger" id="childdatehivstatus_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px"  id="div_enrolledontreatment">
									<label>Enrolled on Treatment?<span class="required">*</span><span class="required"></span></label>
									<select name="childenrolledontreatment" id="childenrolledontreatment" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value!='N/A' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="childenrolledontreatment_label"></div>
									</div>
								</div>										
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px"  id="div_artstartdate">
									<label>ART Start Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="childartstartdate" id="childartstartdate" class="form-control"/>								
									<div class="text-danger" id="childartstartdate_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
								<div class="col-md-12">
									<div class="form-group first" style="margin-left: 5px;" id="div_facilityenrolled">
									<label>Facility Enrolled<span class="required">*</span></label>
									<select name="childfacilityenrolled" id="childfacilityenrolled" class="form-select" style="width: 100%">
									<option disabled selected></option>
										<?php
										$sql = "SELECT facilityname,facilityid 
                                                FROM referraldirectory 
                                                WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
                                                SELECT uid FROM organizationunit WHERE parentid IN (
                                                SELECT uid FROM organizationunit WHERE ouname='$state'))) order by facilityname asc
                                                ";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['facilityname'] ?>"><?php echo $row['facilityname'] ?></option>
									<?php } ?>									
									</select>
									<div class="text-danger" id="childfacilityenrolled_label"></div> 
									</div>    
									</div>
							  </div>							
						</div>
						</div>	
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="birthCertEducation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsebirthCertEducation" aria-expanded="false" aria-controls="collapsebirthCertEducation">
								Birth Certification & Education
								</button>
							</h5>
							</div>	
							<div id="collapsebirthCertEducation" class="collapse" aria-labelledby="birthCertEducation" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Does the Child have a Birth Certificate?<span class="required">*</span><span class="required"></span></label>
									<select name="birthcertificate" id="birthcertificate" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' ORDER BY keyword_value desc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="birthcertificate_label"></div>
									</div>
								</div>										
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Is the child in School?<span class="required">*</span><span class="required"></span></label>
									<select name="childinschool" id="childinschool" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' ORDER BY keyword_value desc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="childinschool_label"></div>
									</div>
								</div>										
							</div>
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Name of School<span class="required">*</span><span class="required"></span></label>
									<select name="schoolname" id="schoolname" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT id,schoolname 
												FROM school 
												WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
												SELECT uid FROM organizationunit WHERE parentid IN (
												SELECT uid FROM organizationunit WHERE ouname='$state'))) ORDER BY schoolname ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['schoolname'] ?>"><?php echo $row['schoolname'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="schoolname_label"></div>
									</div>
								</div>										
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Class<span class="required">*</span><span class="required"></span></label>
									<select name="schoolgrade" id="schoolgrade" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "select distinct gradename as gradename from schoolgrade order by gradename asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['gradename'] ?>"><?php echo $row['gradename'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="schoolgrade_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Is Child on Vocational Training<span class="required">*</span><span class="required"></span></label>
									<select name="childonvocationaltraining" id="childonvocationaltraining" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' ORDER BY keyword_value desc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="childonvocationaltraining_label"></div>
									</div>
								</div>										
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Name of Vocational Training Institute<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="vocationalinstitute" id="vocationalinstitute" class="form-control"/>									
									<div class="text-danger" id="vocationalinstitute_label"></div>
									</div>
								</div>										
							</div>									
						</div>
						</div>	
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="caregiverInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecaregiverInformation" aria-expanded="false" aria-controls="collapsecaregiverInformation">
								Caregiver Information
								</button>
							</h5>
							</div>	
							<div id="collapsecaregiverInformation" class="collapse" aria-labelledby="caregiverInformation" data-parent="#accordion">
							<div class="row">								
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Caregiver<span class="required">*</span><span class="required"></span></label>
									<select name="caregivername" id="caregivername" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT concat(surname,' ',firstname ) as caregiver FROM hh_vulnerability_assessment WHERE hh_unique_num='$data_id'";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['caregiver'] ?>"><?php echo $row['caregiver'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="caregiver_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Caregivers Relationship to Child<span class="required">*</span><span class="required"></span></label>
									<select name="caregiverrelationshiptochild" id="caregiverrelationshiptochild" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='caregiver_rship_to_child'";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="caregiverrelationshiptochild_label"></div>
									</div>
								</div>									
							</div>							
						</div>
						</div>																	
							  <button type="submit" id="submitVCForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    </div>
  </div>
</div>
<!-- NEW VULNERABLE CHILDREN MODAL -- END -->	

<!-- NEW CARE AND SUPPORT CHECKLIST -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newcandsChecklist" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header">CARE AND SUPPORT CHECKLIST<button class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="candsChecklist">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecandsChecklist" aria-expanded="true" aria-controls="collapsecandsChecklist">
								General Information 
								</button>
							</h5>
							</div>	
							<div id="collapsecandsChecklist" class="collapse show" aria-labelledby="candsChecklist" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date of Enrollment<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="enrollment_date" id="enrollment_date" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="enrollment_date_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>VC Unique ID<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="vc_unique_id" id="vc_unique_id" class="form-control" readonly/>
									<div class="text-danger" id="vc_unique_id_label"></div> 
								  </div>    
								</div>
							</div>
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Childs' Surname<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="surname" id="surname" class="form-control" />
									<div class="text-danger" id="surname_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Other Names<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="othernames" id="othernames" class="form-control" />
									<div class="text-danger" id="othernames_label"></div> 
								  </div>    
								</div>
							</div>
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Gender(sex)<span class="required">*</span><span class="required"></span></label>
									<select name="gender" id="gender" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Gender' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="gender_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of Birth<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="dob" id="dob" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="dob_label"></div>
									</div>
								</div>									
							</div>	
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="enrollmentStreams">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseenrollmentStreams" aria-expanded="false" aria-controls="collapseenrollmentStreams">
								Enrollment Streams
								</button>
							</h5>
							</div>	
							<div id="collapseenrollmentStreams" class="collapse" aria-labelledby="enrollmentStreams" data-parent="#accordion">
							<table class="table table-bordered" style="border: 1; width: 100%;">  
								<tr>  
									<td colspan="2">Select Enrollment Stream:</td>  
								</tr>  
								<tr>  
									<td>1. Child living with HIV (CLHIV)<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child living with HIV (CLHIV)"></td>  
									<td>2. HIV Exposed Infants (HEI)<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="HIV Exposed Infants (HEI)"></td>  
								</tr>  
								<tr>  
									<td>3. Child living with an HIV Positive Adult<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child living with an HIV Positive Adult"></td>  
									<td>4. Child at risk or have experienced sexual violence or any other form of violence;<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child at risk or have experienced sexual violence or any other form of violence"></td>  
								</tr>  
								<tr>  
									<td>5. Teenage mother<input style="margin-left: 5px" type="checkbox" name="enrollmentstream[]" value="Teenage mother"></td>  
									<td>6. Children in need of alternative family care<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children in need of alternative family care"></td>  
								</tr>  
								<tr>  
									<td>7. Children living on the street (exploited almajiri, nomadic, militants)<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children living on the street (exploited almajiri, nomadic, militants)"></td>  
									<td>8. Children in conflict with law<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children in conflict with law"></td>  
								</tr>  
								<tr>  
									<td>9. Children of KP;<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children of KP"></td>  
									<td>10. Child orphaned by AIDS<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child orphaned by AIDS"></td>  
								</tr>  
								<tr>  
									<td>11. Child living in a child Headed Household<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Child living in a child Headed Household"></td>  
									<td>12. Child especially adolescent females at risk of transactional sex<input style="margin-left: 5px" type="checkbox" name="enrollmentstream[]" value="Child especially adolescent females at risk of transactional sex"></td>  
								</tr>  
								<tr>  
									<td>13. Socially excluded children<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Socially excluded children"></td>  
									<td>14. Children with disabilities<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children with disabilities"></td>  
								</tr>  
								<tr>  
									<td>15. Children trafficked/in exploitative labour<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children trafficked/in exploitative labour"></td>  
									<td>16. Children affected by armed conflict<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Children affected by armed conflict"></td>  
								</tr>  
								<tr>  
									<td>17. Siblings of CLHIV<input style="margin-left: 5px" type="checkbox" id="enrollmentstream" name="enrollmentstream[]" value="Siblings of CLHIV"></td>  
									<div class="text-danger" id="enrollmentstream_label"></div>
									<td>
										<div class="form-group last mb-3" style="margin-right: 10px" >
											<label>Indicate on which stream enrollment is based<span class="required">*</span><span class="required"></span></label>
											<input autocomplete="off" type="number" name="enrollmentstreambasedon" id="enrollmentstreambasedon" class="form-control" />
											<div class="text-danger" id="enrollmentstreambasedon_label"></div>
										</div>
									</td>  
								</tr>  
							</table> 							
						</div>
						</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="childsHIVStatus">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsechildsHIVStatus" aria-expanded="false" aria-controls="collapsechildsHIVStatus">
								Childs HIV Status
								</button>
							</h5>
							</div>	
							<div id="collapsechildsHIVStatus" class="collapse" aria-labelledby="childsHIVStatus" data-parent="#accordion">
							<div class="row">
							<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>HIV Status<span class="required">*</span><span class="required"></span></label>
									<select name="hiv_status" id="hiv_status" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='hiv_status' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="hiv_status_label"></div>
									</div>
								</div>										
							</div>							
						</div>
						</div>	
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="birthCertEducation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsebirthCertEducation" aria-expanded="false" aria-controls="collapsebirthCertEducation">
								Birth Certification & Education
								</button>
							</h5>
							</div>	
							<div id="collapsebirthCertEducation" class="collapse" aria-labelledby="birthCertEducation" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Does the Child have a Birth Certificate?<span class="required">*</span><span class="required"></span></label>
									<select name="birthcertificate" id="birthcertificate" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' ORDER BY keyword_value desc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="birthcertificate_label"></div>
									</div>
								</div>										
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Is the child in School?<span class="required">*</span><span class="required"></span></label>
									<select name="childinschool" id="childinschool" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' ORDER BY keyword_value desc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="childinschool_label"></div>
									</div>
								</div>										
							</div>							
						</div>
						</div>	
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="caregiverInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecaregiverInformation" aria-expanded="false" aria-controls="collapsecaregiverInformation">
								Caregiver Information
								</button>
							</h5>
							</div>	
							<div id="collapsecaregiverInformation" class="collapse" aria-labelledby="caregiverInformation" data-parent="#accordion">
							<div class="row">								
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Caregiver<span class="required">*</span><span class="required"></span></label>
									<select name="caregivername" id="caregivername" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT concat(surname,' ',firstname ) as caregiver FROM hh_vulnerability_assessment WHERE hh_unique_num='$data_id'";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['caregiver'] ?>"><?php echo $row['caregiver'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="caregiver_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Caregivers Relationship to Child<span class="required">*</span><span class="required"></span></label>
									<select name="caregiverrelationshiptochild" id="caregiverrelationshiptochild" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='caregiver_rship_to_child'";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="caregiverrelationshiptochild_label"></div>
									</div>
								</div>									
							</div>							
						</div>
						</div>																	
							  <button type="submit" id="submitVCForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    </div>
  </div>
</div>
<!-- NEW CARE AND SUPPORT CHECKLIST -- END -->	

<!-- NEW Service Form MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newServicesForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">New Services: &nbsp; <span id="vc_unique_id_for_service" class="btn btn-primary"></span><button class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="serviceDate">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseServiceDate" aria-expanded="true" aria-controls="collapseServiceDate">
								Service Date 
								</button>
							</h5>
							</div>	
							<div id="collapseServiceDate" class="collapse show" aria-labelledby="serviceDate" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Service Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="service_date" id="service_date" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="service_date_label"></div> 
								  </div>    
								</div>
							</div>	
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="availableServices">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseavailableServices" aria-expanded="false" aria-controls="collapseavailableServices">
								Available Services
								</button>
							</h5>
							</div>	
							<div id="collapseavailableServices" class="collapse" aria-labelledby="availableServices" data-parent="#accordion">
							<div class="text-danger" id="availableservices_label"></div> 
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
							<tr>  
									<td colspan="3" style="font-weight: 600; font-size:18px">MIGRATION</td>  
								</tr>  
								<tr>  
									<td>Medical Care<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Medical Care"></td>  
									<td>Re-settlement/Shelter<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Re-settlement/Shelter"></td>  
									<td>Psychosocial Support<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Psychosocial Support"></td>  
								</tr>  
								<tr>  
								<td>Water, Sanitation/Hygiene<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Water, Sanitation/Hygiene"></td>  
								<td></td>  
								<td></td>  
								</tr>  
								<tr>  
									<td colspan="3" style="font-weight: 600; font-size:18px">HEALTHY</td>  
								</tr>  
								<tr>  
									<td>COVID Services<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="COVID Services"></td>  
									<td>Drugs<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Drugs"></td>  
									<td>Wasting/Edema<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Wasting/Edema"></td>  
								</tr>  
								<tr>  
									<td>Severe Acute Malnutrition (SAM)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Severe Acute Malnutrition (SAM)"></td>  
									<td>Food and Nutrition Supplement<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Food and Nutrition Supplement"></td>  
									<td>Water Treatment<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Water Treatment"></td>  
								</tr>  
								<tr>  
									<td>Insecticide Treated Net<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Insecticide Treated Net"></td>  
									<td>Adolescent HIV Prevention and SRH Services<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Adolescent HIV Prevention and SRH Services"></td>  
									<td>Growth Monitoring<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Growth Monitoring"></td>  
								</tr>  
								<tr>  
									<td>Nutrition Assessment, Counseling and Support (NACS)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Nutrition Assessment, Counseling and Support (NACS)"></td>  
									<td>Food Package(s)/Nutritional Supplement<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Food Package(s)/Nutritional Supplement"></td>  
									<td>Community TB Symptom Screening<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Community TB Symptom Screening"></td>  
								</tr>  
								<tr>  
									<td>Structured PLHA Support Group<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Structured PLHA Support Group"></td>  
									<td>ART Adherence Support (Including transportation support)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="ART Adherence Support (Including transportation support)"></td>  
									<td>Age appropriate HIV treatment literacy (for CLHIV)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Age appropriate HIV treatment literacy (for CLHIV)"></td>  
								</tr>  
								<tr>  
									<td>Age appropriate counselling and HIV Disclosure support<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Age appropriate counselling and HIV Disclosure support"></td>  
									<td>HIV services referral - HTS/EID/ART/PMTCT/VL/TB/STIs<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="HIV services referral - HTS/EID/ART/PMTCT/VL/TB/STIs"></td>  
									<td>Community HIV Services - HTS<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Severe"></td>  
								</tr>  
								<tr>  
									<td>Water, Sanitation and Hygiene Services (WASH) messaging<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Water, Sanitation and Hygiene Services (WASH) messaging"></td>  
									<td>Household health insurance coverage<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Household health insurance coverage"></td>  
									<td>Insecticide Treated Bed Nets<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Insecticide Treated Bed Nets"></td>  
								</tr>  
								<tr>  
									<td>Health Education<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Severe"></td>  
									<td></td>  
									<td></td>  
								</tr>  
								<tr>  
									<td colspan="3" style="font-weight: 600; font-size:18px">STABLE</td>  
								</tr>  
								<tr>  
									<td>Safe shelter-related repair or construction<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Safe shelter-related repair or construction"></td>  
									<td>Short term emergency cash support<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Short term emergency cash support"></td>  
									<td>Savings group (SILC, VLSA etc)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Savings group (SILC, VLSA etc)"></td>  
								</tr>  
								<tr>  
									<td>Cash transfer scheme<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Cash transfer scheme"></td>  
									<td>Agricultural inputs/value chain<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Agricultural inputs/value chain"></td>  
									<td>Vocational/Apprenticeship training<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Vocational/Apprenticeship training"></td>  
								</tr>  
								<tr>  
									<td>Access to Microfinance<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Access to Microfinance"></td>  
									<td>Financial Education<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Financial Education"></td>  
									<td></td>  
								</tr>  
								<tr>  
									<td colspan="3" style="font-weight: 600; font-size:18px">SCHOOLED</td>  
								</tr>  
								<tr>  
									<td>School Performance Assessment<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="School Performance Assessment"></td>  
									<td>Assistance/Support with Homework<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Assistance/Support with Homework"></td>  
									<td>Provision of school materials/uniform<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Provision of school materials/uniform"></td>  
								</tr>  
								<tr>  
									<td>Waiver of school fees<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Waiver of school fees"></td>  
									<td></td>  
									<td></td>  
								</tr>  
								<tr>  
									<td colspan="3" style="font-weight: 600; font-size:18px">SAFE</td>  
								</tr>  								
								<tr>  
									<td>Participated in evidence-based intervention on preventing HIV and sexual violence<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Participated in evidence-based intervention on preventing HIV and sexual violence"></td>  
									<td>Child abuse case report to police/local authority<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Child abuse case report to police/local authority"></td>  
									<td>Post GBV Care<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Post GBV Care"></td>  
								</tr>  
								<tr>  
									<td>Birth registration<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Birth registration"></td>  
									<td>Succession plan<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Succession plan"></td>  
									<td>Legal services (eg. received for GBV, Trafficking, exploitation, maltreatment)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Legal services (eg. received for GBV, Trafficking, exploitation, maltreatment)"></td>  
								</tr>  
								<tr>  
									<td>Life skills support<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Life skills support"></td>  
									<td>Structured safe spaces intervention<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Structured safe spaces intervention"></td>  
									<td>Recreational activity (e.g., kids and youth clubs)<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Recreational activity (e.g., kids and youth clubs)"></td>  
								</tr>  
								<tr>  
									<td>Post-violence trauma counselling from a trained provider<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Post-violence trauma counselling from a trained provider"></td>  
									<td>Emergency shelter/care facility<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Emergency shelter/care facility"></td>  
									<td>Clothing support<input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Clothing support"></td>  
								</tr>  
								<tr>  
									<td>Structured PSS related to family conflict mitigation <input style="margin-left: 5px" type="checkbox" id="availableservices" name="availableservices[]" value="Structured PSS related to family conflict mitigation "></td>  
									<td></td>  
									<td></td>  
								</tr>  
							</table> 							
						</div>
						</div>
							  <button type="submit" id="submitVCServicesForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW Service Form MODAL-- END -->	
<!-- NEW CONSENT Form MODAL-- START -->	
<div class="modal fade bd-example-modal-xl" id="newConsentFormModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">CONSENT FORM: &nbsp; <span id="hh_unique_id_consent" class="btn btn-primary"></span><button id="modalExitButtonConsent" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button><span id="hh_unique_id_label"></span></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="consentDeclaration">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentDeclaration" aria-expanded="true" aria-controls="collapseconsentDeclaration">
								DECLARATION 
								</button>
							</h5>
							</div>	
							<div id="collapseconsentDeclaration" class="collapse show" aria-labelledby="consentDeclaration" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>I<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name" readonly />
									<div class="text-danger" id="fullname_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>of<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="community_cf" id="community_cf"  class="form-control" placeholder="Community" readonly/>
									<div class="text-danger" id="community_cf_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>in<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="ward_cf" id="ward_cf" class="form-control" readonly />
									<div class="text-danger" id="ward_cf_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>LGA<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="lga_cf" id="lga_cf"  class="form-control" readonly />
									<div class="text-danger" id="lga_cf_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>State<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="state_cf" id="state_cf"  class="form-control" readonly />
									<div class="text-danger" id="state_cf_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>acknowledge that the<span class="required">*</span><span class="required"></span></label>
									<select name="ip_cf" id="ip_cf" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='implementing_partner' ORDER BY keyword_value asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="ip_cf_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>OVC program and its activities have been explained to me and I hereby voluntarily give informed consent for my household to participate in the program implemented by<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cbo_code_cf" id="cbo_code_cf"  class="form-control" readonly />
									<div class="text-danger" id="cbo_code_cf_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>with support from<span class="required">*</span><span class="required"></span></label>
									<select name="supporting_ip_cf" id="supporting_ip_cf" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='implementing_partner' ORDER BY keyword_value asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="supporting_ip_cf_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>with funding from<span class="required">*</span><span class="required"></span></label>
									<select name="donor" id="donor" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='donor' ORDER BY keyword_value asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="donor_label"></div>
									</div>
								</div>									
							</div>	
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="consentConditions">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentConditions" aria-expanded="false" aria-controls="collapseconsentConditions">
								CONDITIONS
								</button>
							</h5>
							</div>	
							<div id="collapseconsentConditions" class="collapse" aria-labelledby="consentConditions" data-parent="#accordion">
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 80%">QUESTION</th>  
								<th style="width: 20%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="consentQuestion1">I also agree to “shared confidentiality” with other staff for purpose of supporting my household</td>  
									<td>									
										<select name="responseQuestion1" id="responseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion1_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion2">I consent to pictures being taken of my household in the course of participation in the program</td>  
									<td>									
										<select name="responseQuestion2" id="responseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion2_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion3">I consent to pictures of my household being shared on program reports, newsletters, journals and the website of [Name of Implementing Partner]</td>  
									<td>									
										<select name="responseQuestion3" id="responseQuestion3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion3_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion4">I consent that my child(ren)/ward could participate in the program related activities</td>  
									<td>									
										<select name="responseQuestion4" id="responseQuestion4" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion4_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion5">I consent that the organization and/or its staff should not be held liable at the event of injuries that may occur to my child(ren)/ward’s as a result of his/her/their participation in program-related activity(ies).</td>  
									<td>									
										<select name="responseQuestion5" id="responseQuestion5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion5_label"></div>
									</td>  
								</tr>  
							</table> 							
						</div>
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="consentSignature">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentSignature" aria-expanded="false" aria-controls="collapseconsentSignature">
								SIGNATURE 
								</button>
							</h5>
							</div>	
							<div id="collapseconsentSignature" class="collapse" aria-labelledby="consentSignature" data-parent="#accordion">
							<div class="row">
							<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of Household Head<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="household_caregiver" id="household_caregiver" class="form-control" readonly />
									<div class="text-danger" id="household_caregiver_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Signature<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_caregiver_signature" id="hh_caregiver_signature"  class="form-control"/>
									<div class="text-danger" id="hh_caregiver_signature_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Phonenumber<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_caregiver_phone" id="hh_caregiver_phone"  class="form-control"/>
									<div class="text-danger" id="hh_caregiver_phone_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="hh_caregiver_sign_date" id="hh_caregiver_sign_date"  class="form-control"/>
									<div class="text-danger" id="hh_caregiver_sign_date_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of witness<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="household_witness" id="household_witness" class="form-control" />
									<div class="text-danger" id="household_witness_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Signature<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_witness_signature" id="hh_witness_signature"  class="form-control"/>
									<div class="text-danger" id="hh_witness_signature_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Phonenumber<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_witness_phone" id="hh_witness_phone"  class="form-control"/>
									<div class="text-danger" id="hh_witness_phone_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="hh_witness_sign_date" id="hh_witness_sign_date"  class="form-control"/>
									<div class="text-danger" id="hh_witness_sign_date_label"></div> 
								  </div>    
								</div>
							</div>	
						</div>					
						</div>
							  <button type="submit" id="submitConsentForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW CONSENT Form MODAL-- END -->	
<!-- BENEFICIARY STATUS UPDATE-- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="beneficiaryStatusUpdateForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Beneficiary Program Status Update/Follow-Up Information: &nbsp;  <span id="vc_unique_id_for_update" class="btn btn-primary"></span><button class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button><span id="hh_unique_id_label"></span></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="beneficiaryStatusUpdate">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsebeneficiaryStatusUpdate" aria-expanded="true" aria-controls="collapsebeneficiaryStatusUpdate">
								Follow-Up Information 
								</button>
							</h5>
							</div>	
							<div id="collapsebeneficiaryStatusUpdate" class="collapse show" aria-labelledby="beneficiaryStatusUpdate" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="followup_date" id="followup_date" max="<?php echo Date('Y-m-d'); ?>" class="form-control"/>
									<div class="text-danger" id="followup_date_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Status<span class="required">*</span></label>
										<select name="status" id="status" class="form-select" style="width: 100%">
										<option disabled selected>Select</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='follow_up' ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
									<div class="text-danger" id="status_label"></div> 
								  </div>    
								</div>
							</div>	
						</div>					
						</div>
					</div>
							  <button type="submit" id="submitStatusUpdateForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- BENEFICIARY STATUS UPDATE-- END -->	
<!-- NEW CAREGIVER-- START -->	
<div class="modal fade bd-example-modal-xl" id="newCaregiverFormModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">New Caregiver:&nbsp; <span  class="btn btn-primary" id="hh_unique_id_cg"></span><button  id="modalExitButtonCaregiver" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">

						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="primaryCaregiverInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseprimaryCaregiverInformation" aria-expanded="false" aria-controls="collapseprimaryCaregiverInformation">
									Caregiver Information
								</button>
							</h5>
							</div>	
							<div id="collapseprimaryCaregiverInformation" class="collapse show" aria-labelledby="primaryCaregiverInformation" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Surname<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cg_surname" id="cg_surname" class="form-control" />
									<div class="text-danger" id="cg_surname_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Firstname<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cg_firstname" id="cg_firstname" class="form-control"/>
									<div class="text-danger" id="cg_firstname_label"></div>
									</div>
								</div>									
							</div>							
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Gender(sex)<span class="required">*</span><span class="required"></span></label>
									<select name="cg_gender" id="cg_gender" class="form-select" style="width: 100%">
									<option disabled selected>Select Gender</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Gender' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="cg_gender_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of Birth<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="cg_dob" id="cg_dob" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="cg_dob_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Phonenumber<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="number" name="cg_phonenumber" id="cg_phonenumber" class="form-control" />
									<div class="text-danger" id="cg_phonenumber_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of Enrollment</label>
									<input autocomplete="off" type="date" name="enrollmentdate" id="enrollmentdate" class="form-control"/>
									<div class="text-danger" id="enrollmentdate_label"></div>
									</div>
								</div>									
							</div>							
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Marital Status<span class="required">*</span><span class="required"></span></label>
									<select name="cg_marital_status" id="cg_marital_status" class="form-select" style="width: 100%">
									<option disabled selected>Select Marital Status</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Marital_Status' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="cg_marital_status_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Occupation<span class="required">*</span><span class="required"></span></label>
									<select name="cg_occupation" id="cg_occupation" class="form-select" style="width: 100%">
									<option disabled selected>Select Occupation</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Occupation' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="cg_occupation_label"></div>
									</div>
								</div>									
							</div>	
							<hr/>
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>HIV Status<span class="required">*</span><span class="required"></span></label>
									<select name="cg_hiv_status" id="cg_hiv_status" class="form-select" style="width: 100%">
									<option disabled selected>Select HIV Status</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='hiv_status' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="cg_hiv_status_label"></div>
									</div>
								</div>										
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of HIV Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="cg_datehivstatus" id="cg_datehivstatus" class="form-control" disabled/>								
									<div class="text-danger" id="cg_datehivstatus_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px">
									<label>Enrolled on Treatment?<span class="required">*</span><span class="required"></span></label>
									<select name="cg_enrolledontreatment" id="cg_enrolledontreatment" class="form-select" style="width: 100%" disabled>
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value!='N/A' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="cg_enrolledontreatment_label"></div>
									</div>
								</div>										
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>ART Start Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="cg_artstartdate" id="cg_artstartdate" class="form-control" disabled/>								
									<div class="text-danger" id="cg_artstartdate_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
								<div class="col-md-6">
									<div class="form-group first" style="margin-left: 5px;"  >
									<label>Facility Enrolled<span class="required">*</span></label>
									<select name="cg_facilityenrolled" id="cg_facilityenrolled" class="form-select" style="width: 100%" disabled >
									<option disabled selected></option>
										<?php
										$sql = "SELECT facilityname,facilityid 
                                                FROM referraldirectory 
                                                WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
                                                SELECT uid FROM organizationunit WHERE parentid IN (
                                                SELECT uid FROM organizationunit WHERE ouname='$state'))) order by facilityname asc
                                                ";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['facilityname'] ?>"><?php echo $row['facilityname'] ?></option>
									<?php } ?>									
									</select>
									<div class="text-danger" id="cg_facilityenrolled_label"></div> 
									</div>    
									</div>
								<div class="col-md-6">
									<div class="form-group first" style="margin-right: 5px;" id="div_treatment_art_no">
									<label>Treatment/ART No<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="cg_treatment_art_no" id="cg_treatment_art_no" class="form-control" disabled/>	
									</select>
									<div class="text-danger" id="cg_treatment_art_no_label"></div> 
									</div>    
									</div>
							  </div>
						</div>
						</div>	
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="beneficiaryStatus">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsebeneficiaryStatus" aria-expanded="true" aria-controls="collapsebeneficiaryStatus">
								BENEFICIARY STATUS 
								</button>
							</h5>
							</div>	
							<div id="collapsebeneficiaryStatus" class="collapse" aria-labelledby="beneficiaryStatus" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>Beneficiary Type<span class="required">*</span><span class="required"></span></label>
									<select name="beneficiary_type" id="beneficiary_type" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='beneficiary_type'";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="beneficiary_type_label"></div>
									</div>
								</div>		
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Beneficiary ID<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="beneficiary_id" id="beneficiary_id" class="form-control" readonly />
									<div class="text-danger" id="beneficiary_id_label"></div> 
								  </div>    
								</div>
							</div>
						</div>					
						</div>						
						</div>
							  <button type="submit" id="submitNewCaregiverForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						</form>
							</div>
							</div>

					  </div>    
			</div>
  </div>
</div>
<!-- NEW CAREGIVER-- END -->	
<!-- NEW CONSENT Form MODAL-- START -->	
<div class="modal fade bd-example-modal-xl" id="newConsentFormModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">CONSENT FORM: &nbsp; <span id="hh_unique_id_consent" class="btn btn-primary"></span><button id="modalExitButtonConsent" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button><span id="hh_unique_id_label"></span></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="consentDeclaration">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentDeclaration" aria-expanded="true" aria-controls="collapseconsentDeclaration">
								DECLARATION 
								</button>
							</h5>
							</div>	
							<div id="collapseconsentDeclaration" class="collapse show" aria-labelledby="consentDeclaration" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>I<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name"  />
									<div class="text-danger" id="fullname_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>of<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="community_cf" id="community_cf"  class="form-control" placeholder="Community" />
									<div class="text-danger" id="community_cf_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>in<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="ward_cf" id="ward_cf" class="form-control"  />
									<div class="text-danger" id="ward_cf_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>LGA<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="lga_cf" id="lga_cf"  class="form-control"  />
									<div class="text-danger" id="lga_cf_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>State<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="state_cf" id="state_cf"  class="form-control"  />
									<div class="text-danger" id="state_cf_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>acknowledge that the<span class="required">*</span><span class="required"></span></label>
									<select name="ip_cf" id="ip_cf" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='implementing_partner' ORDER BY keyword_value asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="ip_cf_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>OVC program and its activities have been explained to me and I hereby voluntarily give informed consent for my household to participate in the program implemented by<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cbo_code_cf" id="cbo_code_cf"  class="form-control" />
									<div class="text-danger" id="cbo_code_cf_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>with support from<span class="required">*</span><span class="required"></span></label>
									<select name="supporting_ip_cf" id="supporting_ip_cf" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='implementing_partner' ORDER BY keyword_value asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="supporting_ip_cf_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>with funding from<span class="required">*</span><span class="required"></span></label>
									<select name="donor" id="donor" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='donor' ORDER BY keyword_value asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="donor_label"></div>
									</div>
								</div>									
							</div>	
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="consentConditions">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentConditions" aria-expanded="false" aria-controls="collapseconsentConditions">
								CONDITIONS
								</button>
							</h5>
							</div>	
							<div id="collapseconsentConditions" class="collapse" aria-labelledby="consentConditions" data-parent="#accordion">
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 80%">QUESTION</th>  
								<th style="width: 20%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="consentQuestion1">I also agree to “shared confidentiality” with other staff for purpose of supporting my household</td>  
									<td>									
										<select name="responseQuestion1" id="responseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion1_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion2">I consent to pictures being taken of my household in the course of participation in the program</td>  
									<td>									
										<select name="responseQuestion2" id="responseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion2_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion3">I consent to pictures of my household being shared on program reports, newsletters, journals and the website of [Name of Implementing Partner]</td>  
									<td>									
										<select name="responseQuestion3" id="responseQuestion3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion3_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion4">I consent that my child(ren)/ward could participate in the program related activities</td>  
									<td>									
										<select name="responseQuestion4" id="responseQuestion4" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion4_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion5">I consent that the organization and/or its staff should not be held liable at the event of injuries that may occur to my child(ren)/ward’s as a result of his/her/their participation in program-related activity(ies).</td>  
									<td>									
										<select name="responseQuestion5" id="responseQuestion5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion5_label"></div>
									</td>  
								</tr>  
							</table> 							
						</div>
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="consentSignature">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentSignature" aria-expanded="false" aria-controls="collapseconsentSignature">
								SIGNATURE 
								</button>
							</h5>
							</div>	
							<div id="collapseconsentSignature" class="collapse" aria-labelledby="consentSignature" data-parent="#accordion">
							<div class="row">
							<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of Household Head<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="household_caregiver" id="household_caregiver" class="form-control" />
									<div class="text-danger" id="household_caregiver_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Signature<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_caregiver_signature" id="hh_caregiver_signature"  class="form-control"/>
									<div class="text-danger" id="hh_caregiver_signature_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Phonenumber<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_caregiver_phone" id="hh_caregiver_phone"  class="form-control"/>
									<div class="text-danger" id="hh_caregiver_phone_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="hh_caregiver_sign_date" id="hh_caregiver_sign_date"  class="form-control"/>
									<div class="text-danger" id="hh_caregiver_sign_date_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of witness<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="household_witness" id="household_witness" class="form-control" />
									<div class="text-danger" id="household_witness_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Signature<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_witness_signature" id="hh_witness_signature"  class="form-control"/>
									<div class="text-danger" id="hh_witness_signature_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Phonenumber<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="hh_witness_phone" id="hh_witness_phone"  class="form-control"/>
									<div class="text-danger" id="hh_witness_phone_label"></div> 
								  </div>    
								</div>
								<div class="col-md-3">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="hh_witness_sign_date" id="hh_witness_sign_date"  class="form-control"/>
									<div class="text-danger" id="hh_witness_sign_date_label"></div> 
								  </div>    
								</div>
							</div>	
						</div>					
						</div>
							  <button type="submit" id="submitConsentForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW CONSENT Form MODAL-- END -->	

<!-- NEW OFFER FORM MODAL-- START -->	
<div class="modal fade bd-example-modal-xl" id="newOfferFormModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Facility OVC Program Offer Form:<button id="modalExitButtonOffer" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryOfferForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="artDetails">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseartDetails" aria-expanded="true" aria-controls="collapseartDetails">
								ART Details 
								</button>
							</h5>
							</div>	
							<div id="collapseartDetails" class="collapse show" aria-labelledby="artDetails" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>ART No. of Identified Client<span class="required">*</span></label>
									<input  oninput="this.value = this.value.toUpperCase()" autocomplete="off" type="text" name="treatment_art_no_offer" id="treatment_art_no_offer" class="form-control"/>
									<div class="text-danger" id="treatment_art_no_offer_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>ART Start Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="artstartdate_offer" id="artstartdate_offer"  class="form-control"/>
									<div class="text-danger" id="artstartdate_offer_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row">
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of Client<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="clientname" id="clientname" class="form-control"/>
									<div class="text-danger" id="clientname_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">
									<div class="form-group first" style="margin-right: 5px;" id="div_facilityenrolled">
									<label>Facility Name<span class="required">*</span></label>
									<select name="facilityname" id="facilityname" class="form-select" style="width: 100%">
									<option disabled selected></option>
										<?php
										$sql = "SELECT facilityname,facilityid 
                                                FROM referraldirectory 
                                                WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
                                                SELECT uid FROM organizationunit WHERE parentid IN (
                                                SELECT uid FROM organizationunit WHERE ouname='$state'))) order by facilityname asc
                                                ";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['facilityname'] ?>"><?php echo $row['facilityname'] ?></option>
									<?php } ?>									
									</select>
									<div class="text-danger" id="facilityname_label"></div> 
									</div>    
									</div>   
							</div>	
							<div class="row">
								<div class="col-md-6">
								<div class="form-group first" style="margin-left: 5px;">
									<label>State of Residence<span class="required">*</span></label>
									<select id="stateofresidence" name="stateofresidence" class="form-select" style="width: 100%">
										<option disabled selected>Select State</option>
										<?php
										$sql = "SELECT DISTINCT ouname AS state FROM organizationunit WHERE LOWER(ouname)=LOWER('$state') ORDER BY ouname ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['state'] ?>"><?php echo $row['state'] ?></option>
									<?php } ?>
									</select>
									<div class="text-danger" id="stateofresidence_label"></div>
								</div>    
								</div>
								<div class="col-md-6">
									<div class="form-group first" style="margin-right: 5px;">
									<label>Local Government of Residence<span class="required">*</span></label>
									<select name="lgaofresidence" id="lgaofresidence" class="form-select" style="width: 100%">
									</select>
									<div class="text-danger" id="lgaofresidence_label"></div> 
									</div>    
									</div>
							  </div>

						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-info" id="instructions">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-target="#collapseconsentInstructions" aria-expanded="true">
								INSTRUCTIONS
								</button>
							</h5>
							</div>	
							<div id="collapseconsentInstructions" aria-labelledby="consentInstructions" data-parent="#accordion">
							<div class="row">
							    <div class="col-md-12" style="margin-left:5px; margin-right: 5px">
							    <span style="font-weight: bold">Brief on OVC /Key messages for introducing the OVC program (the listed points to be discussed with the Head of HH by the facility staff)</span>
							    <p>•	The OVC program has helped a lot of children and families living with HIV to improve the quality of Life </p>
							    <p>•	The OVC program works with children 0-17 years and their caregivers/households </p>
							    <p>•	The OVC supports treatment outcomes (adherence, nutritional support, Psychosocial support) </p>
							    <p>•	The households are supported by trained Community Volunteers who also conduct home visits</p>
							    <p>•	The OVC program is recommended for every household with a HIV positive child accessing treatment in our facility </p>
							</div>	
							</div>							
						</div>
						</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="consentConditions">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentConditions" aria-expanded="false" aria-controls="collapseconsentConditions">
								CONSENT
								</button>
							</h5>
							</div>	
							<div id="collapseconsentConditions" class="collapse" aria-labelledby="consentConditions" data-parent="#accordion">
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 80%">QUESTION</th>  
								<th style="width: 20%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="consentQuestion1Offer">Should I share your contact/address with <?php echo $cbo_name; ?> for possible enrolment on the OVC program?</td>  
									<td>									
										<select name="responseQuestion1Offer" id="responseQuestion1Offer" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion1Offer_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="consentQuestion2Offer">Would you like to receive reminders from the OVC Program Partner for drug refills and viral load tests?</td>  
									<td>									
										<select name="responseQuestion2Offer" id="responseQuestion2Offer" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion2Offer_label"></div>
									</td>  
								</tr>  
							</table> 
								<div class="col-md-12" id="div_phonenumberConsent">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Enter Phonenumber<span class="required">*</span></label>
									<input autocomplete="off" type="number" name="phonenumberOfferForm" id="phonenumberOfferForm"  class="form-control"/>
									<div class="text-danger" id="phonenumberOfferForm_label"></div> 
								  </div>    
								</div>							
						</div>
						</div>						
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="consentSignature">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseconsentSignature" aria-expanded="false" aria-controls="collapseconsentSignature">
								SIGNATURE 
								</button>
							</h5>
							</div>	
							<div id="collapseconsentSignature" class="collapse" aria-labelledby="consentSignature" data-parent="#accordion">
							<div class="row">
							<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of Caregiver<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="caregiver_name" id="caregiver_name" class="form-control" />
									<div class="text-danger" id="caregiver_name_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Signature<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="caregiver_signatureOffer" id="caregiver_signatureOffer"  class="form-control"/>
									<div class="text-danger" id="caregiver_signatureOffer_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="caregiver_date" id="caregiver_date"  class="form-control"/>
									<div class="text-danger" id="caregiver_date_label"></div> 
								  </div>    
								</div>
							</div>		
							<div class="row">
							<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of Facility Staff<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="facility_staff_name" id="facility_staff_name" class="form-control" />
									<div class="text-danger" id="facility_staff_name_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Signature<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="facility_staff_signature" id="facility_staff_signature"  class="form-control"/>
									<div class="text-danger" id="facility_staff_signature_label"></div> 
								  </div>    
								</div>
								<div class="col-md-4">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="facility_staff_date" id="facility_staff_date"  class="form-control"/>
									<div class="text-danger" id="facility_staff_date_label"></div> 
								  </div>    
								</div>
							</div>		
						</div>					
						</div>
							  <button type="submit" id="submitOfferForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW OFFER FORM MODAL-- END -->	
<!-- NEW CAREGIVER STATUS UPDATE-- START -->	
<div class="modal fade bd-example-modal-xl" id="updateCaregiverStatusFormModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Beneficiary Status Update Form:&nbsp; <span  class="btn btn-primary" id="hh_beneficiary_id"></span><button  onclick="modalExitButtonCaregiverStatusUpdate()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">

						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryFormBeneficiaryStatusUpdate">
							<div id="accordion">
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="primaryCaregiverInformationUpdate">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseprimaryCaregiverInformationUpdate" aria-expanded="false" aria-controls="collapseprimaryCaregiverInformationUpdate">
									Caregiver Information
								</button>
							</h5>
							</div>	
							<div id="collapseprimaryCaregiverInformationUpdate" class="collapse show" aria-labelledby="primaryCaregiverInformationUpdate" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Surname<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="upd_cg_surname" id="upd_cg_surname" class="form-control" />
									<div class="text-danger" id="upd_cg_surname_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Firstname<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="upd_cg_firstname" id="upd_cg_firstname" class="form-control"/>
									<div class="text-danger" id="upd_cg_firstname_label"></div>
									</div>
								</div>									
							</div>							
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Gender(sex)<span class="required">*</span><span class="required"></span></label>
									<select name="upd_cg_gender" id="upd_cg_gender" class="form-select" style="width: 100%">
									<option disabled selected>Select Gender</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Gender' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="upd_cg_gender_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of Birth<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="upd_cg_dob" id="upd_cg_dob" max="<?php echo Date('Y-m-d'); ?>" class="form-control" />
									<div class="text-danger" id="upd_cg_dob_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Phonenumber<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="number" name="upd_cg_phonenumber" id="upd_cg_phonenumber" class="form-control" />
									<div class="text-danger" id="upd_cg_phonenumber_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of Enrollment</label>
									<input autocomplete="off" type="date" name="upd_enrollmentdate" id="upd_enrollmentdate" class="form-control"/>
									<div class="text-danger" id="upd_enrollmentdate_label"></div>
									</div>
								</div>									
							</div>							
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Marital Status<span class="required">*</span><span class="required"></span></label>
									<select name="upd_cg_marital_status" id="upd_cg_marital_status" class="form-select" style="width: 100%">
									<option disabled selected>Select Marital Status</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Marital_Status' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="upd_cg_marital_status_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Occupation<span class="required">*</span><span class="required"></span></label>
									<select name="upd_cg_occupation" id="upd_cg_occupation" class="form-select" style="width: 100%">
									<option disabled selected>Select Occupation</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='Occupation' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="upd_cg_occupation_label"></div>
									</div>
								</div>									
							</div>	
							<hr/>
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>HIV Status<span class="required">*</span><span class="required"></span></label>
									<select name="upd_cg_hiv_status" id="upd_cg_hiv_status" class="form-select" style="width: 100%">
									<option disabled selected>Select HIV Status</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='hiv_status' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="upd_cg_hiv_status_label"></div>
									</div>
								</div>										
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Date of HIV Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="upd_cg_datehivstatus" id="upd_cg_datehivstatus" class="form-control" disabled/>								
									<div class="text-danger" id="upd_cg_datehivstatus_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px">
									<label>Enrolled on Treatment?<span class="required">*</span><span class="required"></span></label>
									<select name="upd_cg_enrolledontreatment" id="upd_cg_enrolledontreatment" class="form-select" style="width: 100%" disabled>
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value!='N/A' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="upd_cg_enrolledontreatment_label"></div>
									</div>
								</div>										
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>ART Start Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="upd_cg_artstartdate" id="upd_cg_artstartdate" class="form-control" disabled/>								
									<div class="text-danger" id="upd_cg_artstartdate_label"></div>
									</div>
								</div>										
							</div>	
							<div class="row">
								<div class="col-md-6">
									<div class="form-group first" style="margin-left: 5px;"  >
									<label>Facility Enrolled<span class="required">*</span></label>
									<select name="upd_cg_facilityenrolled" id="upd_cg_facilityenrolled" class="form-select" style="width: 100%" disabled >
									<option disabled selected></option>
										<?php
										$sql = "SELECT facilityname,facilityid 
                                                FROM referraldirectory 
                                                WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
                                                SELECT uid FROM organizationunit WHERE parentid IN (
                                                SELECT uid FROM organizationunit WHERE ouname='$state'))) order by facilityname asc
                                                ";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['facilityname'] ?>"><?php echo $row['facilityname'] ?></option>
									<?php } ?>									
									</select>
									<div class="text-danger" id="upd_cg_facilityenrolled_label"></div> 
									</div>    
									</div>
								<div class="col-md-6">
									<div class="form-group first" style="margin-right: 5px;" id="div_treatment_art_no">
									<label>Treatment/ART No<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="upd_cg_treatment_art_no" id="upd_cg_treatment_art_no" class="form-control" disabled/>	
									</select>
									<div class="text-danger" id="upd_cg_treatment_art_no_label"></div> 
									</div>    
									</div>
							  </div>
						</div>
						</div>	
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="beneficiaryStatusUpdate">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsebeneficiaryStatusUpdate" aria-expanded="true" aria-controls="collapsebeneficiaryStatusUpdate">
								BENEFICIARY STATUS 
								</button>
							</h5>
							</div>	
							<div id="collapsebeneficiaryStatusUpdate" class="collapse" aria-labelledby="beneficiaryStatusUpdate" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px; margin-right: 5px" >
									<label>Beneficiary Type<span class="required">*</span><span class="required"></span></label>
									<select name="upd_beneficiary_type" id="upd_beneficiary_type" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='beneficiary_type'";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="upd_beneficiary_type_label"></div>
									</div>
								</div>		
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Beneficiary ID<span class="required">*</span></label>
									<input autocomplete="off" type="text" name="upd_beneficiary_id" id="upd_beneficiary_id" class="form-control" readonly />
									<div class="text-danger" id="upd_beneficiary_id_label"></div> 
								  </div>    
								</div>
							</div>
						</div>					
						</div>						
						</div>
							  <button type="submit" id="submitNewCaregiverUpdateForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						</form>
							</div>
							</div>

					  </div>    
			</div>
  </div>
</div>
<!-- NEW CAREGIVER STATUS UPDATE-- END -->	
<!-- NEW Caregiver Access To Emergency Fund Checklist MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newaccessToEmergencyFundForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Caregiver Access To Emergency Fund Checklist: &nbsp; <span id="beneficiary_id_for_ef" class="btn btn-primary"></span><span id="record_id_ef" class="btn btn-info"></span><button onclick="closeModalButtonEmergencyFundChkList()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryFormEmergencyFund">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="accessToEmergencyFund">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseaccessToEmergencyFund" aria-expanded="true" aria-controls="collapseaccessToEmergencyFund">
								Caregiver Access To Emergency Fund
								</button>
							</h5>
							</div>	
							<div id="collapseaccessToEmergencyFund" class="collapse show" aria-labelledby="accessToEmergencyFund" data-parent="#accordion">
							<div class="row" id="q1">
							  <div class="col-md-12">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label id="efserviceQuestion1">Did you make any unexpected expenditure in the past six (6) months?<span class="required">*</span></label>
								  <select name="efresponseQuestion1" id="efresponseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value NOT IN ('N/A') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
									<div class="text-danger" id="efresponseQuestion1_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row" id="q2" style="display: none">
							  <div class="col-md-12">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label id="efserviceQuestion2">If “Yes”, were you able to access money to pay for this unexpected expenditure?<span class="required">*</span></label>
								  <select name="efresponseQuestion2" id="efresponseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value NOT IN ('N/A') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
									<div class="text-danger" id="efresponseQuestion2_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row" id="q3" style="display: none">
							  <div class="col-md-12">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label id="efserviceQuestion3">What are the household (HH) needs requiring routine and/or emergency cash to address?<span class="required">*</span></label>
								<table class="table table-bordered" id="table_q3" style="border: 1; width: 100%;">  
								<tr>  
									<td>Borrowed from a friend</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_1" name="efresponseQuestion3[]" value="Borrowed from a friend"></td>
									<td>Income from trade</td> 
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_2" name="efresponseQuestion3[]" value="Income from trade"></td> 
									<td>Through my salary</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_3" name="efresponseQuestion3[]" value="Through my salary"></td>
								</tr>  
								<tr>  
								<td>Took a loan/Received Amount saved or social fund from a SILC group</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_4" name="efresponseQuestion3[]" value="Took a loan/Received Amount saved or social fund from a SILC group"></td>
								<td>Sold some items in the house</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_5" name="efresponseQuestion3[]" value="Sold some items in the house"></td>
								<td>From my personal savings</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_6" name="efresponseQuestion3[]" value="From my personal savings"></td>
								</tr> 
								<tr>  
								<td>Others<input style="margin-left: 5px" type="checkbox" id="efresponseQuestion3_7" name="efresponseQuestion3[]" value="Others"></td>  
								<td>									
									<div id="divefresponseQuestion3_other" class="form-group last mb-3" style="margin-left: 5px; display: none" >
									<label>Specify Others <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="efresponseQuestion3_other" id="efresponseQuestion3_other" class="form-control" />
										<div class="text-danger" id="efresponseQuestion3_other_label"></div>
									</div>
								</td>  
								<td></td>  
								</tr> 
								</table> 
									<div class="text-danger" id="efresponseQuestion3_label"></div> 
								  </div>    
								</div>
							</div>	
							<div class="row" id="q4" style="display: none">
							  <div class="col-md-12">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label id="efserviceQuestion4">How were you able to raise income? ?<span class="required">*</span></label>
								  <table class="table table-bordered" id="table_q4" style="border: 1; width: 100%;">  
								<tr>  
									<td>Food</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_1" name="efresponseQuestion4[]" value="Food"></td>
									<td>Agriculture Inputs</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_2" name="efresponseQuestion4[]" value="Agriculture Inputs"></td>
									<td>Clothes/Shoes</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_3" name="efresponseQuestion4[]" value="Clothes/Shoes"></td>
									<td>Debt Repayment</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_4" name="efresponseQuestion4[]" value="Debt Repayment"></td>
									<td>Businesss Investment</td>  
									<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_5" name="efresponseQuestion4[]" value="Businesss Investment"></td>
								</tr>  
								<tr>  
								<td>Gift</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_6" name="efresponseQuestion4[]" value="Gift"></td>
								<td>Livestock</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_7" name="efresponseQuestion4[]" value="Livestock"></td>
								<td>Water</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_8" name="efresponseQuestion4[]" value="Water"></td>
								<td>Medical</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_9" name="efresponseQuestion4[]" value="Medical"></td>
								<td>Transport</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_10" name="efresponseQuestion4[]" value="Transport"></td>
								</tr> 
								<tr>  
								<td>House Rent/Shelter Materials</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_11" name="efresponseQuestion4[]" value="House Rent/Shelter Materials"></td>
								<td>Savings/In Hand/SILC</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_12" name="efresponseQuestion4[]" value="Savings/In Hand/SILC"></td>
								<td>Household Items</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_13" name="efresponseQuestion4[]" value="Household Items"></td>
								<td>Firewood</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_14" name="efresponseQuestion4[]" value="Firewood"></td>
								<td>Others</td>  
								<td><input style="margin-left: 5px" type="checkbox" id="efresponseQuestion4_15" name="efresponseQuestion4[]" value="Others"></td>
								</tr> 
								<tr>  
								<td>									
									<div id="divefresponseQuestion4_other" class="form-group last mb-3" style="margin-left: 5px; display: none" >
									<label>Specify Others <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="efresponseQuestion4_other" id="efresponseQuestion4_other" class="form-control" />
										<div class="text-danger" id="efresponseQuestion4_other_label"></div>
									</div>
								</td>  
								<td></td>  
								<td></td>  
								<td></td>  
								<td></td>  
								</tr> 
								</table> 
									<div class="text-danger" id="efresponseQuestion4_label"></div> 
								  </div>    
								</div>
							</div>	
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="efServiceProviderInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseefServiceProviderInformation" aria-expanded="false" aria-controls="collapseefServiceProviderInformation">
								Service Provider Information
								</button>
							</h5>
							</div>	
							<div id="collapseefServiceProviderInformation" class="collapse" aria-labelledby="efServiceProviderInformation" data-parent="#accordion">
							<div class="row">
								<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Service Date <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="service_date_ef" id="service_date_ef" class="form-control" />
										<div class="text-danger" id="service_date_ef_label"></div>
									</div>
								</div>									
						</div>
						</div>
						</div>
						<button type="submit" id="submitEmergencyFundForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						<button type="submit" id="updateEmergencyFundForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW Caregiver Access To Emergency Fund Checklist MODAL-- END -->	
<!-- NEW REFERRAL FORM MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newreferralForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Referral Form: &nbsp; <span id="beneficiaryid_for_rf" class="btn btn-primary"></span><span id="record_id_rf" class="btn btn-info"></span><span id="record_date_rf" class="btn btn-info"></span><button onclick="closeModalReferral()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entryReferralForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="referralForm">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsereferralForm" aria-expanded="true" aria-controls="collapsereferralForm">
								Referral Details
								</button>
							</h5>
							</div>	
							<div id="collapsereferralForm" class="collapse show" aria-labelledby="referralForm" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Name of referring organization<span class="required">*</span></label>
								  <select name="referring_organization" id="referring_organization" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT cbo_code FROM cbo ORDER BY cbo_code asc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['cbo_code'] ?>"><?php echo $row['cbo_code'] ?></option>
										<?php } ?>									
										</select>									
									<div class="text-danger" id="referring_organization_label"></div> 
								  </div>    
								</div>
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Name of receiving organization <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="receiving_organization" id="receiving_organization" class="form-control" />
										<div class="text-danger" id="receiving_organization_label"></div>
									</div>
								</div>									
							</div>	
						</div>					
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="servicesReferredFor">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseservicesReferredFor" aria-expanded="true" aria-controls="collapseservicesReferredFor">
								Services Referred for
								</button>
							</h5>
							</div>	
							<div id="collapseservicesReferredFor" class="collapse" aria-labelledby="servicesReferredFor" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label style="font-size: 18px; text-align:center; font-weight: 700">HEALTHY<span class="required">*</span></label>
								  <table class="table table-bordered" style="border: 1; width: 100%;">  
								  <tr>  
									<td>Prevention Support (PrEP/Condoms/VMMC)</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_1" name="reservicereferred[]" value="Prevention Support (PrEP/Condoms/VMMC)"></td>  
									<td>Wasting/Edema</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_2" name="reservicereferred[]" value="Wasting/Edema"></td>  
									<td>Severe Acute Malnutrition (SAM)</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_3" name="reservicereferred[]" value="Severe Acute Malnutrition (SAM)"></td>  
									<td>Food and Nutrition Supplement</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_4" name="reservicereferred[]" value="Food and Nutrition Supplement"></td>  
									</tr>  
									<tr>  									
									<td>Water Treatment</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_5" name="reservicereferred[]" value="Water Treatment"></td>  
									<td>Insecticide Treated Nets</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_6" name="reservicereferred[]" value="Insecticide Treated Nets"></td>  
									<td>Vitamin A, Zinc & Iron Complements</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_7" name="reservicereferred[]" value="Vitamin A, Zinc & Iron Complements"></td>  
									<td>Emergency Healthcare</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_8" name="reservicereferred[]" value="Emergency Healthcare"></td>  
									</tr>  
									<tr>  
									<td>Routine Healthcare (e.g. Immunization)</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_9" name="reservicereferred[]" value="Routine Healthcare (e.g. Immunization)"></td>  
									<td>Sexual/Reproductive Health</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_10" name="reservicereferred[]" value="Sexual/Reproductive Health"></td>  
									<td>STI Treatment</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_11" name="reservicereferred[]" value="STI Treatment"></td>  
									<td>TB Diagnosis</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_12" name="reservicereferred[]" value="TB Diagnosis"></td>  
								</tr>  
								<tr>  
									<td>CD4 VL</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_13" name="reservicereferred[]" value="CD4 VL"></td>  
									<td>ART</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_14" name="reservicereferred[]" value="ART"></td>  
									<td>Early Infant Diagnosis (EID)</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_15" name="reservicereferred[]" value="Early Infant Diagnosis (EID)"></td>  
									<td>HIV Related Testing (HTS, PMTCT)</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_16" name="reservicereferred[]" value="HIV Related Testing (HTS, PMTCT)"></td>  
								</tr>  
								</table> 
								  </div>    
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label style="font-size: 18px; text-align:center; font-weight: 700">SAFE<span class="required">*</span></label>
								  <table class="table table-bordered" style="border: 1; width: 100%;">  
								  <tr>  
									<td>Emergency Shelter</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_17" name="reservicereferred[]" value="Emergency Shelter"></td>  
									<td>Post-violence Medical Services</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_18" name="reservicereferred[]" value="Post-violence Medical Services"></td>  
									<td>Birth Registration</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_19" name="reservicereferred[]" value="Birth Registration"></td>  
									<td>Life Building Skills</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_20" name="reservicereferred[]" value="Life Building Skills"></td>  
									</tr>  
									<tr>  									
									<td>Community Support Group</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_21" name="reservicereferred[]" value="Community Support Group"></td>  
									<td>Spiritual Support</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_22" name="reservicereferred[]" value="Spiritual Support"></td>  
									<td>Post-violence-trauma-informed counselling</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_23" name="reservicereferred[]" value="Post-violence-trauma-informed counselling"></td>  
									<td>Income generating activities</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_24" name="reservicereferred[]" value="Income generating activities"></td>  
									</tr>  
									<tr>  
									<td>Private and Public sector skills acquisition scheme</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_25" name="reservicereferred[]" value="Private and Public sector skills acquisition scheme"></td>  
									<td>Microfinance</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_26" name="reservicereferred[]" value="Microfinance"></td>  
									<td>Skill Acquisition training</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_27" name="reservicereferred[]" value="Skill Acquisition training"></td>  
									<td>Legal Services</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_28" name="reservicereferred[]" value="Legal Services"></td>  
								</tr>  
								</table> 
									<div class="text-danger" id="reservicereferred_label"></div> 
								  </div>    
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label style="font-size: 18px; text-align:center; font-weight: 700">STABLE<span class="required">*</span></label>
								  <table class="table table-bordered" style="border: 1; width: 100%;">  
								  <tr>  
								  <td>Income generating activities</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_29" name="reservicereferred[]" value="Income generating activities"></td>  
								  <td>Private and Public sector skills acquisition scheme</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_30" name="reservicereferred[]" value="Private and Public sector skills acquisition scheme"></td>  
									<td>Microfinance</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_31" name="reservicereferred[]" value="Microfinance"></td>  
									<td>Vocational Training</td><td><input style="margin-left: 5px" type="checkbox" id="reservicereferred_32" name="reservicereferred[]" value="Vocational Training"></td>  
									</tr>  
								</table> 
									<div class="text-danger" id="reservicereferred_label"></div> 
								  </div>    
								</div>
							</div>	
	
						</div>					
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="servicesReferredSectionB">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseservicesReferredSectionB" aria-expanded="true" aria-controls="collapseservicesReferredSectionB">
								Section B: (To be filled by person/representative receiving the referral)
								</button>
							</h5>
							</div>	
							<div id="collapseservicesReferredSectionB" class="collapse" aria-labelledby="servicesReferredSectionB" data-parent="#accordion">
							<div class="row">
							<div class="col-md-12">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Name of organization providing referral<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="organization_providingreferral" id="organization_providingreferral" class="form-control" />
										<div class="text-danger" id="organization_providingreferral_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-12">             
							<table  id="tbl" class="table table-bordered" style="border: 1; width: 100%;"> 
							<thead>
							<tr>
								<th>Service Provided</th>
								<th>Service Completed</th>
								<th>Follow Up Needed</th>
								<th>Follow Up Date</th>
								<th></th>
							</tr>
							<thead>
							<tbody>
							<tr>
								<td><input autocomplete="off" type="text" name="rf_service_provided[]" id="rf_service_provided" class="form-control" /></td>
								<td><select name="rf_service_completed[]" id="rf_service_completed" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
								</td>
								<td><select name="rf_followup_needed[]" id="rf_followup_needed" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
								</td>
								<td><input autocomplete="off" type="date" name="rf_followup_date[]" id="rf_followup_date" class="form-control" /></td>
								<td><button disabled class="btn btn-danger remove-row"><i class="fa fa-close"></i></button></th>
							</tr>
							</tbody>
							</table> 
							<button disabled id="addRFRow" style="margin-top: 5px;margin-bottom: 5px; margin-left:5px" class="btn px-5 btn-secondary add-row"><i class="fa fa-plus"></i></button>
						</div>									
							</div>	
							</div>					
						</div>		
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="servicesReferredSectionC">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseservicesReferredSectionC" aria-expanded="true" aria-controls="collapseservicesReferredSectionC">
								Section C: (To be filled by person/representative receiving the service)
								</button>
							</h5>
							</div>	
							<div id="collapseservicesReferredSectionC" class="collapse" aria-labelledby="servicesReferredSectionC" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Referral Status<span class="required">*</span><span class="required"></span></label>
									<select name="rf_referral_status" id="rf_referral_status" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='referral_status' ORDER BY keyword_value asc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="rf_referral_status_label"></div>
									</div>
								</div>	
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Referral Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="referral_date" id="referral_date" class="form-control" />
										<div class="text-danger" id="referral_date_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Name of person receiving referral form<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="referral_receiver" id="referral_receiver" class="form-control" />
										<div class="text-danger" id="referral_receiver_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Designation<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="referral_receiver_designation" id="referral_receiver_designation" class="form-control" />
										<div class="text-danger" id="referral_receiver_designation_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Phonenumber<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="number" name="referral_receiver_phonenumber" id="referral_receiver_phonenumber" class="form-control" />
										<div class="text-danger" id="referral_receiver_phonenumber_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>email<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="email" name="referral_receiver_email" id="referral_receiver_email" class="form-control" />
										<div class="text-danger" id="referral_receiver_email_label"></div>
									</div>
								</div>									
							</div>	
							</div>					
						</div>										
					</div>

					<button type="submit" id="submitReferralForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
					<button type="submit" id="updateReferralForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW REFERRAL FORM MODAL-- END -->	

</body>
</html>