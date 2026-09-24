<?php
require("includes/startup.php");


if(isset($_POST['user_login']) && $_POST['user_login']!='' && isset($_POST['user_password']) && $_POST['user_password']!='')
{
	$user=array();
	$user['user_login'] = str_prepare($_POST['user_login']);
	$q = "SELECT * from ".TABLE_PREFIX."user_master where user_login='".$user['user_login']."' and user_password='".md5($_POST['user_password'])."'";
	$res=$conn->Execute($q);

	if(!$res || $res->RecordCount() == 0)
	{
		setMsg('Login Failed! Enter correct  username or password.');
		header('location: login.php');
		exit();
	}

	$arr=$res->fields;
	
	$_SESSION[SESSION_PREFIX.'USER_ID']=$arr['user_id'];
	$_SESSION[SESSION_PREFIX.'USER_LOGIN']=$arr['user_login'];
	$_SESSION[SESSION_PREFIX.'FIRST_NAME']=$arr['first_name'];
	$_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE']=$arr['induction_complete'];
	
	if(isset($arr['it_policy']) && $arr['it_policy'] == 1)
	{
		$_SESSION[SESSION_PREFIX.'pageViewed'][16]="true";
	}
	
	if(isset($arr['leave_policy']) && $arr['leave_policy'] == 1)
	{
		$_SESSION[SESSION_PREFIX.'pageViewed'][17]="true";
	}
	
	if(isset($arr['list_of_holidays_policy']) && $arr['list_of_holidays_policy'] == 1)
	{
		$_SESSION[SESSION_PREFIX.'pageViewed'][18]="true";
	}
	
	if(isset($arr['travel_policy']) && $arr['travel_policy'] == 1)
	{
		$_SESSION[SESSION_PREFIX.'pageViewed'][19]="true";
	}
	
	if(isset($arr['increment_policy']) && $arr['increment_policy'] == 1)
	{
		$_SESSION[SESSION_PREFIX.'pageViewed'][20]="true";
	}
	
	if(isset($arr['productivity_policy']) && $arr['productivity_policy'] == 1)
	{
		$_SESSION[SESSION_PREFIX.'pageViewed'][21]="true";
	}
	
   
	$user_login_detail= array();
	$user_login_detail['user_id'] = $arr['user_id'];
	$user_login_detail['login_time'] = date('Y-m-d H:i:s');

   $user_login_insert = $conn->Autoexecute("user_login_history", $user_login_detail, "INSERT", true, false, MAGIC_QUOTES);
   $login_history_id = $conn->Insert_Id();
   
   $_SESSION[SESSION_PREFIX.'LOGIN_HISTORY_ID']=$login_history_id;
   header('location: index.php');
	exit();
}
else
{
    setMsg('Enter correct  username or password!');
    header('location: index.php');
    exit();

}

   

?>