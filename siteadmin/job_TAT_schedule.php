<?php 
require_once('includes/startup.php');
require_once('authenticate.php');

$date = date('Y-m-d');
$today_date = date("Y-m-d");
// echo $date;
// echo $today_date;

$sql = "TRUNCATE job_tat_schedule";
$conn->Execute($sql);

$sql = "UPDATE file_master set job_tat_balance = job_tat_balance_original WHERE job_tat_balance_original > 0 AND status_id IN (2,4,6)";
$conn->Execute($sql);



while(true)
{
	if(isHoliday($date))
	{
		echo "<br>Holiday on ".$date;
		$date = date('Y-m-d', strtotime($date . "+1 days"));
		echo "<br>Now date is ".$date;
		// echo "<pre>";
		// print_r($date);
	   //die();
	}
	else if(isWeekend($date))
	{
		echo "<br>Weekend on ".$date;
		$date = date('Y-m-d', strtotime($date . "+1 days"));
		echo "<br>Now date is ".$date;
		// echo "<pre>";
		// print_r($date);
		// die();
		
	}



		/* Fetch all employees available for the day */
		$sql = "SELECT user_id,user_name FROM user_master WHERE user_type_id=4 AND is_active=1 AND user_id NOT IN (SELECT user_id FROM attendance_master WHERE attendance_date='".$date."' AND on_leave=1)";

		$res = $conn->Execute($sql);

		$job_available = 0;


		while($result = $res->FetchRow())
		{

			echo "<br><br>".$result['user_id']." - ".$result['user_name']." - ".$date;
			/* Calculate remaining hours for the employee */
			if($date == $today_date)
			 {
			 	
				$query = "SELECT login_time,logout_time FROM attendance_master WHERE attendance_date='".$date."' AND user_id=".$result['user_id'];
		     	$row = $conn->Execute($query);
		     	if($row->RowCount())
		     	{
		     		$data = $row->FetchRow();

		     		$get_login_time = strtotime($data['login_time']);
	    		
	    			if(empty($data['logout_time']))
					 {
						$calculate_working = round(abs((time() - $get_login_time)/3600),2);
					 }
					 else
					{
						/*$logout_time = strtotime($data['logout_time']);
						$calculate_working = round(abs(($logout_time - $get_login_time)/3600),2);*/
						continue;
					}

					$remaining_hrs = FULL_DAY - ((FULL_DAY/WORKING_HRS)*$calculate_working);
					if($remaining_hrs < 0)
					{
						$remaining_hrs = 0;
					}

		     	}
		     	else
		     	{
		     		$remaining_hrs = FULL_DAY;
		     	}
		    }
		    else
		    {
		    	$remaining_hrs = FULL_DAY;
		    }

		    echo "<br>Remaining Hrs: ".$remaining_hrs."<br>";

		    /* Fetch allocated jobs for the employee */
		    $associate_jobs = "SELECT fm.file_title,fm.job_tat_balance,fm.file_id,fm.job_tat_date_original FROM employee_job_association as eja,file_master as fm WHERE eja.user_id = ".$result['user_id']." AND eja.file_id = fm.file_id AND fm.job_tat_balance > 0 AND fm.status_id IN (2,4,6) ORDER BY eja.sort_order ASC";

			$res_jobs = $conn->Execute($associate_jobs);

			$job_available += $res_jobs->RowCount();

			while ($jobs = $res_jobs->FetchRow())
			{
				echo "Job: ".$jobs['file_id']." <br>Job TAT Balance: ".$jobs['job_tat_balance']."<br><br>";

					/* 
						Allocate remaining hours to a job. If the job completes with hours to spare, allocate new_remaining_hours to the next job. Otherwise break.
					*/
					$edit_TAT = array();

					if($jobs['job_tat_balance'] > $remaining_hrs)
					{
						$allocated_hours = $remaining_hrs;
						//print $allocated_hours;
						 $edit_TAT['job_tat_balance'] =  $jobs['job_tat_balance'] - $remaining_hrs;
						$remaining_hrs = 0;
					}
					else
					{
						$allocated_hours = $jobs['job_tat_balance'];
						$edit_TAT['job_tat_balance'] = 0;
						$edit_TAT['job_tat_date'] =  $date;

						if($jobs['job_tat_date_original'] ==""){
						 	$edit_TAT['job_tat_date_original'] = $date;
						}
						$remaining_hrs = $remaining_hrs - $jobs['job_tat_balance'];
						$job_available--;
					}

					$conn->AutoExecute("file_master",$edit_TAT, "UPDATE", "file_id= ".$conn->qstr($jobs['file_id']),true,false,MAGIC_QUOTES);

					$add_hours = array();
			  		$add_hours['file_id'] = $jobs['file_id'];
					$add_hours['user_id'] = $result['user_id'];
			  		$add_hours['schedule_date'] = $date;
			  		$add_hours['allocated_hours'] = $allocated_hours;
					$conn->Autoexecute(TABLE_PREFIX.'job_tat_schedule',$add_hours,'INSERT',false,true);

					print_r($add_hours);

					if($remaining_hrs<=0)
					{
						break;
					}
				}
		}

		$date = date('Y-m-d', strtotime($date . "+1 days"));
		

	if($job_available == 0)
	{
		break;
	}
}



 ?>