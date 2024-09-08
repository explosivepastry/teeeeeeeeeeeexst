<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Registration Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/registration.css">
  </head>
  <body style="background-color: #666666;">
    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100">
	  <form class="login100-form validate-form" id="form" action="/api/register" method="POST">
  	    <span class="login100-form-title p-b-43">
	      Registration
	    </span>
            <?php
            if (isset($_GET['error'])) {
              echo "<div id='alerts'></div>";
              echo '<div class="alert alert-danger" style="margin-left:34px;margin-right:34px;text-align:center;">'.$_GET["error"].'</div>'; }
            ?>
            <div class="wrap-input100 validate-input">
              <input class="input100" type="text" name="username">
                <span class="focus-input100"></span>
                <span class="label-input100">Username</span>
            </div>
 	    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
	      <input class="input100" type="text" name="email">
	        <span class="focus-input100"></span>
	        <span class="label-input100">Email</span>
	    </div>
  	    <div class="wrap-input100 validate-input" data-validate="Password is required">
	      <input class="input100" type="password" name="password">
	        <span class="focus-input100"></span>
	        <span class="label-input100">Password</span>
	    </div>
            <div class="wrap-input100 validate-input" data-validate="Repeated password is required">
              <input class="input100" type="password" name="confirm_password">
                <span class="focus-input100"></span>
                <span class="label-input100">Password</span>
            </div>
 	    <div class="container-login100-form-btn">
	      <button class="login100-form-btn">
	        Register
	      </button>
              <div style="margin-top:50px; text-align:center;">
                <a href="/login" class="txt1">
                  Already have a account?<br>Login here!
                </a>
              </div>
	    </div>
  	  </form>
	  <div class="login100-more" style="background-image: url('../assets/images/faq-header.jpg');">
        </div>
      </div>
    </div>
    <script src="../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../assets/vendor/animsition/js/animsition.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/popper.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/select2/select2.min.js"></script>
    <script src="../assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="../assets/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="../assets/vendor/countdowntime/countdowntime.js"></script>
    <script src="../assets/js/registration.js"></script>
  </body>
</html>