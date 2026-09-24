<?php
require("../includes/startup.php");
require_once('authenticate.php');

$comm_material_id = $_REQUEST['comm_material_id'];

$sql="Select material_file FROM comm_material_master where comm_material_id=".$comm_material_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

$delete = "delete from comm_material_master where comm_material_id =".$comm_material_id;
$exec1 = $conn->Execute($delete);
if($exec1)
{
	if(isset($row['material_file']) && $row['material_file']!="" && file_exists(UPLOADS_DIR."/material/".$row['material_file']))
	{
		@unlink(UPLOADS_DIR."/material/".$row['material_file']);
	}
	setMsg("Communication Material has been deleted successfully");
    header("location: manage_comm_material.php");
	exit();
}
else
{
	setMsg("Error!Coumnication Material could not be deleted.");
	header("location: manage_comm_material.php");
	exit();
}

?>