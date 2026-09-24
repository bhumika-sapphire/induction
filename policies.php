<?php
	include_once 'includes/startup.php';
	include_once 'authenticate.php';


	$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
	$sql = "SELECT * FROM user_master WHERE user_id=".$user_id;
	$execc = $conn->Execute($sql);
	$user = $execc->FetchRow();
	
	$page_id=9;
	
	$_SESSION[SESSION_PREFIX.'pageViewed'][$page_id]="true";
	
	if(!$_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE'])
	{
		$status = induction_complete();
		
		if($status)
		{
			/* Show notification that with this page, his induction is complete */
			echo "<script>alert('Wohoo! Induction is complete.');</script>";
			/* This is temporary. We will use bootstrap notification */
		}
	}
	//user_topics
	$training = "SELECT * FROM cms_master WHERE page_id =".$page_id;
	$execc = $conn->Execute($training);
	$roww = $execc->FetchRow();
	$shortcode = true;
	
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
							<a <?php if(array_key_exists($row['page_id'],$_SESSION[SESSION_PREFIX.'pageViewed'])){print "class='listViewed'"; }print "class='notViewed'"; ?> <?php if($row['page_id'] == 7){ ?> href="employee_details.php"<?php }else if($row['page_id'] == 8){?> href="employee_documents.php" <?php }else if($row['page_id'] == 9){?> href="policies.php"<?php }else{?> href="induction.php?page_id=<?php print $row['page_id']; ?>" <?php } ?> ><?php print $row['nav_title']; ?></a>
							
						</li>
						<?php
							}
							?>
					
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-12 col-md-12 induction-right-side">
						<center><h1 class="pageTitle"><?php print $roww['page_title']; ?></h1></center>
						<div class="course-post">
							<div class="info contentBg">
								<div class="name"><?php print $roww['page_content']; ?>
								<?php  $sql="select * FROM cms_master WHERE is_policy=1 ORDER BY sort_order";
							$exec1 = $conn->Execute($sql);
							$ctr = 1;
							while($row1 = $exec1->FetchRow())
							{ 
						?>
						<div id="<?php echo $ctr; ?>" style="display:none">
						<form name="policy_<?php print $row1['page_id']; ?>" class="policy_form" role="form" method="post">
						<?php if($user[$row1['nav_title']] == 1){ 
						$row1['page_content'] = "<style>#".$row1['nav_title']."_form{display:none;}</style>".$row1['page_content'];
						} 
						print $row1['page_content']; ?>
						<input type="hidden" name="page_id" value="<?php print $row1['page_id']; ?>" >
						</form>
						</div>
							<?php $ctr++; } ?>
							<p><a href="employee_documents.php" class="prevButton">Prev</a><a href="induction.php?page_id=10" class="nextButton">Next</a></p>
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
<script>
$(document).ready(function () {
	
	$("#myBtn1").click(function(event){
	  event.preventDefault();
	});
	$("#myBtn2").click(function(event){
	  event.preventDefault();
	});
	$("#myBtn3").click(function(event){
	  event.preventDefault();
	});
});
</script>