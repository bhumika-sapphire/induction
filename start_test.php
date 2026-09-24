<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
$chapter_id=$_REQUEST['chapter_id'];
$url = "test_question.php";
$chapter_name ="select t.topic_id,c.chapter_name,t.topic_name,c.sort_order from chapter_master c, topic_master t where t.topic_id=c.topic_id AND c.chapter_id=".$chapter_id;
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
				
					 <h2>Test :- <?php echo $row1['chapter_name']." (".$row1['topic_name'].")"; ?></h2>
				
				
				
                </div>
                <div class="row">
				<div class="col-md-12">
				<!--There will be
					<?php echo FINAL_COMM_TEST_QUESTIONS; ?>
			
				 questions from the above chapter.--> Once you start the test, do not refresh the page as it will start a new test and increase the count of the tests taken. This will affect your performance graph.
				<p class="text-center"><a class="btn" href="<?php echo $url; ?>?chapter_id=<?php print $chapter_id."&topic_id=".$row1['topic_id']."&sort_order=".$row1['sort_order']; ?>" >Start Test</a></p>
				</div>
                </div>
        </section>
<?php include '_footer.php';?> 