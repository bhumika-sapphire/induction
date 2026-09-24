<?php
require_once("includes/startup.php");
$current_page = basename($_SERVER['PHP_SELF']);
$index_page = "index.php";
$a_tag ="";
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
    <link href="css/jquery.countdown.css" rel="stylesheet">
    <link href="css/jquery.selectbox.css" rel="stylesheet"><!-- select box -->
    <link href="css/jquery.fancybox.css" rel="stylesheet"><!-- select box -->
    <link href="css/docs.css" rel="stylesheet"><!--  template structure css -->
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	 <link rel="stylesheet" href="css/normalize.css">
     <link rel="stylesheet" href="css/main.css">
	 <?php if(isset($shortcode) && $shortcode != ""){ ?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/shortcodes.css">
	 <?php } ?>
	 <?php if(isset($skin) && $skin != ""){ ?>
		<link rel="stylesheet" href="css/skin.css">
	 <?php } ?>
	 <?php if($datatable){ ?>
		<link href="siteadmin/css/jquery.dataTables.css" rel="stylesheet">
	<?php } ?>
     <link rel="stylesheet" href="css/jquery.steps.css">
    
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900%7CPT+Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
    
<body onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onContextmenu="return false">
    <div class="wapper">
    	<div id="loader-wrapper">
			<div id="loader"></div>
			<div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div> 
		</div>
    	<div class="quck-nav style2">
            <!--<div class="contact-no"><a href="#"><i class="fa fa-map-marker"></i>Brooklyn, NY 10036, United States</a></div>-->
            <div class="contact-no"><a href="#"><i class="fa fa-phone"></i>+91-161-5002086, 2443434 (IN)</a></div>
            <div class="contact-no"><a href="mailto: $info@sapphireinfo.net"><i class="fa fa-envelope" aria-hidden="true"></i> info@sapphireinfo.net</a></div>
            <div class="quck-right">
                <div class="right-link"><a href="#"><i class="fa fa-phone"></i>(+44) 2030026314 (UK)</a></div>
                <div class="right-link language-select">
                    <a target="_blank" href="https://sapphireinfonet.wordpress.com/"></i>Blog</a>
                </div>
				<div class="right-link language-select">
                    <a target="_blank" href="https://www.facebook.com/sapphireinfosolutions/"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                </div>
				<div class="right-link language-select">
                    <a target="_blank" href="https://in.linkedin.com/in/kawitansh-kevin-khanna-326b3b20"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                </div>
				
				<?php
				
                    if(isset($_SESSION[SESSION_PREFIX.'USER_LOGIN'])  && $_SESSION[SESSION_PREFIX.'USER_LOGIN']!="")
					{
						?>
						<div class="right-link"><a href="logout.php"><i class="fa fa-window-close"></i>Logout</a></div>
						<?php
					}
					else
					{
						?>
						<div class="right-link"><a href="login-register.php"><i class="fa  fa-user"></i>Login \ Regester</a></div>
						<?php
					}
				?>
                
            </div>
        </div>
        <header id="header" class="style2">
            <nav id="nav-main">
                <div class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <a href="index.php" class="navbar-brand"><img src="images/logo/logo.png" class="logoset" alt=""></a>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>                
                    <div class="navbar-collapse collapse">
					<?php
								if($current_page == $index_page)
								{
									?>
							    <ul class="nav navbar-nav">
                                <li class="active sub-menu links">
                                	<a href="#section1">Home </a>
                                </li>
                                <li class="links">
								    <a href="#section2">Test</a>
								</li>
                                <li class="links">
								    <a href="#section3">Contact Us</a>
								</li>
                            </ul>
							<?php
								}
								else
								{
									
								?>
                            <ul class="nav navbar-nav">
                                <li class="active sub-menu links">
                                	<a href="index.php#section1">Home </a>
                                </li>
                                <li class="links">
								    <a href="index.php#section2">Test</a>
								</li>
                                <li class="links">
								    <a href="index.php#section3">Contact Us</a>
								</li>
                            </ul>
							<?php
							}
									
								?>
                        </div>
                </div>
            </nav>
        </header>