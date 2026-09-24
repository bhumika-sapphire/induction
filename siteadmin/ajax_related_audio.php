<?php
	include_once '../includes/startup.php';
	include_once 'authenticate.php';
	$chapter_id = $_REQUEST['chapter_id'];
	$sql="select * from comm_audio_master WHERE is_active = 1 And chapter_id = ".$chapter_id;
	$exec = $conn->Execute($sql);
	$final = array();
	while($result = $exec->FetchRow())
	{ 
		$final[$result['comm_audio_id']] = $result['audio_title'];
		
	}
	echo json_encode($final);
	
?>