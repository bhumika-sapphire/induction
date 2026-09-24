<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_chapters';
$material_setting = true;
$datatable = true;
include_once '_header.php';
?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Manage Chapters </h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> Manage Chapters</li>
          
        </ol>
        <a class="col-lg-2 breadcrumb" href="add_chapter.php" >Add chapter</a>
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
                <th>Chapter Name</th>
                <th>Topic Name</th>
				<th class="text-center">Is Active</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
				<th>Sr. No.</th>
                <th>Chapter Name</th>
                <th>Topic Name</th>
				<th class="text-center">Is Active</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
              </tr>
            </tfoot>
            <tbody>
				<?php 
					$sql="select c.*, t.topic_name from chapter_master c, topic_master t where t.topic_id=c.topic_id ORDER BY c.sort_order";
					$exec = $conn->Execute($sql);
					$ctr = 0;
					while($result = $exec->FetchRow())
					{
						$ctr++;
				?>
              <tr>
                <td class="text-center"><?php echo $ctr; ?></td>
                <td><?php echo $result["chapter_name"];?></td>
                <td><?php echo $result["topic_name"];?></td>
				<td class="text-center"><?php if($result["is_active"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></td>
                <td class="text-center"><a href="edit_chapter.php?chapter_id=<?php echo $result["chapter_id"];?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>
                <td class="text-center"><a onclick="return confirm('Are you sure you want to delete this chapter?')" href="delete_chapter.php?chapter_id=<?php echo $result["chapter_id"];?>"><button class="btn btn-primary">
				<span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
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