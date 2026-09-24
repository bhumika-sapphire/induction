<?php
require("../includes/startup.php");
require_once('authenticate.php');

$chapter_id = $_REQUEST['chapter_id'];
$delete = "delete from chapter_master where chapter_id =".$chapter_id;
$exec = $conn->Execute($delete);
if($exec)
{
	
	setMsg("Chapter has been deleted successfully");
	header("location: manage_chapters.php");
	exit();
}
else
{
	setMsg("Chapter has not been deleted successfully");
	header("location: manage_chapters.php");
	exit();
}


?>