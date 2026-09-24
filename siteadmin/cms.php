<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'cms';
$datatable = true;
$cms_setting = true;
include_once '_header.php';

?>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Content Management System </h1>
        <ol class="breadcrumb col-lg-12">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> CMS</li>
          
        </ol>
        
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
                <th class="text-center">Navbar Title</th>
                <th class="text-center">Page Title</th>
                <th class="text-center">Sort Order</th>
                <th class="text-center">Edit</th>  
              </tr>
            </thead>
            <tfoot>
              <tr>
			    <th class="text-center">S.No.</th>
                <th class="text-center">Navbar Title</th>  
                <th class="text-center">Page Title</th>  
                <th class="text-center">Sort Order</th>  
				<th class="text-center">Edit</th>  
              </tr>
            </tfoot>
            <tbody>
            <?php 
				$sql="SELECT * FROM cms_master ORDER BY sort_order";
				$exec = $conn->Execute($sql);
				$ctr = 1;
				while($result = $exec->FetchRow())
				{
			?>
              <tr>
				<td class="text-center"><?php echo $ctr++; ?></td>
                <td class="text-center"><?php echo $result["nav_title"]; ?></td>
                <td class="text-center"><?php echo $result["page_title"]; ?></td>
                <td class="text-center"><?php echo $result["sort_order"]; ?></td>
                <td  class="text-center"><a href="edit_cms.php?page_id=<?php echo $result["page_id"];?>" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>
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