<?php
require("../includes/startup.php");
require_once('authenticate.php');

$comm_audio_id = $_REQUEST['comm_audio_id'];

$sql="Select audio_file FROM comm_audio_master where comm_audio_id=".$comm_audio_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

$delete = "delete from comm_audio_master where comm_audio_id =".$comm_audio_id;
$exec = $conn->Execute($delete);
if($exec)
{
	if(isset($row['audio_file']) && $row['audio_file']!="" && file_exists(UPLOADS_DIR."/material/".$row['audio_file']))
	{
		@unlink(UPLOADS_DIR."/material/".$row['audio_file']);
	}
	setMsg("Communication Audio has been deleted successfully");
	header("location: manage_comm_audio.php");
	exit();
}
else
{
	setMsg("Error!Coumnication Audio could not be deleted.");
	header("location: manage_comm_audio.php");
	exit();
}

?>