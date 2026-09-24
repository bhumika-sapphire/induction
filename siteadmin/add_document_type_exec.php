<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$data = array();
	$data["document_type"] = str_prepare($_POST["document_type"]);
	$data["sort_order"] = str_prepare($_POST["sort_order"]);
	$data["is_active"] = 1;
 
	$doc_type_insert = $conn->Autoexecute("document_type_master", $data, "INSERT", true, false, MAGIC_QUOTES);


		
if($doc_type_insert)
{
	setMsg("Document Type added successfully");
    header("location: document_type.php");
    exit();
}	
else
{
	setMsg("Error! Document Type could not be added.");
    header("location: document_type.php");
    exit();
} 

?>