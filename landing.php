<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$sql="select tm.topic_id,topic_name,tm.is_communication from user_topics as ut inner join topic_master as tm on ut.topic_id=tm.topic_id WHERE ut.user_id='$user_id'";
$exec = $conn->Execute($sql);

include_once '_header.php';
?>

    <section class="banner" id="section1">
        	<div class="banner-img"><img src="images/slider-3-slide-2.jpg" alt=""></div>
            <div class="banner-text">
            	<div class="container">
                    <p>Welcome to Sapphire</p>
                	<h1>NEW JOINEE ONBOARDING</h1>
					<p> <a href="induction.php?page_id=1" class="btn">Click here to continue</a></p>
                </div>
            </div>
    </section>
        
  <div id="section3">      
<?php include '_footer.php';?>   
</div>  