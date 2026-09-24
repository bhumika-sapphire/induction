<?php
require_once("includes/startup.php");
require_once('authenticate.php');
$err = false;

   // $data["document_type_id"] = str_prepare($_POST["document_type_id"]);
    
//print "<pre>";
//print_r($_POST);	
//print "<br> ============================================<br>";
//print_r($_FILES);
//exit();	


$sql="SELECT * FROM document_type_master WHERE is_active=1 ORDER BY sort_order";
$exec = $conn->Execute($sql);
$ctr = 1;
while($result = $exec->FetchRow())
{
	if(isset($_POST["document_".$result['document_type_id']]) && count($_POST["document_".$result['document_type_id']]) > 0){
		 foreach ($_POST["document_".$result['document_type_id']] as $file) {
			$file = @json_decode($file);
			if (!is_object($file)) continue;
			
			
			$filename = "document_".$result['document_type_id']."_".time()."_".$file->name;
			$file_data = base64_decode($file->data);
			$handle = fopen(UPLOADS_DOCS_DIR . $filename, 'w');
			fwrite($handle, $file_data);
			fclose($handle);
			
			/**/
			$data = array();
			$data["document_type_id"] = $result['document_type_id'];
			$data["user_id"] = $_SESSION[SESSION_PREFIX.'USER_ID'];
			$data["file_name"] = $filename;
			$data["orig_name"] = $file->name;
			$data["upload_date"] = date('Y-m-d H:i:s');
			$docs_insert = $conn->Autoexecute("user_documents", $data, "INSERT", true, false, MAGIC_QUOTES);
			
		 }
	}
}
		
if($docs_insert)
{
	setMsg("Documents updated successfully");
    header("location: employee_documents.php");
    exit();
}	
else
{
	setMsg("Error! Documents could not be updated.");
    header("location: employee_documents.php");
    exit();
} 

?>