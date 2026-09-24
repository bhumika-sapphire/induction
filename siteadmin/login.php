<?php
require_once('../includes/startup.php');
 
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Web Supplements">
    <title>Admin Panel - <?php print APP_NAME; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
   <!--<link href="css/jquery.dataTables.css" rel="stylesheet">

     Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
</head>
<body>
<div id="wrapper" style="padding-left:0 !important">
<div >
<div class="container" >
   
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form" align="center">
          <form method="post" action="login_exec.php" role="login" >
			<img src="images/logo.png" class="img-responsive" alt="<?php print APP_NAME; ?>" />
            
          <p style="color: red;"><?php echo getMsg('error'); ?></p>
          <input type="text" name="admin_uname" placeholder="Username" required class="form-control input-lg"  />
          
        <input type="password" class="form-control input-lg" id="password" name="admin_password" placeholder="Password" required="" />
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
      <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
          
        </form>
        
        <div class="form-links">
			<span style="color:#ffffff;">Copyright &copy; SAPPHIRE </span>
        </div>
      </section>  
      </div>
      
      <div class="col-md-4"></div>
      
    <br>
    <br>
    
  </p>     
  
  
</div>
    </div>