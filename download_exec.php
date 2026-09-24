<?php 
set_time_limit(0);
	include_once 'includes/startup.php';
	include_once 'authenticate.php';

$topic_id=$_REQUEST['topic_id'];
$test_id=$_REQUEST['test_id'];
if(isset($_SESSION[SESSION_PREFIX.'download_id']) && $_SESSION[SESSION_PREFIX.'download_id'] !="")
{

         setMsg("You have already file Download. Please upload file.");
		header("location: download_and_upload.php?topic_id=".$topic_id."&test_id=".$test_id);
		exit();

}


$data = array();
$files = array();

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$sql="select * FROM user_files_master where topic_id=".$topic_id;
$exec = $conn->Execute($sql);
 
if(isset($test_id) && $test_id !="")
{
    $sql1="select max(round) as round FROM user_files_upload_master where final_test_id=".$test_id." and user_id=".$user_id;
}
else
{
    $sql1="select max(round) as round FROM user_files_upload_master where user_id=".$user_id." and topic_id=".$topic_id;
}

$exec1 = $conn->Execute($sql1);

$result1 = $exec1->FetchRow();
 $round= 1;
    if(isset($result1['round']) && $result1['round'] !="")
    {
        $round= ($result1['round'] + 1);
    }


$files['topic_id']=$topic_id;
$files['user_id']=$user_id;
$files['final_test_id']=$test_id;
$files['round']=$round;
$files['download_date']=date("Y-m-d H:i:s");

$page_insert = $conn->Autoexecute(TABLE_PREFIX."user_files_upload_master", $files, "INSERT", true, false, MAGIC_QUOTES);




while($result = $exec->FetchRow())
{

    if($result['rounds'] == $round)
    {
            $start_time = date("Y-m-d H:i:s", strtotime('+2 hours'));
            $_SESSION[SESSION_PREFIX.'file_timer']=$start_time;
            $_SESSION[SESSION_PREFIX.'download_id'] = $conn->Insert_Id();
            $_SESSION[SESSION_PREFIX.'topic_id'] = $topic_id;
            $file_path=SITE_ADMIN_UPLOADS_DIR.$result['file_path']."/".$result['file_name'];
            download($file_path);
            
        
    }

}




function download($file_path)
{        

    if(isset($file_path) && file_exists($file_path))
    {
        $file_ext = trim(strtolower(strrchr($file_path,'.')));
        if($file_ext == ".pdf")
        {
            $ctype="application/pdf"; 	
        }
        else if($file_ext == ".docx")
        {
            $ctype="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        }
        else if($file_ext == ".doc")
        {
            $ctype="application/msword";
        }
        else 
        {

            $ctype="application/octet-stream";
        }
        //	@ob_end_clean();
        header('Pragma: public');
        header('Expires: 0');
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Cache-Control: private",false); // required for certain browsers 
        header('Content-Type: '.$ctype); 	
        header("Content-Disposition: attachment; filename=\"".basename($file_path)."\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($file_path));
        readfile($file_path);
        exit();
    }
    else
    {
        die("File not found!");
    }



}


?>