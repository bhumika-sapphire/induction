<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = 'manage_users';

$user_id=$_REQUEST['user_id'];
$sql="select * FROM user_master where user_id=".$user_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

$userDetailsTable = "SELECT * FROM user_details WHERE user_id =".$user_id;
$execccc = $conn->Execute($userDetailsTable);
$values = $execccc->FetchRow();

$sql="select * from user_topics WHERE user_id=".$user_id;
$exec1 = $conn->Execute($sql);
$topics = array();
while($row1 = $exec1->FetchRow())
{
	$topics[] = $row1['topic_id'];
}

include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Edit User</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Edit User</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_users.php">Back</a>
            </div>
        </div>
        <form role="form" action="edit_user_exec.php" method="post" enctype='multipart/form-data' novalidate>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "user_login">User login</label>
						 <input required type="text" class="form-control" name="user_login" id="user_login" value="<?php echo $row['user_login']; ?>" >
                    </div>
					<div class="form-group">
                        <label for = "first_name">First Name</label>
						<input required type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $row['first_name']; ?>" >
                    </div>					
					<div class="form-group">
                        <label for = "last_name">Last Name</label>
                       <input required type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $row['last_name']; ?>" >
                    </div>					
					<div class="form-group">
						<label for="department">Department</label>
						<input id="department" class="form-control" type="text" name="department" value="<?php print $values['department']; ?>" >
					</div>					
					<div class="form-group">
						<label for="designation">Designation</label>
						<input id="designation" class="form-control" type="text" name="designation" value="<?php print $values['designation']; ?>" >
					</div>					
					<div class="form-group">
						<label for="present_address">Present Address</label>
						<input id="present_address" class="form-control" type="text" name="present_address" value="<?php print $values['present_address']; ?>" >
					</div>					
					<div class="form-group">
						<label for="permanent_address">Permanent Address</label>
						<input id="permanent_address" class="form-control" type="text" name="permanent_address" value="<?php print $values['permanent_address']; ?>" >
					</div>					
					<div class="form-group">
						<label for="aadhar_number">Adhar number</label>
						<input id="aadhar_number" class="form-control" type="text" name="aadhar_number" value="<?php print $values['aadhar_number']; ?>" >
					</div>					
					<div class="form-group">
						<label for="pan_number">Pan Number</label>
						<input id="pan_number" class="form-control" type="text" name="pan_number" value="<?php print $values['pan_number']; ?>" >
					</div>					
					<div class="form-group">
						<label for="bank_name">Bank Name</label>
						<input id="bank_name" class="form-control" type="text" name="bank_name" value="<?php print $values['bank_name']; ?>" >
					</div>
					<div class="form-group">
						<label for="account_number">Account Number</label>
						<input id="account_number" class="form-control" type="text" name="account_number" value="<?php print $values['account_number']; ?>" >
					</div>
					<div class="form-group">
						<label for="branch_name">Branch Name</label>
						<input id="branch_name" class="form-control" type="text" name="branch_name" value="<?php print $values['branch_name']; ?>" >
					</div>
					<div class="form-group">
						<label for="ifsc_code">IFSC Code</label>
						<input id="ifsc_code" class="form-control" type="text" name="ifsc_code" value="<?php print $values['ifsc_code']; ?>" >
					</div>								
                </div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for = "user_password">Password</label>
						<input type="password" class="form-control" name="user_password" id="user_password" />
                    </div>
					<div class="form-group">
                        <label for = "son_daughter_wife_of">S/O, D/O, W/O</label>
						<input type="text" class="form-control" name="son_daughter_wife_of" id="son_daughter_wife_of" value="<?php echo $values['son_daughter_wife_of']; ?>" >
                    </div>					
					<div class="form-group">
                        <label for = "user_phone">Phone no.</label>
						<input required type="text" class="form-control" name="user_phone" id="user_phone" value="<?php echo $row['user_phone']; ?>" >
                    </div>
					<div class="form-group">
						<label for="other_contact_number">Other Contact Number</label>
						<input id="other_contact_number" class="form-control" type="text" name="other_contact_number" value="<?php print $values['other_contact_number']; ?>" >
					</div>
					<div class="form-group">
						<label for="blood_group">Blood Group</label>
						<input id="blood_group" class="form-control" type="text" name="blood_group" value="<?php print $values['blood_group']; ?>" >
					</div>
					<div class="form-group">
						<label for="dob">Date of Birth</label>
						<input id="dob" class="form-control" type="date" name="dob" value="<?php print $values['dob']; ?>" >
					</div>
					<div class="form-group">
						<label for="date_of_joining">Date of Joining</label>
						<input id="date_of_joining" class="form-control" type="date" name="date_of_joining" value="<?php print $values['date_of_joining']; ?>" >
					</div>
					<div class="form-group">
						<label for="address_copy">Permanent Address Copy</label>
						<input id="address_copy" class="form-control" type="file" name="address_copy" accept="image/*" >
					</div>
					<div class="form-group">
						<label for="pan_copy">Pan Number Copy</label>
						<input id="pan_copy" class="form-control" type="file" name="pan_copy" accept="image/*" >
					</div>
					<div class="form-group">
						<label for="adhar_copy">Adhar Number Copy</label>
						<input id="adhar_copy" class="form-control" type="file" name="adhar_copy" accept="image/*" >
					</div>
					<div class="form-group">
						<label for="passbook_copy">Passbook Copy</label>
						<input id="passbook_copy" class="form-control" type="file" name="passbook_copy" accept="image/*" >
					</div>
					<div class="form-group">
						<label for="profile_pic">Profile Picture</label>
						<input id="profile_pic" class="form-control" type="file" name="profile_pic" accept="image/*" >
					</div>
					<div class="form-group">
						 <label>Topic Name</label>
						<?php 
						
						$sql="select * from topic_master WHERE is_active = 1 ORDER BY sort_order";
						
                         $exec = $conn->Execute($sql);  ?>
						<select multiple required name="topic_id[]" id="topic_id" class="form-control select2" >
						<option value="">Select Topic</option>
						<?php while($row1=$exec->FetchRow()) { ?>
						<option value="<?php echo $row1['topic_id']; ?>"  <?php if(in_array($row1['topic_id'],$topics)) { echo ' selected '; } ?> ><?php echo $row1['topic_name']; ?></option>
						<?php } ?>
						</select>
                    </div>					
				</div>
				<div class="col-lg-12">
					<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($row['is_active']) && $row['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active"><br>
						  <button class="btn btn-default" type="submit">Submit</button>
                    </div>
					
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" >
				</div>
				
            
        </div>
        <!-- /.row --> 
        </form>
        <br/>
    </div>
    <!-- /.container-fluid --> 
</div>


<?php include '_footer.php'; ?>