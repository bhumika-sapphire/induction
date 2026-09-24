<?php
require("../includes/startup.php");
require_once('authenticate.php');

$user_request_id = $_REQUEST['user_request_id'];

   $date =  date('Y-m-d H:i:s');

 $approved = $conn->Execute("UPDATE user_request SET request_status = 'Approved', request_approval_date =  '".$date."' where user_request_id='".$user_request_id."'");
   
	if($approved)
	{
		
		setMsg("User Approval successfully");
		header("location: user_approval.php");
		exit();
	}
	else
	{
		setMsg("User has not been Approval successfully");
		header("location: user_approval.php");
		exit();
	}


?>