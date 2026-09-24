<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_topics';
$material_setting = true;
$datatable = true;
include_once '_header.php';
$user_id=$_GET['id'];
?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> User Test Perfomance</h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> User Test Perfomance</li>
          
        </ol>
        <a class="col-lg-2 breadcrumb" href="edit_remarks.php?id=<?php echo $user_id; ?>">Add Remarks</a>
        <span class="col-lg-2 breadcrumb" >&nbsp;</span>
      </div>
    </div>
    <!-- /.row -->
    <p style="color:#F00"><?php echo getMsg('error');?></p>
    <div class="row">
      <div class="col-lg-12">
        <!--<h2>List of Categories</h2>-->
        <div class="table-responsive">
          <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
              <th>Name</th>
                <th>Chapter Name</th>
			    <th class="text-center">Days Spent</th>
				<th class="text-center">Test</th>
				<th class="text-center">Pass/Fail</th>
                <th class="text-center">Completed Chapter On</th>
                <th>Remarks</th>
              </tr>
            </thead>
         
            <tbody>
              <?php 
	$sql="SELECT uctm.*,cm.chapter_name,tm.topic_name,um.first_name
    FROM user_master AS um,user_chapter_test_master AS uctm,topic_master AS tm,chapter_master AS cm
    WHERE uctm.user_id=um.user_id AND cm.chapter_id=uctm.chapter_id AND tm.topic_id=uctm.topic_id AND um.user_id=".$user_id." GROUP BY um.user_id";
		$exec = $conn->Execute($sql);
		while($result = $exec->FetchRow())
		{
	?>

                        <?php 
						$sql1 = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(logout_time, login_time))/60 /60/8) as time_spent FROM user_login_history WHERE user_id=".$user_id;
						$result1 = $conn->Execute($sql1);
                         $row = $result1->FetchRow();						
					    ?>
              <tr>
              <td><?php echo $result["first_name"];?></td>
                <td><?php echo $result["topic_name"];?></td>
                <td class="text-center"><?php echo round($row['time_spent']); ?></td>
                <td class="text-center"><?php echo $result["topic_name"];?></td>
                
                <?php
                if(isset($result["is_pass"]) && $result["is_pass"] == 1)
                {                    
                ?>
                <td class="text-center">Pass</td>
                <td class="text-center">1</td>

                <?php 
                }else{
                ?>
                    <td class="text-center">Fail</td>
                    <td class="text-center">0</td>
                <?php } ?>
                <td><?php echo $result["comment"];?></td>
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