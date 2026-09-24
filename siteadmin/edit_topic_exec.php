<?php 
	require_once("../includes/startup.php");
	require_once('authenticate.php');

	$data = array();
	$err = false;

	
	$data["topic_name"] = str_prepare($_POST["topic_name"]);
	$data["sort_order"] = str_prepare($_POST["sort_order"]);


    if(isset($_POST["file_test"]) && $_POST["file_test"])
    {
        $data["file_test"] = 1;
    }
    else
    {
        $data["file_test"] = 0;
    }

    if(isset($_POST["is_communication"]) && $_POST["is_communication"])
    {
        $data["is_communication"] = 1;
    }
    else
    {
        $data["is_communication"] = 0;
    }
    
	if(isset($_POST["is_active"]) && $_POST["is_active"])
	{
		$data["is_active"] = 1;
	}
	else
	{
		$data["is_active"] = 0;
	}
    // print "<pre>";
    // print_r($data);
     
    //  exit();
	$topic_status = $conn->AutoExecute(TABLE_PREFIX."topic_master",$data, "UPDATE","topic_id= ".$conn->qstr($_POST["topic_id"]),true,false,MAGIC_QUOTES);


 
	if(!$topic_status)
	{
		setMsg("Sorry! Topic could not be edited.");
		header("location: edit_topic.php?topic_id=".$_POST["topic_id"]);
		exit();
		
	}



$path="topic/".$_POST['topic_name'];
$muliple_files= array();
foreach ($_FILES["files"]["error"] as $key => $error)
{


    if(isset($_FILES['files']['name'][$key]) && $_FILES['files']['name'][$key] !="")
    {
        $file_ext = trim(strtolower(strrchr($_FILES['files']['name'][$key],'.')));
        if($file_ext == '.doc' || $file_ext == '.docx' || $file_ext == '.pdf' || $file_ext == '.xlsx' || $file_ext == '.xls')
        {
            $file_type = "Document";
        }
        else if($file_ext == '.mp4' || $file_ext == '.mpeg' || $file_ext == '.avi' || $file_ext == '.3gp')
        {
            $file_type = "Video";
        }
        else if($file_ext == '.mp3' || $file_ext == '.wav' || $file_ext == '.wma')
        {
            $file_type = "Audio";
        }
        else 
        {
            $file_type = "Others";
        }
        
        $replace = array(" ","&","'",'"',"+","?",",","__","@","#","$","%","-",",","/",":",";","?","¥","©","~","=","!","|","^","`","*");

        $_FILES['files']['name'][$key]=str_replace($replace,"_",$_FILES['files']['name'][$key]);
        $material_file=time()."_".$_FILES['files']['name'][$key];

  
        $file_path_pg=SITE_ADMIN_UPLOADS_DIR."topic/".$_POST['topic_name']."/".$material_file;

        $file_path_folder=SITE_ADMIN_UPLOADS_DIR."topic/".$_POST['topic_name'];

        if (!file_exists($file_path_folder)) {
            mkdir ($file_path_folder, 0777, true);
        }
        
        

        if(!move_uploaded_file($_FILES['files']['tmp_name'][$key],$file_path_pg))
        {
                setMsg("Error uploading files!");
                header("location: add_topic.php");
                exit();
        
        }
        else
        {
            if(isset($_POST['old_material_file']) && $_POST['old_material_file']!="" &&
            file_exists(SITE_ADMIN_UPLOADS_DIR."topic/".$_POST["topic_name"]."/".$_POST['old_material_file']))
            {
                @unlink(SITE_ADMIN_UPLOADS_DIR."topic/".$_POST["topic_name"]."/".$_POST['old_material_file']);
            }
        }


    $muliple_files["file_name"] = $material_file;

    if(isset($_POST['insert_files']) && $_POST['insert_files'] == 1)
    {
        $muliple_files["file_path"] = $path;
        $muliple_files["topic_id"] = $_POST["topic_id"];
        $muliple_files["rounds"] = $key;
        $insert = $conn->Autoexecute(TABLE_PREFIX."user_files_master", $muliple_files, "INSERT", true, false, MAGIC_QUOTES);
    }
    else
    {
        $insert = $conn->AutoExecute(TABLE_PREFIX."user_files_master",$muliple_files, "UPDATE","id= ".$conn->qstr($key),true,false,MAGIC_QUOTES);

    }
	




    }

}

setMsg("Topic edited successfully!");
header("location: manage_topics.php");
exit();


?>