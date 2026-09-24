<?php
require("../includes/startup.php");
require_once('authenticate.php');

$user_document_id = $_REQUEST['user_document_id']; 
$user_id = $_REQUEST['user_id'];
$sql="Select ".$user_document_id." FROM user_details where user_id=".$user_id;

$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

$delete = "UPDATE user_details set $user_document_id=NULL where user_id =".$user_id;

$exec = $conn->Execute($delete);
if($exec)
{
	if(isset($row[$user_document_id]) && $row[$user_document_id]!="" && file_exists(UPLOADS_DETAILS_DIR.$row[$user_document_id]))
	{
		@unlink(UPLOADS_DETAILS_DIR.$row[$user_document_id]);
	}
	setMsg("Document has been deleted successfully");
	header("location: view_docs.php?user_id=".$user_id);
	exit();
}
else
{
	setMsg("Error! Document could not be deleted.");
	header("location: view_docs.php?user_id=".$user_id);
	exit();
}

?>