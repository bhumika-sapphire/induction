<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "user_report";
$report_setting = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Report</h1>
                <ol class="breadcrumb col-lg-12">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i>User Report</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="user_report_exec.php" method="post" >
                <div class="col-lg-6">
                    
					<div class="form-group"  style="position:relative">
                        <label for = "student_id">User Name</label>
						
						<select required class="form-control select2" name="user_id" id="user_id">
						<option value="">Select Student</option>
						
						<?php
							$sql="select * from user_master";
							$exec = $conn->Execute($sql);
							while($result = $exec->FetchRow())
							{ ?>
								<option <?php if(isset($_GET['user_id']) && $_GET['user_id'] == $result["user_id"]) echo " selected"; ?> value="<?php echo $result["user_id"]; ?>"><?php echo $result["user_login"]." - ".$result["first_name"];  echo " ".$result["last_name"]; ?> </option>
					  <?php } ?>
						</select>
                    </div>
					
					<div class="form-group"  style="position:relative">
                        <label for = "report">Choose Report</label>
						<select required class="form-control " name="report" id="report">
						<option value="">Select Report</option>
						<option value="chapter">Chapter</option>
						<option value="attendence">Attendence</option>
						<option value="communication">Communication</option>
						</select>
                    </div>
					
                    <button class="btn btn-default" type="submit">Submit</button>
                </div>					

            </form>

        </div>
        <!-- /.row --> 
        <br/>
    </div>
    <!-- /.container-fluid --> 

</div>
<?php include '_footer.php'; ?>
