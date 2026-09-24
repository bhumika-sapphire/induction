<?php 
require_once('includes/startup.php');
require_once('authenticate.php');

$file_id = $_POST['file_id'];
$insert_job_extension = array();
$insert_job_extension['file_id'] = $file_id;
$insert_job_extension['sub_admin_id'] = $_SESSION[SESSION_PREFIX.'ADMIN_ID'];
$insert_job_extension['original_tat_date'] = str_prepare($_POST['job_tat_date_original']);
$insert_job_extension['new_tat_date'] = str_prepare($_POST['job_tat_date']);
$insert_job_extension['manager_comments'] = str_prepare($_POST['manager_comments']);

$insert_TAT = $conn->Autoexecute(TABLE_PREFIX.'job_tat_extentions',$insert_job_extension,'INSERT',false,true,MAGIC_QUOTES);

	$edit_record = array();
	$edit_record['job_tat_date_original'] = str_prepare($_POST['job_tat_date']);
	$edit_record['tat_flag'] = 0;
	$conn->AutoExecute("file_master",$edit_record, "UPDATE", "file_id= ".$conn->qstr($_POST["file_id"]),true,false,MAGIC_QUOTES);
 
if($insert_TAT)
{
	setMsg("TAT Extension inserted successfully");
    header("location: manage_inbox.php");
    exit();
}	
else
{
	setMsg("Error! TAT Extension inserted could not be inserted.");
    header("location: manage_inbox.php");
    exit();
} 



 ?>