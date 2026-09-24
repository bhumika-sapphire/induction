<?php
require("../includes/startup.php");
require_once('authenticate.php');

$training_material_id = $_REQUEST['training_material_id'];

$sql="Select material_file FROM training_material_master where training_material_id=".$training_material_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

$delete = "delete from training_material_master where training_material_id =".$training_material_id;
$exec = $conn->Execute($delete);
if($exec)
{
	if(isset($row['material_file']) && $row['material_file']!="" && file_exists(UPLOADS_DIR."/material/".$row['material_file']))
	{
		@unlink(UPLOADS_DIR."/material/".$row['material_file']);
	}
	setMsg("Material has been deleted successfully");
	header("location: manage_material.php");
	exit();
}
else
{
	setMsg("Error! Material could not be deleted.");
	header("location: manage_material.php");
	exit();
}

?>