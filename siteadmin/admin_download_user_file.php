<?php 
set_time_limit(0);
include_once '../includes/startup.php';
require_once('authenticate.php');

$file_path=$_REQUEST['file_path'];
$file_id=$_REQUEST['file_id'];

$file_path=UPLOADS_DIR.$file_path;
download($file_path);


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

        setMsg("File Download Successfully");
		header("location: user_file_check.php?file_id=".$file_id);
		exit();

}


?>