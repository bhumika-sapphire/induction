<?php
require_once("../includes/startup.php");
require_once('authenticate.php');
$err = false;
$data = array();
    $data["topic_id"] = str_prepare($_POST["topic_id"]);
    $data["chapter_id"] = str_prepare($_POST["chapter_id"]);
	$data["audio_title"] = str_prepare($_POST["audio_title"]);
	$data["material_file"] = str_prepare($_POST["material_file"]);
	$data["audio_material_text"] = str_prepare($_POST["audio_material_text"]);
	$data["file_duration"] = str_prepare($_POST["material_time_duration"]);
	$data["add_date"] = date('Y-m-d H:i:s');
	
	

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
		$file_path_pg=UPLOADS_DIR."/material/".$material_file;
		
		
		$data['material_file'] = $material_file;
		$data['file_type'] = $file_type;
			
		if(!move_uploaded_file($_FILES['material_file']['tmp_name'],$file_path_pg))
		{
		$err=true;
		$msg='Error uploading file!';
		}
	}
 
	$material_insert = $conn->Autoexecute("comm_material_master", $data, "INSERT", true, false, MAGIC_QUOTES);


		
if($material_insert)
{
	setMsg("Communication material added successfully");
    header("location: manage_comm_material.php");
    exit();
}	
else
{
	setMsg("Error! Communication material could not be added.");
    header("location: manage_comm_material.php");
    exit();
} 

?>