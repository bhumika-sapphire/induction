<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

if(!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "")
{
 $issue_log = log_issue("Tried to open chapter test page directly for Topic: ".$_REQUEST['topic_id']." AND Chapter:".$_REQUEST['chapter_id']);
	header("location: error.php");
	exit();
}
   
   
if(!isset($_SESSION[SESSION_PREFIX.'CHAPTER_TEST']) || $_SESSION[SESSION_PREFIX.'CHAPTER_TEST'] == false)
{
	log_issue("Tried to refresh or open chapter test page directly for Topic: ".$_REQUEST['topic_id']." AND Chapter:".$_REQUEST['chapter_id']);
	header("location: error.php");
	exit();
}
$_SESSION[SESSION_PREFIX.'CHAPTER_TEST'] = false;

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
$chapter_test = true;
$topic_id=$_REQUEST['topic_id'];
$chapter_id=$_REQUEST['chapter_id'];

$data = array();
$data['topic_id'] = $topic_id;
$data['chapter_id'] = $chapter_id;
$data['chapter_sort_order'] = $_REQUEST['sort_order'];
$data['user_id'] = $user_id;
$data['test_date'] = date('Y-m-d H:i:s');
$data['total_questions'] = CHAPTER_TEST_QUESTIONS;
$test_insert = $conn->Autoexecute(TABLE_PREFIX."user_chapter_test_master", $data, "INSERT", true, false, MAGIC_QUOTES);
$chapter_test_id = $conn->Insert_Id();


include_once '_header.php';
?>
	<section class="quiz-view">
		<div class="container">
			<div class="quiz-title">
				<h2>Chapter:- <?php
			 $chapter_name ="select chapter_name from chapter_master where chapter_id=".$chapter_id;
			 $exec1 = $conn->Execute($chapter_name);
			 $row1 = $exec1->FetchRow();
			echo $row1['chapter_name']; ?></h2>
			</div>
			<div class="row">
				<div class="qustion-list">
				<form method="post" action="user_answer_exec.php" id="chapter_form" name="chapter_form">
				<div class="col-sm-8 col-md-9">	
					<div class="qustion-main">
				<?php
				$chapter = "select * from question_bank_master where chapter_id=".$chapter_id." ORDER BY RAND() LIMIT ".CHAPTER_TEST_QUESTIONS;
				$exec1 = $conn->Execute($chapter);
				if($exec1->RowCount() == 0)
				{
				?><h2><center>Sorry ! Questions Not Found.<a href="index.php" name="backhome"> Back To Home</a></center></h2>
					<?php	
				} else {
				$ctr = 1;
				$questions = array();
				while($row1 = $exec1->FetchRow())
				{
					$questions[] = $row1['question_id'];
					?>
							<div class="qustion-box">
							<div class="qustion"><strong>Question <?php echo $ctr; ?>.</strong> <?php print $row1['question_text']; ?> </div>
							<div class="ans">
								<div class="ans-slide">
									<label class="label_radio" for="question_<?php print $row1['question_id']."_".$ctr."_1"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row1['question_id']."_".$ctr."_1"; ?>" value="<?php print $row1['question_id']."_1"; ?>" type="radio"><?php print $row1['option1']; ?></label>
								</div>
								<div class="ans-slide">
									<label class="label_radio" for="question_<?php print $row1['question_id']."_".$ctr."_2"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row1['question_id']."_".$ctr."_2"; ?>" value="<?php print $row1['question_id']."_2"; ?>" type="radio"><?php print $row1['option2']; ?></label>
								</div>
								 <div class="ans-slide">
									<label class="label_radio" for="question_<?php print $row1['question_id']."_".$ctr."_3"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row1['question_id']."_".$ctr."_3"; ?>" value="<?php print $row1['question_id']."_3"; ?>" type="radio"><?php print $row1['option3']; ?></label>
								</div>
								

								<div class="ans-slide">
									<label class="label_radio" for="question_<?php print $row1['question_id']."_".$ctr."_4"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row1['question_id']."_".$ctr."_4"; ?>" value="<?php print $row1['question_id']."_4"; ?>" type="radio"><?php print $row1['option4']; ?></label>
								</div>

								

							</div>
						  </div>
         <?php $ctr++; } ?>		
			  <input type="hidden" name="chapter_test_id" value="<?php print $chapter_test_id; ?>" >
			  <input type="hidden" name="topic_id" value="<?php print $topic_id; ?>" >
			  <input type="hidden" name="questions" value="<?php print implode(",",$questions); ?>" >
						  <div class="btn-slide">
								<center><button type="submit" class="btn">Submit</button>
								</center>
							   <!-- <a href="#" class="btn">Submit</a>-->
		
							</div>
				<?php } ?>
					</div>
				</div >
				<div>
				<div id="countdown" name="time"></div>
				<input type="hidden" name="time_taken" id="tss" value="0" /> 
				</div>
			</div>
			</form>
		</div>
		</div>
		</div>
	</section>
<?php include '_footer.php'; ?> 