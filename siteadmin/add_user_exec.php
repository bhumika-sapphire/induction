<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$add_user = array();

   $add_user["user_login"] = str_prepare($_POST["user_login"]);
   $res = $conn->Execute("select * from user_master where user_login='".$add_user["user_login"]."'");
   if($res->RowCount()>0){
	    setMsg('Username already exists');
        header('location: manage_users.php');
        exit();
   }
   $add_user["first_name"] = str_prepare($_POST["first_name"]);
   $add_user["user_phone"] = str_prepare($_POST["phone"]);
   $add_user["user_password"] = md5($_POST["Password"]);
   $add_user["last_name"] = str_prepare($_POST["last_name"]);
   $add_user["reg_date"] = date('Y-m-d H:i:s');

    $add_user_insert = $conn->Autoexecute("user_master", $add_user, "INSERT", true, false, MAGIC_QUOTES);
//   $add_user_insert = $conn->Autoexecute(TABLE_PREFIX."user_master", $add_user, "INSERT", true, false, MAGIC_QUOTES);
      
   $add_user_insert = $conn->Insert_Id();

	foreach($_POST["topic_id"] as $topic_id)
	{
		$data1= array();
		$data1["user_id"] = $add_user_insert;
		$data1["topic_id"] = $topic_id;
		$data1["allocation_date"] = date('Y-m-d H:i:s');
		$conn->Autoexecute("user_topics", $data1, "INSERT", true, false, MAGIC_QUOTES);
	}
	
if($add_user_insert)
{
	setMsg("User added successfully");
    header("location: manage_users.php");
    exit();
}	
else
{
	setMsg("Error! User could not be added.");
   header("location: manage_users.php");
    exit();
} 

?>