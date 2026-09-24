<?php
require("../includes/startup.php");
require_once('authenticate.php');

$document_type_id = $_REQUEST['document_type_id'];
$delete = "delete from document_type_master where document_type_id =".$document_type_id;
$exec = $conn->Execute($delete);
if($exec)
{
	setMsg("Document Type has been deleted successfully");
	header("location: document_type.php");
	exit();
}
else
{
	setMsg("Error! Document Type could not be deleted.");
	header("location: document_type.php");
	exit();
}

?>