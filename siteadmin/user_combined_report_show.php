<?php
   include_once '../includes/startup.php';
   include_once 'authenticate.php';
   $datatable = true;
   $page = "user_report";
   $report_setting = true;
   include_once '_header.php';
   
   	$report_date = $_REQUEST["report_date"];
   	
   		 $sql="SELECT uctm.*,cm.chapter_name,tm.topic_name,um.* FROM user_chapter_test_master as uctm, topic_master as tm,user_master as um, chapter_master as cm WHERE uctm.topic_id = tm.topic_id AND uctm.chapter_id = cm.chapter_id AND uctm.user_id = um.user_id AND uctm.test_date like '".$report_date."%'";
   		$exec1 = $conn->Execute($sql);
   
   
   
   ?>
<link href="css/select2.min.css" rel="stylesheet" />
<script src="js/select2.min.js"></script>
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <ol class="breadcrumb col-lg-10">
         <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
         <li class="active"> <i class="fa fa-edit"></i> User Progress Report</li>
      </ol>
      <a class="col-lg-2 breadcrumb" href="excel_combined_report.php?report_date=<?php echo $report_date; ?>" >Export to Excel</a>
      <div class="col-lg-12">
         <!--<div class="row">
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
            </div>-->
         <!-- /.row -->
         <div class="row">
            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <div class="table-responsive">
               <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Topic</th>
                        <th class="text-center">Chapter</th>
                        <th class="text-center">Test Date</th>
                        <th class="text-center">Total Questions</th>
                        <th class="text-center">Correct Answer</th>
                        <th class="text-center">Time Taken</th>
                        <th class="text-center">Result</th>
                     </tr>
                  </thead>
                  <tfoot>
                     <tr>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Topic</th>
                        <th class="text-center">Chapter</th>
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
                        <td class="text-center"><?php echo stripslashes($result1["first_name"]);?> <?php echo $result1["last_name"]; ?></td>
                        <td class="text-center"><?php echo stripslashes($result1["topic_name"]);?></td>
                        <td class="text-center"><?php echo stripslashes($result1["chapter_name"]);?></td>
                        <td class="text-center"><?php echo date('d M,Y',strtotime($result1["test_date"]));?></td>
                        <td class="text-center"><?php echo stripslashes($result1["total_questions"]);?></td>
                        <td class="text-center"><?php echo $result1["correct_answers"];?></td>
                        <td class="text-center"><?php echo round($result1["time_taken"]/60,2);?> min</td>
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

<div class="col-lg-12 text-center">
               <br>
               	<a class="col-lg-12 breadcrumb" href="user_combined_report.php">Back</a>
               </div>
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
        <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">User Attendance</h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i>User Attendance</li>
        </ol>
		<a class="col-lg-2 breadcrumb" href="execl_combined_attendence_report.php?report_date=<?php echo $report_date; ?>" >Export to Excel</a>
        <!--<a class="col-lg-2 breadcrumb" href="add_question.php">Add Question</a>-->
      </div>
    </div>
      <!-- /.row -->
      <p style="color:#F00"><?php echo getMsg('error');?></p>
      <div class="row">
         <div class="col-lg-12">
            <!--<h2>List of Categories</h2>-->
            <div class="table-responsive">
               <table id="example1" class="display" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <th class="text-center">Sr. No.</th>
                        <th>User Name</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
						<th>Toatl Time Spent</th>
                     </tr>
                  </thead>
                  <tfoot>
                     <tr>
                        <th class="text-center">Sr. No.</th>
                        <th>User Name</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
						<th>Toatl Time Spent</th>
                     </tr>
                  </tfoot>
                  <tbody>
                     <?php 
                        $sql="SELECT *,TIMEDIFF(logout_time, login_time) as total_time FROM user_login_history as ulh inner join user_master as um where ulh.user_id=um.user_id AND ulh.login_time like '".$report_date."%' order by login_history_id DESC";
                        $exec = $conn->Execute($sql);
                        $ctr = 0;
                        while($result = $exec->FetchRow())
                        {
                        	$ctr++;
                        ?>
                     <tr>
                        <td class="text-center"><?php echo $ctr; ?></td>
                        <td><?php echo $result["first_name"];?>&nbsp;<?php echo $result["last_name"];?></td>
                        <td><?php echo date("d M, Y H:i:s",strtotime($result["login_time"]));?></td>
                        <td ><?php echo date("d M, Y H:i:s",strtotime($result["logout_time"]));?></td>
						<td><?php echo date("H:i:s",strtotime($result["total_time"]));?></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- /.row --> 
   </div>
   <!-- /.container-fluid --> 
   <br/>
</div>
<?php include '_footer.php'; ?>