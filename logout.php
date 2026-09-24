<?php
    include_once('includes/startup.php');
$logout_time=array();

    $login_history_id =  ($_SESSION[SESSION_PREFIX.'LOGIN_HISTORY_ID']);
    $user_id =  ($_SESSION[SESSION_PREFIX.'USER_ID']);
	
	$logout_time['logout_time'] = date('Y-m-d H:i:s');
	$logout_status = $conn->AutoExecute(TABLE_PREFIX."user_login_history",$logout_time, "UPDATE","login_history_id= ".$login_history_id,true,false,MAGIC_QUOTES);
	
	//$user_logout = $conn->Execute("UPDATE user_master SET is_active = '0' where user_id='".$user_id."'");
	
    unset($_SESSION[SESSION_PREFIX.'USER_LOGIN']);
    unset($_SESSION);
    session_destroy();
    setMsg('You have been logged out!');
	
	
    header("location:index.php");
    exit();
?>