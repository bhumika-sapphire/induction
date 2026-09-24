<?php
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once(INCLUDES_DIR.'parser.php');
	require_once(LIB_DIR.'mail-wrapper.php');
	// echo "<pre>";
	// print_r($_POST);
	// echo strip_tags($_POST['file_desc']);
	// die();
    $id=$_POST['file_id']; 
	if(isset($_POST['user_name']) && $_POST['user_name']!="")
	{
		if(str_prepare(trim($_POST['user_name']))=='')
		{
			setMsg("Error! User Name cannot be empty");
			header("location:manage_inbox.php?file_id=".$id."");   
			exit();
		}
	}

	
	
	$edit_inbox = array(); 
	$edit_inbox['job_tat'] = str_prepare($_POST['job_tat']);
	if(isset($_POST['job_tat']) && $_POST['job_tat'] !=""){
		$edit_inbox['job_tat_balance'] = str_prepare($_POST['job_tat']);
		$edit_inbox['job_tat_balance_original'] = str_prepare($_POST['job_tat']);

	}
	$edit_inbox['job_start_date'] = str_prepare($_POST['job_start_date']);
	$edit_inbox['job_budget_client'] = str_prepare($_POST['job_budget_client']);
	$edit_inbox['job_budget_sapphire'] = str_prepare($_POST['job_budget_sapphire']);
	$edit_inbox['status_id'] = str_prepare($_POST['status_id']);
	if (isset($_POST['status_id'])  && $_POST['status_id'] == 7) {
	// When a job is edited by sub-admin or admin and its status is marked as 7, then clear the job_tat_date for it.
	$edit_inbox['job_tat_date'] = NULL;
	$edit_inbox['job_tat_date_original'] = NULL;
	}
	$edit_inbox['status_add_date']=date('Y-m-d H:i:s');
	$manage_inbox = $conn->AutoExecute("file_master",$edit_inbox, "UPDATE", "file_id= ".$conn->qstr($_POST["file_id"]),true,false,MAGIC_QUOTES);

	$sql = "DELETE FROM employee_job_association WHERE file_id = ".$id;
	$res=$conn->Execute($sql);
	$employee = array();
	$employee['file_id'] = $id;
	$employee['is_active'] = 1;

	foreach ($_POST['employee_ids'] as $user_id) {
		$employee['user_id'] = $user_id;
		
		$sql_select = "SELECT MAX(sort_order) as priority FROM employee_job_association WHERE user_id = ".$user_id;
		$res = $conn->Execute($sql_select);
        $row = $res->FetchRow();
        $employee['sort_order'] = $row['priority'] + 1;
        $conn->Autoexecute(TABLE_PREFIX.'employee_job_association',$employee,'INSERT',false,true,MAGIC_QUOTES);

	}



	 $sql="select u.fname,u.lname,u.email,u.addon_emails,file_title FROM file_master as fm,user_master as u WHERE u.user_id = fm.user_id AND fm.file_id = ".$id;
	$res=$conn->Execute($sql);
	$res=$res->FetchRow();

	$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'budget.php'),
				   array('NAME'=>$res['fname']." ".$res['lname'],
						'MESSAGE'=> 'You have approved the budget for the job - '.$res['file_title'],
						'APP_URL'=>APP_URL,
						'App_Name'=>APP_NAME,
						'JOB_BUDGET'=>$edit_inbox['job_budget_sapphire']
						));
				                      
	sendmail($emailMsg,ADMINEMAIL,APP_NAME,$res['email'],"Job Budget Approved (Job Id: $id)",$res['addon_emails']);
		
	/* Email to Admin */
	$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'budget.php'),
					   array('NAME'=>"Admin",
							'MESSAGE'=> 'Your proposed budget has been approved for the job - '.$res['file_title'],
							'APP_URL'=>APP_URL,
							'App_Name'=>APP_NAME,
							'JOB_BUDGET'=>$edit_inbox['job_budget_sapphire']
							));
	                      
	sendmail($emailMsg,ADMINEMAIL,APP_NAME,ADMINEMAIL,"Job Budget Approved (Job Id: $id)");

	
if($manage_inbox)
{
	setMsg("Inbox updated successfully");
    header("location: manage_inbox.php");
    exit();
}	
else
{
	setMsg("Error! Inbox could not be updated.");
    header("location: manage_inbox.php");
    exit();
} 
?>