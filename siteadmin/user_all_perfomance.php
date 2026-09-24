<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'user_all_performance';
$user_setting = true;
$datatable = true;
include_once '_header.php';
?>



<!--Chpater Details-->
<div id="page-wrapper">
  <div class="container-fluid"> 
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Final Test Perfomance</h1>
        <ol class="breadcrumb col-lg-12">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i>User All Perfomance</li>
          
        </ol>
        
      </div>
    </div>
    <!-- /.row -->
    <p style="color:#F00"><?php echo getMsg('error');?></p>
    <div class="row">
      <div class="col-lg-12">
        <!--<h2>List of Categories</h2>-->
        <div class="table-responsive">
          <table id="example2" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Sr. No.</th>
                      <th>User ID</th>      <!-- hidden column -->
                <th>Name</th>
				        <th>Topics</th>
                <th>Details</th>
				        <th>Result</th>
                <th>Date</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
				        <th>Sr. No.</th>
                <th>Name</th>
				        <th>Topics</th>
                <th>Details</th>
				        <th>Result</th>
                <th>Date</th>
                <th>Edit</th>
              </tr>
            </tfoot>
            <tbody>
				<?php 

        $sql="SELECT 
              uftm.*, 
              um.first_name, 
              um.last_name, 
              fm.*, 
              uftm.is_pass AS final_test, 
              uftm.user_id AS final_user_id
          FROM user_master um
          JOIN user_files_upload_master fm 
              ON fm.user_id = um.user_id 
              AND fm.file_path IS NOT NULL
          LEFT JOIN user_final_test_master uftm 
              ON uftm.user_id = um.user_id 
              AND uftm.is_pass IN (0,1)
          ORDER BY fm.final_test_id DESC;";

					$exec = $conn->Execute($sql);
					$ctr = 0;
					while($result = $exec->FetchRow())
					{
						$ctr++;
				?>
              <tr>
                <td ><?php echo $ctr; ?></td>
                <td><?php echo $result['user_id']; ?></td>  <!-- user_id column -->
                <td><?php echo $result["first_name"]." ".$result["last_name"]; ?></td>
                
				 <td><?php $sql = "SELECT GROUP_CONCAT(DISTINCT topic_name ORDER BY topic_name SEPARATOR ',<br>') as topics FROM user_topics ut, topic_master tm WHERE ut.topic_id=tm.topic_id AND ut.user_id=".$result['user_id'];
				$exec1 = $conn->Execute($sql);
				$row = $exec1->FetchRow();
				echo $row['topics']; ?></td>
				 <td>
				 <table>
					<tr><td>Total Questions:</td><td><?php echo $result['total_questions']; ?></td></tr>
					<tr><td>Correct Questions:</td><td><?php echo $result['correct_answers']; ?></td></tr>
					<tr><td>Time Taken:</td><td><?php echo $result['time_taken']." secs"; ?></td></tr>
          





           <?php if(isset($result["download_date"]) && $result["download_date"] !="" && $result["download_date"] != Null){ ?>
          <tr><td>File Download:</td><td><?php echo date("d M, Y",strtotime($result["download_date"]));?></td></tr>

          <?php }else{ ?> 
            
            <tr><td>File Download:</td><td></td></tr>
            <?php }?>


          <?php if(isset($result["upload_date"]) && $result["upload_date"] !=""){ ?>
          <tr><td>File Upload:</td><td><?php echo date("d M, Y",strtotime($result["upload_date"]));?></td></tr>

          <?php }else{ ?> 
            
            <tr><td>File Upload:</td><td></td></tr>
            <?php }?>


          <?php if(isset($result["is_pass"]) && $result["is_pass"] !=""){ ?>
          <tr><td>File Result:</td><td><?php if($result["is_pass"] ==0) echo "Fail"; else echo "Pass";?></td></tr>

          <?php }else{ ?> 
            
            <tr><td>File Result:</td><td></td></tr>
            <?php }?>


				 </table></td>
				 <td>
          
         <?php
         if(isset($result["final_test"]) && $result["final_test"] !="")
         {
            if($result["final_test"] ==0) echo "Fail"; else echo "Pass";
         }
          

          ?>

        </td>
				 <td><?php
         if(isset($result["test_date"]) && $result["test_date"] !="")
         {
            echo date("d M, Y H:i",strtotime($result["test_date"]));
         }
        
         
         ?></td>




                   <?php if(isset($result["id"]) && $result["id"] !=""){ ?>
                  <td class="text-center"><a href="user_file_check.php?file_id=<?php echo $result["id"];?>">
				<button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a>
        </td>

          <?php }else{ ?> 
            
            <td></td>
            <?php }?>



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


<?php include '_footer.php';?> 


<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(function () {
  $("#example2").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'csv',
        exportOptions: {
          columns: [1,2,5,6]
        }
      },
      {
        extend: 'excel',
        exportOptions: {
          columns: [1,2,5,6]
        }
      },
      {
        extend: 'pdf',
        exportOptions: {
          columns: [1,2,5,6]
        }
      },
      {
        extend: 'print',
        exportOptions: {
         columns: [1,2,5,6]
        }
      },

    ],
      columnDefs: [
    {
      targets: [1],   // hide user_id column in table
      visible: false
    }
  ]
  });
});
</script>

