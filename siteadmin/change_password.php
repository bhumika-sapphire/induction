<?php
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'change_password';
include_once '_header.php';
?>
<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Change Password</h1>
                <ol class="breadcrumb">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i>Change Password</li>

                </ol>
            </div>
        </div>
        <!-- /.row -->
        <p style="color: red;"><?php echo getMsg('error'); ?></p>
        <div class="row">
            <div class="col-lg-4">
                <form role="form" action="change_password_exec.php" method="post" name="change_password" id="change_password" >

                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password"  class="form-control" name="admin_password"  id="admin_password" required>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password"  class="form-control" name="new_password" id="new_password" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" data-match="#new_password" data-match-error="Whoops, these don't match" class="form-control" name=" confirm_password" id="confirm_password" required>
                        <div class="help-block with-errors"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-primary" type="reset">Reset</button>

                </form>
            </div>
        </div>
        <!-- /.row --> 
        <br/>
    </div>
    <!-- /.container-fluid --> 

</div>
<?php include '_footer.php'; ?>