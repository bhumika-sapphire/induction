<?php
require("../includes/startup.php");
require_once('authenticate.php');

$user_id = $_REQUEST['user_id'];
$delete = "delete from user_master where user_id =".$user_id;
$exec = $conn->Execute($delete);
if($exec)
{
	
	setMsg("User has been deleted successfully");
	header("location: manage_users.php");
	exit();
}
else
{
	setMsg("User could not be deleted successfully");
	header("location: manage_users.php");
	exit();
}


?>