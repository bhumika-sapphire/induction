<?php
include_once 'includes/startup.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$chapter_test_id=$_REQUEST['chapter_test_id'];

$chapter_name = "SELECT COUNT(question_id) AS total_questions, COUNT(CASE WHEN is_correct = 1 THEN 1 ELSE null END) AS total_correct, COUNT(CASE WHEN answer_option != 0 THEN 1 ELSE null END) AS total_answered FROM user_chapter_test_details WHERE chapter_test_id =".$chapter_test_id;
$exec = $conn->Execute($chapter_name);
$row = $exec->FetchRow();

include_once '_header.php';
?>
        <section class="breadcrumb white-bg">
        	<div class="container">
            	<ul>
                	<li><a href="index.php">Home</a></li>
                    <li><a href="#">Chapter Result</a></li>
                </ul>
            </div>
        </section>
        <section class="quiz-view">
        	<div class="container">
                <div class="quiz-title">
			</div>
                <div class="row">
			
                    <div class="col-sm-12 col-md-12">
				

                    	<div class="quiz-result">
                        	<h3>Your Chapter Test Result</h3>
                            <div class="leaderboard">
							<table class="table">
							<tr><th>Total Questions :</th><td><?php print $row['total_questions']; ?></td></tr>
							<tr><th>Questions Attempted</th><td><?php print $row['total_answered']; ?></td></tr>
							<tr><th>Correct Answers</th><td><?php print $row['total_correct']; ?></td></tr>
							</table>
								
								<h3>Test Result Details</h3>
								<table class="table">
								<tr>
								<th>S. No.</th>
								<th width="90%">Question</th>
								
								</tr>
							<?php $sql = "SELECT qbm.*,uctd.answer_option,is_correct FROM user_chapter_test_details uctd, question_bank_master qbm WHERE uctd.question_id=qbm.question_id AND chapter_test_id=".$chapter_test_id; 
							$exec1 = $conn->Execute($sql);
							$ctr = 1;
							while($row1 = $exec1->FetchRow())
							{
							?>
								<tr <?php if($row1['answer_option'] != $row1['correct_answer']) {echo ' style="background-color:#FFBABA"';} ?> >
								<td><?php echo $ctr++; ?></td>
								<td><?php echo $row1['question_text']; ?></td>
																
								</tr>
							<?php } ?>
								</table>
                                <?php 
                                 if($row['total_correct']*100/$row['total_questions'] >= CHAPTER_TEST_PASS)
								 {
									?><br> 
									 <div class="view-btn text-center">
									 <h3>Congratulations! You have cleared the test. </h3>
                                           <p class="text-center"><a href="all_chapters.php?topic_id=<?php print $_REQUEST['topic_id']; ?>" class="btn">Next Chapter</a></p>
                                        </div>
								<?php
								 }
								 else
								 {?>
									<br> 
									 <div class="view-btn text-center">
									 <h3>Oops! You have not cleared the test. </h3>
                                           <p class="text-center"><a href="all_chapters.php?topic_id=<?php print $_REQUEST['topic_id']; ?>" class="btn">Try Again</a></p>
                                        </div>
								<?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php include '_footer.php';?> 