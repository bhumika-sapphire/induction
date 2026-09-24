<?php
require_once("../includes/startup.php");
require_once('authenticate.php');

$err = false;


$data = array();
    $data["topic_name"] = str_prepare($_POST["topic_name"]);
    $data["sort_order"] = str_prepare($_POST["sort_order"]);
    if(isset($_POST["is_communication"]) && $_POST["is_communication"] !="")
    {
        $data["is_communication"] = str_prepare($_POST["is_communication"]);
    }
	
	$data["is_active"] = 1;
    $data["file_test"] = str_prepare($_POST["file_test"]);
    
$page_insert = $conn->Autoexecute(TABLE_PREFIX."topic_master", $data, "INSERT", true, false, MAGIC_QUOTES);
 
if(!$page_insert)
{
	setMsg("Error! Topic has not been added.");
    header("location: add_topic.php");
    exit();
}	

$last_id =$conn->Insert_Id();
$muliple_files= array();
$path="topic/".$_POST['topic_name'];

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
        $rounds=($key+1);

    $muliple_files["topic_id"] = $last_id;
    $muliple_files["file_name"] = $material_file;
    $muliple_files["file_path"] = $path;
    $muliple_files["rounds"] = $rounds;

    $insert = $conn->Autoexecute(TABLE_PREFIX."user_files_master", $muliple_files, "INSERT", true, false, MAGIC_QUOTES);

    }

}
  	setMsg("Topic added successfully");
    header("location: manage_topics.php");
    exit();


?>