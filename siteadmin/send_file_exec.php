<?php
	require_once('includes/startup.php');
	require_once('authenticate.php');	
	require_once(INCLUDES_DIR.'parser.php');
	require_once(LIB_DIR.'mail-wrapper.php');
	$tmp = $_REQUEST['tmp'];

	/* if(isset($_POST['file_title']) && $_POST['file_title']!="")
	{
		$sql="SELECT file_id from file_master WHERE user_id = ".$_POST["recipient_id"]." AND file_title LIKE '".$_POST['file_title']."'";
		//die($sql);
		$res=$conn->Execute($sql);
		if($res->RecordCount()<=0)
		{
			
			$folder=getClientInbox($_POST['recipient_id']);
		
			foreach($_POST['file_upload_multiple'] as $file) {

				$replace = array(" ","&","'",'"',"__");
				$file=str_replace($replace,"_",$file);
				$filename1=$tmp."_".$file;
				$file_path=UPLOADS_CLIENT_DIR.$folder.$filename1;
				if($filename1 != "")
				{
					@unlink($file_path);
				}
				
			}
			
			
			setMsg("Error! No matching client name for selected user!");
			header("location:send_file.php");
			exit();
		}
	} */
	
	if(isset($_POST['file_title']) && $_POST['file_title']!="")
	{
		if(str_prepare(trim($_POST['file_title']))=='')
		{
			
			$folder=getClientInbox($_POST['recipient_id']);
		
			foreach($_POST['file_upload_multiple'] as $file) {

				$replace = array(" ","&","'",'"',"+","?",",","__");
				$file=str_replace($replace,"_",$file);
				$filename1=$tmp."_".$file;
				$file_path=UPLOADS_CLIENT_DIR.$folder.$filename1;
				if($filename1 != "")
				{
					@unlink($file_path);
				}
				
			}
			
			setMsg("Error! Client Name cannot be empty");
			header("location:send_file.php");
			exit();
		}
	}
 
    $data = array();
    $data1 = array();
 	$data['user_id']=$_SESSION[SESSION_PREFIX.'ADMIN_ID'];
	$data['recipient_id']=$_POST['recipient_id'];
    $data['uploaded_by_name']= $_SESSION[SESSION_PREFIX.'USER_NAME'];
	$data['file_title']=str_prepare($_POST['file_title']);	
	$data['file_desc']=str_prepare(nl2br($_POST['file_desc']));
	$data['upload_date']=date('Y-m-d H:i:s');
	$data['status_id']=1;
	
	 
	$sql="select user_name,addon_emails from user_master where user_id=".$_POST['recipient_id'];
    $res=$conn->Execute($sql);
    $row = $res->FetchRow();
	$err=false;
	
	$status=$conn->Autoexecute(TABLE_PREFIX.'file_master',$data,'INSERT',false,true,MAGIC_QUOTES);
	$file_id = $conn->Insert_ID();
	
	if($status) {
		$folder=getClientInbox($_POST['recipient_id']);
		
		foreach($_POST['file_upload_multiple'] as $file) {

			$replace = array(" ","&","'",'"',"+","?",",","__");
			$file=str_replace($replace,"_",$file);
			$filename1=$tmp."_".$file;
			$file_path=UPLOADS_CLIENT_DIR.$folder.$filename1;
			
			$data1['file_name'] = $folder.$filename1;
			$data1['file_id'] = $file_id;
			$data1['upload_date'] = date('Y-m-d H:i:s');
			
			$status1=$conn->Autoexecute(TABLE_PREFIX.'file_detail_master',$data1,'INSERT',false,true,MAGIC_QUOTES);
		}
	} else {
		$err = true;
	}

if(!$err)
{
	$sql="select * from user_master where user_id=".$data['recipient_id'];
		$res=$conn->Execute($sql);
		$res=$res->FetchRow();
			 
	$data['file_desc'] = str_replace("£","&pound;",$data['file_desc']);
	$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'file_upload.php'),
	    						array('NAME'=>$res['fname']." ".$res['lname'],
									'TITLE'=>$data['file_title'],
									'DESC'=>str_prepare(nl2br($data['file_desc'])),
									'APP_URL'=>APP_URL,
									'App_Name'=>APP_NAME));
	sendmail($emailMsg,ADMINEMAIL,'Sapphire',$res['email'],"A new file has been uploaded for you (Job Id: $file_id)",$row['addon_emails']);
 
	setMsg("File uploaded successfully!");
	header("location:send_file.php");
	exit();
}
else
{
	setMsg("Error uploading file!");
	header("location:send_file.php");
	exit();
}
?>