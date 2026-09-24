<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$user_data = array();
   
    $user_data["chapter_id"] = str_prepare($_POST["chapter_id"]);
	$user_data["material_title"] = str_prepare($_POST["material_title"]);
	$user_data["material_text"] = str_prepare($_POST["material_text"]);
	$user_data["material_time_duration"] = str_prepare($_POST["material_time_duration"]);
	$user_data["sort_order"] = str_prepare($_POST["sort_order"]);
	$user_data["add_date"] = date('Y-m-d H:i:s');
	$user_data["sort_order"] = str_prepare($_POST["sort_order"]);
	if(isset($_POST["is_active"]) && $_POST["is_active"]==1)
	{
		$user_data["is_active"] = 1;
	}
	else
	{
		$user_data["is_active"] = 0;
	}
	
	if(isset($_POST["fileremove"]) && $_POST["fileremove"]==1)
	{
		$user_data['material_file'] = NULL;
		$user_data['material_file_type'] = NULL;
		if(isset($_POST['old_material_file']) && $_POST['old_material_file']!="" && file_exists(UPLOADS_DIR."/material/".$_POST['old_material_file']))
		{
			@unlink(UPLOADS_DIR."material/".$_POST['old_material_file']);
		}
	}
	

	if(isset($_FILES['video']['name']) && $_FILES['video']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['video']['name'],'.')));
			
		$replace = array(" ","&","'",'"',"__","?","♫");
		$_FILES['video']['name']=str_replace($replace,"_",$_FILES['video']['name']);
		$video=time()."_".$_FILES['video']['name'];
		$file_path_pg=UPLOADS_DIR."material/".$video;

		$file_path_folder=UPLOADS_DIR."material";
		if (!file_exists($file_path_folder)) {
            mkdir ($file_path_folder, 0777, true);
        }
		
		$folder="material/".$video;
		$user_data['material_video'] = $folder;
			
		if(!move_uploaded_file($_FILES['video']['tmp_name'],$file_path_pg))
		{
			$err=true;
			$msg='Error video uploading file!';
		}
	}



	if(isset($_FILES['material_file']['name']) && $_FILES['material_file']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['material_file']['name'],'.')));
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
		
		/* $file_ext = trim(strtolower(strrchr($_FILES['material_file']['name'],'.')));
		switch($file_ext)
		{
			case '.png':			
			case '.jpeg':		
			case '.jpg':
			case '.gif':
			case '.pdf':
			case '.doc':
			case '.docx':
			case '.xlsx':
			case '.xls':
			case '.csv':
			case '.txt':
			break;
			default:
			$msg[]='Only JPG, JPEG, PNG, DOC, DOCX, XLSX, XLS, CSV, TXT and GIF files can be uploaded!';
			$err=true;
		}
 			
		if($err)
		{
			setMsg($msg);		
			header("location:add_progress.php");
			exit();
		} */
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['material_file']['name']=str_replace($replace,"_",$_FILES['material_file']['name']);
		$material_file=time()."_".$_FILES['material_file']['name'];
		$file_path_pg=UPLOADS_DIR."/material/".$material_file;
		
		
		$user_data['material_file'] = $material_file;
		$user_data['material_file_type'] = $file_type;
		if(!move_uploaded_file($_FILES['material_file']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading file!';
		}
		else
		{
			if(isset($_POST['old_material_file']) && $_POST['old_material_file']!="" && file_exists(UPLOADS_DIR."/material/".$_POST['old_material_file']))
			{
				@unlink(UPLOADS_DIR."/material/".$_POST['old_material_file']);
			}
		}
	}

	$material_update = $conn->AutoExecute(TABLE_PREFIX."training_material_master",$user_data, "UPDATE", "training_material_id= ".$conn->qstr($_POST["training_material_id"]),true,false,MAGIC_QUOTES);

		
if($material_update)
{
	setMsg("Training material updated successfully");
    header("location: manage_material.php");
    exit();
}	
else
{
	setMsg("Error! Training material could not be updated.");
    header("location: manage_material.php");
    exit();
} 

?>