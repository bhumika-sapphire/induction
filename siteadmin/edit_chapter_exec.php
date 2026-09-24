<?php 
	require_once("../includes/startup.php");
	require_once('authenticate.php');

	$data = array();
	$err = false;
	
	$data["chapter_name"] = str_prepare($_POST["chapter_name"]);
	$data["topic_id"] = str_prepare($_POST["topic_id"]);
	$data["sort_order"] = str_prepare($_POST["sort_order"]);
	if(isset($_POST["is_active"]) && $_POST["is_active"])
	{
		$data["is_active"] = 1;
	}
	else
	{
		$data["is_active"] = 0;
	}
	
	$topic_status = $conn->AutoExecute(TABLE_PREFIX."chapter_master",$data, "UPDATE", "chapter_id= ".$conn->qstr($_POST["chapter_id"]),true,false,MAGIC_QUOTES);

	if($topic_status)
	{
		setMsg("Chapter Edited Successfully");
		header("location: manage_chapters.php");
		exit();
	}
	else
	{
		setMsg("Sorry! Chapter could not be edited");
		header("location: edit_chapter.php?chapter_id=".$_POST["chapter_id"]);
		exit();
	}
?>