<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';
	$topic_id=$_REQUEST['topic_id'];
$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
$_SESSION[SESSION_PREFIX.'FINAL_TEST'] = true;
include_once '_header.php';
?>
        <section class="breadcrumb white-bg">
        	<div class="container">
            	<ul>
                	<li><a href="index.php">Home</a></li>
                    <li><a href="#">Test</a></li>
                </ul>
            </div>
        </section>
        <section class="quiz-view">
        	<div class="container">
                <div class="quiz-title">
                    <h2>Final Test</h2>
                </div>
                <div class="row">
				<div class="col-md-12">
				There will be <?php echo FINAL_TEST_QUESTIONS; ?> questions from the all the  chapters of various topics allocated to you. Once you start the test, do not refresh the page as it will mark an entry and then you won't be able to take another test before admin approves it for you. Also, this will affect your performance graph.
				<p class="text-center"><a class="btn" href="final_test.php?topic_id=<?php echo $topic_id; ?>">Start Test</a></p>
				</div>
                </div>
        </section>
<?php include '_footer.php';?> 