<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$data = array();
    $data["topic_id"] = str_prepare($_POST["topic_id"]);
    $data["chapter_id"] = str_prepare($_POST["chapter_id"]);
	$data["material_title"] = str_prepare($_POST["material_title"]);
	$data["material_text"] = str_prepare($_POST["material_text"]);
	$data["material_time_duration"] = str_prepare($_POST["material_time_duration"]);
	$data["sort_order"] = str_prepare($_POST["sort_order"]);
	$data["add_date"] = date('Y-m-d H:i:s');
	$data["is_active"] = 1;
	
	
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
		$data['material_video'] = $folder;
			
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
			header("location:add_material.php");
			exit();
		} */
			
		$replace = array(" ","&","'",'"',"__","?");
		$_FILES['material_file']['name']=str_replace($replace,"_",$_FILES['material_file']['name']);
		$material_file=time()."_".$_FILES['material_file']['name'];
		$file_path_pg=UPLOADS_DIR."material/".$material_file;

		$file_path_folder=UPLOADS_DIR."material";
		if (!file_exists($file_path_folder)) {
            mkdir ($file_path_folder, 0777, true);
        }
		
		$data['material_file'] = $material_file;
		$data['material_file_type'] = $file_type;
			
		if(!move_uploaded_file($_FILES['material_file']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading file!';
		}
	}
 
	$material_insert = $conn->Autoexecute("training_material_master", $data, "INSERT", true, false, MAGIC_QUOTES);


		
if($material_insert)
{
	setMsg("Training material added successfully");
    header("location: manage_material.php");
    exit();
}	
else
{
	setMsg("Error! Training material could not be added.");
    header("location: manage_material.php");
    exit();
} 

?>