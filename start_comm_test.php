<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
$topic_id=$_REQUEST['topic_id'];
$url = "test_question_comm.php";

$chapter_name ="select t.topic_id,t.topic_name,is_communication from topic_master t where t.topic_id=".$topic_id;
$exec1 = $conn->Execute($chapter_name);
$row1 = $exec1->FetchRow();

$_SESSION[SESSION_PREFIX.'CHAPTER_TEST'] = true;

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
				<h2>Communication Test - <?php echo $row1['topic_name']; ?></h2>
				
                </div>
                <div class="row">
				<div class="col-md-12">
				There will be <?php echo FINAL_COMM_TEST_QUESTIONS; ?> questions from the above chapter. Once you start the test, do not refresh the page as it will start a new test and increase the count of the tests taken. This will affect your performance graph.
				<p class="text-center"><a class="btn" href="<?php echo $url; ?>?topic_id=<?php print $topic_id; ?>" >Start Test</a></p>
				</div>
                </div>
        </section>
<?php include '_footer.php';?> 