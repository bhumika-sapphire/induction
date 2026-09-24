<?php 

	require_once('includes/startup.php');
	require_once('authenticate.php');	
	//require_once('lib/spreadsheet-reader/excel_reader2.php');
	require_once('lib/spreadsheet-reader/SpreadsheetReader.php');



  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

  if(in_array($_FILES["excel_file"]["type"],$mimes)){

    $uploadFilePath = 'uploads/import_jobs/'.basename($_FILES["excel_file"]['name']);
    move_uploaded_file($_FILES["excel_file"]['tmp_name'], $uploadFilePath);

    $Reader = new SpreadsheetReader($uploadFilePath);
	$Sheets = $Reader -> Sheets();

    foreach ($Sheets as $Index => $Name)
	{

		$Reader -> ChangeSheet($Index);

		foreach ($Reader as $Row)
		{
			if(isset($Row[0]) && trim($Row[0]) != "")
			{
				$data=array();

				$data['file_title']=$Row[0];
		        $data['job_type_id']= $Row[1];		        		
				$data['file_desc']=$Row[2];
				$data['job_budget_client']=$Row[3];
				$data['recipient_id']=$_POST['recipient_id'];
				$data['user_id']=$_SESSION[SESSION_PREFIX.'ADMIN_ID'];
				
				$file_master=$conn->Autoexecute(TABLE_PREFIX.'file_master',$data,'INSERT',false,true);
			}
			
		}
	}

   	if($file_master){
		setMsg("Data added successfully!");
		header("location:excel.php");
		exit();
	}
	else
	{
		setMsg("Error adding data!");
		header("location:excel.php");
		exit();       
	}

  }else { 
    die("<br/>Sorry, File type is not allowed. Only Excel file."); 
  }

?>