<?php
require("../includes/startup.php");
require_once('authenticate.php');

$topic_id = $_REQUEST['topic_id'];

$delete1 = "delete from user_files_master where topic_id =".$topic_id;
$exec1 = $conn->Execute($delete1);
if($exec1)
{
		$delete = "delete from topic_master where topic_id =".$topic_id;
		$exec = $conn->Execute($delete);
		if($exec)
		{
			
			setMsg("Topic has been deleted successfully");
			header("location: manage_topics.php");
			exit();
		}
		else
		{
			setMsg("Topic could not be deleted successfully");
			header("location: manage_topics.php");
			exit();
		}
}
else
{
			setMsg("Topic Files could not be deleted successfully");
			header("location: manage_topics.php");
			exit();
}




?>