<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_topics';
$material_setting = true;
$datatable = true;
include_once '_header.php';

?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Manage Topics </h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> Manage Topics</li>
          
        </ol>
        <a class="col-lg-2 breadcrumb" href="add_topic.php" >Add Topic</a>
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
                <th>Topic</th>
                <th class="text-center">Sort Order</th>
				<th class="text-center">Is Communication</th>
				<th class="text-center">Is Active</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Topic</th>
			    <th class="text-center">Sort Order</th>
				<th class="text-center">Is Communication</th>
				<th class="text-center">Is Active</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
              </tr>
            </tfoot>
            <tbody>
              <?php 
	  $sql="select * from topic_master order by sort_order";
		$exec = $conn->Execute($sql);
		while($result = $exec->FetchRow())
		{
	?>
              <tr>
                <td><?php echo $result["topic_name"];?></td>
                <td class="text-center"><?php echo $result["sort_order"];?></td>
				<td class="text-center"><?php if($result["is_communication"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></td>
				<td class="text-center"><?php if($result["is_active"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></td>
                <td class="text-center"><a href="edit_topic.php?topic_id=<?php echo $result["topic_id"];?>">
				<button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>
                <td class="text-center"><a onclick="return confirm('Are you sure you want to delete this Topic?')" 
				href="delete_topic.php?topic_id=<?php echo $result["topic_id"];?>">
				<button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
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