<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 9 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
    <!--begin::Head-->
    <head>
        <meta charset="utf-8" />
        <title>Sign-in | OVC</title>
        <meta name="description" content="Login page example" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Page Custom Styles(used by this page)-->
        <link href="assets/css/pages/login/classic/login-4.css" rel="stylesheet" type="text/css" />
        <!--end::Page Custom Styles-->
        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles-->
        <!--begin::Layout Themes(used by all pages)-->
        <!--end::Layout Themes-->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" href="./pages/vc-dashboard/css/styles.css">

        <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
        <!--begin::Main-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Login-->
            <div class="login login-4 login-signin-on login-signin-on d-flex flex-row-fluid" id="kt_login">
                <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center" style="background-image: url(assets/media/bg/demo-7.jpg); background-position: 50% 50%;background-size: 100%;">
                    <!--begin:Aside-->
                    <div class="d-flex w-100 flex-center p-15">
                        <div class="login-wrapper">
                            <!--begin:Aside Content-->
                            <div class="text-dark-75">
                                <a href="#">
                                    <img src="assets/media/logos/apinlogo.png" class="max-h-150px" alt="" />
                                </a>
                                <p style="font-size: 30px; color: #fff;" class="mt-22 font-weight-bold">Electronic OVC Platform (eOVC)</p>
                            </div>
                            <!--end:Aside Content-->
                        </div>
                    </div>
                    <!--end:Aside-->
                    <!--begin:Divider-->
                    <!-- <div class="login-divider">
                        <div style="height: 100%"></div>
                    </div> -->
                    <!--end:Divider-->
                    <!--begin:Content-->
                    <div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden">
                        <div class="login-wrapper">
                            <!--begin:Sign In Form-->
                            <div class="login-signin">
                                <div class="text-center mb-10 mb-lg-20">
                                    <h2 class="text-white">Sign In</h2>
                                    <div id="checkfiledstatus">
                                    <?php if (isset($_GET['reason']) && $_GET['reason']=='session_timeout') { ?>
                                        <div id="response" class="alert alert-danger"><div class="message"><strong>Error: </strong><?php echo "SESSION TIMEOUT"; ?></div></div>
                                        <?php } ?>
                                    <?php if (isset($_GET['reason']) && $_GET['reason']=='password') { ?>
                                        <div id="response" class="alert alert-danger"><div class="message"><strong>Error: </strong><?php  echo "Wrong login details"; ?></div></div>
                                        <?php } ?>
                                    </div>
                                    <p class="text-muted">Enter your email and password</p>
                                </div>
								<form action="./controllers/db/checklogin.php" method="POST" class="form"  id="kt_login_signin_form">                                    
                                    <div class="form-group py-2 m-0">
                                        <input class="form-control" type="text" placeholder="Email" id="email" name="email" autocomplete="off" />
                                    </div>
                                    <div class="form-group py-2 border-top m-0">
                                        <input class="form-control" type="Password" placeholder="Password" name="password" id="password" />
                                    </div>

                                    <div class="text-center mt-15">
                                        <button class="btn btn-primary" id="submitForm">Sign In</button>
                                    </div>
                                </form>
                            </div>
                            <!--end:Sign In Form-->

                        </div>
                    </div>
                    <!--end:Content-->
                </div>
            </div>
            <!--end::Login-->
        </div>
        <!--end::Main-->
        <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
        <!--begin::Global Config(global config for global JS scripts)-->
        <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
        <!--end::Global Config-->
        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <!--end::Global Theme Bundle-->
        <!--begin::Page Scripts(used by this page)-->
        <script src="assets/js/pages/custom/login/login.js"></script>
        <!--end::Page Scripts-->

        <script>
                          function _(x){
                          return document.getElementById(x);
                          }
                          function toggleElement(x){
                          var x = _(x);
                          if (x.style.display == 'block'){
                          x.style.display = 'none';
                          } else{
                          x.style.display = 'block';
                          }
                          }

                          function ajaxObj(meth, url) {
                          var x = new XMLHttpRequest();
                          x.open(meth, url, true);
                          x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                          return x;
                          }
                          function ajaxReturn(x){
                          if (x.readyState == 4 && x.status == 200){
                          return true;
                          }
                          }
                          function ajaxLoading(l){
                          if (l.readyState == 3 && l.status == 200){
                          return true;
                          }
                          }

                          function checkfields(){

                          var email = _("email").value;
                          var password = _("password").value;
                          var status = _("checkfiledstatus");
                          if (email === "" || password === ""){
                          status.innerHTML = '<div id="response" class="alert alert-danger"><div class="message"><strong>Error : </strong>Please enter email and password!</div></div>';
                          $(".requiredx").each(function(i, obj) {

                          if ($(this).val() === ''){
                          $(this).parent().addClass("has-error");
                          } else{
                          $(this).parent().removeClass("has-error");
                          }


                          });
                          window.scrollTo(0, 0);
                          return false;
                          }

                          }

                          function restrict(elem){
                          var tf = _(elem);
                          var rx = new RegExp;
                          if (elem === "email"){
                          rx = /[' "]/gi; /* i means the can put 0 to 9 */
                          }
                          tf.value = tf.value.replace(rx, "");
                          }
        </script>
    </body>
    <!--end::Body-->
</html>