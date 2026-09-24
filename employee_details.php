<?php
	include_once 'includes/startup.php';
	include_once 'authenticate.php';
	
	$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
	$page_id=7;
	
	$usePrefilledDetails = "SELECT * FROM user_master WHERE user_id =".$user_id;
	$execcc = $conn->Execute($usePrefilledDetails);
	$details = $execcc->FetchRow();
	
	$userDetailsTable = "SELECT * FROM user_details WHERE user_id =".$user_id;
	$execccc = $conn->Execute($userDetailsTable);
	$values = $execccc->FetchRow();
	
	$_SESSION[SESSION_PREFIX.'pageViewed'][$page_id]="true";
	
	
	//user_topics
	$training = "SELECT * FROM cms_master WHERE page_id =".$page_id;
	$execc = $conn->Execute($training);
	$roww = $execc->FetchRow();
	$shortcode = true;
	$skin = true;
	
	include_once '_header.php';
	?>
<section class="breadcrumb">
	<div class="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Induction</a></li>
		</ul>
	</div>
</section>
<section class="courses-view">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="right-slide left">
					<h3 class="colorBlue">Induction Process</h3>
					<ul class="catagories-list cmsList">
						<?php
						
					
							$sql="select page_id,page_title,nav_title FROM cms_master WHERE is_policy=0 ORDER BY sort_order";
							$exec = $conn->Execute($sql);
							while($row = $exec->FetchRow())
							{ ?>
						
						<li <?php if($row['page_id'] == $page_id) echo "class='active'"; ?>>	
							<a <?php if(array_key_exists($row['page_id'],$_SESSION[SESSION_PREFIX.'pageViewed'])){print "class='listViewed'"; }print "class='notViewed'"; ?> <?php if($row['page_id'] == 7){ ?> href="employee_details.php"<?php }else if($row['page_id'] == 8){?> href="employee_documents.php" <?php }else if($row['page_id'] == 9){?> href="policies.php" <?php }else{?> href="induction.php?page_id=<?php print $row['page_id']; ?>" <?php } ?> ><?php print $row['nav_title']; ?></a>
							
						</li>
						<?php
							}
							?>
					
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<center><h3 class="pageTitle"><?php print $roww['page_title']; ?></h3></center>
						<div class="course-post">
							<?php echo getMsg('error'); ?>
							<div class="info contentBg">
								<div class="name">
									
									<form id="employee_details"  class="inited" role="form" action="employee_details_exec.php" method="post" enctype='multipart/form-data'>
										<div class="sc_contact_form_info">
											<div class="col-sm-6 col-md-6">
												<label for="firstName">First Name</label>
												<input required id="firstName" type="text" name="firstName" value="<?php print $details['first_name']; ?>">
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="lastName">Last Name</label>
												<input required id="lastName" type="text" name="lastName" value="<?php print $details['last_name']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="son_daughter_wife_of">S/O, D/O, W/O</label>
												<input id="son_daughter_wife_of" type="text" name="son_daughter_wife_of" value="<?php print $values['son_daughter_wife_of']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="dob">Date of Birth</label>
												<input id="dob" type="date" name="dob" value="<?php print $values['dob']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="blood_group">Blood Group</label>
												<input id="blood_group" type="text" name="blood_group" value="<?php print $values['blood_group']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="present_address">Present Address</label>
												<input id="present_address" type="text" name="present_address" value="<?php print $values['present_address']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="permanent_address">Permanent Address</label>
												<input id="permanent_address" type="text" name="permanent_address" value="<?php print $values['permanent_address']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="address_copy">Permanent Address Copy</label>
												<input id="address_copy" type="file" name="address_copy" accept="image/*" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="contact_number">Contact Number</label>
												<input id="contact_number" type="text" name="contact_number" value="<?php print $details['user_phone']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="other_contact_number">Other Contact Number</label>
												<input id="other_contact_number" type="text" name="other_contact_number" value="<?php print $values['other_contact_number']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="pan_number">Pan Number</label>
												<input id="pan_number" type="text" name="pan_number" value="<?php print $values['pan_number']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="pan_copy">Pan Card Copy</label>
												<input id="pan_copy" type="file" name="pan_copy" accept="image/*" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="aadhar_number">Adhar number</label>
												<input id="aadhar_number" type="text" name="aadhar_number" value="<?php print $values['aadhar_number']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="adhar_copy">Adhar Card Copy</label>
												<input id="adhar_copy" type="file" name="adhar_copy" accept="image/*" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="bank_name">Bank Name</label>
												<input id="bank_name" type="text" name="bank_name" value="<?php print $values['bank_name']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="account_number">Account Number</label>
												<input id="account_number" type="text" name="account_number" value="<?php print $values['account_number']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="branch_name">Branch Name</label>
												<input id="branch_name" type="text" name="branch_name" value="<?php print $values['branch_name']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="ifsc_code">IFSC Code</label>
												<input id="ifsc_code" type="text" name="ifsc_code" value="<?php print $values['ifsc_code']; ?>" >
											</div>
											
											<div class="col-sm-6 col-md-6">
												<label for="designation">Designation</label>
												<input id="designation" type="text" name="designation" value="<?php print $values['designation']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="department">Department</label>
												<input id="department" type="text" name="department" value="<?php print $values['department']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="date_of_joining">Date Of Joining</label>
												<input id="date_of_joining" type="date" name="date_of_joining" value="<?php print $values['date_of_joining']; ?>" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="passbook_copy">Passbook Copy</label>
												<input id="passbook_copy" type="file" name="passbook_copy" accept="image/*" >
											</div>
											<div class="col-sm-6 col-md-6">
												<label for="profile_pic">Profile Picture</label>
												<input id="profile_pic" type="file" name="profile_pic" accept="image/*" >
											</div>
											<div class="col-sm-6 col-md-6"><label>&nbsp;</label><label>&nbsp;</label></div>
											
											<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
											<div class="sc_contact_form_item sc_contact_form_button">
												<center><button class="margin10">Update My Details</button></center>
											</div>
										</div>
									</form>
								
									<p><a href="induction.php?page_id=6" class="prevButton">Prev</a><a href="employee_documents.php" class="nextButton">Next</a></p>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div style="display:none;" class="row">
					<div class="col-sm-12 col-md-12">
						<center><h3 class="pageTitle">Uploaded Files</h3></center>
						<div class="course-post">
							<div class="info">
								<div class="name">
									<div class="table-responsive">
										<table id="example" class="display" cellspacing="0" width="100%">
											<thead>
											  <tr>
												<th class="text-center">S.No.</th>
												<th class="text-center">Document Type</th>
												<th class="text-center">File Name</th>		
											  </tr>
											</thead>
											<tfoot>
											  <tr>
												<th class="text-center">S.No.</th>
												<th class="text-center">Document Type</th>
												<th class="text-center">File Name</th>		
											  </tr>
											</tfoot>
											<tbody>
											<tr>
												<td class="text-center">1</td>
												<td class="text-center">Permanent Address Copy</td>
												<td class="text-center"><?php echo $values['address_copy']; ?></td>
											</tr>
											<tr>
												<td class="text-center">2</td>
												<td class="text-center">PAN Card Copy</td>
												<td class="text-center"><?php echo $values['pan_copy']; ?></td>
											</tr>
											<tr>
												<td class="text-center">3</td>
												<td class="text-center">Adhar Card Copy</td>
												<td class="text-center"><?php echo $values['adhar_copy']; ?></td>
											</tr>
											<tr>
												<td class="text-center">4</td>
												<td class="text-center">Passbook Copy</td>
												<td class="text-center"><?php echo $values['passbook_copy']; ?></td>
											</tr>
											<tr>
												<td class="text-center">5</td>
												<td class="text-center">Profile Picture</td>
												<td class="text-center"><?php echo $values['profile_pic']; ?></td>
											</tr>
											</tbody>
										</table>
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</section>
<?php include '_footer.php';?>