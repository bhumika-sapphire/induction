<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "user_combined_report";
$report_setting = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Combined Report</h1>
                <ol class="breadcrumb col-lg-12">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i>User Combined Report</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="user_combined_report_show.php" method="post" >
                <div class="col-lg-6">
                    
					<div class="form-group" id="sandbox-container" style="position:relative">
                        <label for = "date">Date</label>
						
						<input required class="form-control datepicker" name="report_date" id="report_date">
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
