<?php 
	require_once('../includes/startup.php');
	
	$report_date = $_REQUEST["report_date"];
	$date=date('Y-m-d')."_".time();

	/*$qry="SELECT * FROM user_login_history as ulh inner join user_master as um where ulh.user_id=um.user_id AND ulh.user_id=".$user_id; */


	$qry="SELECT *,TIMEDIFF(logout_time, login_time) as total_time FROM  user_login_history as ulh inner join user_master as um where ulh.user_id=um.user_id AND ulh.login_time like '".$report_date."%' order by login_history_id DESC";

	$file="Reports"."_".$date.".xls";
	
	$headingArr=array("First Name","Last Name","Login Time", "Logout Time", "Total Time Spent");
	$fieldArr=array('first_name','last_name','login_time','logout_time','total_time');

	$heading="Attendance Report";
	
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
				if($field == 'login_time' && $row[$field]!="")
				{
					$row[$field] = date('d M,Y H:i:s',strtotime($row[$field]));
				} 
				if($field == 'logout_time' && $row[$field]!="")
				{
					$row[$field] = date('d M,Y H:i:s',strtotime($row[$field]));
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