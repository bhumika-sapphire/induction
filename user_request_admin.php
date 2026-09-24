<?php
include_once 'includes/startup.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
	$topic_id=$_REQUEST['topic_id'];

include_once '_header.php';
?>
        <section class="quiz-view">
        	<div class="container">
                <div class="quiz-title">
			</div>
                <div class="row">
					<form action="user_request_admin_exec.php" method="post">
						<div class="col-sm-12 col-md-12">
							<div class="quiz-result">
								<center><h2>Admin Request</h2></center>
								<div class="leaderboard">
								<div><textarea rows="4" name="description" class="form-control" placeholder="Message" required></textarea></div>
										 <div class="view-btn text-center">
											<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
											 <p class="text-center"><input type="submit" class="btn" value="Send"> </a></p>
										</div>
								   </div>
							  </div>
						 </div>
					</form>
                </div>
            </div>
        </section>
<?php include '_footer.php';?> 