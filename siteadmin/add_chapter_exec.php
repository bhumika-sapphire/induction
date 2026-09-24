<?php
require_once("../includes/startup.php");
require_once('authenticate.php');

$err = false;
$data = array();

    $data["chapter_name"] = str_prepare($_POST["chapter_name"]);
    $data["topic_id"] = str_prepare($_POST["topic_id"]);
    $data["sort_order"] = str_prepare($_POST["sort_order"]);
	$data["is_active"] = 1;
    
	
	$topic_id= "SELECT * FROM chapter_master where topic_id=".$data["topic_id"];
	$exec = $conn->Execute($topic_id);
    $row = $exec->FetchRow();
	
if($data["sort_order"] == $row['sort_order'] )
	{
		setMsg("This Sort order already Exists For this Topic");
		header("location: add_chapter.php");
        exit();
	}
else
{
	$page_insert = $conn->Autoexecute(TABLE_PREFIX."chapter_master", $data, "INSERT", true, false, MAGIC_QUOTES);
	
if($page_insert)
{
	setMsg("Chapter added successfully");
    header("location: manage_chapters.php");
    exit();
}	
else
{
	setMsg("Error! Chapter could not be added.");
    header("location: add_chapter.php");
    exit();
}
} 
?>