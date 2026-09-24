<?php

include_once '../includes/startup.php';
require_once('authenticate.php');

$file_id=$_POST["file_id"];
$data = array();

if(isset($_POST["try_again"]) && $_POST["try_again"])
{
    $data["try_again"] = 1;
}

$data["is_pass"]= $_POST["pass"];
$data["file_check_date"]=date("Y-m-d H:i:s");

$insert = $conn->AutoExecute(TABLE_PREFIX."user_files_upload_master",$data, "UPDATE","id= ".$conn->qstr($file_id),true,false,MAGIC_QUOTES);


if($insert)
{
    setMsg("user result edited successfully!");
    header("location: user_file_check.php?file_id=".$file_id);
    exit();
}
else
{
    setMsg("user result not edited successfully!");
    header("location: user_file_check.php?file_id=".$file_id);
    exit();
}

?>