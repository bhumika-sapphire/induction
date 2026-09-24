<?php 
require("../includes/startup.php");
if(isset($_POST['admin_uname']) && $_POST['admin_uname']!='' && isset($_POST['admin_password']) && $_POST['admin_password']!='')
{
	$admin=array();
	$admin['admin_uname'] = str_prepare($_POST['admin_uname']);
	$q = "SELECT * from ".TABLE_PREFIX."admin_master where admin_uname='".$admin['admin_uname']."' and admin_password='".md5($_POST['admin_password'])."'";
	$res=$conn->Execute($q);

	if(!$res || $res->RecordCount() == 0)
	{
		setMsg('Login Failed!');
		header('location: login.php');
		exit();
	}

	$arr=$res->fields;
	
	$_SESSION[SESSION_PREFIX.'ADMIN_ID']=$arr['admin_id'];
	$_SESSION[SESSION_PREFIX.'ADMIN_NAME']=$arr['admin_name'];
	$_SESSION[SESSION_PREFIX.'ADMIN_UNAME']=$arr['admin_uname'];
	
	header('location: index.php');
	exit();
}
else
{
    setMsg('Enter correct  username or password!');
    header('location: login.php');
    exit();

}
 ?>