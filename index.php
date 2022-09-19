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
$current_page = 'landing_page';
if(!isset($email) || !isset($cbo_name)){
    session_destroy();
    die(header("location:./login.php?loginFailed=true&reason=session_timeout"));
}
elseif(isset($_GET['rr']) && $_GET['rr']=='sign-out'){
    session_destroy();
	die(header("location:./login.php"));
}
if($role=='Owner'){
    $isOwner=true;
}
else{
    $isOwner=false;
}
/* This will give an error. Note the output
 * above, which is before the header() call */
 include_once("./controllers/db/dbHandler.php");
 include './controllers/version.php';
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Dashboard | OVC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />	
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>	

<script>
    var cbo_id = "<?php echo $cbo_name; ?>"
</script>
<script src="./controllers/handler/dashboardItems.js"></script>
  </head>
  <body>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
		
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
	          <li class="active">
	              <a href="#"><span style="font-weight: 600;">Home</span></span></a>
	          </li>
	          <li>
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">HouseHold</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
				<li>
					<a href="./pages/household-list">HouseHold List</a>
				</li>
                <li>
                    <a href="./pages/household-vulnerability-assessment">New HouseHold Vulnerability Assessment</a>
                </li>
	            </ul>
	          </li>			 
			  <li>
              <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Administration</a>
              <ul class="collapse list-unstyled" id="adminSubmenu">
                <li><a href="./admin/user-setup">User Setup</a></li>
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
                    }                     ?>
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

        <h2 class="mb-4">Dashboard: &nbsp;<span class="btn btn-primary" id="dashboard_cbo_name"></span></h2>
		<hr/>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
		</div>

    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>