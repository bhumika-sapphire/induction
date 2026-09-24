<?php
	require_once('includes/startup.php');
	require_once('authenticate.php');	
	require_once(INCLUDES_DIR.'parser.php');
	require_once(LIB_DIR.'mail-wrapper.php');

	/* if(isset($_POST['client_name']) && $_POST['client_name']!="")
	{
		$sql="SELECT file_id from file_master WHERE user_id = ".$_POST["user_id"]." AND file_title LIKE '".$_POST['client_name']."'";
		//die($sql);
		$res=$conn->Execute($sql);
		if($res->RecordCount()<=0)
		{
			setMsg("Error! No matching client name for selected user!");
			header("location:add_client_status.php");
			exit();
		}
	} */
	
	if(isset($_POST['client_name']) && $_POST['client_name']!="")
	{
		if(str_prepare(trim($_POST['client_name']))=='')
		{
			setMsg("Error! Client Name cannot be empty");
			header("location:add_client_status.php");
			exit();
		}
	}

	$data = array(); 
	$data['user_id']=str_prepare($_POST['user_id']);
	$data['client_name']=str_prepare($_POST['client_name']);
	$data['job_type_id']= $_POST['job_type_id'];
	$data['date_receipt']=($_POST['date_receipt']);
	$data['job_allocated_to']=str_prepare($_POST['job_allocated_to']);
	$data['date_job_started']=($_POST['date_job_started']);
	$data['date_pendency_send']=$_POST['date_pendency_send'];
	$data['date_pendency_receipt']=($_POST['date_pendency_receipt']);
	$data['date_query_send']=($_POST['date_query_send']);
	$data['date_query_reply']=($_POST['date_query_reply']);
	$data['date_job_upload']=($_POST['date_job_upload']);
	$data['date_receipt_remark']=str_prepare($_POST['date_receipt_remark']);
	$data['date_job_started_remark']=str_prepare($_POST['date_job_started_remark']);
	$data['date_pendency_send_remark']=str_prepare($_POST['date_pendency_send_remark']);
	$data['date_pendency_receipt_remark']=str_prepare($_POST['date_pendency_receipt_remark']);
	$data['date_query_send_remark']=str_prepare($_POST['date_query_send_remark']);
	$data['date_query_reply_remark']=str_prepare($_POST['date_query_reply_remark']);
	$data['date_job_upload_remark']=str_prepare($_POST['date_job_upload_remark']);
	$data['last_updated_by']= $_SESSION[SESSION_PREFIX.'USER_NAME'];

	$data['status_add_date']=date('Y-m-d H:i:s');

	if(isset($_POST['user_id']) && $_POST['user_id']!='' && isset($_POST['client_name']) && $_POST['client_name']!=''){
		$status=$conn->Autoexecute(TABLE_PREFIX.'job_status_master',$data,'INSERT',false,true);


	if(isset($_POST['send_mail']) && ($_POST['send_mail']=="yes" || $_POST['send_mail']=="true"))
	{
			$sql="select fname, lname, email, addon_emails from user_master where user_id=".$data['user_id'];
			$res=$conn->Execute($sql);
			$res=$res->FetchRow();
			$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'status.php'),
		   array('NAME'=>$res['fname']." ".$res['lname'],
				'MESSAGE'=> 'Job status updated for a client named '.$data['client_name'].' on '.date("d-m-Y H:i",strtotime($data['status_add_date'])),
				'APP_URL'=>APP_URL,
				'App_Name'=>APP_NAME,
				'client_name'=>$data['client_name'],
				'date_receipt'=>(empty($_POST['date_receipt'])) ? '-' : date("d-m-Y",strtotime($data['date_receipt'])),
				'date_job_started'=>(empty($_POST['date_job_started'])) ? '-' : date("d-m-Y",strtotime($data['date_job_started'])),
				'date_pendency_send'=>(empty($_POST['date_pendency_send'])) ? '-' : date("d-m-Y",strtotime($data['date_pendency_send'])),
				'date_pendency_receipt'=>(empty($_POST['date_pendency_receipt'])) ? '-' : date("d-m-Y",strtotime($data['date_pendency_receipt'])),
				'date_query_send'=>(empty($_POST['date_query_send'])) ? '-' : date("d-m-Y",strtotime($data['date_query_send'])),
				'date_query_reply'=>(empty($_POST['date_query_reply'])) ? '-' : date("d-m-Y",strtotime($data['date_query_reply'])),
				'date_job_upload'=>(empty($_POST['date_job_upload'])) ? '-' : date("d-m-Y",strtotime($data['date_job_upload']))));
			
			sendmail($emailMsg,ADMINEMAIL,'Sapphire Info Solutions (P). Ltd.',$res['email'],'Job Status Update',$res['addon_emails']);
			setMsg("Client status added successfully & mail sent!");
			header("location:manage_clients_status.php");
			exit();		
		}
		else
			setMsg("client status added successfully");
			header("location:manage_clients_status.php");
			exit();		

	}
	else
	{
		setMsg("Error adding status!");
		header("location:add_client_status.php");
		exit();
	}

?>