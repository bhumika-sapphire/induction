<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$user_data = array();

	$user_data["nav_title"] = str_prepare($_POST["nav_title"]);
	$user_data["page_title"] = str_prepare($_POST["page_title"]);
	$user_data["page_content"] = str_prepare($_POST["page_content"]);
	$user_data["sort_order"] = str_prepare($_POST["sort_order"]);
	

	$page_update = $conn->AutoExecute(TABLE_PREFIX."cms_master",$user_data, "UPDATE", "page_id= ".$conn->qstr($_POST["page_id"]),true,false,MAGIC_QUOTES);

		
if($page_update)
{
	setMsg("CMS page updated successfully");
    header("location: cms.php");
    exit();
}	
else
{
	setMsg("Error! CMS page could not be updated.");
    header("location: cms.php");
    exit();
} 

?>