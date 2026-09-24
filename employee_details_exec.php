<?php

require_once("includes/startup.php");

$add_details = array();
$update_details = array();
$err = false;

	$update_details["first_name"] = str_prepare($_POST["firstName"]);
	$update_details["last_name"] = str_prepare($_POST["lastName"]);
	$update_details["user_phone"] = str_prepare($_POST["contact_number"]);
	$add_details["son_daughter_wife_of"] = str_prepare($_POST["son_daughter_wife_of"]);
	$add_details["dob"] = str_prepare($_POST["dob"]);
	$add_details["blood_group"] = str_prepare($_POST["blood_group"]);
	$add_details["present_address"] = str_prepare($_POST["present_address"]);
	$add_details["permanent_address"] = str_prepare($_POST["permanent_address"]);
	$add_details["contact_number"] = str_prepare($_POST["contact_number"]);
	$add_details["other_contact_number"] = str_prepare($_POST["other_contact_number"]);
	$add_details["pan_number"] = str_prepare($_POST["pan_number"]);
	$add_details["aadhar_number"] = str_prepare($_POST["aadhar_number"]);
	$add_details["bank_name"] = str_prepare($_POST["bank_name"]);
	$add_details["account_number"] = str_prepare($_POST["account_number"]);
	$add_details["branch_name"] = str_prepare($_POST["branch_name"]);
	$add_details["ifsc_code"] = str_prepare($_POST["ifsc_code"]);
	$add_details["designation"] = str_prepare($_POST["designation"]);
	$add_details["department"] = str_prepare($_POST["department"]);
	$add_details["date_of_joining"] = str_prepare($_POST["date_of_joining"]);
	$add_details["user_id"] = $_SESSION[SESSION_PREFIX.'USER_ID'];

	if(isset($_FILES['passbook_copy']['name']) && $_FILES['passbook_copy']['name']!="")
	{		
		$file_ext = trim(strtolower(strrchr($_FILES['passbook_copy']['name'],'.')));
		switch($file_ext)
		{
			case '.png':			
			case '.jpeg':		
			case '.jpg':
			break;
			default:
			$msg[]='Only JPG, JPEG and PNG files can be uploaded!';
			$err=true;
		}
 			
		if($err)
		{
			setMsg($msg);		
			header("location:employee_details.php");
			exit();
		}
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['passbook_copy']['name']=str_replace($replace,"_",$_FILES['passbook_copy']['name']);
		$passbook_copy=time()."_passbook_copy_".$_FILES['passbook_copy']['name'];
		$file_path_pg=UPLOADS_DIR."employeeDetails/".$passbook_copy;

		if(!move_uploaded_file($_FILES['passbook_copy']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading Passbook Copy file!';
		}else{
			 $add_details['passbook_copy'] = $passbook_copy;
		}
	}
	if(isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['profile_pic']['name'],'.')));
		switch($file_ext)
		{
			case '.png':			
			case '.jpeg':		
			case '.jpg':
			break;
			default:
			$msg[]='Only JPG, JPEG and PNG files can be uploaded!';
			$err=true;
		}
 			
		if($err)
		{
			setMsg($msg);		
			header("location:employee_details.php");
			exit();
		}
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['profile_pic']['name']=str_replace($replace,"_",$_FILES['profile_pic']['name']);
		$profile_pic=time()."_profile_pic_".$_FILES['profile_pic']['name'];
		$file_path_pg=UPLOADS_DIR."employeeDetails/".$profile_pic;
			
		if(!move_uploaded_file($_FILES['profile_pic']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading Profile Picture!';
		}else{
			 $add_details["profile_pic"] = $profile_pic;
		}
	}
	if(isset($_FILES['pan_copy']['name']) && $_FILES['pan_copy']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['pan_copy']['name'],'.')));
		switch($file_ext)
		{
			case '.png':			
			case '.jpeg':		
			case '.jpg':
			break;
			default:
			$msg[]='Only JPG, JPEG and PNG files can be uploaded!';
			$err=true;
		}
 			
		if($err)
		{
			setMsg($msg);		
			header("location:employee_details.php");
			exit();
		}
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['pan_copy']['name']=str_replace($replace,"_",$_FILES['pan_copy']['name']);
		$pan_copy=time()."_pan_copy_".$_FILES['pan_copy']['name'];
		$file_path_pg=UPLOADS_DIR."employeeDetails/".$pan_copy;
			
		if(!move_uploaded_file($_FILES['pan_copy']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading Pan Card Copy!';
		}else{
			 $add_details["pan_copy"] = $pan_copy;
		}
	}
	if(isset($_FILES['adhar_copy']['name']) && $_FILES['adhar_copy']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['adhar_copy']['name'],'.')));
		switch($file_ext)
		{
			case '.png':			
			case '.jpeg':		
			case '.jpg':
			break;
			default:
			$msg[]='Only JPG, JPEG and PNG files can be uploaded!';
			$err=true;
		}
 			
		if($err)
		{
			setMsg($msg);		
			header("location:employee_details.php");
			exit();
		}
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['adhar_copy']['name']=str_replace($replace,"_",$_FILES['adhar_copy']['name']);
		$adhar_copy=time()."_adhar_copy_".$_FILES['adhar_copy']['name'];
		$file_path_pg=UPLOADS_DIR."employeeDetails/".$adhar_copy;
			
		if(!move_uploaded_file($_FILES['adhar_copy']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading Adhar Number Copy!';
		}else{
			 $add_details["adhar_copy"] = $adhar_copy;
		}
	}
	if(isset($_FILES['address_copy']['name']) && $_FILES['address_copy']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['address_copy']['name'],'.')));
		switch($file_ext)
		{
			case '.png':			
			case '.jpeg':		
			case '.jpg':
			break;
			default:
			$msg[]='Only JPG, JPEG and PNG files can be uploaded!';
			$err=true;
		}
 			
		if($err)
		{
			setMsg($msg);		
			header("location:employee_details.php");
			exit();
		}
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['address_copy']['name']=str_replace($replace,"_",$_FILES['address_copy']['name']);
		$address_copy=time()."_address_copy_".$_FILES['address_copy']['name'];
		$file_path_pg=UPLOADS_DIR."employeeDetails/".$address_copy;
			
		if(!move_uploaded_file($_FILES['address_copy']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading Permanent Address Copy!';
		}else{
			 $add_details["address_copy"] = $address_copy;
		}
	}
	
	
	$sqlCheckusr = "SELECT user_id from user_details where user_id=".$add_details["user_id"];
	$exec = $conn->Execute($sqlCheckusr);
	if($exec->recordCount() > 0){
		$add_details_insert = $conn->AutoExecute(TABLE_PREFIX."user_details",$add_details, "UPDATE", "user_id= ".$conn->qstr($add_details["user_id"]),true,false,MAGIC_QUOTES);
	}else{
		
		$add_details_insert = $conn->AutoExecute("user_details", $add_details, "INSERT", true, false, MAGIC_QUOTES);
	}
	
	if(!$add_details_insert)
	{
		//print $conn->errorMsg();
	}
	
	$update_details_insert = $conn->AutoExecute(TABLE_PREFIX."user_master",$update_details, "UPDATE", "user_id= ".$conn->qstr($add_details["user_id"]),true,false,MAGIC_QUOTES);
	/*
	print "$add_details_insert -- $update_details_insert <pre>";
	print_r($add_details);
	print_r($update_details);
	print_r($_FILES);
	
	exit();
*/
	setMsg("Employee details updated successfully");
	header("location: employee_details.php");
	exit();



?>