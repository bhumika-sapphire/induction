<?php 
    require_once('../includes/startup.php');
    include_once 'authenticate.php';
    $page = 'index';
    include '_header.php';
?>
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <b><?php print APP_NAME; ?></b> Dashboard
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
			
				<!--Section 1-->
			<div class="row">
				<div class="col-lg-12">
				<!--User Active Graph-->
				<div  class="col-lg-6 col-xs-12 " >
					<div id="active_inactive_userGraph" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
					<?php  
					 
					 $tittle = "Total Active Users";
					 $total_active_user = array();
					 $sql = "SELECT SUM(is_active) as active,count(user_id) as total FROM user_master";
					 $res = $conn->Execute($sql);
					 $row = $res->FetchRow();
					 $inactive = (int)$row['total'] - (int)$row['active'];
						$activeuser = array();
						$activeuser[] = array("name"=>"Active Users","y"=>(int)$row['active']);
						$activeuser[] = array("name"=>"In-Active Users","y"=>(int)$inactive);
					
					//print json_encode($activeuser);
					?>	
				</div>	
				<!--End User Active Graph-->
						
				<!--pass/ fail final test assaign Graph-->
					<div class="col-lg-6 col-xs-12 ">
						<div id="user_given_final_Graph" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
						<?php
						$sql = "SELECT COUNT(DISTINCT um2.user_id) AS pass_users,       	  COUNT(DISTINCT um3.user_id) AS fail_users
	                    FROM user_final_test_master um2, user_final_test_master um3 
						WHERE um3.user_id!=um2.user_id AND um2.is_pass='1' AND um3.is_pass='0' AND um3.user_id NOT IN (SELECT user_id FROM user_final_test_master WHERE is_pass=1)";						
						$res1 = $conn->Execute($sql);
					    $row1 = $res1->FetchRow();
                        
						$sql = "SELECT count(user_id) as all_users from user_master";
						$res2 = $conn->Execute($sql);
					    $row2 = $res2->FetchRow();
						
						$final_test_user = array();
						$final_test_user[] = array("name"=>"Total Users","y"=>(int)$row2['all_users']);
						$final_test_user[] = array("name"=>"Final Test Pass Users","y"=>(int)$row1['pass_users']);
						$final_test_user[] = array("name"=>"Final Test Fail Users","y"=>(int)$row1['fail_users']);
						
						?>
					</div>
				<!--End final test assaign Graph-->	
				</div>
			</div>
			<br>
			<br>
			<br>
				<div class="row">
					<div class="col-lg-12">
					<!--Chapter Performance Graph-->
						<div class="col-lg-12 col-xs-12 ">
							<div id="Topic_chapter_performance_Graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							<?php
							$sql = "SELECT distinct ut.topic_id,topic_name FROM topic_master tm, user_topics ut WHERE tm.topic_id=ut.topic_id order by sort_order";
							$res1 = $conn->Execute($sql);
							$topics = array();
							$chapters = array();
							$final_chapter = array();
							while($row1 = $res1->FetchRow())
							{
								$chapters[$row1['topic_id']] = array();
								$sql = "SELECT sum(is_correct) as correct_ans, count(distinct final_test_detail_id) as total_ques FROM user_final_test_details AS uftd INNER JOIN question_bank_master AS qbm WHERE uftd.question_id=qbm.question_id AND qbm.topic_id=".$row1['topic_id'];
								$res2 = $conn->Execute($sql);
								while($row2 = $res2->FetchRow())
								{
									if($row2['total_ques']>0)
									{
										$per = $row2['correct_ans']*100/$row2['total_ques'];
										$topics[] = array("name"=>$row1['topic_name'],"y"=>$per,"drilldown"=>$row1['topic_name']);
										
									}
									else
									{
										$topics[] = array("name"=>$row1['topic_name'],"y"=>0,"drilldown"=>$row1['topic_name']);
									}
									
								}
								
								$sql = "SELECT chapter_id, chapter_name FROM chapter_master WHERE topic_id=".$row1['topic_id'];
								$res3 = $conn->Execute($sql);
								
								while($row3 = $res3->FetchRow())
								{
									$sql = "SELECT sum(is_correct) as correct_ans, count(distinct final_test_detail_id) as total_ques FROM user_final_test_details AS uftd INNER JOIN question_bank_master AS qbm WHERE uftd.question_id=qbm.question_id AND qbm.chapter_id=".$row3['chapter_id'];
									$res4 = $conn->Execute($sql);
									while($row4 = $res4->FetchRow())
									{
										if($row4['total_ques']>0)
										{
											$per1 = $row4['correct_ans']*100/$row4['total_ques'];
											$chapters[$row1['topic_id']][] = array($row3['chapter_name'],(float)$per1);
											
										}
										else
										{
											$chapters[$row1['topic_id']][] = array($row3['chapter_name'],0);
										}
									}
								}
								
								$final_chapter[] = array("name"=>$row1['topic_name'],"id"=>$row1['topic_name'],"data"=>$chapters[$row1['topic_id']]);
							}
							
							//print "<br>Topic:".json_encode($topics);
								//print "<br>Chapter:".json_encode($final_chapter);
								//print "<pre>";
								//print_r($final_chapter);
							?>
						
						</div>
						<!--END Chapter Performance Graph-->
					</div>
				</div>
            </div>
            <!-- /.container-fluid -->   
        <!-- /#page-wrapper -->
    </div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="js/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- active inactive User Graph-->
<script>
Highcharts.chart('active_inactive_userGraph', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Active/Inactive User Graph'
    },
    tooltip: {
        pointFormat: '<b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            
        }
    },
    series: [{
        name: 'Total Active',
        colorByPoint: true,
        data: <?php print json_encode($activeuser); ?>
    }]
});
</script>
<!-- active inactive User Graph-->


<!-- Final User Graph-->
<script>
Highcharts.chart('user_given_final_Graph', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Final Pass/Fail User Graph'
    },
    tooltip: {
        pointFormat: '<b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            
        }
    },
    series: [{
        name: 'Total Active',
        colorByPoint: true,
        data: <?php print json_encode($final_test_user); ?>
    }]
});
</script>
<!-- End Final User Graph-->

<!-- Topic wise chapter Performance-->
<script>
Highcharts.chart('Topic_chapter_performance_Graph', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Topic-wise Chapter Percentage'
    },
    subtitle: {
        text: 'Click the Topics to view Chapter Percantage.'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Percentage'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    "series":  [
        {
            "name": "Topics",
            "colorByPoint": true,
			"data":<?php print json_encode($topics); ?>
		}
	],
    "drilldown": {
        "series": <?php print json_encode($final_chapter); ?>
    }
});

</script>
<!-- End Topic wise chapter Performance-->
<?php include '_footer.php'; ?>