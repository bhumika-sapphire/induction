<?php 
include_once('../includes/startup.php');
require_once 'authenticate.php';
$page = 'manage_user';
$material_setting = true;
//$datatable = true;
include '_header.php';
$user_id = $_REQUEST['user_id'];
?>
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12" >
                        <h1 class="page-header">
                            <b><?php print APP_NAME; ?></b> Dashboard <span class="backbtn"><a href="manage_users.php">Back</a></span>
                        </h1>
                    </div>
              </div>
			
                <!-- /.row -->
				<div class="row">
				<div class="col-lg-6 col-xs-12">
						<div id="attendanceGraph" style="margin: 0 auto"></div>
					</div>
				</div>
				<!--Section 1-->
				
					<!--End Section 1-->
					

				<!-- section 2-->
				<div class="row">
					
					<div  class="col-lg-6 col-xs-12 " >
						<div class= "dashboard_background">
						<div class="row">
							<div class="col-lg-2"><h2 class="userpic"><i class="glyphicon glyphicon-user"></i></h2></div>
							<div class="col-lg-10"><h4 class="userspace">User Details</h4><p class="text-center"></div>
							</div>
							
							<!--time count-->
						<?php 
						$sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(logout_time, login_time))/60 /60) as time_spent FROM user_login_history WHERE user_id=".$user_id;
						$result = $conn->Execute($sql);
                         $row = $result->FetchRow();						
					?>
							<div class="col-lg-3 col-xs-4"><h4 class="text-center minHeightDataHeadings">hours spent</h4><p class="text-center"><?php echo round($row['time_spent']); ?></p></div>
							<!--End time count-->
								<!--Chapter count-->
							<?php 
						  $total_chpater = "SELECT count(chapter_id) as chapter_count FROM user_chapter_test_master as uctm  WHERE uctm.is_pass='1' AND uctm.user_id=".$user_id;
						  $result = $conn->Execute($total_chpater);
                          $row = $result->FetchRow();							  
					      ?>
							<div class="col-lg-3 col-xs-4"><h4 class="text-center minHeightDataHeadings">Chapter <i class="glyphicon glyphicon-thumbs-up"></i> test cleared</h4><p class="text-center"><?php echo $row['chapter_count'];?></p></div>
							<!--End Chapter count-->
							
							
                           <!--Fails Chapter count-->
						   <?php 
						  $total_chpater = "SELECT count(chapter_id) as fail_count FROM user_chapter_test_master as uctm  WHERE uctm.is_pass='0' AND uctm.user_id=".$user_id;
						  $result = $conn->Execute($total_chpater);
                          $row = $result->FetchRow();							  
					      ?>
							<div class="col-lg-3 col-xs-4"><h4 class="text-center minHeightDataHeadings">Chapter <i class="glyphicon glyphicon-thumbs-down"></i> test fails </h4><p class="text-center"><?php echo $row['fail_count'];?></p></div>
							   <!--End Fails Chapter count-->
							   
							  <!--Topic count-->
							  <?php
							   $topic_id = "SELECT count(topic_id) as topic_count FROM user_topics WHERE topic_completed=1 AND user_id=".$user_id;
							   $result = $conn->Execute($topic_id);
							   $row1 = $result->FetchRow();	
                              ?>						  
							<div class="col-lg-3 col-xs-4"><h4 class="text-center minHeightDataHeadings">Topics <i class="glyphicon glyphicon-thumbs-up"></i> Completed </h4><p class="text-center"><?php echo $row1['topic_count']; ?></p></div>
							<!--End Topic count-->
							<div class="text-center"><a href="user_test_perfomance.php?id=<?php echo $user_id; ?>" class="btn btn-primary" style="margin-top: 20px; margin-bottom: 20px;" id="loadMore">Test Report</a></div>
						</div>
					</div>
					
					<div class="col-lg-6 col-xs-12 ">
						<div class= "dashboard_background">
							<div class="col-lg-2"><h2><i class="glyphicon glyphicon-user"></i></h2></div>
							<div class="col-lg-10"><h4 class="usersecond">User Attendance Details</h4></div>
							<div class="col-lg-12">
								<div class="table-responsive">
									<table id="example" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												
												<th class="text-center">Login Time</th>
												<th class="text-center">Logout Time</th>
												<th  class="text-center">Total Time</th>
								            </tr>
										</thead>
										<tbody>
										<?php 
										     $sql = "SELECT *,TIMEDIFF(logout_time, login_time) as total_time FROM user_login_history as ulh inner join user_master as us where ulh.user_id =us.user_id AND ulh.user_id=".$user_id."
											 ORDER BY ulh.login_history_id";
												$exec = $conn->Execute($sql);
												$ctr = 1;
												while($result = $exec->FetchRow())
												{
												?>
													<tr class="<?php if($ctr <= 3){ print 'tdshow'; } else { print 'tdhide';} ?>">
														
														<td class="text-center"><?php echo date("d M, Y H:i",strtotime($result["login_time"]));?></td>
														<td class="text-center"><?php echo date("d M, Y H:i",strtotime($result["logout_time"]));?></td>
														<td class="text-center"><?php echo date("H:i:s",strtotime($result["total_time"]));?></td>
													</tr>
												<?php $ctr++; }  ?>
										</tbody>
									</table>
								</div></br>
								<div class="text-center"><button class="btn btn-primary" id="loadMore">Show More</button></div>
							</div> &nbsp;
						</div>
					</div>
				</div>
				<div class="row">
				<!--Chapter Performance Graph-->
					<div class="col-lg-6 col-xs-12 ">
						<div id="performanceGraph" style="margin: 0 auto"></div>
						<?php 
						$sql="SELECT ut.topic_id,topic_name FROM user_topics ut,topic_master tm WHERE tm.topic_id = ut.topic_id AND user_id = $user_id";
						$res = $conn->Execute($sql);
						$final = array();
						while($row = $res->FetchRow())
						{
							$sql="SELECT cm.chapter_id,chapter_name, correct_answers*100/total_questions as percent FROM chapter_master cm, user_chapter_test_master uctm WHERE cm.chapter_id=uctm.chapter_id AND uctm.topic_id=".$row['topic_id']." AND is_pass=1 AND user_id=$user_id";
							$res1 = $conn->Execute($sql);
							$temp = array();
							while($row1 = $res1->FetchRow())
							{
								$temp[] = (float)$row1['percent'];
								$chapter_name = $row1['chapter_name'];
							}
							if(count($temp))
							{	
								//$final[] = array("name"=>$row['topic_name'],"data"=>array("name"=>$chapter_name,"data"=>$temp));
								$final[] = array("name"=>$row['topic_name'],"data"=>$temp);
							}
						}
						//print json_encode($final);
						?>
					</div>
					<!--END Chapter Performance Graph-->
					
					<!--Topic wise time taken-->
					<div class="col-lg-6 col-xs-12 ">
					<div id="timetakenGraph" style="margin: 0 auto"></div>
						<?php 
						 $sql="SELECT ut.topic_id,topic_name FROM user_topics ut,topic_master tm WHERE tm.topic_id = ut.topic_id AND user_id = $user_id";
						$res = $conn->Execute($sql);
						$time = array();
						while($row = $res->FetchRow())
						{
							
							 $sql="select time_taken as time from user_chapter_test_master as uctm where uctm.topic_id=".$row['topic_id']." AND uctm.user_id=".$user_id;
							$res1 = $conn->Execute($sql);
							$temp = array();
							while($row1 = $res1->FetchRow())
							{
								$temp[] = (float)$row1['time'];
							}
							if($temp)
							{	
								//$final[] = array("name"=>$row['topic_name'],"data"=>array("name"=>$chapter_name,"data"=>$temp));
								$time[] = array("name"=>$row['topic_name'],"data"=>$temp);
							}
						}
						//print json_encode($time);
						?>
					</div>
					<!--END Topic wise time taken-->
				</div>
				
				<div class="row">
				<!--final test Performance Graph-->
					<div class="col-lg-6 col-xs-12 ">
						<div id="finaltestGraph" style="margin: 0 auto"></div>
							<?php 
								
								$sql="SELECT test_date,correct_answers*100/total_questions as percent FROM user_final_test_master WHERE user_id=$user_id";
								 $res1 = $conn->Execute($sql);
								 $finaltestGraph_data = array();
								while($row1 = $res1->FetchRow())
								{
									$finaltestGraph = array();
									
									$finaltestGraph_data[] = array("name"=>date("d M,Y H:i",strtotime($row1['test_date'])),"y"=>(float)$row1['percent']);
									
								}
								
							//print json_encode($finaltestGraph_data);
							?>
					</div>
					<!--END Final test Performance Graph-->
					
					<!-- Attendance Performance Graph-->
					<div class="col-lg-6 col-xs-12 ">
						<div id="Attandanceperformance" style="margin: 0 auto"></div>
							<?php $timee = array();
								  $sql="select logout_time-login_time as total_time from user_login_history where user_id=".$user_id." order by user_id DESC LIMIT 10";
								 $res = $conn->Execute($sql);
								 $totaltime = array();
								while($row = $res->FetchRow())
								{
									 $totaltime[] = (float)$row['total_time']/60;
								}
								$totaltime = array("name"=>"Time Spent","data"=>$totaltime);
							//print json_encode($totaltime);
							?>
					</div>
					<!--END  Attendance Performance Graph-->
				 </div>				
			</div>
        </div>
            <!-- /.container-fluid -->  
        <!-- /#page-wrapper -->
    </div>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>

<!-- Attandance hide show-->
<script>
$(document).ready(function (){
	$('tr.tdhide').hide();
		$('#loadMore').click(function(){
			$('tr.tdhide').toggle();
			$('#loadMore').text($('#loadMore').text() == 'Show More' ? 'Show Less' : 'Show More');
	});
});
</script>

<!--Chapter Performance Graph-->
<script>
Highcharts.chart('performanceGraph', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Chapter Performance Graph'
    },
	plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 1
        }
    },
    xAxis: {
        //type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
		title: {
            text: 'Chapters'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Test Percentage'
        }
    },
    legend: {
        enabled: true
    },
    tooltip: {
        pointFormat: 'Percentage: <b>{point.y:.1f} %</b>'
    },
    series: <?php print json_encode($final); ?>
});
</script>
<!--End Chapter Performance Graph-->


<!--Topic wise time taken-->
<script>
Highcharts.chart('timetakenGraph', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Topic Time Taken Graph'
    },
	plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 1
        }
    },
    xAxis: {
        //type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
		title: {
            text: 'Topic'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Time Taken'
        }
    },
    legend: {
        enabled: true
    },
    tooltip: {
        pointFormat: 'Time: <b>{point.y:.1f} seconds</b>'
    },
    series: <?php print json_encode($time); ?>
});
</script>
<!--Topic wise time taken-->

<!--final test Performance Graph-->
<script>
Highcharts.chart('finaltestGraph', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Final Test Performance Graph'
    },
	plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 1
        }
    },
    xAxis: {
        //type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
		
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Percentage'
        }
    },
    legend: {
        enabled: true
    },
    tooltip: {
        pointFormat: 'Percentage: <b>{point.y:.1f} %</b>'
    },
    series: [
        {
            "name": "Final Test Submissions",
			"data": <?php print json_encode($finaltestGraph_data); ?>
		}]
});
</script>
<!--End final test Performance Graph-->

<!--Attendance Performance datewise Graph-->
<script>
Highcharts.chart('Attandanceperformance', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Attendance Performance Graph'
    },
	plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 1
        }
    },
    xAxis: {
        //type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
		title: {
            text: 'Login Entries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Time Spent'
        }
    },
    legend: {
        enabled: true
    },
    tooltip: {
        pointFormat: '<b>{point.y:.1f} minutes</b>'
    },
    series: [<?php print json_encode($totaltime); ?>]
});
</script>
<!--End Attendance Performance datewise Graph-->


<?php include '_footer.php'; ?>