<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_comm_material';
$datatable = true;
$material_setting = true;
include_once '_header.php';

?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Manage Communication Material </h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> Manage Communication Material</li>
          
        </ol>
        <a class="col-lg-2 breadcrumb" href="add_comm_material.php" >Add Material</a>
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
                <th class="text-center">S.No.</th>
                <th class="text-center">Material Title</th>
                <th class="text-center">Chapter Name</th>
				<th class="text-center">Topic Name</th>
				<th class="text-center">File</th> 
				<th class="text-center">Edit</th>  
				<th class="text-center">Delete</th>  
              </tr>
            </thead>
            <tfoot>
              <tr>
			    <th class="text-center">S.No.</th>
                <th class="text-center">Material Title</th>
                <th class="text-center">Chapter Name</th>
				<th class="text-center">Topic Name</th>
                <th class="text-center">File</th> 				
				<th class="text-center">Edit</th>  
				<th class="text-center">Delete</th>   
              </tr>
            </tfoot>
            <tbody>
              <?php 
			$sql="SELECT tmm.*, c.chapter_name, t.topic_name FROM comm_material_master tmm, chapter_master c, topic_master t WHERE t.topic_id=tmm.topic_id AND c.chapter_id=tmm.chapter_id AND t.topic_id=c.topic_id";
			$exec = $conn->Execute($sql);
			$ctr = 1;
			while($result = $exec->FetchRow())
			//while(0)
			{
			?>
              <tr>
				<td class="text-center"><?php echo $ctr++; ?></td>
                <td class="text-center"><?php echo $result["audio_title"]; ?></td>
                <td class="text-center"><?php echo $result["chapter_name"]; ?></td>
                <td class="text-center"><?php echo $result["topic_name"]; ?></td> 
				<td  class="text-center"><?php if(isset($result['file_type']) && $result['file_type']!="") { echo $result["file_type"];} else{ echo '<span class="glyphicon glyphicon-remove"></span>'; } ?></td>
                <td  class="text-center"><a href="edit_comm_material.php?comm_material_id=<?php echo $result["comm_material_id"];?>" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>
                <td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Material?')" href="delete_comm_material.php?comm_material_id=<?php echo $result["comm_material_id"];?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
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