<?php 

require("includes/startup.php");

$sql = "UPDATE user_login_history SET logout_time ='".date('Y-m-d H:i:s')."' WHERE login_history_id=".$_REQUEST['login_history_id']; 
if($res=$conn->Execute($sql))
	print "true";
else
	print "false";
?>