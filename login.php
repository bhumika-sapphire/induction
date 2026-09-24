<?php
require_once("includes/startup.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"><!-- Mobile Specific Metas -->
    
    <!-- Title -->
    <title> SAPPHIRE INFO SOLUTIONS [P].LTD</title>
    
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/logo/logo.png">
    
    <!-- CSS Stylesheet -->
    <link href="css/bootstrap.css" rel="stylesheet"><!-- bootstrap css -->
    <link href="css/owl.carousel.css" rel="stylesheet"><!-- carousel Slider -->
    <link href="css/font-awesome.css" rel="stylesheet"><!-- font awesome -->
    <!--<link href="css/loader.css" rel="stylesheet">--><!--  loader css -->
    <link href="css/jquery.selectbox.css" rel="stylesheet"><!-- select box -->
    <link href="css/docs.css" rel="stylesheet"><!--  template structure css -->
	<link rel="stylesheet" type="text/css" href="css/notifit.min.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
    
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900%7CPT+Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
    
<body>
    <div class="wapper">
		<section>
		<div class="col-sm-4"></div>
		<div class="col-sm-4 loginlogoset"><img src="images/logo/logo.png" class="img-responsive" alt="" />
		</div>
		<div class="col-sm-4"></div>
		</section>
        <section class="login-view">
        	<div class="container">
            	<div class="row">
				<form method="post" action="user_login_exec.php">
                	<div class="col-sm-6 col-sm-offset-3">
                    	<div class="section-title">
                        	<h2>Employee Login</h2>
                            <p>Login to your account below</p>
                        </div>
						<p style="color:#F00"><?php echo getMsg('error');?></p>
                        <div class="input-box">
                        	<input type="text" name="user_login" placeholder="User Name" required >
                        </div>
                        <div class="input-box">
                        	<input type="password" name="user_password" placeholder="Password" required>
                        </div>
                        <div class="check-slide">
                        	<!--<label class="label_check" for="checkbox-01"><input id="checkbox-01" type="checkbox"> Remember Me</label>
                            <div class="right-link">
                            	<a href="forget_password.php">Forget Password? </a>
                            </div>-->
                        </div>
                        <div class="submit-slide">
                        	<center><input type="submit" value="Login" class="btn"></center>  
                        </div>
                    </div>
					</form>
					<div class="col-sm-4"></div>
		             <div class="col-sm-4 copyrightset">Copyright © SAPPHIRE Portal
		             </div>
                    <!--<div class="col-sm-6">
                    	<div class="section-title">
                        	<h2>REGISTER</h2>
                            <p>Register now - Completely free</p>
                        </div>
                        <div class="input-box">
                        	<input type="text" placeholder="User Name">
                        </div>
                        <div class="input-box">
                        	<input type="text" placeholder="Email">
                        </div>
                        <div class="input-box">
                        	<input type="password" placeholder="Password">
                        </div>
                        <div class="input-box">
                        	<input type="password" placeholder="Re-Password">
                        </div>
                        <div class="submit-slide">
                        	<input type="submit" value="SIGN UP" class="btn">
                        </div>
                    </div>-->
                </div>
                <div class="sosiyal-login">
				<div class="col-md-12"></div>
                	<!--<div class="row">
                    	<div class="col-sm-3 col-md-3">
                        	<a href="#" class="facebook"><i class="fa fa-facebook"></i>Facebook</a>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <a href="#" class="google-pluse"><i class="fa fa-google-plus"></i>Google</a>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <a href="#" class="twitter"><i class="fa fa-twitter"></i>Twitter</a>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <a href="#" class="linkedin"><i class="fa fa-linkedin"></i>Linkedin</a>
                        </div>
                    </div>-->
                </div>
            </div>
        </section>
      