<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = 'manage_users';
$user_setting = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add User</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add User</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_users.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="add_user_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "user_login">User login</label>
						<input required class="form-control" name="user_login" id="user_login" />
                    </div>
					
					<div class="form-group">
                        <label for = "first_name">First Name</label>
						<input required class="form-control" name="first_name" id="chapter_id"/>
                    </div>
					<div class="form-group">
                        <label for = "last_name">Last Name</label>
                       <input required type="text" class="form-control" name="last_name" id="last_name" >
                    </div>
					
					
					
										
                </div>
				<div class="col-lg-6">

					<div class="form-group">
					<label for = "Password">Password</label>
					<input type="password" class="form-control" name="Password" id="Password" />
                    </div>
					
					<div class="form-group">
                        <label for = "phone">Phone No</label>
                        <input required type="text" class="form-control" name="phone" id="phone" >
                    </div>
					
					
                      	<div class="form-group">
                        <label for = "topic_id">Select Topics</label>
						<select multiple required class="form-control select2" name="topic_id[]" id="topic_id">
						
						<?php
						$sql="select * from topic_master WHERE is_active = 1 ORDER BY sort_order";
						$exec = $conn->Execute($sql);
						while($row=$exec->FetchRow()) {?>
						<option value="<?php echo $row['topic_id']; ?>" selected><?php echo $row['topic_name']; ?></option>
						<?php } ?>
						</select>
					</div>
					
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<input type="hidden" name="add_date" id="add_date" value="<?php echo date('Y-m-d, h:i:s'); ?>" >
                        <button class="btn btn-default" type="submit">Submit</button>
					</div>
				</div>
				
            </form>
        </div>
        <!-- /.row --> 
        <br/>
    </div>
    <!-- /.container-fluid --> 
</div>
<?php include '_footer.php'; ?>