<?php 
include_once '../includes/startup.php';
require_once('authenticate.php');


?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="index.php">Admin Panel - <?php echo APP_NAME; ?></a> 
	</div>

    <!-- Top Menu Items -->
	<ul class="nav top-nav pull-right">
		<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Site Admin <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li> <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a> </li>
            </ul>
		</li>
	</ul>
	
	
	
    <ul class="nav top-nav">
		<!--<form role="form" action="search_result.php" method="post" name="search_form" id="search_form" >
			<div class="input-group pull-right search">
				<input required name="student_name" class="form-control search-form search-form3" placeholder="Search By User Name" type="text">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 4px 30px 30px 4px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>-->
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse" href="#collapse1" style="overflow-y:auto;">
        <ul class="nav navbar-nav side-nav" id="style-4" style="overflow-y:auto !important;max-height:90%;">
		
			<a href="index.php" class="list-group-item list-group-item-success strong ">
				<li <?php if (isset($page) && $page == 'index') { print 'class="activeMenu"';} ?>><i class="glyphicon glyphicon-book"></i>DASHBOARD</li>
			</a>
			
			<a href="cms.php" class="list-group-item list-group-item-success strong ">
				<li <?php if (isset($cms_setting) && $cms_setting == 'cms') { print 'class="activeMenu"';} ?>><i class="glyphicon glyphicon-folder-open"></i> &nbsp; CMS Settings</li>
			</a>
			<a href="document_type.php" class="list-group-item list-group-item-success strong ">
				<li <?php if (isset($doc_setting) && $doc_setting == 'document_type') { print 'class="activeMenu"';} ?>><i class="glyphicon glyphicon-folder-open"></i> &nbsp; Document Type Settings</li>
			</a>
			
			<a href="#demo3" class="list-group-item list-group-item-success strong <?php if(isset($material_setting) && $material_setting == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-user-plus"></i> &nbsp; TRAINING MATERIAL</i><i class="fa fa-angle-right pull-right"></i></a>
				<div <?php if(!isset($material_setting) || $material_setting == false) echo ' class="collapse activeSection" '; ?>  id="demo3">	
					<a href="manage_topics.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_topics') { print 'class="activeMenu"';} ?>> &nbsp; <i class="fa fa-angle-double-right"></i> &nbsp; Manage Topics</li>
					</a>
					<a href="manage_chapters.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_chapters') { print 'class="activeMenu"';} ?>> &nbsp; <i class="fa fa-angle-double-right"></i> &nbsp; Manage Chapters </li>
					</a>
					
					<a href="manage_material.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_material') { print 'class="activeMenu"';} ?>> &nbsp; <i class="fa fa-angle-double-right"></i> &nbsp; Manage Material </li>
					</a>
					<a href="manage_comm_material.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_comm_material') { print 'class="activeMenu"';} ?>> &nbsp; <i class="fa fa-angle-double-right"></i> &nbsp; Communication Material </li>
					</a>
					
				</div>	
			
			<a href="#demo5" class="list-group-item list-group-item-success strong <?php if(isset($user_setting) && $user_setting == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-calendar-check-o"></i> &nbsp; USER SECTION</i><i class="fa fa-angle-right pull-right"></i></a>
				<div <?php if(!isset($user_setting) || $user_setting == false) echo ' class="collapse activeSection" '; ?>  id="demo5">
					<a href="manage_users.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_users') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Users</li>
					</a>
					<a href="manage_attendance.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_attendance') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> User Attendance</li>
					</a>
					<a href="user_approval.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'user_approval') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Re-Appear Approval</li>
					</a>
					<a href="user_all_perfomance.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'user_all_performance') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Final Test Performance</li>
					</a>
					<a href="user_all_perfomance_question.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'user_all_perfomance_question') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Final Test Questions</li>
					</a>
				</div>
			
			
			
			
			<a href="#demo6" class="list-group-item list-group-item-success strong <?php if(isset($question_setting) && $question_setting == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-university" aria-hidden="true"></i> &nbsp; QUESTION BANK</i><i class="fa fa-angle-right pull-right"></i></a>
				<div <?php if(!isset($question_setting) || $question_setting == false) echo ' class="collapse activeSection" '; ?>  id="demo6">
					<a href="manage_question.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_question') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Question</li>
					</a>
					<a href="manage_comm_audio.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_comm_audio') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Communication Audio</li>
					</a>
					<a href="manage_comm_question.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_comm_question') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Communication Question</li>
					</a>
				</div>
			
			<!--<a href="manage_progress.php" class="list-group-item list-group-item-success strong ">
				<li <?php if (isset($page) && $page == 'manage_progress') { print 'class="activeMenu"';} ?>><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp; Manage Progress </li>
			</a>-->
		
				
			<a href="#demo7" class="list-group-item list-group-item-success strong <?php if(isset($report_setting) && $report_setting == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-info-circle"></i>&nbsp; USER REPORTS <i class="fa fa-angle-right pull-right"></i></a>	  
				<div <?php if(!isset($report_setting) || $report_setting == false) echo ' class="collapse activeSection" '; ?> id="demo7">
					<a href="user_report.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'user_report') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Report</li>
					</a>
					<a href="user_combined_report.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'user_combined_report') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Combine Report</li>
					</a>
					<a href="complied_summary.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'complied_summary') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Compiled Summary</li>
					</a>
				</div>
				
			
			<!--<a href="#demo7" class="list-group-item list-group-item-success strong <?php if(isset($email_section) && $email_section == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email Section<i class="fa fa-angle-right pull-right"></i></a>	  
				<div <?php if(!isset($email_section) || $email_section == false) echo ' class="collapse activeSection" '; ?> id="demo7">
					<a href="email_students.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'email_students') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Email Students</li>
					</a>
					<a href="email_staff.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'email_staff') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Email Staff</li>
					</a>
					<a href="email_section.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'email_sections') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Email Sections</li>
					</a>
					<a href="email_all.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'email_all') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Email All(students & staff)</li>
					</a>
				</div>
				
			<a href="#demo8" class="list-group-item list-group-item-success strong <?php if(isset($report_section) && $report_section == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-file" aria-hidden="true"></i> &nbsp; Reports Section<i class="fa fa-angle-right pull-right"></i></a>	  
				<div <?php if(!isset($report_section) || $report_section == false) echo ' class="collapse activeSection" '; ?> id="demo8">
					<a href="report_attendance.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'report_attendance') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Attendance Sheet</li>
					</a>
					<a href="student_report.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'student_report') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Student Report</li>
					</a>
						<a href="fee_report.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'fee_report') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Fee Report</li>
					</a>
				</div>
			
			<a href="#demo4" class="list-group-item list-group-item-success strong <?php if(isset($system_setting) && $system_setting == true) echo ' activeSection'; ?>" data-toggle="collapse" data-parent="#MainMenu">
				<i class="fa fa-gears"></i>&nbsp; System Setting <i class="fa fa-angle-right pull-right"></i>
			</a>
				<div <?php if(!isset($system_setting) || $system_setting == false) echo ' class="collapse activeSection" '; ?> id="demo4">
					<a href="manage_timeslots.php" class="list-group-item">
					
						<li <?php if (isset($page) && $page == 'manage_timeslots') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage TimeSlot</li>
					</a>
					<a href="manage_rooms.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_rooms') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Rooms</li>
					</a>
					<a href="manage_teachers.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_teachers') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Teacher</li>
					</a>
					<a href="manage_subjects.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_subjects') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Subjects</li>
					</a>
					<a href="manage_sections.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_sections') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Section</li>
					</a>
					
					<a target="_blank" href="manage_timetable.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_timetable') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage TimeTable</li>
					</a>
					<a href="manage_schedule.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_schedule') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Schedule</li>
					</a>
					<a href="manage_terms.php" class="list-group-item">
						<li <?php if (isset($page) && $page == 'manage_terms') { print 'class="activeMenu"'; } ?>><i class="fa fa-angle-double-right"></i> Manage Terms</li>
					</a>
				</div>-->
			
			<a href="change_password.php" class="list-group-item list-group-item-success strong " >
			 <li <?php if (isset($page) && $page == 'change_password') {
				print 'class="activeMenu"';
				} ?>><i class="glyphicon glyphicon-user"></i>&nbsp; Change Password <i class="fa fa-angle-right pull-right"></i></li>
			</a>
			<a href="logout.php" class="list-group-item list-group-item-success strong" >
			<li> <i class="fa fa-fw fa-power-off"></i> Log Out </li></a>
		</ul>
	</div>
    <!-- /.navbar-collapse --> 
</nav>
