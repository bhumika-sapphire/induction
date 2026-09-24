<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$sql="select tm.topic_id,topic_name,tm.is_communication from user_topics as ut inner join topic_master as tm on ut.topic_id=tm.topic_id WHERE ut.user_id='$user_id'";
$exec = $conn->Execute($sql);
include_once '_header.php';
?>

     <section class="banner" id="section1">
        	<div class="banner-img"><img src="images/logo/1463445299491.jpg" alt=""></div>
            <div class="banner-text">
            	<div class="container">
                	<h1>Sapphire Info Solutions (P) Ltd.</h1>
                    <p>Employee Induction & Training Portal</p>
					<p> <a href="landing.php" class="btn">Induction Section</a> &nbsp; <?php if($_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE']) { ?><a href="#section2" class="btn">Training Section</a><?php } ?> </p>
                </div>
            </div>
        </section>
		<?php if($_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE']) { ?>
		  <section  class="our-studies" id="section2">
        	<div class="container space">
            	<div class="section-title2">
                	<h2>Your Topics</h2>
                </div>
                <div class="row">
				<?php
				$ctr=1;
				while($row = $exec->FetchRow())
				{ ?>
                	<div class="col-sm-6 col-md-4">
                    	<div class="studies-box color<?php echo $ctr; ?>">
						<?php
						if($row['is_communication']==0)
						{
						?>
                        	<div class="name"><a href="all_chapters.php?topic_id=<?php print $row['topic_id']; ?>"><?php print $row['topic_name']; ?></a></div>
							<?php 
						}
						else
						{							
							?>
							<div class="name"><a href="comm_all_chapters.php?topic_id=<?php print $row['topic_id']; ?>"><?php print $row['topic_name']; ?></a></div>
						<?php } ?>
                        </div>
                    </div>
				<?php $ctr++; } ?>
                    
                </div>
            </div>
        </section>
		<?php } ?>
  <div id="section3">      
<?php include '_footer.php';?>   
</div>  