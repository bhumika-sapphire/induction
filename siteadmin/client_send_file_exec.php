<?php
	require_once('includes/startup.php');
	require_once('authenticate.php');	
	require_once('restrict_employee.php');
	require_once(INCLUDES_DIR.'parser.php');
	require_once(LIB_DIR.'mail-wrapper.php');
	// echo "<pre>";
	// print_r($_POST);
	// die();
	
	$tmp = $_REQUEST['tmp'];
	$id = $_SESSION[SESSION_PREFIX.'ADMIN_ID'];
    $data = array();
	$data1 = array();
 	$data['user_id']=$id;
	$data['recipient_id']=1;
	 
	$data['file_title']=str_prepare($_POST['file_title']);	
	$data['file_desc']=str_prepare(nl2br($_POST['file_desc']));
	
	if(isset($_POST['job_type_id']) && $_POST['job_type_id'] !=""){
		$job_type_id = str_prepare($_POST['job_type_id']);
		$split = explode("," , $job_type_id);
		// echo "<pre>";
		// print_r($split);
		// die();
		$data['job_type_id'] =   $split[0];
   		$data['job_tat'] = $split[1];
		
	}

	$data['job_budget_client']=str_prepare($_POST['job_budget_client']);
	$data['upload_date']=date('Y-m-d H:i:s');
	$data['status_id']=1;
	// echo "<pre>";
	// print_r($data);
	// die();
	$sql="select user_name from user_master where user_id=".$id;
    $res=$conn->Execute($sql);
    $row = $res->FetchRow();
	$err=false;
		

	$status=$conn->Autoexecute(TABLE_PREFIX.'file_master',$data,'INSERT',false,true,MAGIC_QUOTES);
	$file_id = $conn->Insert_ID();
	
	if($status) {
		$folder=getClientOutbox($id);
		foreach($_POST['file_name'] as $file) {


			$replace = array(" ","&","'",'"',"__");
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
	$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'file_upload_user.php'),
		array('NAME'=>"Admin",
		'TITLE'=>$data['file_title'],
		'DESC'=>$data['file_desc'],
		'APP_URL'=>APP_URL,
		'App_Name'=>$_SESSION[SESSION_PREFIX.'USER_NAME']));
	
    
	$sql = "select group_concat(email SEPARATOR ';') as emails from user_master as  um,sub_admin_client_master as sbm where um.user_id = sbm.sub_admin_id AND sbm.client_id = ".$id;

	 $res = $conn->Execute($sql);
	
	 if($row = $res->FetchRow($res))
	 {
	 	
	 	$cc = $row['emails'];
	 }
	 else
	 {
	 	$cc = "";
	 }
	sendmail($emailMsg,ADMINEMAIL,'Sapphire Info Solutions (P). Ltd.',ADMINEMAIL,"A new file has been uploaded for you (Job Id: $file_id)",$cc);

	setMsg("File uploaded successfully!");
	header("location:client_send_file.php");
	exit();
}
else
{
	setMsg($msg);
	header("location:client_send_file.php");
	exit();
}
?>