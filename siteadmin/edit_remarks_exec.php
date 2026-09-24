<?php 
	require_once("../includes/startup.php");
	require_once('authenticate.php');

	$data = array();
	$err = false;
	
	$data["comment"] = str_prepare($_POST["edit_remarks"]);
	
	$topic_status = $conn->AutoExecute(TABLE_PREFIX."user_chapter_test_master",$data, "UPDATE","user_id= ".$conn->qstr($_POST["user_id"]),true,false,MAGIC_QUOTES);

	if($topic_status)
	{
		setMsg("Remarks edited successfully!");
		header("location:user_test_perfomance.php?id=".$_POST["user_id"]);
		exit();
	}
	else
	{
		setMsg("Sorry! Remarks could not be edited.");
		header("location: user_test_perfomance.php?id=".$_POST["user_id"]);
		exit();
	}
?>