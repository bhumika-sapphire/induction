<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$topic_id=$_REQUEST['topic_id'];

$sql="select cm.chapter_id,chapter_name from user_topics as ut inner join chapter_master as cm on ut.topic_id=cm.topic_id WHERE ut.topic_id='$topic_id'";
$exec = $conn->Execute($sql);

include_once '_header.php';
?>
        <section class="banner inner-page">
        	<div class="banner-img"><img src="images/banner/courses-banner.jpg" alt=""></div>
            <div class="page-title">	
	            <div class="container">
                    <h1>Courses Grid</h1>
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
            	<div class="filter-row">
                	<div class="view-type">
                    	<a href="courses-gride.html" class="active"><i class="fa fa-th-large"></i></a>
                        <a href="courses-list.html"><i class="fa fa-list"></i></a>
                    </div>
                	<div class="search">
                    	<input type="text" placeholder="Search">
                        <input type="submit" value="">
                    </div>
                </div>
            	<div class="row">
				<?php
				$ctr=1;
				while($row = $exec->FetchRow())
				{ ?>
                	<div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img4.jpg" alt="">
                            	<div class="price">$18</div>    
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Basic Time Management Course</div>
                                <div class="expert"><span>By </span>Michael Windzor</div>
                            </div>
                            <div class="product-footer">
                                <div class="comment-box">	
                                    <div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                    <div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course_details.php" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php $ctr++; } ?>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img5.jpg" alt="">
                                <div class="price free">free</div>    
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Introduction to Mobile Apps Development</div>
                                <div class="expert"><span>By </span>Michael Windzor</div>
                            </div>
                            <div class="product-footer">
                            	<div class="comment-box">	
 	                            	<div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                	<div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course_details.php" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img6.jpg" alt="">
                                <div class="price">$23</div>
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Lorem Ipsum is simply dummy</div>
                                <div class="expert"><span>By </span>text of the printing</div>
                            </div>
                            <div class="product-footer">
                            	<div class="comment-box">	
 	                            	<div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                	<div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course-details.html" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img7.jpg" alt="">
                                <div class="price">$78</div>    
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Lorem Ipsum has been the</div>
                                <div class="expert"><span>By </span>unknown printer</div>
                            </div>
                            <div class="product-footer">
                            	<div class="comment-box">	
 	                            	<div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                	<div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course-details.html" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img6.jpg" alt="">
                                <div class="price">$23</div>
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Lorem Ipsum is simply dummy</div>
                                <div class="expert"><span>By </span>text of the printing</div>
                            </div>
                            <div class="product-footer">
                            	<div class="comment-box">	
 	                            	<div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                	<div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course-details.html" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img4.jpg" alt="">
                            	<div class="price">$18</div>    
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Basic Time Management Course</div>
                                <div class="expert"><span>By </span>Michael Windzor</div>
                            </div>
                            <div class="product-footer">
                                <div class="comment-box">	
                                    <div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                    <div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course-details.html" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img7.jpg" alt="">
                                <div class="price">$78</div>    
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Lorem Ipsum has been the</div>
                                <div class="expert"><span>By </span>unknown printer</div>
                            </div>
                            <div class="product-footer">
                            	<div class="comment-box">	
 	                            	<div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                	<div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course-details.html" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                    	<div class="course-post">
                        	<div class="img">
                            	<img src="images/courses/courses-img5.jpg" alt="">
                                <div class="price free">free</div>    
                                <div class="icon">
                                	<a href="#"><img src="images/book-icon.png" alt=""></a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="name">Introduction to Mobile Apps Development</div>
                                <div class="expert"><span>By </span>Michael Windzor</div>
                            </div>
                            <div class="product-footer">
                            	<div class="comment-box">	
 	                            	<div class="box"><i class="fa fa-users"></i>35 Enrolled</div>
                                </div>
                                <div class="rating">
                                	<div class="fill" style="width:45%"></div>
                                </div>
                                <div class="view-btn">
                                	<a href="course-details-free.html" class="btn">view more</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
        </section>
<?php include '_footer.php';?> 