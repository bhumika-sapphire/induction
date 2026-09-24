<?php
require_once("../includes/startup.php");
require_once('authenticate.php');

$err = false;
$edit_audio = array();
    $edit_audio["topic_id"] = str_prepare($_POST["topic_id"]);
    $edit_audio["chapter_id"] = str_prepare($_POST["chapter_id"]);
    $edit_audio["audio_title"] = str_prepare($_POST["audio_title"]);
	if(isset($_POST["is_active"]) && $_POST["is_active"])
	{
		$edit_audio["is_active"] = 1;
	}
	else
	{
		$edit_audio["is_active"] = 0;
	}
	if(isset($_FILES['audio_file']['name']) && $_FILES['audio_file']['name']!="")
	{
		$file_ext = trim(strtolower(strrchr($_FILES['audio_file']['name'],'.')));
		if($file_ext == '.mp3' || $file_ext == '.wav')
		{
			$replace = array(" ","&","'",'"',"__","?");
			$_FILES['audio_file']['name']=str_replace($replace,"_",$_FILES['audio_file']['name']);
			$audio_file=time()."_".$_FILES['audio_file']['name'];
			$file_path_pg=UPLOADS_DIR."/material/".$audio_file;
			
			
			$edit_audio['audio_file'] = $audio_file;
				
			if(!move_uploaded_file($_FILES['audio_file']['tmp_name'],$file_path_pg))
			{
				$err=true;
				$msg='Error uploading file!';
			}
		}
		else
		{
			setMsg("Wrong file format. Only MP3/WAV allowed.");
			header("location:add_comm_audio.php");
			exit();
		}
	}
	$audio_edit = $conn->AutoExecute(TABLE_PREFIX."comm_audio_master",$edit_audio, "UPDATE","comm_audio_id= ".$conn->qstr($_POST["comm_audio_id"]),true,false,MAGIC_QUOTES);
 
if($audio_edit)
{
	setMsg("Audio added successfully");
    header("location: manage_comm_audio.php");
    exit();
}	
else
{
	setMsg("Error! Audio has not been added.");
    header("location: manage_comm_audio.php");
    exit();
} 
?>