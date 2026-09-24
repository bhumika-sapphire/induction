<?php
require("../includes/startup.php");
require_once('authenticate.php');

$question_id = $_REQUEST['question_id'];
$delete = "delete from question_bank_master where question_id =".$question_id;
$exec = $conn->Execute($delete);
if($exec)
{
	
	setMsg("Question has been deleted successfully");
	header("location: manage_question.php");
	exit();
}
else
{
	setMsg("Question has not been deleted successfully");
	header("location: manage_question.php");
	exit();
}


?>