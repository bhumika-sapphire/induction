<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$sql="select tm.topic_id,topic_name from user_topics as ut inner join topic_master as tm on ut.topic_id=tm.topic_id WHERE ut.user_id='$user_id'";
$exec = $conn->Execute($sql);

$topic_id=$_REQUEST['topic_id'];

$sql1="select cm.chapter_id,chapter_name from user_topics as ut inner join chapter_master as cm on ut.topic_id=cm.topic_id WHERE ut.user_id='".$user_id."' AND ut.topic_id=".$topic_id;
$exec1 = $conn->Execute($sql1);


include_once '_header.php';
?>
        <section class="banner inner-page">
        	<div class="banner-img"><img src="images/banner/courses-banner.jpg" alt=""></div>
            <div class="page-title">	
	            <div class="container">
                    <h1>Courses Grid SideBar</h1>
                </div>
            </div>
        </section>
        <section class="breadcrumb">
        	<div class="container">
            	<ul>
                	<li><a href="#">Home</a></li>
                    <li><a href="#">All courses</a></li>
                </ul>
            </div>
        </section>
        <section class="courses-view">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-3">
                    	<div class="right-slide left">
                        	<h3>Your Toipcs</h3>
							<?php
				$ctr=1;
				while($row = $exec->FetchRow())
				{ ?>
                            <ul class="catagorie-list">
                            	<li><a href="all_chpater_gride_sideBar.php?topic_id=<?php print $row['topic_id']; ?>"><?php print $row['topic_name']; ?></a></li>
                              
                            </ul>

					<?php $ctr++; } ?>
					                        </div>
                    </div>
                    <div class="col-md-9">
                    	
                        <div class="row">
						<?php
				$ctr=1;
				while($row1 = $exec1->FetchRow())
				{ ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="course-post">
                                    <div class="img">   
                                        <div class="icon">
                                            <a href="#"><img src="images/book-icon.png" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <center><div class="name"><?php print $row1['chapter_name']; ?></div></center>
                                       <!-- <div class="expert"><span>By </span> Michael Windzor</div>-->
                                    </div>
                                    <div class="product-footer">
                                   <div class="comment-box">
								   <?php
$count_lession = "SELECT count(tmm.chapter_id) as lesson_count
FROM chapter_master AS cm
INNER JOIN training_material_master AS tmm ON cm.topic_id = tmm.topic_id and cm.chapter_id=tmm.chapter_id
WHERE cm.chapter_id=".$row1['chapter_id']." and tmm.topic_id=".$topic_id;	
 $exec2 = $conn->Execute($count_lession);
				 $row2 = $exec2->FetchRow(); ?><div class="box"><i class="fa fa-leanpub" aria-hidden="true"></i><?php echo $row2['lesson_count'];  ?> Lession</div>
                                        </div>
										
                                           <div class="view-btn">
                                           <a href="chapter_details.php?chapter_id=<?php print $row1['chapter_id'] ?>" class="btn">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
							 <?php $ctr++; } ?>
                        </div>
                        <div class="pagination">
                            <ul>
                                <li class="next"><a href="#"><i class="fa fa-angle-left"></i><span>Next</span></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li class="prev"><a href="#"><span>prev</span> <i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            	
            </div>
        </section>
<?php include '_footer.php';?> 