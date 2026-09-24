<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'complied_summary';
$report_setting = true;
$datatable = true;
include_once '_header.php';
?>
<style>
	.btn-info{min-width:120px;}
</style>
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Compiled Summary</h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> Compiled Summary</li>
          
        </ol>
		<a class="col-lg-2 breadcrumb" href="execl_compiled_summary.php" >Export to Excel</a>
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
                <th>Name</th>
				<th>Policies Agreement</th>
				<th>Documents</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
				<th>Sr. No.</th>
                <th>Name</th>
				<th>Policies Agreement</th>
				<th>Documents</th>
              </tr>
            </tfoot>
            <tbody>
			
			
				<?php 
					$sql="select * from user_master";
					$exec = $conn->Execute($sql);
					$ctr = 0;
					while($result = $exec->FetchRow())
					{
						$ctr++;
				?>
              <tr>
			  
			  
                <td class="text-center"><?php echo $ctr; ?></td>
				<td>
					<strong> <?php echo $result["first_name"];?> <?php echo $result["last_name"];?> </strong>
				</td>
				
				<td>
					<ul>
						<li>IT Policy: <?php if($result["it_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
						<li>Leave Policy: <?php if($result["leave_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
						<li>List of Holidays: <?php if($result["list_of_holidays_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
						<li>Travel Policy: <?php if($result["travel_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
						<li>Increment Policy: <?php if($result["increment_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
						<li>Productivity Rules & Regulations: <?php if($result["productivity_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
					</ul>
				</td>
				<td>
					<ul>
						<?php $sql3 = "SELECT distinct dtm.document_type_id,dtm.document_type,user_id FROM document_type_master dtm LEFT JOIN user_documents ud ON dtm.document_type_id=ud.document_type_id AND user_id=".$result['user_id']." WHERE dtm.is_active = 1 ORDER BY dtm.sort_order"; 
					
						$exec3 = $conn->Execute($sql3);
												
						while($result3 = $exec3->FetchRow())
						{
						
							if(isset($result3['user_id']) && $result3['user_id'] != ""){
								$docFlag = true;
							}
							else
							{
								$docFlag = false;
							}
					
						?>
							
							
							<li><?php echo $result3['document_type']; ?>: <?php if($docFlag == true){ echo "<span class='glyphicon glyphicon-ok'></span>"; } else{ echo "<span class='glyphicon glyphicon-remove'></span>"; } ?></li>
						
						
						<?php 
						
						}
						
						?>
							<li>Permanent Address: <?php if (isset($result2['address_copy']) && $result2['address_copy'] != "") { echo "<span class='glyphicon glyphicon-ok'></span>"; } else{ echo "<span class='glyphicon glyphicon-remove'></span>"; } ?></li>
							<li>Adhar Card: <?php if (isset($result2['adhar_copy']) && $result2['adhar_copy'] != "") { echo "<span class='glyphicon glyphicon-ok'></span>"; } else{ echo "<span class='glyphicon glyphicon-remove'></span>"; } ?></li>
							<li>PAN Card: <?php if (isset($result2['pan_copy']) && $result2['pan_copy'] != "") { echo "<span class='glyphicon glyphicon-ok'></span>"; } else{ echo "<span class='glyphicon glyphicon-remove'></span>"; } ?></li>
							<li>Passbook: <?php if (isset($result2['passbook_copy']) && $result2['passbook_copy'] != "") { echo "<span class='glyphicon glyphicon-ok'></span>"; } else{ echo "<span class='glyphicon glyphicon-remove'></span>"; } ?></li>
						
					</ul>
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