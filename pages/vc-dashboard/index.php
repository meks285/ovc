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
 $sql = "SELECT vc_unique_id FROM vcenrollment WHERE vc_unique_id ='$data_id' and id='$query_id'";
 $result = mysqli_query($conn, $sql);
 $rows = mysqli_num_rows($result);
 if($rows == 0){
	echo '<script>alert("Not Permitted!")</script>';
    die(header("location:../../login.php?loginFailed=true&reason=forbidden"));
 }
 else{
	$vcUniqueId = $data_id;
 }
?>
<!doctype html>
<html lang="en">
<head>
  	<title>VC Dashboard | OVC</title>
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

<!-- Fomantic JS & CSS
<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css"/>
-->
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>	
<!-- Inhouse JS -->
<script src="./js/actions.js"></script>
<script src="./js/vcdashboard.js"></script>
<script src="./js/candsChecklist.js"></script>
<script src="./js/referralFunctions.js"></script>
<script src="./js/caregiverVcStatusUpdateList.js"></script>
<script src="./js/referralsList.js"></script>
<script src="./js/childEducationAssessment.js"></script>
<script src="./js/hivRiskAssessmentList.js"></script>
<script src="./js/nutritionalAssessmentList.js"></script>
<script src="./js/careAndSupportChecklistFunctions.js"></script>

<script>
    vcUniqueId = "<?php echo $vcUniqueId; ?>";
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
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle"><span style="font-weight: 600;">HouseHold<span style="font-size: 10px; margin-left: 2px" class="btn btn-primary">VC Dashboard</span></span></a>
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

			<h2 class="mb-4">Vulnerable Children Dashboard: <span class="btn btn-primary"><?php echo $vcUniqueId; ?></span></h2>
			<hr/>
			<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">

<div class="row">
<div class="col-md-4" id="divVCDashboard">             
		<div class="card text-white bg-danger mb-3" style="width: 100%;">
		<div class="card-header">Vulnerable Child: <span class="btn btn-primary" style="color: white;" id="vc_status"></span></div>
		<div class="card-body">
			<!-- <h5 class="card-title">Primary card title</h5> -->
			<p class="card-text"><span style="font-weight: 600;"></span><span class="btn btn-primary" style="color: white;" id="vc_id"></span></p>
			<p class="card-text"><span style="font-weight: 600;">NAME: </span><span class="btn btn-primary" style="color: white;" id="vc_name"></span></p>
			<p class="card-text"><span style="font-weight: 600;">GENDER: </span><span class="btn btn-primary" style="color: white;" id="vc_gender"></span></p>
			<p class="card-text"><span style="font-weight: 600;">AGE: </span><span class="btn btn-primary" style="color: white;" id="vc_age"></span></p>
			<hr/>
			<p class="card-text"><span style="font-weight: 600;">HIV STATUS: </span><span class="btn btn-primary" style="color: white;" id="hiv_status"></span></p>
		</div>
		</div>
	</div>
	<div class="col-md-8">        
	<div class="row" style="margin-left: 0px; margin-right: 0px">
	<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white">SERVICE FORMS</div>
		<div class="card-body bg-white">
		<div class="row">
		<div class="col-md-6">             
		<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Service Forms<span class="required">*</span><span class="required"></span></label>
									<select name="service_form" id="service_form" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='service_forms' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="service_forms_label"></div>
									</div>
		</div>
		<div class="col-md-2">
	<!-- <button type="submit" id="openServiceForm" data-target="#newcareandsupportChecklist" style="margin-top: 30px;" class="btn px-5 btn-primary">OPEN</button> -->
		<button type="submit" id="openServiceForm" class="btn btn-primary" style="margin-left: 5px; margin-top: 30px;" data-toggle="modal" data-whatever="@mdo">OPEN</button>

		</div>
	</div>			
	</div>
	</div>
	</div>
	<div class="row" style="margin-left: 0px; margin-right: 0px">
	<div class="card text-black bg-danger mb-3" style="width: 100%;">
		<div class="card-header text-white">ASSESSMENT FORMS</div>
		<div class="card-body bg-white">
		<div class="row">
		<div class="col-md-6">             
		<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Assessment Forms<span class="required">*</span><span class="required"></span></label>
									<select name="assessment_form" id="assessment_form" class="form-select" style="width: 100%">
									<option disabled selected>Select</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='assessment_forms' ORDER BY keyword_value ASC";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="assessment_form_label"></div>
									</div>
		</div>
		<div class="col-md-2">
	<!-- <button type="submit" id="openServiceForm" data-target="#newcareandsupportChecklist" style="margin-top: 30px;" class="btn px-5 btn-primary">OPEN</button> -->
		<button type="submit" id="openAssessmentForm" class="btn btn-primary" style="margin-left: 5px; margin-top: 30px;" data-toggle="modal" data-whatever="@mdo">OPEN</button>

		</div>
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
		<div class="card-header text-white"  id="careandSupportFormListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecareandSupportFormListTable" aria-expanded="false" aria-controls="collapsecareandSupportFormListTable">
		CARE & SUPPORT CHECKLIST </button>
	</div>
		<div id="collapsecareandSupportFormListTable" class="collapse show" aria-labelledby="careandSupportFormListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='careAndSupportTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>VC-ID</th>
									<th>Household ID</th>
									<th>on ART?</th>
									<th>Date</th>
									<th>Total Questions</th>
									<th>TotalYes</th>
									<th>TotalNo</th>
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
		<div class="card-header text-white" id="caregiverUpdateListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecaregiverUpdateListTable" aria-expanded="true" aria-controls="collapsecaregiverUpdateListTable">
		Caregiver & VC Status Updates (History) 
		</button>
			
		</div>
		<div id="collapsecaregiverUpdateListTable" class="collapse show" aria-labelledby="caregiverUpdateListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='caregiverVcStatusUpdateTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>Category</th>
									<th>Unique ID</th>
									<th>HIV Status</th>
									<th>HIV Test Date</th>
									<th>Birth Certificate?</th>
									<th>Child In Sch?</th>
									<th>Child in Vocational Training?</th>
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
									<th>Unique ID</th>
									<th>Referring Org</th>
									<th>Receiving Org</th>
									<th>Services</th>
									<th>Service Provided</th>
									<th>Service Completed?</th>
									<th>Follow Needed?</th>
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
		<div class="card-header text-white" id="childEducationAssessmentListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsechildEducationAssessmentListTable" aria-expanded="true" aria-controls="collapsechildEducationAssessmentListTable">
		Child Education Assessment
		</button>
			
		</div>
		<div id="collapsechildEducationAssessmentListTable" class="collapse show" aria-labelledby="childEducationAssessmentListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='childEducationAssessmentTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>VC Unique ID</th>
									<th>Question</th>
									<th>Question</th>
									<th>Question</th>
									<th>Question</th>
									<th>Question</th>
									<th>Question</th>
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
		<div class="card-header text-white" id="hivRiskAssessmentListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsehivRiskAssessmentListTable" aria-expanded="true" aria-controls="collapsehivRiskAssessmentListTable">
		Community based paed HIV risk Assessment
		</button>
			
		</div>
		<div id="collapsehivRiskAssessmentListTable" class="collapse show" aria-labelledby="hivRiskAssessmentListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='hivRiskAssessmentTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>VC Unique ID</th>
									<th>R/Ship to Child</th>
									<th>Child HIV status Known?</th>
									<th>HIV Status</th>
									<th>Question</th>
									<th>Question</th>
									<th>Question</th>
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
		<div class="card-header text-white" id="nutritionalAssessmentListTable">
		<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenutritionalAssessmentListTable" aria-expanded="true" aria-controls="collapsenutritionalAssessmentListTable">
		 Nutritional Assessment  
		</button>
			
		</div>
		<div id="collapsenutritionalAssessmentListTable" class="collapse show" aria-labelledby="nutritionalAssessmentListTable" data-parent="#accordion">
		<div class="card-body bg-white">
			<!-- <h5 class="card-title">Primary card title</h5> -->
				<!-- Page Information starts here -->
				<div class="content flex-column-fluid" id="kt_content" style="background-color:#fff;">
			<!-- Table -->
				<table id='nutritionalAssessmentTable' class='display dataTable' style="width: 100%;">
								<thead>
								<tr>
									<th>VC Unique ID</th>
									<th>Date</th>
									<th>Weight</th>
									<th>Height</th>
									<th>BMI</th>
									<th>Oedema</th>
									<th>MUAC</th>
									<th>Question</th>
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


	</div>
</div>

    <script src="../../js/popper.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/main.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!-- NEW Care & Support MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newcareandsupportChecklist" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Care & Support Checklist: <span  class="btn btn-primary" id="vc_unique_id_cf"></span><span id="record_id_cf"  class="btn btn-info"></span><button onclick="closeModalButtonCareSupportChkList()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="entrycandsChecklistForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="sectionA">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsesectionA" aria-expanded="true" aria-controls="collapsesectionA">
								Section A - ART
								</button>
							</h5>
							</div>	
							<div id="collapsesectionA" class="collapse show" aria-labelledby="sectionA" data-parent="#accordion">
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 60%">QUESTION</th>  
								<th style="width: 40%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="csquestion1">Is the Beneficiary currently on ART? </td>  
									<td>									
										<select name="csresponseQuestion1" id="csresponseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion1_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Which health facility is beneficiary currently receiving ART? </td>  
									<td>									
										<select name="artfacility" id="artfacility" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT facilityname,facilityid 
                                                FROM referraldirectory 
                                                WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
                                                SELECT uid FROM organizationunit WHERE parentid IN (
                                                SELECT uid FROM organizationunit WHERE ouname='$state'))) order by facilityname asc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['facilityname'] ?>"><?php echo $row['facilityname'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="artfacility_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Date of last drug pickup</td>  
									<td>									
									<input autocomplete="off" type="date" name="lastdrugpickupdate" id="lastdrugpickupdate" class="form-control"/>									
										<div class="text-danger" id="lastdrugpickupdate_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Current Regimen</td>  
									<td>									
										<select name="currentregimen" id="currentregimen" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='regimen_list'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="currentregimen_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Duration (days) of refill</td>  
									<td>									
										<select name="refillduration" id="refillduration" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword = 'refill_duration' ";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value']." Days" ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="refillduration_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Next clinical appointment date</td>  
									<td>									
    									<input autocomplete="off" type="date" name="nextappointmentdate" id="nextappointmentdate" class="form-control"/>									
    									<div class="text-danger" id="nextappointmentdate_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion2">Has the Beneficiary missed his/her ARVs more than two doses in a month in the last 3 months? </td>  
									<td>									
										<select name="csresponseQuestion2" id="csresponseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion2_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Check for reasons why people missed ARVs </td>  
									<td>									
										<select name="missedarvreason" id="missedarvreason" class="selectpicker w-100" multiple style="width: 100%">
										<option disabled></option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='missed_arv_reason'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="missedarvreason_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion3">Has the beneficiary experienced sore/rash/pain/discharge/bleeding from the vagina or penis in the last six months?</td>  
									<td>									
										<select name="csresponseQuestion3" id="csresponseQuestion3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion3_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion4">Has the beneficiary disclosed HIV status to his/her partner?</td>  
									<td>									
										<select name="csresponseQuestion4" id="csresponseQuestion4" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion4_label"></div>
									</td>  
								</tr>  
							</table>
						</div>					
						</div>
					</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="sectionB">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsesectionB" aria-expanded="false" aria-controls="collapsesectionB">
								Section B - Viral Load
								</button>
							</h5>
							</div>	
							<div id="collapsesectionB" class="collapse" aria-labelledby="sectionB" data-parent="#accordion">
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 60%">QUESTION</th>  
								<th style="width: 40%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="csquestion5">Has the Beneficiary carried out viral load test in the last one year?</td>  
									<td>									
										<select name="csresponseQuestion5" id="csresponseQuestion5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion5_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>When was the last viral load sample collected?</td>  
									<td>									
    									<input autocomplete="off" type="date" name="lastviralloadsampledate" id="lastviralloadsampledate" class="form-control"/>									
										<div class="text-danger" id="lastviralloadsampledate_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion6">Do you know the viral load test result?</td>  
									<td>									
										<select name="csresponseQuestion6" id="csresponseQuestion6" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion6_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>What was the result</td>  
									<td>									
    									<input autocomplete="off" type="text" name="viralloadtestresult" id="viralloadtestresult" class="form-control"/>									
										<div class="text-danger" id="viralloadtestresult_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Date result was received</td>  
									<td>									
    									<input autocomplete="off" type="date" name="viralloadtestresultdate" id="viralloadtestresultdate" class="form-control"/>									
										<div class="text-danger" id="viralloadtestresultdate_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Why was the viral load not done</td>  
									<td>									
    									<textarea autocomplete="off" name="whyviralloadnotdone" id="whyviralloadnotdone" class="form-control"></textarea>									
										<div class="text-danger" id="whyviralloadnotdone_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion7">Has the beneficiary received transportation support to access ARVs in the last six months?</td>  
									<td>									
										<select name="csresponseQuestion7" id="csresponseQuestion7" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion7_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion8">Is the viral load greater than 1,000 copies/ml?</td>  
									<td>									
										<select name="csresponseQuestion8" id="csresponseQuestion8" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion8_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion9">Completed EAC?</td>  
									<td>									
										<select name="csresponseQuestion9" id="csresponseQuestion9" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion9_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>What is the viral load result after EAC?</td>  
									<td>									
    									<input autocomplete="off" type="text" name="viralloadresultaftereac" id="viralloadresultaftereac" class="form-control"/>									
										<div class="text-danger" id="viralloadresultaftereac_label"></div>
									</td>  
								</tr>  
							</table>
						</div>
						</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="sectionC">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsesectionC" aria-expanded="false" aria-controls="collapsesectionC">
								Section C - TB Screening/Referral
								</button>
							</h5>
							</div>	
							<div id="collapsesectionC" class="collapse" aria-labelledby="sectionC" data-parent="#accordion">
							<table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 60%">QUESTION</th>  
								<th style="width: 40%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="csquestion10">Beneficiary has been coughing persistently for the last two weeks?</td>  
									<td>									
										<select name="csresponseQuestion10" id="csresponseQuestion10" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion10_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion11">Has the beneficiary been losing weight or not growing properly?</td>  
									<td>									
										<select name="csresponseQuestion11" id="csresponseQuestion11" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion11_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion12">Has the beneficiary been having fever for the last two weeks?</td>  
									<td>									
										<select name="csresponseQuestion12" id="csresponseQuestion12" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion12_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion13">Has the beneficiary been having night sweats for the last two weeks?</td>  
									<td>									
										<select name="csresponseQuestion13" id="csresponseQuestion13" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion13_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion14">Is there any member of the household that has any symptoms above or has been treated for TB in the past two years?</td>  
									<td>									
										<select name="csresponseQuestion14" id="csresponseQuestion14" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion14_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="csquestion15">Has the beneficiary been referred for TB Test?</td>  
									<td>									
										<select name="csresponseQuestion15" id="csresponseQuestion15" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="csresponseQuestion15_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td>Date of referral</td>  
									<td>									
    									<input autocomplete="off" type="date" name="tbreferraldate" id="tbreferraldate" class="form-control"/>									
										<div class="text-danger" id="tbreferraldate_label"></div>
									</td>  
								</tr>  
							</table>
						</div>
						</div>
						<div class="card" style="width: 100%; margin-top: 5px;" >
							<div class="card-header bg-danger" id="ServiceProviderSection">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseServiceProviderSection" aria-expanded="false" aria-controls="collapseServiceProviderSection">
								Service Provider
								</button>
							</h5>
							</div>	
							<div id="collapseServiceProviderSection" class="collapse" aria-labelledby="ServiceProviderSection" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Service Provider Name <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="serviceprovidername" id="serviceprovidername" class="form-control"  max="<?php echo Date('Y-m-d'); ?>"/>
										<div class="text-danger" id="serviceprovidername_label"></div>
									</div>
								</div>									
							  <div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Designation <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="serviceproviderdesignation" id="serviceproviderdesignation" class="form-control"  max="<?php echo Date('Y-m-d'); ?>"/>
										<div class="text-danger" id="serviceproviderdesignation_label"></div>
									</div>
								</div>									
							</div>
							<div class="row">
							  <div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Phone Number <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="tel" name="serviceproviderphone" id="serviceproviderphone" class="form-control"  max="<?php echo Date('Y-m-d'); ?>"/>
										<div class="text-danger" id="serviceproviderphone_label"></div>
									</div>
								</div>									
							  <div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Date <span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="datesigned" id="datesigned" class="form-control"  max="<?php echo Date('Y-m-d'); ?>"/>
										<div class="text-danger" id="datesigned_label"></div>
									</div>
								</div>									
							</div>
 							
						</div>
						</div>

						<button type="submit" id="submitCareSupportChecklistForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						<button type="submit" id="updateCareSupportChecklistForm" style="margin-top: 5px; display: none" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW Care & Support MODAL -- END -->	

<!-- NEW CareGiver & VC Status Update MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newcaregiverandVCStatusUpdate" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Caregiver & VC Status Update: <span  class="btn btn-primary" id="vc_unique_id_su"></span><span id="record_id_su" class="btn btn-info"></span><button onclick="closeModalButtonCaregiverAndVCModal()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="caregiverandVCStatusUpdateForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="childInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsechildInformation" aria-expanded="true" aria-controls="collapsechildInformation">
								CHILD INFORMATION 
								</button>
							</h5>
							</div>	
							<div id="collapsechildInformation" class="collapse show" aria-labelledby="childInformation" data-parent="#accordion">
							<div class="row">
							<div class="col-md-4">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 2px;" >
									<label>Name<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="fullname" id="fullname" class="form-control"/>									
										<div class="text-danger" id="fullname_label"></div>
									</div>
								</div>									
							<div class="col-md-4">             
									<div class="form-group last mb-3" style="margin-left: 2px;margin-right: 2px;" >
									<label>Sex<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="sex" id="sex" class="form-control"/>									
										<div class="text-danger" id="sex_label"></div>
									</div>
								</div>									
							<div class="col-md-4">             
									<div class="form-group last mb-3" style="margin-left: 2px;margin-right: 5px;" >
									<label>Current HIV Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="currenthivstatus" id="currenthivstatus" class="form-control"/>									
										<div class="text-danger" id="currenthivstatus_label"></div>
									</div>
								</div>									
							</div>								
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;" >
									<label>Enrollment Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="enrollmentstatus" id="enrollmentstatus" class="form-control"/>									
										<div class="text-danger" id="enrollmentstatus_label"></div>
									</div>
								</div>									
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px;" >
									<label>Date of Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="date_enrollmentstatus" id="date_enrollmentstatus" class="form-control"/>									
										<div class="text-danger" id="date_enrollmentstatus_label"></div>
									</div>
								</div>										
							</div>								
						</div>					
						</div>							    
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="hivTestInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsehivTestInformation" aria-expanded="true" aria-controls="collapsehivTestInformation">
								HIV Status Information Update 
								</button>
							</h5>
							</div>	
							<div id="collapsehivTestInformation" class="collapse show" aria-labelledby="hivTestInformation" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px;" >
									<label>New HIV Status<span class="required">*</span><span class="required"></span></label>
									<select name="su_hivstatus" id="su_hivstatus" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='hiv_status'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="su_hivstatus_label"></div>
									</div>
								</div>
    							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px;" >
									<label>Date of New Status<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="su_date_hivstatus" id="su_date_hivstatus" class="form-control"/>									
										<div class="text-danger" id="su_date_hivstatus_label"></div>
									</div>
								</div>									
							</div>								
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px;" >
									<label>Enrolled on Treatment?<span class="required">*</span><span class="required"></span></label>
									<select name="su_enrolledontreatment" id="su_enrolledontreatment" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="su_enrolledontreatment_label"></div>
									</div>
								</div>
    							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px;" >
									<label>Facility Enrolled<span class="required">*</span><span class="required"></span></label>
									<select name="su_facilityenrolled" id="su_facilityenrolled" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT facilityname,facilityid 
                                                    FROM referraldirectory 
                                                    WHERE organizationunitid IN ( SELECT uid FROM organizationunit WHERE parentid IN ( 
                                                    SELECT uid FROM organizationunit WHERE parentid IN (
                                                    SELECT uid FROM organizationunit WHERE ouname='$state')))";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['facilityname'] ?>"><?php echo $row['facilityname'] ?></option>
										<?php } ?>									
										</select>										
										<div class="text-danger" id="su_facilityenrolled_label"></div>
									</div>
								</div>									
							</div>								
							<div class="row">
    							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;" >
									<label>ART Start Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="su_artstartdate" id="su_artstartdate" class="form-control"/>									
										<div class="text-danger" id="su_artstartdate_label"></div>
									</div>
								</div>	
    							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px;" >
									<label>Treatment/ART No.<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="su_treatment_art_no" id="su_treatment_art_no" class="form-control"/>									
										<div class="text-danger" id="su_treatment_art_no_label"></div>
									</div>
								</div>									
							</div>								

						</div>					
						</div>
						<div class="card" style="width: 100%;"  id="currentBirthEducationStatus" >
							<div class="card-header text-white bg-danger">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecurrentBirthEducationStatus" aria-expanded="true" aria-controls="collapsecurrentBirthEducationStatus">
								Birth Registration & Education 
								</button>
							</h5>
							</div>	
							<div id="collapsecurrentBirthEducationStatus" class="collapse" aria-labelledby="currentBirthEducationStatus" data-parent="#accordion">
							<div class="row">								
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px">
									<label>Child has Birth Certificate? <span class="required">*</span><span class="required"></span></label>
									<select name="su_childhasbirthcertificate" id="su_childhasbirthcertificate" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="su_childhasbirthcertificate_label"></div>
									</div>
								</div>											
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px">
									<label>Child in School? <span class="required">*</span><span class="required"></span></label>
									<select name="su_childinschool" id="su_childinschool" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="su_childinschool_label"></div>
									</div>
								</div>											
							</div>
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Name of School<span class="required">*</span><span class="required"></span></label>
									<select name="su_schoolname" id="su_schoolname" class="form-select" style="width: 100%">
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
									<div class="text-danger" id="su_schoolname_label"></div>
									</div>
								</div>										
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Grade/Form<span class="required">*</span><span class="required"></span></label>
									<select name="su_schoolgrade" id="su_schoolgrade" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "select distinct gradename as gradename from schoolgrade order by gradename asc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['gradename'] ?>"><?php echo $row['gradename'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="su_schoolgrade_label"></div>
									</div>
								</div>										
							</div>								
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px" >
									<label>Is Child on Vocational Training<span class="required">*</span><span class="required"></span></label>
									<select name="su_childonvocationaltraining" id="su_childonvocationaltraining" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' ORDER BY keyword_value desc";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
									<?php } ?>									
									</select>									
									<div class="text-danger" id="su_childonvocationaltraining_label"></div>
									</div>
								</div>										
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-right: 5px" >
									<label>Name of Vocational Training Institute<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="su_vocationalinstitute" id="su_vocationalinstitute" class="form-control"/>									
									<div class="text-danger" id="su_vocationalinstitute_label"></div>
									</div>
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
									<label>Caregiver Name <span class="required">*</span><span class="required"></span></label>
									<select name="su_caregivername" id="su_caregivername" class="form-select" style="width: 100%">
									<option disabled selected>Response</option>
										<?php
										$sql = "SELECT concat(surname,' ',firstname ) as caregiver FROM hh_vulnerability_assessment WHERE hh_unique_num=SUBSTR('$data_id',1,17)";
										$result = mysqli_query($conn, $sql);
										while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row['caregiver'] ?>"><?php echo $row['caregiver'] ?></option>
									<?php } ?>									
									</select>										
									<div class="text-danger" id="su_caregivername_label"></div>
									</div>
								</div>								
						</div>
						</div>
					</div>
					<div class="card" style="width: 100%; margin-top: 5px;" >
						<div class="card-header bg-danger" id="enrollmentExitInformation">
						<h5 class="mb-0">
							<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseenrollmentExitInformation" aria-expanded="false" aria-controls="collapseenrollmentExitInformation">
							Beneficiary Enrollment/Exit Status
							</button>
						</h5>
						</div>	
						<div id="collapseenrollmentExitInformation" class="collapse" aria-labelledby="enrollmentExitInformation" data-parent="#accordion">
							<div class="row">
								<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Update Child Enrollment Status<span class="required">*</span></label>
										<select name="su_enrollmentstatus" id="su_enrollmentstatus" class="form-select" style="width: 100%">
										<option disabled selected>Select</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='follow_up' ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
									<div class="text-danger" id="su_enrollmentstatus_label"></div> 
								  </div>    
								</div>							    
							<div class="col-md-6">
								  <div class="form-group first" style="margin-left: 5px; margin-right: 5px;">
								  <label>Date<span class="required">*</span></label>
									<input autocomplete="off" type="date" name="su_enrollmentstatus_date" id="su_enrollmentstatus_date" max="<?php echo Date('Y-m-d'); ?>" class="form-control"/>
									<div class="text-danger" id="su_enrollmentstatus_date_label"></div> 
								  </div>    
								</div>
							</div>
						</div>
					</div>
					
						<button type="submit" id="submitcaregiverandVCStatusUpdateForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						<button type="submit" id="updatecaregiverandVCStatusUpdateForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW CareGiver & VC Status Update MODAL -- END -->	


<!-- NEW REFERRAL FORM MODAL -- BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newreferralForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Referral Form: &nbsp; <span id="vc_unique_id_for_rf" class="btn btn-primary"></span><span id="record_id_rf" class="btn btn-info"></span><span id="record_date_rf" class="btn btn-info"></span><button onclick="closeModalReferral()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
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
								<td><button class="btn btn-danger remove-row"><i class="fa fa-close"></i></button></th>
							</tr>
							</tbody>
							</table> 
							<button id="addRFRow" style="margin-top: 5px;margin-bottom: 5px; margin-left:5px" class="btn px-5 btn-secondary add-row"><i class="fa fa-plus"></i></button>
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
									<input autocomplete="off" type="text" name="referral_receiver_phonenumber" id="referral_receiver_phonenumber" class="form-control" />
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
<!-- NEW Child Educational Performance Assessment Tool BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newChildEducationalPerfAssForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Child Educational Performance Assessment Tool: &nbsp; <span id="vc_unique_id_for_cepa" class="btn btn-primary"></span><span id="record_id_for_cepa" class="btn btn-info"></span><button onclick="closeModalChildEduPerfAssess()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="childEducationalPerfAssForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="referralForm">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsechildEducationalPerfAssForm" aria-expanded="true" aria-controls="collapsechildEducationalPerfAssForm">
								Physical & Psychosocial Assessment
								</button>
							</h5>
							</div>	
							<div id="collapsechildEducationalPerfAssForm" class="collapse show" aria-labelledby="childEducationalPerfAssForm" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 80%">QUESTION</th>  
								<th style="width: 20%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="ppassessmentQuestion1">Child has injuries or marks that cannot be explained by the child</td>  
									<td>									
										<select name="ppassessmentresponseQuestion1" id="ppassessmentresponseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="ppassessmentresponseQuestion1_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="ppassessmentQuestion2">Child is socially withdrawn among peers</td>  
									<td>									
										<select name="ppassessmentresponseQuestion2" id="ppassessmentresponseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="ppassessmentresponseQuestion2_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="ppassessmentQuestion3">Child shows signs of fatigue and constant tiredness</td>  
									<td>									
										<select name="ppassessmentresponseQuestion3" id="ppassessmentresponseQuestion3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="ppassessmentresponseQuestion3_label"></div>
									</td>  
								</tr>  
							</table>   
								</div>								
							</div>	
						</div>					
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="academicAssessment">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseacademicAssessment" aria-expanded="true" aria-controls="collapseacademicAssessment">
								Academic Assessment
								</button>
							</h5>
							</div>	
							<div id="collapseacademicAssessment" class="collapse" aria-labelledby="academicAssessment" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" id="services_table" style="border: 1; width: 100%;">  
								<tr>  
								<th style="width: 80%">QUESTION</th>  
								<th style="width: 20%">RESPONSE</th>  
								</tr>  
								<tr>  
									<td id="aaassessmentQuestion1">Child attends school regularly- not missing more than 2 days in the last one month- 4 weeks</td>  
									<td>									
										<select name="aaassessmentresponseQuestion1" id="aaassessmentresponseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="aaassessmentresponseQuestion1_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="aaassessmentQuestion2">Child shows steady improvement in his/her class work</td>  
									<td>									
										<select name="aaassessmentresponseQuestion2" id="aaassessmentresponseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="aaassessmentresponseQuestion2_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="aaassessmentQuestion3">Child resumes early at school</td>  
									<td>									
										<select name="aaassessmentresponseQuestion3" id="aaassessmentresponseQuestion3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="aaassessmentresponseQuestion3_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="aaassessmentQuestion4">Child performed very well in the last Examination</td>  
									<td>									
										<select name="aaassessmentresponseQuestion4" id="aaassessmentresponseQuestion4" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="aaassessmentresponseQuestion4_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td id="aaassessmentQuestion5">Child progressed in school to a higher class in the new school year</td>  
									<td>									
										<select name="aaassessmentresponseQuestion5" id="aaassessmentresponseQuestion5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="aaassessmentresponseQuestion5_label"></div>
									</td>  
								</tr>  
							</table>   
								</div>
							</div>	
	
						</div>					
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="serviceProviderInformation">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseserviceProviderInformation" aria-expanded="true" aria-controls="collapseserviceProviderInformation">
								Service Provider Information
								</button>
							</h5>
							</div>	
							<div id="collapseserviceProviderInformation" class="collapse" aria-labelledby="serviceProviderInformation" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Community volunteer (CV)/CSO staff name<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="cso_staffname" id="cso_staffname" class="form-control" />
										<div class="text-danger" id="cso_staffname_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="cso_date" id="cso_date" class="form-control" />
										<div class="text-danger" id="cso_date_label"></div>
									</div>
								</div>									
							</div>	
							<div class="row">
							<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Class Teacher/Trainer Name<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="teacher_name" id="teacher_name" class="form-control" />
										<div class="text-danger" id="teacher_name_label"></div>
									</div>
								</div>									
								<div class="col-md-6">             
									<div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="teacher_date" id="teacher_date" class="form-control" />
										<div class="text-danger" id="teacher_date_label"></div>
									</div>
								</div>									
							</div>	
							</div>					
						</div>										
					</div>

					<button type="submit" id="submitEducationalPerformanceForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
					<button type="submit" id="updateEducationalPerformanceForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>

<!-- NEW Child Educational Performance Assessment Tool END -->	

<!-- NEW Community Based PAEDS HIV Risk Assessment Checklist BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newcommunityBasedPaedsForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Community Based PAEDS HIV Risk Assessment Checklist: &nbsp; <span id="vc_unique_id_for_cbpaeds" class="btn btn-primary"></span><span id="record_id_for_cbpaeds" class="btn btn-info"></span><button onclick="closeModalRiskAssess()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="communityBasedPaedsForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="communityBasedPaedsForm">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecommunityBasedPaedsForm" aria-expanded="true" aria-controls="collapsecommunityBasedPaedsForm">
								General Information
								</button>
							</h5>
							</div>	
							<div id="collapsecommunityBasedPaedsForm" class="collapse show" aria-labelledby="communityBasedPaedsForm" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Relationship of Respondent to Child<span class="required">*</span><span class="required"></span></label>
									<select name="respondent_childrelationship" id="respondent_childrelationship" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='caregiver_rship_to_child'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>										
										<div class="text-danger" id="respondent_childrelationship_label"></div>
									</div>								
								</div>
							</div>	
									
							<div class="row">
								<div class="col-md-6">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Do you know the HIV status of Child<span class="required">*</span><span class="required"></span></label>
									<select name="childhivstatusknowledge" id="childhivstatusknowledge" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>										
										<div class="text-danger" id="childhivstatusknowledge_label"></div>
									</div>
								</div>									
								<div class="col-md-6">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px; display: none" id="childhivstatus_div" >
									<label>Childs HIV Status<span class="required">*</span><span class="required"></span></label>
									<select name="childhivstatus_paeds" id="childhivstatus_paeds" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='hiv_status'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>										
										<div class="text-danger" id="childhivstatus_paeds_label"></div>
									</div>
								</div>									
								</div>	
						</div>					
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="communityBasedPaedsFormSectionA">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecommunityBasedPaedsFormSectionA" aria-expanded="true" aria-controls="collapsecommunityBasedPaedsFormSectionA">
								Section A
								</button>
							</h5>
							</div>	
							<div id="collapsecommunityBasedPaedsFormSectionA" class="collapse" aria-labelledby="communityBasedPaedsFormSectionA" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" style="border: 1; width: 100%;">  
							  <tr>  
								<td colspan="4" id="cbp_mainQuestion1" style="font-weight: bold">Is the child/adolescents caregiver/biological parent:</td>  
								</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_subQuestion1_1">HIV-positive?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse1_1" id="cbp_subQuestionResponse1_1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse1_1_label"></div>
									</td>  
									<td style="width: 30%" id="cbp_subQuestion2_1">Having a long standing sickness (frequent hospital visits/admissions, frequent use of medicines)?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse2_1" id="cbp_subQuestionResponse2_1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse2_1_label"></div>
									</td>  
								</tr>  
								<tr>  
								<td colspan="4" id="cbp_mainQuestion2" style="font-weight: bold">Does the child/adolescent have a sibling that is:</td>  
								</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_subQuestion1_2">HIV-positive?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse1_2" id="cbp_subQuestionResponse1_2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse1_2_label"></div>
									</td>  
									<td style="width: 30%" id="cbp_subQuestion2_2">Having a long standing sickness (frequent hospital visits/admissions, frequent use of medicines)?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse2_2" id="cbp_subQuestionResponse2_2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse2_2_label"></div>
									</td>  
								</tr>  
								<tr>  
								<td colspan="4" id="cbp_mainQuestion3" style="font-weight: bold">In the last three months, has this child/adolescent:</td>  
								</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_subQuestion1_3">Been sick (e.g. frequent hospital visits/admissions, frequent use of medicines)?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse1_3" id="cbp_subQuestionResponse1_3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse1_3_label"></div>
									</td>  
									<td style="width: 30%" id="cbp_subQuestion2_3">Has had ≥ 2 of following: Frequent Cough, longstanding Fever, longstanding Diarrhoea, Loss of weight//poor weight gain, longstanding/ frequent skin rash?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse2_3" id="cbp_subQuestionResponse2_3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse2_3_label"></div>
									</td>  
								</tr>  
								<tr>  
								<td colspan="2" id="cbp_Question4" style="font-weight: bold">Has the child/adolescent ever had Tuberculosis (TB) in the past?:</td>  
								<td colspan="2">									
										<select name="cbp_QuestionResponse4" id="cbp_QuestionResponse4" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_QuestionResponse4_label"></div>
									</td>  
							</tr>  
								<tr>  
								<td colspan="4" id="cbp_mainQuestion5" style="font-weight: bold">Has the child:</td>   						
							</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_subQuestion1_5">ever received blood transfusion?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse1_5" id="cbp_subQuestionResponse1_5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse1_5_label"></div>
									</td>  
									<td style="width: 30%" id="cbp_subQuestion2_5">had any of the following in the last 3 months: circumcision, ear piercing, scarification, injection/drip outside the hospital</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse2_5" id="cbp_subQuestionResponse2_5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse2_5_label"></div>
									</td>  
								</tr>  
								<tr>  
								<td colspan="4" id="cbp_mainQuestion6" style="font-weight: bold">Has the child/adolescent ever been:</td>   						
							</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_subQuestion1_6">Forced to have sex (any form)?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse1_6" id="cbp_subQuestionResponse1_6" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse1_6_label"></div>
									</td>  
									<td style="width: 30%" id="cbp_subQuestion2_6">Pregnant (female children)?</td>  
									<td style="width: 20%">									
										<select name="cbp_subQuestionResponse2_6" id="cbp_subQuestionResponse2_6" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_subQuestionResponse2_6_label"></div>
									</td>  
								</tr>  
							</table>   
								</div>
							</div>	
	
						</div>					
						</div>	
						<div class="card" style="width: 100%;" id="communityBasedPaedsFormSectionBCard">
							<div class="card-header text-white bg-danger" id="communityBasedPaedsFormSectionB">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecommunityBasedPaedsFormSectionB" aria-expanded="true" aria-controls="collapsecommunityBasedPaedsFormSectionA">
								Section B (To be filled by children of ages 15-17)
								</button>
							</h5>
							</div>	
							<div id="collapsecommunityBasedPaedsFormSectionB" class="collapse" aria-labelledby="communityBasedPaedsFormSectionB" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" style="border: 1; width: 100%;">  
							  <tr>  
									<td style="width: 30%" id="cbp_Question7">Have you ever had sex in the past? (anal, vaginal or oral)?</td>  
									<td style="width: 20%">									
										<select name="cbp_QuestionResponse7" id="cbp_QuestionResponse7" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_QuestionResponse7_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_Question8">Have you experienced painful urination, lower abdominal pain, vaginal or penile discharge in the past?</td>  
									<td style="width: 20%">									
										<select name="cbp_QuestionResponse8" id="cbp_QuestionResponse8" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_QuestionResponse8_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td style="width: 30%" id="cbp_Question9">Have you experienced painful urination, lower abdominal pain, vaginal or penile discharge in the past?</td>  
									<td style="width: 20%">									
										<select name="cbp_QuestionResponse9" id="cbp_QuestionResponse9" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="cbp_QuestionResponse9_label"></div>
									</td>  
								</tr>  
								<tr>  
									<td style="width: 80%; font-style: italic; font-weight: bold">Child/Adolescent at risk?</td>  
									<td style="width: 20%">									
									<select name="childatrisk" id="childatrisk" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No') ORDER BY keyword_value desc";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="childatrisk_label"></div>
									</td>  
								</tr>  
							</table>   
								</div>
							</div>	
	
						</div>					
						</div>	
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="communityBasedPaedsServiceProviderForm">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsecommunityBasedPaedsServiceProviderForm" aria-expanded="true" aria-controls="collapsecommunityBasedPaedsServiceProviderForm">
								Service Provider Information
								</button>
							</h5>
							</div>	
							<div id="collapsecommunityBasedPaedsServiceProviderForm" class="collapse" aria-labelledby="communityBasedPaedsServiceProviderForm" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Service Provider<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="serviceprovider" id="serviceprovider" class="form-control"/>
										<div class="text-danger" id="serviceprovider_label"></div>
									</div>								
								</div>
								<div class="col-md-6">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Service Provision Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="serviceprovisiondate" id="serviceprovisiondate" class="form-control"/>
										<div class="text-danger" id="serviceprovisiondate_label"></div>
									</div>								
								</div>
							</div>	
						</div>					
						</div>																					
						</div>

						<button type="submit" id="submitcommunityBasedPaedsForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						<button type="submit" id="updatecommunityBasedPaedsForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>

<!-- NEW Community Based PAEDS HIV Risk Assessment Checklist END -->	

<!-- NEW Nutritional Assessment Form BEGIN -->	
<div class="modal fade bd-example-modal-xl" id="newnutritionalAssessmentForm" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
	<header class="modal-header" style="font-size: 20px">Nutritional Assessment Checklist: &nbsp; <span id="vc_unique_id_for_na" class="btn btn-primary"></span><span id="record_id_for_na" class="btn btn-info"></span><button onclick="closeModalNutriAssess()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></header>
	<div class="container form-style-1">
						<div class="row align-items-center justify-content-center">
						  <div class="col-md-9 py-5">					
							<form onsubmit="return false" id="nutritionalAssessmentForm">
							<div id="accordion">
							<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="nutritionalAssessmentForm">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenutritionalAssessmentForm" aria-expanded="true" aria-controls="collapsenutritionalAssessmentForm">
								Anthropometric
								</button>
							</h5>
							</div>	
							<div id="collapsenutritionalAssessmentForm" class="collapse show" aria-labelledby="nutritionalAssessmentForm" data-parent="#accordion">
							<div class="row">
							<div class="col-md-4">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Date of Assessment<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="assessmentdate" id="assessmentdate" class="form-control"/>
										<div class="text-danger" id="assessmentdate_label"></div>
									</div>								
								</div>
								<div class="col-md-4">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Weight<span class="required"><i>(kg)</i>*</span><span class="required"></span></label>
									<input autocomplete="off" type="number" name="weight" id="weight" class="form-control"/>
										<div class="text-danger" id="weight_label"></div>
									</div>								
								</div>
								<div class="col-md-4">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Height<span class="required"><i>(cm)</i>*</span><span class="required"></span></label>
									<input autocomplete="off" type="number" name="height" id="height" class="form-control"/>
										<div class="text-danger" id="height_label"></div>
									</div>								
								</div>
							</div>	
							<div class="row">
							<div class="col-md-4">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Body Mass Index (BMI)<span class="required">*</span><span class="required"></span></label>
									<input style="font-weight: 700" autocomplete="off" type="text" name="bmi" id="bmi" class="form-control" readonly />
									</div>								
								</div>
								<div class="col-md-4">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
							  <label>Child has Oedema<span class="required">*</span><span class="required"></span></label>
									<select name="oedema" id="oedema" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' AND keyword_value IN ('Yes','No')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>										
										<div class="text-danger" id="oedema_label"></div>
									</div>								
								</div>
								<div class="col-md-4">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
							  <label>MUAC<span class="required">*</span><span class="required"></span></label>
									<select name="muac" id="muac" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='muac'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>										
										<div class="text-danger" id="muac_label"></div>
									</div>								
								</div>
							</div>		
						</div>					
						</div>
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="naFoodSecurityandDiet">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenaFoodSecurityandDiet" aria-expanded="true" aria-controls="collapsenaFoodSecurityandDiet">
								Food Security & Diet
								</button>
							</h5>
							</div>	
							<div id="collapsenaFoodSecurityandDiet" class="collapse" aria-labelledby="naFoodSecurityandDiet" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" style="border: 1; width: 100%;">  
							  <tr>  
									<td style="width: 30%" id="Question1">In the last 30 days, was there ever no food to eat in the household?</td>  
									<td style="width: 20%">									
										<select name="naresponseQuestion1" id="naresponseQuestion1" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='nutri_assess'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="naresponseQuestion1_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question2">In the last 30 days did any household member go to sleep hungry because there wasnt any food?</td>  
									<td style="width: 20%">									
										<select name="naresponseQuestion2" id="naresponseQuestion2" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='nutri_assess'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="naresponseQuestion2_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question3">In the last 30 days, did any household member go a whole day and night without eating anything because there was not enough food?</td>  
									<td style="width: 20%">									
										<select name="naresponseQuestion3" id="naresponseQuestion3" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='nutri_assess'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="naresponseQuestion3_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question4">Did the child receive any food or liquid besides breast milk in the last 24 hours?</td>  
									<td style="width: 20%">									
										<select name="naresponseQuestion4" id="naresponseQuestion4" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="naresponseQuestion4_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question5">Is the mother experiencing any difficulties with breastfeeding?</td>  
									<td style="width: 20%">									
										<select name="naresponseQuestion5" id="naresponseQuestion5" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='nutri_assess'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="naresponseQuestion5_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question6">How many times did the child eat yesterday?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion6" id="responseQuestion6" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='count'";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion6_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question7">Yesterday, did the child eat any vitamin A rich foods (for example: mango, carrots, papaya, red palm oil, zogali, ugu, cassava, liver, or kidney)?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion7" id="responseQuestion7" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion7_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question8">Yesterday, did the child eat any Iron-rich foods (for example: liver, kidney, beans, groundnut, or dark green leaves such as spinach, zogali, ugu, cassava)?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion8" id="responseQuestion8" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion8_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question9">Yesterday, did the child eat any protein foods (for example: meat, eggs, fish, beans, groundnut, milk, cheese, soya, etc.)?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion9" id="responseQuestion9" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion9_label"></div>
									</td>   
								</tr>  
							</table>   
								</div>
							</div>	
	
						</div>					
						</div>	
						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="naHygiene">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenaHygiene" aria-expanded="true" aria-controls="collapsenaHygiene">
								Hygiene
								</button>
							</h5>
							</div>	
							<div id="collapsenaHygiene" class="collapse" aria-labelledby="naHygiene" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" style="border: 1; width: 100%;">  
							  <tr>  
									<td style="width: 30%" id="Question10">Does the household have soap and water to wash dishes and utensils?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion10" id="responseQuestion10" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion10_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question11">Does the household have soap or ash for hand washing?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion11" id="responseQuestion11" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion11_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question12">Do you normally wash your hands with soap/ash before cooking/eating?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion12" id="responseQuestion12" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion12_label"></div>
									</td>   
								</tr>  
								<tr>  
									<td style="width: 30%" id="Question13">Do you normally wash your hands with soap/ash after the toilet?</td>  
									<td style="width: 20%">									
										<select name="responseQuestion13" id="responseQuestion13" class="form-select" style="width: 100%">
										<option disabled selected>Response</option>
											<?php
											$sql = "SELECT keyword_value FROM optionstable WHERE keyword='boolean_yn' and keyword_value NOT IN ('N/A')";
											$result = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_assoc($result)){
										?>
										<option value="<?php echo $row['keyword_value'] ?>"><?php echo $row['keyword_value'] ?></option>
										<?php } ?>									
										</select>									
										<div class="text-danger" id="responseQuestion13_label"></div>
									</td>   
								</tr>  
							</table>   
								</div>
							</div>	
	
						</div>					
						</div>	

						<div class="card" style="width: 100%;">
							<div class="card-header text-white bg-danger" id="naClinical">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenaClinical" aria-expanded="true" aria-controls="collapsenaClinical">
								Clinical
								</button>
							</h5>
							</div>	
							<div id="collapsenaClinical" class="collapse" aria-labelledby="naClinical" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" style="border: 1; width: 100%;">  
							  <tr>
							    <th colspan="6">Tick any recent illnesses conditions that have affected child’s nutrition AND REFER FOR MEDICAL EVALUATION</th> 
							 </tr>
							 <tr>  
							  <td>Diarhhea</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_1" name="conditionaffecting_nutrition[]" value="Diarhhea"/></td>  
							  <td>Nausea</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_2" name="conditionaffecting_nutrition[]" value="Nausea"/></td>  
							  <td>Vomiting</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_3" name="conditionaffecting_nutrition[]" value="Vomiting"/></td>  
							</tr>  
							<tr>  
							  <td>Poor Appetite</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_4" name="conditionaffecting_nutrition[]" value="Poor Appetite"/></td>  
							  <td>Mouth Sore</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_5" name="conditionaffecting_nutrition[]" value="Mouth Sore"/></td>  
							  <td>Difficult or Painful Chewing/Swallowing</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_6" name="conditionaffecting_nutrition[]" value="Difficult or Painful Chewing/Swallowing"/></td>  
							</tr>  
							<tr>  
							  <td>None</td>  
							  <td><input type="checkbox" id="conditionaffecting_nutrition_7" name="conditionaffecting_nutrition[]" value="None"/></td>  
							  <td></td>  
							  <td></td>  
							  <td></td>  
							</tr>  
							</table>   
								</div>
							</div>	
	
						</div>					
						</div>	
						<div class="card" style="width: 100%;">
							<div class="card-header text-white bg-danger" id="naReferral">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenaReferral" aria-expanded="true" aria-controls="collapsenaReferral">
								Referral
								</button>
							</h5>
							</div>	
							<div id="collapsenaReferral" class="collapse" aria-labelledby="naReferral" data-parent="#accordion">
							<div class="row">
							  <div class="col-md-12">
							  <table class="table table-bordered" style="border: 1; width: 100%;">  
							  <tr>
							    <th colspan="4">Referral: Document or tick appropriate information</th> 
							 </tr>
							 <tr>  
							  <td>Nutritional Support (Cooking demonstration, establishment of home garden, growth monitoring, etc)</td>  
							  <td><input type="checkbox" id="referral_1" name="referral[]" value="Nutritional Support (Cooking demonstration/establishment of home garden/ growth monitoring/ etc)"/></td>  
							  <td>Referred for HIV risk assessment</td>  
							  <td><input type="checkbox" id="referral_2" name="referral[]" value="Referred for HIV risk assessment"/></td>  
							</tr>  
							</table>   
								</div>
							</div>	
							<div class="row">
							<div class="col-md-12">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Referred for other clinical conditions (specify)<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="referral_other" id="referral_other" class="form-control"/>
										<div class="text-danger" id="referral_other_label"></div>
									</div>								
								</div>
							</div>	
						</div>					
						</div>	

						<div class="card" style="width: 100%;" >
							<div class="card-header text-white bg-danger" id="naServiceProviderForm">
							<h5 class="mb-0">
								<button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapsenaServiceProviderForm" aria-expanded="true" aria-controls="collapsenaServiceProviderForm">
								Service Provider Information
								</button>
							</h5>
							</div>	
							<div id="collapsenaServiceProviderForm" class="collapse" aria-labelledby="naServiceProviderForm" data-parent="#accordion">
							<div class="row">
							<div class="col-md-6">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Service Provider<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="text" name="serviceprovider_na" id="serviceprovider_na" class="form-control"/>
										<div class="text-danger" id="serviceprovider_label"></div>
									</div>								
								</div>
								<div class="col-md-6">
							  <div class="form-group last mb-3" style="margin-left: 5px;margin-right: 5px" >
									<label>Service Provision Date<span class="required">*</span><span class="required"></span></label>
									<input autocomplete="off" type="date" name="serviceprovisiondate_na" id="serviceprovisiondate_na" class="form-control"/>
										<div class="text-danger" id="serviceprovisiondate_label"></div>
									</div>								
								</div>
							</div>	
						</div>					
						</div>																					
						</div>

						<button type="submit" id="submitNutritionalAssessmentForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Submit</button>
						<button type="submit" id="updateNutritionalAssessmentForm" style="margin-top: 5px;" class="btn px-5 btn-primary">Update</button>
							</form>
						  </div>
						</div>
					  </div>    
			</div>
  </div>
</div>
<!-- NEW Nutritional Assessment Form END -->	

</body>
</html>