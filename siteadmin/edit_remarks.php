<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "manage_topics";
$material_setting = true;
include_once '_header.php';
$user_id=$_GET['id'];
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Add Remarks</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add Remarks </li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="user_test_perfomance.php?id=<?php echo $user_id; ?>">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_remarks_exec.php" method="post" >
                <div class="col-lg-6">
                    
					<div class="form-group">
                        <label for = "topic_name">Add Remarks</label>
                        <textarea  class="form-control" name="edit_remarks" id="edit_remarks" cols="20" rows="5"></textarea>
                    </div>
					<input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                    <button class="btn btn-default" type="submit">Submit</button>
                    <button class="btn btn-default" type="reset">Reset </button>
                </div>					

            </form>

        </div>
        <!-- /.row --> 
        <br/>
    </div>
    <!-- /.container-fluid --> 

</div>
<?php include '_footer.php'; ?>