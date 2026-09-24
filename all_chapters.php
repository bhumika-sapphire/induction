<?php
	include_once 'includes/startup.php';
	include_once 'authenticate.php';
	
	$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
	$topic_id=$_REQUEST['topic_id'];

	
	$sql = "SELECT tm.*, MAX(chapter_sort_order) as chapter_sort_order FROM topic_master tm LEFT JOIN user_chapter_test_master uctm ON tm.topic_id=uctm.topic_id WHERE tm.topic_id=".$topic_id." AND uctm.is_pass=1 AND uctm.user_id=".$user_id;
	$exec0 = $conn->Execute($sql);
	$topic = $exec0->FetchRow();
	$topic_name = $topic['topic_name'];
	
	if(isset($topic['chapter_sort_order']) && $topic['chapter_sort_order']!="")
	{
		$sort_order = $topic['chapter_sort_order'];
	}
	else
	{
		$sort_order = 0;
	}	
	//user_topics
	$traning_topic_id = array();
	$training = "SELECT ut.topic_id FROM user_topics as ut WHERE ut.user_id =".$user_id;
	$execc = $conn->Execute($training);
	while($roww = $execc->FetchRow())
	{
		$traning_topic_id[] = $roww['topic_id'];
	}
	
	$sql = "SELECT sort_order FROM chapter_master WHERE topic_id=".$topic_id." AND sort_order > $sort_order ORDER BY sort_order LIMIT 1";
	$exec5 = $conn->Execute($sql);
	$max_sort_order = $exec5->FetchRow();
	if(isset($max_sort_order['sort_order']) && $max_sort_order['sort_order'] != "")
	{
		$max_sort_order = $max_sort_order['sort_order'];
	}
	else
	{
		if($sort_order == 0)
			$max_sort_order = 1;
		else
			$max_sort_order = $sort_order;
	}
	include_once '_header.php';
	?>
<section class="breadcrumb">
	<div class="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Professional Tax Training Module</a></li>
		</ul>
	</div>
</section>
<section class="courses-view">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="right-slide left">
					<h3>Your Topics</h3>
					<ul class="catagorie-list">
						<?php
							$sql="select tm.is_communication,tm.topic_id,topic_name from user_topics as ut inner join topic_master as tm on ut.topic_id=tm.topic_id WHERE ut.user_id='".$user_id."' ORDER BY is_communication ASC, topic_name ASC";
							$exec = $conn->Execute($sql);
							while($row = $exec->FetchRow())
							{ ?>
						<?php
							if(in_array($row['topic_id'], $traning_topic_id))
							{
								?>
						<li <?php if($row['topic_id'] == $topic_id) echo "class='active'"; ?>>
							<?php
								if($row['is_communication']==0)
								{
									?>
							<a href="all_chapters.php?topic_id=<?php print $row['topic_id']; ?>"><?php print $row['topic_name']; ?></a>
							<?php
								}
								else
								{
									?>
							<a href="comm_all_chapters.php?topic_id=<?php print $row['topic_id']; ?>"><?php print $row['topic_name']; ?></a>
							<?php
								}
								?>
						</li>
						<?php
							}
							?>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<?php if($topic_id =="3"){ ?>

					<h2>TAX CALC POSTING GUIDE</h2>
				<?php } ?>
				<div class="row">
					<?php
						$ctr=1;
						$sql1="select cm.chapter_id,chapter_name,cm.sort_order from user_topics as ut inner join chapter_master as cm on ut.topic_id=cm.topic_id WHERE ut.user_id='".$user_id."' AND ut.topic_id=".$topic_id." ORDER BY cm.sort_order";
						$exec1 = $conn->Execute($sql1);
						if($exec1->RowCount()>0)
						{
						while($row1 = $exec1->FetchRow())
						{ ?>
								<div class="col-sm-6 col-md-6">
									<div class="course-post">
										<div class="img">
											<div class="icon">
												<a href="#"><img src="images/book-icon.png" alt=""></a>
											</div>
										</div>
										<div class="info">
											<center>
												<div class="name"><?php print $row1['chapter_name']; ?></div >
											</center>
											<!-- <div class="expert"><span>By </span> Michael Windzor</div>-->
										</div>
										<div class="product-footer">
											<div class="comment-box">
												<?php
													$count_lession = "SELECT count(tmm.chapter_id) as lesson_count
													FROM training_material_master AS tmm WHERE tmm.chapter_id=".$row1['chapter_id']." and tmm.topic_id=".$topic_id;	
													$exec2 = $conn->Execute($count_lession);
													$row2 = $exec2->FetchRow(); 
													?>
												<div class="box" id="try"><i class="fa fa-leanpub" aria-hidden="true"></i><?php echo $row2['lesson_count'];  ?> Lesson</div>
											</div>
											<div class="view-btn">
												<?php if($row1['sort_order'] <= $max_sort_order || $user_id == 59 || $user_id == 88 || $user_id == 69){ ?>
												<a href="chapter_details.php?topic_id=<?php echo $topic_id; ?>&chapter_id=<?php print $row1['chapter_id'] ?>" class="btn">view more</a>
												<?php } else { ?>
												<!-- <a href="javascript:void(0)" class="btn">Disabled</a> -->
												<a href="chapter_details.php?topic_id=<?php echo $topic_id; ?>&chapter_id=<?php print $row1['chapter_id'] ?>" class="btn">view more</a>
												<?php } ?>
											</div>
										</div>
									</div>
									<input type="hidden" name="chapter_id" value="<?php echo $row1['chapter_id']  ?>">
								</div>
					<?php $ctr++; } }else {  ?><h2 class="chapter">No Chapter</h2><?php } ?>
				</div>
			</div>
		</div>
		<?php
	
			$sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(logout_time, login_time))/60 /60) as totalhours FROM user_login_history WHERE user_id=".$user_id;
			$result = $conn->Execute($sql);
			$row = $result->FetchRow();
			$total_hours = round($row['totalhours']);
			// if($total_hours >= TOTAL_TIME_ALL_CHAPTER)
				
				if(check_final_eligibility($_SESSION[SESSION_PREFIX.'USER_ID'],$topic_id))
				{
				?>
				
						<div class="view-btn text-center">
							<a href="final_start_test.php?topic_id=<?php echo $topic_id; ?>" class="btn">Final Test</a>
						</div>
			<?php } else
			{
				if(check_final_reappear($_SESSION[SESSION_PREFIX.'USER_ID'],$topic_id))
				{
					
					if(!check_user_pass_reappear_btn_hide($_SESSION[SESSION_PREFIX.'USER_ID'],$topic_id))
					{ 
				?>
				<div class="view-btn text-center">
					<a href="user_request_admin.php?topic_id=<?php echo $topic_id; ?>" class="btn">Request Re-Appear</a>
				</div>
		<?php } } }  ?>

		<?php if(check_test_files($_SESSION[SESSION_PREFIX.'USER_ID'],$topic_id)){ 
			
			$sql1 = "SELECT MAX(final_test_id) as id FROM user_final_test_master where user_id=".$user_id." AND is_pass=1 AND topic_id=".$topic_id;
			$exec1 = $conn->Execute($sql1);
			$result1 = $exec1->FetchRow();
			
			if(check_files_result($_SESSION[SESSION_PREFIX.'USER_ID'],$topic_id))
			{
				
			?>
			
			<div class="view-btn text-center">
					<a href="download_and_upload.php?topic_id=<?php echo $topic_id; ?>&test_id=<?php echo $result1['id']; ?>" class="btn">Files Download/Upload</a>
			</div>

			<!-- <?php if(isset($_SESSION[SESSION_PREFIX.'topic_id']) &&  $_SESSION[SESSION_PREFIX.'topic_id'] == $topic_id){ ?>
			<div class="view-btn text-center">
					<a href="download_and_upload.php?topic_id=<?php echo $topic_id; ?>&test_id=<?php echo $result1['id']; ?>" class="btn">Files Download/Upload</a>
				</div>
			<?php }else{ ?>

						<div class="view-btn text-center">
					<a href="download_and_upload.php?topic_id=<?php echo $topic_id; ?>&test_id=<?php echo $result1['id']; ?>" class="btn">Files Download/Upload</a>
				</div>

				<?php } ?> -->

		<?php }
			else
			{


				if(display_files_result($_SESSION[SESSION_PREFIX.'USER_ID']) == "pass"){
				?>

				<h3 class="text-center">congratulations You have pass <?PHP echo $_SESSION[SESSION_PREFIX.'FIRST_NAME']; ?></h3>
				
				<?php }elseif(display_files_result($_SESSION[SESSION_PREFIX.'USER_ID']) == "fail"){ ?>


				<h3 class="text-center">You have fail <?PHP echo $_SESSION[SESSION_PREFIX.'FIRST_NAME']; ?></h3>

					<?php }else{ ?>


						<h3 class="text-center">Please Wait For Result. Thanks</h3>
						<p class="text-center">Your file has been successfully uploaded. The team checking your file and then your results.</p>


					<?php } ?>
		<?php	}

	
		}?>

		<!-- Else Timer 30 HRS Spend	 -->
		<!-- <div class="view-btn text-center">
			<center>
				<h4> You should have at least <?php print TOTAL_TIME_ALL_CHAPTER ?> hours aggregate time spent on all Chapters.<br>
					You have Spend Total  <?php echo $total_hours ?> hours.
				</h4>
			</center>
		</div> -->
		
	</div>
</section>
<?php include '_footer.php';?>