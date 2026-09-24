<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'user_all_perfomance_question';
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

    <form action="user_all_perfomance_question.php" method="get">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group"  style="position:relative">
                    <!-- <label for="select_status">Choose Status</label> -->
                    <select required class="form-control " name="status" id="status">
                    <option value="">Select Status</option>
                    <option value="1" <?php  if(isset($_GET['status']) && $_GET['status'] == "1"){ echo "selected"; } ?> >Active</option>
                    <option value="0" <?php  if(isset($_GET['status']) && $_GET['status'] == "0"){ echo "selected"; } ?>>Deactive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6" >
                <button class="btn btn-default" type="submit">Submit</button>
            </div>

        </div>
    </form>

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
                <th>Total Questions</th>  <!-- hidden column -->
                <th>Correct Answers</th>  <!-- hidden column -->
                <th>Wrong Answers</th>  <!-- hidden column -->
				        <th>Result</th>
                <th>Date</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
				        <th>Sr. No.</th>
                <th>User ID</th>      <!-- hidden column -->
                <th>Name</th>
				        <th>Topics</th>
                <th>Details</th>
                <th>Total Questions</th>  <!-- hidden column -->
                <th>Correct Answers</th>  <!-- hidden column -->
                <th>Wrong Answers</th>  <!-- hidden column -->
				        <th>Result</th>

                <th>Date</th>
              </tr>
            </tfoot>
            <tbody>
				<?php 
        $status="";
      if(isset($_GET['status']) && $_GET['status'] != "")
      {
        $status= "WHERE um.is_active =".intval($_GET['status']);     
      }
      $sql="SELECT 
        um.user_id,
        um.first_name,
        um.last_name,
        um.reg_date,
        uftm.test_date,
        uftm.is_pass,
        uftm.total_questions,
        uftm.correct_answers,
        uftm.time_taken,
        uftm.user_id AS final_user_id,
        uftm.is_pass AS final_test
        FROM user_master AS um
        LEFT JOIN (
            SELECT 
                user_final_test_master.*
            FROM user_final_test_master
            INNER JOIN (
                SELECT user_id, MAX(test_date) AS latest_test_date
                FROM user_final_test_master
                GROUP BY user_id
            ) AS latest
            ON user_final_test_master.user_id = latest.user_id 
            AND user_final_test_master.test_date = latest.latest_test_date
        ) AS uftm
        ON um.user_id = uftm.user_id " . $status . " ORDER BY uftm.test_date DESC";

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
					<tr><td>Wrong Questions:</td><td><?php echo ($result['total_questions'] - $result['correct_answers']); ?></td></tr>
					<tr><td>Time Taken:</td><td><?php if(isset($result["time_taken"])) echo $result['time_taken']; else echo "0"; ?> secs</td></tr>
				 </table>
        </td>



          <!-- Hidden export-only columns -->
      <td class="export-data"><?php echo $result['total_questions']; ?></td>
      <td class="export-data"><?php echo $result['correct_answers']; ?></td>
      <td class="export-data"><?php echo ($result['total_questions'] - $result['correct_answers']); ?></td>



				 <td>
          
         <?php
         if(isset($result["is_pass"]) && $result["is_pass"] !="")
         {
            if(isset($result["is_pass"]) && $result["is_pass"] ==0) echo "Fail"; else echo "Pass";
         }else{
          echo "Not Attempted";
         }
          

          ?>

        </td>
				 <td><?php
         if(isset($result["test_date"]) && $result["test_date"] !="")
         {
            echo date("d M, Y H:i",strtotime($result["test_date"]));
         }
        
         
         ?></td>




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
          columns: [1,2,5,6,7, 8, 9,]
        }
      },
      {
        extend: 'excel',
        exportOptions: {
          columns: [1,2,5,6,7, 8, 9,]
        }
      },
      {
        extend: 'pdf',
        exportOptions: {
          columns: [1,2,5,6,7, 8, 9,]
        }
      },
      {
        extend: 'print',
        exportOptions: {
          columns: [1,2,5,6,7, 8, 9,]
        }
      },

    ],
  columnDefs: [
    { targets: [1], visible: false },        // hide user_id
    { targets: [5,6,7], visible: false }     // hide the export-only columns
  ]
  });
});
</script>

