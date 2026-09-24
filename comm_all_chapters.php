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
			<li><a href="#"><?php echo $topic_name; ?></a></li>
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
				<div class="row">
					<?php
						$ctr=1;
						$sql1="select cm.chapter_id,chapter_name,cm.sort_order from user_topics as ut inner join chapter_master as cm on ut.topic_id=cm.topic_id WHERE ut.user_id='".$user_id."' AND ut.topic_id=".$topic_id." ORDER BY cm.sort_order";
						$exec1 = $conn->Execute($sql1);
						if($exec1->RowCount()>0)
						{
						while($row1 = $exec1->FetchRow())
						{ ?>
					<div class="col-sm-6 col-md-4">
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
										FROM comm_material_master AS tmm WHERE tmm.chapter_id=".$row1['chapter_id']." and tmm.topic_id=".$topic_id;	
										$exec2 = $conn->Execute($count_lession);
										$row2 = $exec2->FetchRow();									
										?>
									<div class="box" id="try"><i class="fa fa-leanpub" aria-hidden="true"></i><?php echo $row2['lesson_count'];  ?> Lesson</div>
								</div>
								<div class="view-btn enable">
									<a href="comm_chapter_details.php?topic_id=<?php echo $topic_id; ?>&chapter_id=<?php print $row1['chapter_id'] ?>" class="btn abc1" id="first-abc">view more</a>
								</div>
							</div>
						</div>
						<input type="hidden" name="chapter_id" value="<?php echo $row1['chapter_id']  ?>">
					</div>
					<?php $ctr++; }} else {  ?><h2 class="chapter">No Chapter</h2><?php } ?>
				</div>
			</div>
		</div>
		<?php
		//coummnication test clear user than btn hide/show
			$btn_hide_show = "SELECT is_pass FROM user_final_comm_test_master WHERE user_id='$user_id' AND topic_id='$topic_id' AND is_pass=1";
			$exec0 = $conn->Execute($btn_hide_show);
			
			$sql = "SELECT final_comm_test_id FROM user_final_comm_test_master WHERE user_id=".$user_id." AND test_date LIKE '".date('Y-m-d')."%'";
			$check = $conn->Execute($sql);
		 if($check->RowCount()<2)
		 {
			 if($exec0->RowCount() == 0 && $ctr>1)
				{
				?>
		<div class="submit-slide">
			<center><a href="start_comm_test.php?topic_id=<?php print $topic_id; ?>"><input type="submit" value="Communication Test" class="btn"></a></center>
		</div>
		<?php				
			}
			else if($exec0->RowCount() > 0){
			?>
		<div class="submit-slide">
			<center>
				<h4>You have cleared this Communication topic.</h4>
			</center>
		</div>
		 <?php } } else { ?>
					<div class="submit-slide">
                        	<center>You have already given 2 tests for today. You need to wait for tomorrow to give another test.</center>
                </div>
				<?php } ?>
		
	</div>
</section>
<?php include '_footer.php';?>