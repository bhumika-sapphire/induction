<?php
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once(INCLUDES_DIR.'parser.php');
	require_once(LIB_DIR.'mail-wrapper.php');

	$id=$_POST['file_id']; 
	$edit_budget = array(); 
	
	$edit_budget['job_budget_client'] = str_prepare($_POST['job_budget_sapphire']);
	$edit_budget['status_id'] = 6;
	$edit_budget['budget_approve_date']=date('Y-m-d H:i:s');

	$manage_budget = $conn->AutoExecute("file_master",$edit_budget, "UPDATE", "file_id= ".$conn->qstr($_POST["file_id"]),true,false,MAGIC_QUOTES);

	$sql="select u.fname,u.lname,u.email,u.addon_emails,file_title FROM file_master as fm,user_master as u WHERE u.user_id = fm.user_id AND fm.file_id = ".$id;
	$res=$conn->Execute($sql);
	$res=$res->FetchRow();
	
	/* Email to Client */
	$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'client_budget.php'),
					   array('NAME'=>$res['fname']." ".$res['lname'],
							'MESSAGE'=> 'You have approved the budget for the job - '.$res['file_title'],
							'APP_URL'=>APP_URL,
							'App_Name'=>APP_NAME,
							'JOB_BUDGET'=>$edit_budget['job_budget_client']
							));
	                      
	sendmail($emailMsg,ADMINEMAIL,APP_NAME,$res['email'],"Job Budget Approved (Job Id: $id)",$res['addon_emails']);
		
	/* Email to Admin */
	$emailMsg=parse_template(file_get_contents(MAIL_TEMPLATES_DIR.'client_budget.php'),
					   array('NAME'=>"Admin",
							'MESSAGE'=> 'Your proposed budget has been approved for the job - '.$res['file_title'],
							'APP_URL'=>APP_URL,
							'App_Name'=>APP_NAME,
							'JOB_BUDGET'=>$edit_budget['job_budget_client'],
							));
	                      
	sendmail($emailMsg,ADMINEMAIL,APP_NAME,ADMINEMAIL,"Job Budget Approved (Job Id: $id)");
		
	
if($manage_budget)
{
	setMsg("Budget approved successfully");
    header("location: client_manage_outbox.php");
    exit();
}	
else
{
	setMsg("Error! Budget could not be updated.");
    header("location: client_manage_outbox.php");
    exit();
} 
?>