<?php
include_once 'includes/startup.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$final_test_id=$_REQUEST['final_test_id'];

$chapter_name = "SELECT COUNT(question_id) AS total_questions, COUNT(CASE WHEN is_correct = 1 THEN 1 ELSE null END) AS total_correct, COUNT(CASE WHEN answer_option != 0 THEN 1 ELSE null END) AS total_answered FROM user_final_test_details WHERE final_test_id =".$final_test_id;
$exec = $conn->Execute($chapter_name);
$row = $exec->FetchRow();

include_once '_header.php';
?>
        <section class="breadcrumb white-bg">
        	<div class="container">
            	<ul>
                	<li><a href="index.php">Home</a></li>
                    <li><a href="#">Final Test Result</a></li>
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
                        	<h3>Your Final Test Result</h3>
                            <div class="leaderboard">
							 <div class="qustion-review">
                                	<p>Total Questions <span><?php print $row['total_questions']; ?></span></p>
                                </div>
                                <div class="qustion-review">
                                	<p>Questions Attempted <span><?php print $row['total_answered']; ?></span></p>
                                </div>
                                <div class="qustion-review">
                                	<p>Correct Answers <span><?php print $row['total_correct']; ?></span></p>
                                </div>
                                <?php 
                                 if($row['total_correct']*100/$row['total_questions'] >= CHAPTER_TEST_PASS)
								 {
									?><br> 
									 <div class="view-btn text-center">
									 <h3>Congratulations! You have cleared the test. </h3>
                                           <p class="text-center"><a href="index.php" class="btn">Go Back To Home</a></p>
                                        </div>
								<?php
								 }
								 else
								 {?>
									<br> 
									 <div class="view-btn text-center">
									 <h3>Oops! You have not cleared the test. </h3>
									 <?php if(check_final_reappear($_SESSION[SESSION_PREFIX.'USER_ID']))
			{
			?>
			<div class="view-btn text-center">
                        <a href="user_request_admin.php" class="btn">Request Re-Appear</a>
                  </div>
		<?php } ?>
                                 
                                        </div>
								<?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php include '_footer.php';?> 