<?php
require_once("../includes/startup.php");
require_once('authenticate.php');

$user_id =$_REQUEST['user_id'];
$report_type =$_REQUEST["report"];
	
if($report_type == "chapter")
	{
		header('location: user_report_show.php?user_id='.$user_id);
        exit();
	}
if($report_type == "attendence")
	{
		header('location: user_attendance_report.php?user_id='.$user_id);
        exit();
	}
else
	{
		header('location: user_comm_report_show.php?user_id='.$user_id);
        exit();
	}

?>