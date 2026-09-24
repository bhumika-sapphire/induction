<?php

  if(!isset($_SESSION[SESSION_PREFIX.'USER_ID']) || $_SESSION[SESSION_PREFIX.'USER_ID']=="")
    {
        setMsg('You need to login!');
        header("location: login.php");
        exit();
    }
	else
	{
		$sql = "UPDATE user_login_history SET logout_time ='".date('Y-m-d H:i:s')."' WHERE login_history_id=".$_SESSION[SESSION_PREFIX.'LOGIN_HISTORY_ID']; 
		$res=$conn->Execute($sql);
	}
?>