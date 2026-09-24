<?php 

include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

if(isset($_POST['policy']) && $_POST['policy'] != "" && isset($user_id) && $user_id != "")
{
	$sql = "UPDATE user_master set ".$_POST['policy']." = 1 WHERE user_id=$user_id";
	if($conn->Execute($sql))
	{
		echo $_POST['policy'];
	}
	else
	{
		echo "Error";
	}
	
	
	$_SESSION[SESSION_PREFIX.'pageViewed'][$_POST['page_id']]="true";
}


?>