<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$datatable = true;
$page = "user_report";
$report_setting = true;
include_once '_header.php';

	$user_id = $_GET["user_id"];

    $sql1 = "Select * FROM user_master where is_active = 1 AND user_id=".$user_id;
	$exec = $conn->Execute($sql1);
	$user_detail = $exec->FetchRow();

		$sql="SELECT ufctm.*,tm.topic_name FROM user_final_comm_test_master as ufctm, topic_master as tm WHERE ufctm.topic_id = tm.topic_id AND ufctm.user_id = ".$user_id;
	$exec1 = $conn->Execute($sql);

	
	
?>
<link href="css/select2.min.css" rel="stylesheet" />
<script src="js/select2.min.js"></script>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
			<ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> User Communication Report</li>
                </ol>
				<a class="col-lg-2 breadcrumb" href="execl_comm_report.php?user_id=<?php echo $user_id; ?>" >Export to Excel</a>
<div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12" style="background:white;padding-top:20px;padding-bottom:10px;margin-top:0;">
				<div class="col-lg-3">
					<label for="head2">Username: <?php echo $user_detail["user_login"]; ?></label>
				 </div>
			
				<div class="col-lg-3">
					<label for="head1">Name: 
							<?php echo $user_detail["first_name"]; ?> <?php echo $user_detail["last_name"]; ?>
					</label>
				</div>
				 <div class="col-lg-3">
					<label for="head2">Mobile No: <?php if(isset($user_detail['user_phone']))echo $user_detail['user_phone']; ?></label>
				 </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
	
            <p style="color:red"><?php echo getMsg('error'); ?></p>
			
				<div class="table-responsive">
				  <table id="example" class="display" cellspacing="0" width="100%">
					<thead>
					  <tr>
						<th class="text-center">Topic</th>
						<th class="text-center">Test Date</th>
						<th class="text-center">Total Questions</th>
						<th class="text-center">Correct Answer</th>
						<th class="text-center">Time Taken</th>
						<th class="text-center">Result</th>
					  </tr>
					</thead>
					<tfoot>
					 <tr>
						<th class="text-center">Topic</th>
						<th class="text-center">Test Date</th>
						<th class="text-center">Total Questions</th>
						<th class="text-center">Correct Answer</th>
						<th class="text-center">Time Taken</th>
						<th class="text-center">Result</th>
					  </tr>
					</tfoot>
					<tbody>
					
						<?php
							while($result1 = $exec1->FetchRow())
							{
							?>
								<tr>	
									<td class="text-center"><?php echo stripslashes($result1["topic_name"]);?></td>
									<td class="text-center"><?php echo date('d M,Y',strtotime($result1["test_date"]));?></td>
									<td class="text-center"><?php echo stripslashes($result1["total_questions"]);?></td>
									<td class="text-center"><?php echo $result1["correct_answers"];?></td>
									<td class="text-center"><?php echo $result1["time_taken"]/60;?> min</td>
									<td class="text-center"> 
										<?php if(isset($result1['is_pass']) && $result1['is_pass'] ==1) 
												{ 
													echo "Pass";  
												 
												  } 
												  else  
												  { 
													echo "Fail";
											      } ?>   
									</td>
								</tr>
							<?php 
							}
						if($exec1->RecordCount()==0)
						 {
							 
							print "<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>No Record Found</td>
							<td></td>
							<td></td>
							
							</tr>"; 
						 }
							?>					
					</tbody>
				  </table>
				</div>
				<!--<div class="col-lg-12 text-center">
				<br>
					<a href="export_user_report_sheet.php?user_id=<?php echo $user_id; ?>&subject_id=<?php echo $user_id; ?>" target="blank" class="btn btn-primary" type="submit">Print Report</a>
				</div>-->

        </div>
        <!-- /.row --> 
        <br/>
    </div>
    </div>
    <!-- /.container-fluid --> 

</div>
<?php include '_footer.php'; ?>