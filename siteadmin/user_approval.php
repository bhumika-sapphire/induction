<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'user_approval';
$user_setting = true;
$datatable = true;
include_once '_header.php';
?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Re-Appear Approvals</h1>
        <ol class="breadcrumb col-lg-12">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i>Re-Appear Approval</li>
          
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
                <th>Sr. No.</th>
                
				<th>User Name</th>
                <th>Description</th>
				 <th>Request Date</th>
				
				<th class="text-center">Request status</th>
                <th class="text-center">Approval</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
				<th>Sr. No.</th>
                
				<th>User Name</th>
                <th>Description</th>
				<th>Request Date</th>
				
				<th class="text-center">Request status</th>
                <th class="text-center">Approval</th>
              </tr>
            </tfoot>
            <tbody>
			
			
				<?php 
					$sql="SELECT ur.*,um.first_name FROM user_request as ur inner join user_master as um where ur.user_id=um.user_id;";
					$exec = $conn->Execute($sql);
					$ctr = 0;
					while($result = $exec->FetchRow())
					{
						$ctr++;
				?>
              <tr>
			  <td class="text-center"><?php echo $ctr; ?></td>
                <td><?php echo $result["first_name"];?></td>
                <td><?php echo $result["description"];?></td>
				<td><?php echo $result["request_date"];?></td>
				<td class="text-center"><?php echo $result["request_status"];?></td>
				<td class="text-center">
				<?php 
				if($result["request_status"] =='Pending')
				{
			 ?>
                <a onclick="return confirm('Are you sure you want to approve this request?')" href="approval_user.php?user_request_id=<?php echo $result["user_request_id"];?>"><button class="btn btn-success">
				</span>Approve</button></a>
				<?php } ?>
				</td>
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