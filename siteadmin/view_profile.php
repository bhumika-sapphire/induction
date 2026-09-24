<?php 
include_once('../includes/startup.php');
require_once 'authenticate.php';
$page = 'manage_users';
$user_setting = true;
$datatable = true;
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SWEC">
    <meta name="author" content="Web Supplements">
    <title>Admin Panel - <?php echo APP_NAME; ?></title>
    <!-- Bootstrap Core CSS 
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">-->
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" media='screen,print'>
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">


<style>
	
	body {
    background-color: #f9f9fa
}

.padding {
    padding: 3rem !important
}

.user-card-full {
    overflow: hidden
}

.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    border: none;
    margin-bottom: 30px
}

.m-r-0 {
    margin-right: 0px
}

.m-l-0 {
    margin-left: 0px
}

.user-card-full .user-profile {
    border-radius: 5px 0 0 5px
}

.bg-c-lite-green {
    background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
    background: linear-gradient(to right, #ee5a6f, #f29263)
}

.user-profile {
    padding: 20px 0
}

.card-block {
    padding: 1.25rem
}

.m-b-25 {
    margin-bottom: 25px
}

.img-radius {
    border-radius: 5px
}

h6 {
    font-size: 14px
}

.card .card-block p {
    line-height: 25px
}

@media (min-width: 1400px) {
    p {
        font-size: 14px
    }
}

.card-block {
    padding: 1.25rem
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0
}

.m-b-20 {
    margin-bottom: 20px
}

.p-b-5 {
    padding-bottom: 5px !important
}

.card .card-block p {
    line-height: 25px
}

.m-b-10 {
    margin-bottom: 10px
}

.text-muted {
    color: #919aa3 !important
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0
}

.f-w-600 {
    font-weight: 600
}

.m-b-20 {
    margin-bottom: 20px
}

.m-t-40 {
    margin-top: 20px
}

.p-b-5 {
    padding-bottom: 5px !important
}

.m-b-10 {
    margin-bottom: 10px
}

.m-t-40 {
    margin-top: 20px
}

.user-card-full .social-link li {
    display: inline-block
}

.user-card-full .social-link li a {
    font-size: 20px;
    margin: 0 10px 0 0;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out
}

/* Custom Changes  */
.bg-c-lite-green {
    background: #81BF16;
}
.btn-primary, .btn-primary:hover{
	background: #085182;
	border-color: #085182;
}
.colorWhite{
		color:#fff;
}
.m-b-20{
	color:#81BF16;
	border-color:#81BF16;
	
}

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css"></script>
 -->

</head>
<body>
<?php

	$user_id = $_REQUEST['user_id'];

	$sql="select * from user_master WHERE user_id=$user_id";
	$exec = $conn->Execute($sql);
	$result = $exec->FetchRow();
	
	$sql2="select * from user_details WHERE user_id=$user_id";
	$exec2 = $conn->Execute($sql2);
	$result2 = $exec2->FetchRow();
	

?>
	<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        
                        <div class="col-sm-12">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Basic Details</h6>
                                <div class="row">
									<div class="col-md-10">
										<div class="row">
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">First Name</p>
												<h6 class="text-muted f-w-400"><?php print $result['first_name']; ?></h6>
											</div>
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">Last Name</p>
												<h6 class="text-muted f-w-400"><?php print $result['last_name']; ?></h6>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">S/O, D/O, W/O</p>
												<h6 class="text-muted f-w-400"><?php print $result2['son_daughter_wife_of']; ?></h6>
											</div>
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">Blood Group</p>
												<h6 class="text-muted f-w-400"><?php print $result2['blood_group']; ?></h6>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">Date of Birth</p>
												<h6 class="text-muted f-w-400"><?php print $result2['dob']; ?></h6>
											</div>
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">Date of Joining</p>
												<h6 class="text-muted f-w-400"><?php print $result2['date_of_joining']; ?></h6>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">Designation</p>
												<h6 class="text-muted f-w-400"><?php print $result2['designation']; ?></h6>
											</div>
											<div class="col-sm-6">
												<p class="m-b-10 f-w-600">Department</p>
												<h6 class="text-muted f-w-400"><?php print $result2['department']; ?></h6>
											</div>
										</div>
									</div>
									<div class="col-md-2 user-profile">
										<div class="text-center">
											<div class="m-b-25">
												<?php
													if($result2['profile_pic']){
														$profileimage = "../uploads/employeeDetails/".$result2['profile_pic'];
													} else{
														$profileimage = "https://img.icons8.com/bubbles/100/000000/user.png";
													}
														?>
												<img style="max-width:150px" src="<?php echo $profileimage ?>" class="img-radius border" alt="User-Profile-Image" />
											</div>
										</div>
										
									</div>
								</div>
						
								
								<h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Contact Details</h6>
								<div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Present Address</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['present_address']; ?></h6>
                                    </div>
									<div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Permanent Address</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['permanent_address']; ?></h6>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Contact Number</p>
                                        <h6 class="text-muted f-w-400"><?php print $result['user_phone']; ?></h6>
                                    </div>
									<div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Other Contact Number</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['other_contact_number']; ?></h6>
                                    </div>
                                </div>
								<h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Bank Details</h6>
								<div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Bank Name</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['bank_name']; ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Branch Name</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['branch_name']; ?></h6>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Account Number</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['account_number']; ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">IFSC Code</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['ifsc_code']; ?></h6>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Pan Number</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['pan_number']; ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Adhar number</p>
                                        <h6 class="text-muted f-w-400"><?php print $result2['aadhar_number']; ?></h6>
                                    </div>
                                </div>
								<h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Documents & Policies</h6>
								<div class="row">
                                    <div class="col-sm-6">
										<p class="m-b-10 f-w-600">Documents</p>
                                        <ul>
											<?php $sql3 = "SELECT distinct dtm.document_type_id,dtm.document_type,user_id FROM document_type_master dtm LEFT JOIN user_documents ud ON dtm.document_type_id=ud.document_type_id AND user_id=".$result2['user_id']." WHERE dtm.is_active = 1 ORDER BY dtm.sort_order"; 
										
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
                                    </div>
                                    <div class="col-sm-6">
										<p class="m-b-10 f-w-600">Policies</p>
										<ul>
											<li>IT Policy: <?php if($result["it_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
											<li>Leave Policy: <?php if($result["leave_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
											<li>List of Holidays: <?php if($result["list_of_holidays_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
											<li>Travel Policy: <?php if($result["travel_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
											<li>Increment Policy: <?php if($result["increment_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
											<li>Productivity Rules & Regulations: <?php if($result["productivity_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
											<li>Office Rules: <?php if($result["office_rules_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>"; else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
										</ul>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<center> <a href="#" onclick="window.print()"><button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Print</button></a></center>
<?php include '_footer.php'; ?>