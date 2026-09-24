<?php
include_once 'includes/startup.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$final_comm_test_id=$_REQUEST['final_comm_test_id'];



$comm_chapter_name = "SELECT COUNT(question_id) AS total_questions, COUNT(CASE WHEN is_correct = 1 THEN 1 ELSE null END) AS total_correct, COUNT(CASE WHEN answer_option != 0 THEN 1 ELSE null END) AS total_answered FROM user_final_comm_test_details WHERE final_comm_test_id =".$final_comm_test_id;
$exec = $conn->Execute($comm_chapter_name);
$row = $exec->FetchRow();

include_once '_header.php';
?>
        <section class="breadcrumb white-bg">
        	<div class="container">
            	<ul>
                	<li><a href="index.php">Home</a></li>
                    <li><a href="#">Communication Result</a></li>
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
                        	<h3>Your Communication Test Result</h3>
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
                                 if($row['total_correct']*100/$row['total_questions'] >= FINAL_COMM_TEST_PASS)
								 {
									?><br> 
									 <div class="view-btn text-center">
									 <h3>Congratulations! You have cleared the test. </h3>
                                           <p class="text-center"><a href="index.php" class="btn">Go Back Home</a></p>
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
<script>
history.pushState(null, null, location.href);
    window.onpopstate = function () {
      history.go(1);
   };  
</script>