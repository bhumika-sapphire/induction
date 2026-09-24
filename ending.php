<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$sql="select tm.topic_id,topic_name,tm.is_communication from user_topics as ut inner join topic_master as tm on ut.topic_id=tm.topic_id WHERE ut.user_id='$user_id'";
$exec = $conn->Execute($sql);

if(!$_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE'])
	{
		$status = induction_complete();
		
		if($status)
		{
			/* Show notification that with this page, his induction is complete */
			echo "<script>alert('Wohoo! Induction is complete.');</script>";
			/* This is temporary. We will use bootstrap notification */
		}
	}

include_once '_header.php';
?>

    <section class="banner" id="section1">
        	<div class="banner-img"><img src="images/slide-3-1.jpg" alt=""></div>
            <div class="banner-text">
            	<div class="container">
				<h1>We welcome you to <br>Sapphire Info Solutions Pvt. Ltd.<br>and wish a fruitful and a long term association.</h1>
				<p>&nbsp;</p>
                    <p class="customMargin">Sapphire Info Solutions (P) Ltd.<br>
2nd & 4th Floor, Nego Complex,<br>
Pakhowal Road,<br>
Ludhiana, Punjab.<br>
0161- 5002086<br>
info@sapphireinfo.net</p>
                	
					<p><?php if($_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE']) { ?><a href="index.php#section2" class="btn">Training Section</a><?php } ?> </p>
                </div>
            </div>
    </section>
        
  <div id="section3">      
<?php include '_footer.php';?>   
</div>  