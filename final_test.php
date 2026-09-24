<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';
if(!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "")
{
	log_issue("Tried to open final test page directly : ".$_REQUEST['topic_id']." AND Chapter:".$_REQUEST['chapter_id']);
	header("location: error.php");
	exit();
}

if(!isset($_SESSION[SESSION_PREFIX.'FINAL_TEST']) || $_SESSION[SESSION_PREFIX.'FINAL_TEST'] == false)
{
	log_issue("Tried to refresh or open final test page directly. : ".$_REQUEST['topic_id']." AND Chapter:".$_REQUEST['chapter_id']);
	header("location: error.php");
	exit();
}
$_SESSION[SESSION_PREFIX.'FINAL_TEST'] = false;


$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$sql = "SELECT topic_id FROM user_topics where user_id=".$user_id;
$exec = $conn->Execute($sql);
$topics = array();
//die($sql);
while($row = $exec->FetchRow())
{
	$topics[] = $row['topic_id'];
}
$id = implode(",",$topics);

$steps = true;
$topic_id=$_REQUEST['topic_id'];
$data = array();
$final_test = true;
$data['user_id'] = $user_id;
$data['test_date'] = date('Y-m-d H:i:s');
$data['total_questions'] = FINAL_TEST_QUESTIONS;
$test_insert = $conn->Autoexecute(TABLE_PREFIX."user_final_test_master", $data, "INSERT", true, false, MAGIC_QUOTES);
$final_test_id = $conn->Insert_Id();



include_once '_header.php';
?>			 
<section class="quiz-view">

        	<div class="container">	
			 <div id="countdown" name="time"></div>
                    <p><div class="qustion-main">
                   <form method="post" action="user_final_test_exec.php" id="wizard" name="chapter_form">	
		          
				
				
						   
						<?php
						//$get_id = explode("_",$id);
						$topic = "select * from question_bank_master where topic_id IN($id) ORDER BY RAND() LIMIT ".FINAL_TEST_QUESTIONS;
					    $exec = $conn->Execute($topic);
						$ctr = 1;
					    while($row = $exec->FetchRow())
						{
							$questions[] = $row['question_id'];
					    ?>
						<h2>Question</h2>
							<section>
                                 <div class="qustion-box">
								<div class="qustion"><?php echo $row['question_text']; ?></div>
                                <div class="ans">
                                	<div class="ans-slide">
                                    	<label class="label_radio" for="question_<?php print $row['question_id']."_".$ctr."_1"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row['question_id']."_".$ctr."_1"; ?>" value="<?php print $row['question_id']."_1"; ?>" type="radio"> <?php print $row['option1']; ?></label>
                                    </div>
                                    <div class="ans-slide">
                                    	<label class="label_radio" for="question_<?php print $row['question_id']."_".$ctr."_2"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row['question_id']."_".$ctr."_2"; ?>" value="<?php print $row['question_id']."_2"; ?>" type="radio"> <?php print $row['option2']; ?></label>
                                    </div>
                                    <div class="ans-slide">
                                    	<label class="label_radio" for="question_<?php print $row['question_id']."_".$ctr."_3"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row['question_id']."_".$ctr."_3"; ?>" value="<?php print $row['question_id']."_3"; ?>" type="radio"> <?php print $row['option3']; ?></label>
                                    </div>
                                    <div class="ans-slide">
                                    	<label class="label_radio" for="question_<?php print $row['question_id']."_".$ctr."_4"; ?>"><input name="question_<?php print $ctr; ?>" id="question_<?php print $row['question_id']."_".$ctr."_4"; ?>" value="<?php print $row['question_id']."_4"; ?>" type="radio"> <?php print $row['option4']; ?></label>
                                    </div>
                                </div>
						    </div> </section>
				
							<?php $ctr++; } ?>
							<input type="hidden" name="time_taken" id="tss" value="0" /> 
							<input type="hidden" name="final_test_id" value="<?php print $final_test_id; ?>" >
							<input type="hidden" name="topic_id" value="<?php print $topic_id; ?>" >
							<input type="hidden" name="questions" value="<?php print implode(",",$questions); ?>" >
                        </form>
                    </div>
				 </p> 
            </div>
</section>	 
<?php include '_footer.php';?> 
