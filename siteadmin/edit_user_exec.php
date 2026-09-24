<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$user_data = array();
$update_details = array();

    $user_id = str_prepare($_POST["user_id"]);
    $user_data["user_login"] = str_prepare($_POST["user_login"]);
	if(isset($_POST["user_password"]) && $_POST["user_password"]!="")
	{
		$user_data["user_password"] = md5($_POST["user_password"]);
    }
	$user_data["first_name"] = str_prepare($_POST["first_name"]);	
	$user_data["last_name"] = str_prepare($_POST["last_name"]);
	$user_data["user_phone"] = str_prepare($_POST["user_phone"]);
	if(isset($_POST["is_active"]) && $_POST["is_active"])
	{
		$user_data["is_active"] = 1;
	}
	else
	{
		$user_data["is_active"] = 0;
	}
	
	
	$update_details["son_daughter_wife_of"] = str_prepare($_POST["son_daughter_wife_of"]);
	$update_details["dob"] = str_prepare($_POST["dob"]);
	$update_details["blood_group"] = str_prepare($_POST["blood_group"]);
	$update_details["present_address"] = str_prepare($_POST["present_address"]);
	$update_details["permanent_address"] = str_prepare($_POST["permanent_address"]);
	$update_details["contact_number"] = str_prepare($_POST["contact_number"]);
	$update_details["other_contact_number"] = str_prepare($_POST["other_contact_number"]);
	$update_details["pan_number"] = str_prepare($_POST["pan_number"]);
	$update_details["aadhar_number"] = str_prepare($_POST["aadhar_number"]);
	$update_details["bank_name"] = str_prepare($_POST["bank_name"]);
	$update_details["account_number"] = str_prepare($_POST["account_number"]);
	$update_details["branch_name"] = str_prepare($_POST["branch_name"]);
	$update_details["ifsc_code"] = str_prepare($_POST["ifsc_code"]);
	$update_details["designation"] = str_prepare($_POST["designation"]);
	$update_details["department"] = str_prepare($_POST["department"]);
	$update_details["date_of_joining"] = str_prepare($_POST["date_of_joining"]);
	$update_details["user_id"] = $user_id;
	
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
			header("location:edit_user.php?user_id=$user_id");
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
			 $update_details['passbook_copy'] = $passbook_copy;
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
			header("location:edit_user.php?user_id=$user_id");
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
			 $update_details["profile_pic"] = $profile_pic;
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
			header("location:edit_user.php?user_id=$user_id");
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
			 $update_details["pan_copy"] = $pan_copy;
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
			header("location:edit_user.php?user_id=$user_id");
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
			 $update_details["adhar_copy"] = $adhar_copy;
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
			header("location:edit_user.php?user_id=$user_id");
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
			 $update_details["address_copy"] = $address_copy;
		}
	}
	
	
	$manage_user_update = $conn->AutoExecute("user_master",$user_data, "UPDATE", "user_id= ".$conn->qstr($_POST["user_id"]),true,false,MAGIC_QUOTES);
	

	$sqlCheckusr = "SELECT user_id from user_details where user_id=".$user_id;
	$exec = $conn->Execute($sqlCheckusr);

	if($exec->recordCount() != 0){
		// print_r('uop');
		// exit();
		$add_details_insert=$conn->AutoExecute('user_details',$update_details,'UPDATE',"user_id=".$conn->qstr($user_id,MAGIC_QUOTES),true,MAGIC_QUOTES);
	}else{

	//	$add_details_insert = $conn->AutoExecute("user_details", $update_details, "INSERT", true, false, MAGIC_QUOTES);
		$add_details_insert = $conn->Autoexecute("user_details", $update_details, "INSERT", true, false, MAGIC_QUOTES);
	}
	
	$sql="DELETE from user_topics WHERE user_id=".$user_id;
	$exec1 = $conn->Execute($sql);

	foreach($_POST["topic_id"] as $topic_id)
		{
			$data1= array();
			$data1["user_id"] = $user_id;
			$data1["topic_id"] = $topic_id;
			$data1["allocation_date"] = date('Y-m-d H:i:s');
			$conn->Autoexecute("user_topics", $data1, "INSERT", true, false, MAGIC_QUOTES);
		}

		
if($manage_user_update)
{
	setMsg("User updated successfully");
    header("location: manage_users.php");
    exit();
}	
else
{
	setMsg("Error! User could not be updated.");
    header("location: manage_users.php");
    exit();
} 

?>