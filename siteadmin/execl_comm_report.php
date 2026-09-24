<?php 
	require_once('../includes/startup.php');
	
	$user_id = $_GET["user_id"];
	$date=date('Y-m-d')."_".time();

	$qry="SELECT ufctm.*,tm.topic_name FROM user_final_comm_test_master as ufctm, topic_master as tm WHERE ufctm.topic_id = tm.topic_id AND ufctm.user_id = ".$user_id;

	$file="Reports"."_".$date.".xls";
	
	$headingArr=array("Topic","Test Date","Total Questions", "Correct Answer","Time Taken","Result");
	$fieldArr=array('topic_name','test_date','total_questions','correct_answers','time_taken','is_pass');

	$heading="Communication Report";
	
	generateExcel($headingArr,$qry,$fieldArr,$file,$heading);
	
	function generateExcel($headingArr,$qry,$fieldArr,$filename,$heading)
	{
			
		global $conn;
		include(LIB_DIR.'excelwriter.inc.php');

		$excel=new ExcelWriter(APP_DIR."uploads/excel/".$filename);
		if($excel==false)	
			return false;
		
		$excel->writeHeadingLine($heading,$headingArr);
		$res=$conn->Execute($qry);
		
		while($row=$res->FetchRow())
		{
			$fields=array();
			foreach($fieldArr as $field)
			{
				if($field == 'test_date' && $row[$field]!="")
				{
					$row[$field] = date('d M,Y',strtotime($row[$field]));
				} 
				if($field == 'time_taken' && $row[$field]!="")
				{
					$row[$field] = round($row[$field]/60,2);
				}
				if($field == 'is_pass' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Pass";  
					} 
					else  
					{ 
						$row[$field] = "Fail";
					} 
				}				

				$fields[]=strip_tags($row[$field]);
			}
			$excel->writeLine($fields);
			
		}
		$excel->close();

		$export_file = APP_DIR."uploads/excel/".$filename;
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Pragma: no-cache");
		header ("Last-Modified: ".date("D,d M Y H:i:s")." IST");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Cache-Control: private",false); // required for certain browsers 
		header ("Content-type: application/vnd.ms-excel");
		header ("Content-Disposition: attachment; filename=$filename");
		header ("Content-Description: PHP/INTERBASE Generated Data");
		readfile($export_file);
		//unlink($export_file);
	}
?>