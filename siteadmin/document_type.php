<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'document_type';
$datatable = true;
$doc_setting = true;
include_once '_header.php';

?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Employee Document Type </h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> Employee Document Type</li>
          
        </ol>
		<a class="col-lg-2 breadcrumb" href="add_document_type.php" >Add Document Type</a>
        
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
                <th class="text-center">document_type</th>
                <th class="text-center">sort_order</th>
                <th class="text-center">Is Active</th>
                <th class="text-center">Edit</th>
				<th class="text-center">Delete</th>				
              </tr>
            </thead>
            <tfoot>
              <tr>
			    <th class="text-center">S.No.</th>
                <th class="text-center">document_type</th>
                <th class="text-center">sort_order</th>  
                <th class="text-center">Is Active</th>  
				<th class="text-center">Edit</th>
				<th class="text-center">Delete</th>
              </tr>
            </tfoot>
            <tbody>
            <?php 
				$sql="SELECT * FROM document_type_master ORDER BY sort_order";
				$exec = $conn->Execute($sql);
				$ctr = 1;
				while($result = $exec->FetchRow())
				{
			?>
              <tr>
				<td class="text-center"><?php echo $ctr++; ?></td>
                <td class="text-center"><?php echo $result["document_type"]; ?></td>
				<td class="text-center"><?php echo $result["sort_order"]; ?></td>
				<td class="text-center"><?php if($result["is_active"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></td>
                <td  class="text-center"><a href="edit_document_type.php?document_type_id=<?php echo $result["document_type_id"];?>" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>
				<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document Type?')" href="delete_document_type.php?document_type_id=<?php echo $result["document_type_id"];?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
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