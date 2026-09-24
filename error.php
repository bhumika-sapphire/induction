<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

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
                    <h2>Oops! It seems you tried to fool the system.</h2>
                </div>
                <div class="row">
				<div class="col-md-12">
				But the system has outfooled you. Your attempt has been logged. 
				</div>
                </div>
        </section>
		
<?php include '_footer.php';?> 