<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$data = array();

	$data["document_type"] = str_prepare($_POST["document_type"]);
	$data["sort_order"] = str_prepare($_POST["sort_order"]);
	
	if(isset($_POST["is_active"]) && $_POST["is_active"]==1)
	{
		$data["is_active"] = 1;
	}
	else
	{
		$data["is_active"] = 0;
	}

	$document_type_update = $conn->AutoExecute(TABLE_PREFIX."document_type_master",$data, "UPDATE", "document_type_id= ".$conn->qstr($_POST["document_type_id"]),true,false,MAGIC_QUOTES);

		
if($document_type_update)
{
	setMsg("Document Type updated successfully");
    header("location: document_type.php");
    exit();
}	
else
{
	setMsg("Error! Document Type could not be updated.");
    header("location: document_type.php");
    exit();
} 

?>