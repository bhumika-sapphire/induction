 <footer id="footer" class="style2">
        	<div class="footer-top">
            	<div class="container">
                	<div class="row">
                    	<div class="col-sm-6 col-md-3">
                        	<div class="footer-logo"><a href="index.php"><img class="footerlogo"src="images/logo/logo.png" alt=""></a></div>
                            <div class="footer-text">
							<h5>About</h5>
                                <p>We are one of the earliest providers of accounting outsourcing services in UK since the year 2004. We are one of the accredited gold training partners of ACCA in India.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                        	<h5>Links</h5>
                            <ul class="footer-link ">
                                <li class="links"><a href="#section1">Home</a></li>
                                <li class="links"><a href="#section2">Test</a></li>
                                <li class="links"><a href="#section3">Conatct Us</a></li>
                            </ul>
							 <div class="social-media" class="text-center">
                                <ul >
                                    <li><a target="_blank" href="https://www.facebook.com/sapphireinfosolutions/"><i class="fa fa-facebook"></i></a></li>
                                    <li><a target="_blank" href="https://www.linkedin.com/company/sapphire-info-solutions-p-ltd"> <i class="fa fa-linkedin"></i> </a></li>
                                    <li><a target="_blank" href="https://twitter.com/sapphireinfoso1">
                                    	<img src="images/logo/twitter.png" style="width: 86%;"></a></li>
                                </ul>
                            </div>
                        </div>
						  <div class="col-sm-6 col-md-3">
                        	<h5>ISO Certifications By</h5>
                            <table>
								<tr>
									<td class="tdd"><img src="images/logo/UR.jpg" alt="UR"></td>
									<td><img src="images/logo/eajas.jpg" alt="eajas"></td>
								</tr>
								<tr>
									<td class="tdd"><img src="images/logo/iso2013.jpg" alt="UR"></td>
									<td><img src="images/logo/universal.jpg" alt="eajas"></td>
								</tr>
							</table>
                        </div>
                        <div class="col-sm-6 col-md-3">
                        	<h5>Contact Us</h5>
                            <div class="contact-view">
                            	<div class="contact-slide">
                                	<p><i class="fa fa-location-arrow"></i>UK Address:- 4 Whiteleys Parade, Uxbridge Road, Hillingdon, Uxbridge UB10 0PD</p>
                                </div>
                                <div class="contact-slide">
                                	<p><i class="fa fa-phone"></i>+91-161-5002086 (IN)</p>
                                </div>
                                <div class="contact-slide">
                                	<p><i class="fa fa-phone"></i>(+44) 2030026314 (UK)</p>
                                </div>
                                <div class="contact-slide">
                                	<p><i class="fa fa-envelope"></i><a href="mailTo:info@sapphireinfo.net">info@sapphireinfo.net</a></p>
                                </div>
								<div class="contact-slide">
                                	<p><i class="fa fa-clock-o"></i>MONDAY TO SATURDAY
                                        <br>10:00 AM to 06:30 PM</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="copy-right">
                                <p>© Copyright <strong>Sapphire Info Solutions (P) Ltd.</strong> All Rights Reserved. | <span class="txt">Website design & development</span> by Web Supplements </p></div>
                        </div>
                     
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="top-arrow" id="goTop">
        	<div class="arrow"><i class="fa fa-angle-up"></i></div>
        </div>
        <div class="search-blcok">
        	<div class="close-icon">
            	<i class="fa fa-close"></i>
            </div>
        	<div class="input-box">
        		<input type="text" placeholder="Enter Keyword">
                <div class="note">Input your search keywords and press Enter.</div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/owl.carousel.js"></script>
    <script type="text/javascript" src="js/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="js/jquery.selectbox-0.2.js"></script>
		<script type="text/javascript" src="js/jquery.countdown.js"></script>
    <script type="text/javascript" src="js/countdown-script.js"></script>
    <script type="text/javascript" src="js/placeholder.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
    
	<?php if(isset($steps) && $steps == true){ ?>
	<script src="js/modernizr-2.6.2.min.js"></script>
    <script src="js/jquery.cookie-1.3.1.js"></script>
    <script src="js/jquery.steps.js?a=1"></script>
		<script>
                $(function ()
                {
                    $("#wizard").steps({
                        headerTag: "h2",
                        bodyTag: "section",
                        transitionEffect: "slideLeft",
                        stepsOrientation: "vertical",
						onFinished: function (event, currentIndex)
						{
							var form = $(this);

							// Submit form input

							form.submit();
						}
                    });
                });
            </script>
	<?php } ?>
	<script type="text/javascript" src="js/coustem.js"></script>
	<?php if(isset($chapter_test) && $chapter_test == true){ ?>
		<script> chapter_test(<?php echo CHAPTER_TEST_QUESTIONS*8; ?>); </script>
	<?php }
	if(isset($final_test) && $final_test == true){ ?>
		<!-- <script> final_test(<?php echo FINAL_TEST_QUESTIONS*8; ?>); </script> -->
		<script> final_test(60); </script>
	<?php }
		if(isset($_SESSION[SESSION_PREFIX.'LOGIN_HISTORY_ID']) && $_SESSION[SESSION_PREFIX.'LOGIN_HISTORY_ID']!=""){
	?>
	<script>
	function executeQuery() {
	  $.ajax({
		url: 'ping.php?login_history_id=<?php echo $_SESSION[SESSION_PREFIX.'LOGIN_HISTORY_ID']; ?>',
		success: function(data) {
		  // do something with the return value here if you like
		}
	  });
	  setTimeout(executeQuery, 30000); // you could choose not to continue on failure...
	}
		$(document).ready(function() {
		  // run the first time; all subsequent calls will take care of themselves
		  setTimeout(executeQuery, 30000);
		});
		//enble next btn
		
	</script>
	<?php } ?>
	<?php if($datatable){ ?>
	<script src="siteadmin/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#example').DataTable({"deferRender": true ,"lengthMenu": [ 50, 100,150,200,250,500]});
			$('#example1').DataTable({"deferRender": true ,"lengthMenu": [ 50, 100,150,200,250,500]});
        });
	</script>
	<?php } ?>
	<script>
		$(document).ready(function() {
		  $("a.fancybox").fancybox();
		  
		  $("body").on("submit",".policy_form",function(e){
			  e.preventDefault();
			  
			$.ajax({
				url: 'ajax_policy_exec.php',
				data: $(this).serialize(),
				type : 'POST',
				success: function(response) {
					console.log(response);
					if(response != "Error")
					{
						$("#"+response+"_form").hide();
					}
				}
			});
		  })
		   
		});
	</script>
</body>
</html>

