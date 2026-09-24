<?php
	include_once '../includes/startup.php';
	include_once 'authenticate.php';
	$topic_id = $_REQUEST['topic_id'];
	$sql="select * from chapter_master WHERE is_active = 1 And topic_id = ".$topic_id." ORDER BY sort_order";
	$exec = $conn->Execute($sql);
	$final = array();
	while($result = $exec->FetchRow())
	{ 
		$final[$result['chapter_id']] = $result['chapter_name'];
		
	}
	echo json_encode($final);
	
?>