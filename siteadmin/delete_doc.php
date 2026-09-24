<?php
require("../includes/startup.php");
require_once('authenticate.php');

$user_document_id = $_REQUEST['user_document_id'];$user_id = $_REQUEST['user_id'];
$sql="Select file_name FROM user_documents where user_document_id=".$user_document_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

$delete = "delete from user_documents where user_document_id =".$user_document_id;
$exec = $conn->Execute($delete);
if($exec)
{
	if(isset($row['file_name']) && $row['file_name']!="" && file_exists(UPLOADS_DOCS_DIR.$row['file_name']))
	{
		@unlink(UPLOADS_DOCS_DIR.$row['file_name']);
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