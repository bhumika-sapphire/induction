<?php
	include_once 'includes/startup.php';
	include_once 'authenticate.php';
	
	$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
	$topic_id=$_REQUEST['topic_id'];
    $test_id=$_REQUEST['test_id'];
    $end_time = date("Y-m-d H:i:s");

	
	$sql = "SELECT tm.*, MAX(chapter_sort_order) as chapter_sort_order FROM topic_master tm LEFT JOIN user_chapter_test_master uctm ON tm.topic_id=uctm.topic_id WHERE tm.topic_id=".$topic_id." AND uctm.is_pass=1 AND uctm.user_id=".$user_id;
	$exec0 = $conn->Execute($sql);
	$topic = $exec0->FetchRow();
	$topic_name = $topic['topic_name'];

	if(check_files_result($_SESSION[SESSION_PREFIX.'USER_ID'],$topic_id) == false)
	{
			unset($_SESSION[SESSION_PREFIX.'file_timer']);
			unset($_SESSION[SESSION_PREFIX.'download_id']);
			unset($_SESSION[SESSION_PREFIX.'topic_id']);

			header("location: all_chapters.php?topic_id=".$topic_id);
            exit();
	}


   if(isset($_SESSION[SESSION_PREFIX.'file_timer']) && $_SESSION[SESSION_PREFIX.'file_timer'] !=''  && ($end_time >= $_SESSION[SESSION_PREFIX.'file_timer']))
    {		
		// $_SESSION[SESSION_PREFIX.'file_timer']=0;
		//  	$_SESSION[SESSION_PREFIX.'download_id']=0;
		// 	$_SESSION[SESSION_PREFIX.'topic_id']=0;

			unset($_SESSION[SESSION_PREFIX.'file_timer']);
			unset($_SESSION[SESSION_PREFIX.'download_id']);
			unset($_SESSION[SESSION_PREFIX.'topic_id']);

            log_issue("Timer Finish Files Uploads : ".$_REQUEST['topic_id']." AND user_id:".$user_id);
            header("location: error.php");
            exit();
    }


	include_once '_header.php';
	?>
<section class="breadcrumb">
	<div class="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">
					<?php echo $topic_name; ?>
				</a></li>
			<li>Files Download AND Upload</li>
		</ul>
	</div>
</section>
<section class="courses-view">
	<div class="container">
		<div id="countdown" name="time"></div>
		<div class="row">
			<div class="col-md-3">
				<div class="right-slide left">
					<h3>Your Download files here</h3>
					<p>Once you have downloaded the files. then you will have two hour to upload the files. Thanks</p>

				</div>
			</div>
			<div class="col-md-4" style="margin-top:6rem;">
				<p class="text-center" style="color:#F00" id="msg"></p>
				<div class="view-btn text-center">
					<a href="download_exec.php?topic_id=<?php echo $topic_id; ?>&test_id=<?php echo $test_id; ?>"
						class="btn" id="refreshButton">Download Files</a>
				</div>
			</div>

			<div class="col-md-4" style="margin-top:6rem;">
			 <p style="color:red"><?php echo getMsg('error'); ?></p>
				<form role="form" action="test_file_upload_exec.php" method="post" enctype='multipart/form-data'>
					<div class="form-group">
						<label for="material_file">Upload File</label>
						<input type="file" class="form-control" name="files[]" id="file_upload" />
						<input type="hidden" name="topic_name" value="<?php echo $topic_name; ?>">
						<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
						<input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
						<input type="hidden" name="download_flag" value="<?php echo $_SESSION[SESSION_PREFIX.'download_id']; ?>">
					</div>
					<div class="view-btn ">
						<button type="submit" name="upload" class="btn">Upload File</button>
					</div>
				</from>
			</div>
		</div>
	</div>


	</div>
</section>
<?php include '_footer.php';?>



<script>
	$(document).ready(function () {
		// Attach click event to the button
		$("#refreshButton").click(function () {
			// Display an alert message
			final_test(120);
			$("#msg").text("Your Time Start Now.");
		});
	});
</script>