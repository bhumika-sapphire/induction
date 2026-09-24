<?php 

	include_once 'includes/startup.php';
	include_once 'authenticate.php';

    
$topic_id=$_POST['topic_id'];
$test_id=$_POST['test_id'];

if(isset($_SESSION[SESSION_PREFIX.'download_id']) && $_SESSION[SESSION_PREFIX.'download_id'] !="")
{
$download_flag=$_SESSION[SESSION_PREFIX.'download_id'];
}
else
{
    $download_flag="";
}

if($download_flag =="")
{
		setMsg("Sorry! Please Download File.");
		header("location: download_and_upload.php?topic_id=".$topic_id."&test_id=".$test_id);
		exit();
}

$upload_date = date("Y-m-d H:i:s");
$data=array();
$end_time = date("Y-m-d H:i:s");

    $sql1 = "SELECT upload_date FROM user_files_upload_master where id=".$download_flag;
    $exec1 = $conn->Execute($sql1);
    $file_result = $exec1->FetchRow();
    if(isset($file_result['upload_date']) && $file_result['upload_date'] !="")
    {
        setMsg("You have already file upload. Please wait for result.");
		header("location: download_and_upload.php?topic_id=".$topic_id."&test_id=".$test_id);
		exit();

    }

   if(isset($_SESSION[SESSION_PREFIX.'file_timer']) && $_SESSION[SESSION_PREFIX.'file_timer'] !=''  && ($end_time >= $_SESSION[SESSION_PREFIX.'file_timer']))
    {
            header("location: download_and_upload.php?topic_id=".$topic_id."&test_id=".$test_id);
            exit();
    }



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

  
        $file_path_pg=UPLOADS_DIR."topic/".$_POST['topic_name']."/".$material_file;

        $file_path_folder=UPLOADS_DIR."topic/".$_POST['topic_name'];

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
            file_exists(UPLOADS_DIR."topic/".$_POST["topic_name"]."/".$_POST['old_material_file']))
            {
                @unlink(UPLOADS_DIR."topic/".$_POST["topic_name"]."/".$_POST['old_material_file']);
            }
        }


    $data["upload_date"] = $upload_date;
    $data["file_path"] = "topic/".$_POST['topic_name']."/".$material_file;

   	$upload_file = $conn->AutoExecute(TABLE_PREFIX."user_files_upload_master",$data, "UPDATE","id= ".$conn->qstr($download_flag),true,false,MAGIC_QUOTES);

        if($upload_file)
        {
			unset($_SESSION[SESSION_PREFIX.'file_timer']);
			unset($_SESSION[SESSION_PREFIX.'download_id']);
			unset($_SESSION[SESSION_PREFIX.'topic_id']);
         //   setMsg("file successfully uploaded. Please wait result.");
            header("location: download_and_upload.php?topic_id=".$topic_id."&test_id=".$test_id);
            exit();
        }
        else
        {
            setMsg("file Not successfully uploaded. Please try agin.");
            header("location: download_and_upload.php?topic_id=".$topic_id."&test_id=".$test_id);
            exit();
        }

    }

}








?>