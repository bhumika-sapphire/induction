<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_attendance';
$user_setting = true;
$datatable = true;
include_once '_header.php';
?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Manage Attendance</h1>
        <ol class="breadcrumb col-lg-12">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i>Manage Attendance</li>
          
        </ol>
        <!--<a class="col-lg-2 breadcrumb" href="add_question.php">Add Question</a>-->
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
                <th class="text-center">Sr. No.</th>
				<th>User Name</th>
                <th>Login Time</th>
				<th>Logout Time</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
				<th class="text-center">Sr. No.</th>
				<th>User Name</th>
                <th>Login Time</th>
				<th>Logout Time</th>
              </tr>
            </tfoot>
            <tbody>
			
			
				<?php 
					$sql="SELECT * FROM user_login_history as ulh inner join user_master as um where ulh.user_id=um.user_id order by login_history_id DESC";
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