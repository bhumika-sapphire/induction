<?php 
	require_once('../includes/startup.php');
	
	$date=date('Y-m-d')."_".time();

	$qry="SELECT um.*, ud.*,um.user_id as uid FROM user_master um LEFT JOIN user_details ud ON um.user_id=ud.user_id WHERE um.is_active=1 ORDER BY um.user_id desc";

	$file="Users-Report"."_".$date.".xls";
	
	$headingArr=array("User Login","Registration Date","First Name","Last Name","S/O, D/O, W/O","Date of Birth","Designation","Department","Date of Joining","Blood Group","Present Address","Permanent Address","Pan Number","Adhar Number","bank_name","Account Number","Branch Name","IFSC Code","Passbook Copy","Pan Copy","Adhar Copy","Address Copy","Profile Picture","Induction Complete","Contact Number","Other Contact Number","IT Policy", "Leave Policy","List of Holidays","Travel Policy","Increment Policy","Productivity Rules & Regulations");
	$fieldArr=array('user_login','reg_date','first_name','last_name','son_daughter_wife_of','dob','designation','department','date_of_joining','blood_group','present_address','permanent_address','pan_number','aadhar_number','bank_name','account_number','branch_name','ifsc_code','passbook_copy','pan_copy','adhar_copy','address_copy','profile_pic','induction_complete','user_phone','other_contact_number','it_policy','leave_policy','list_of_holidays_policy','travel_policy','increment_policy','productivity_policy');

	$heading="Consolidated Users Report";
	
	generateExcel($headingArr,$qry,$fieldArr,$file,$heading);
	
	function generateExcel($headingArr,$qry,$fieldArr,$filename,$heading)
	{
			
		global $conn;
		include(LIB_DIR.'excelwriter.inc.php');

		$excel=new ExcelWriter(APP_DIR."uploads/excel/".$filename);
		if($excel==false)	
			return false;
		
		$res=$conn->Execute($qry);
		$ctr = 1;
		while($row=$res->FetchRow())
		{
			$fields=array();
			foreach($fieldArr as $field)
			{
				if($field == 'passbook_copy')
				{
					if(isset($row[$field]) && $row[$field] !="") 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'profile_pic')
				{
					if(isset($row[$field]) && $row[$field] !="") 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'pan_copy')
				{
					if(isset($row[$field]) && $row[$field] !="") 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'adhar_copy')
				{
					if(isset($row[$field]) && $row[$field] !="") 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'address_copy')
				{
					if(isset($row[$field]) && $row[$field] !="") 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'induction_complete' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'it_policy' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'leave_policy' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'list_of_holidays_policy' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'travel_policy' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'increment_policy' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}
				if($field == 'productivity_policy' && $row[$field]!="")
				{
					if(isset($row[$field]) && $row[$field] == 1) 
					{ 
						$row[$field] = "Yes";  
					} 
					else  
					{ 
						$row[$field] = "No";
					} 
				}

				$fields[]=strip_tags($row[$field]);
				
			}
			
			$sql3 = "SELECT distinct dtm.document_type_id,dtm.document_type,user_id FROM document_type_master dtm LEFT JOIN user_documents ud ON dtm.document_type_id=ud.document_type_id AND user_id=".$row['uid']." WHERE dtm.is_active = 1 ORDER BY dtm.sort_order"; 
			/*print "<pre>";
			print_r($row);
			die($sql3);*/
			$res1=$conn->Execute($sql3);
		
			while($result3=$res1->FetchRow())
			{
				if(isset($result3['user_id']) && $result3['user_id'] != ""){
					$docFlag = "Yes";
				}
				else
				{
					$docFlag = "No";
				}
				
				$headingArr[] = $result3['document_type'];
				
				$fields[]=strip_tags($docFlag);
			}
			if($ctr == 1)
			{
				$excel->writeHeadingLine($heading,$headingArr);
				$ctr++;
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