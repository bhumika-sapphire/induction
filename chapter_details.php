<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';
$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$chapter_id=$_REQUEST['chapter_id'];

$sql="select tmm.* from chapter_master as cm, training_material_master as tmm,user_topics as ut where cm.chapter_id=tmm.chapter_id AND tmm.topic_id=ut.topic_id AND ut.user_id=".$user_id." AND cm.chapter_id=".$chapter_id." order by tmm.sort_order";
$exec = $conn->Execute($sql);

if(!$exec->RowCount())
{
	header("location:all_chapters.php?topic_id=".$_REQUEST['topic_id']);
}
include_once '_header.php';
?>
       
        <section class="breadcrumb">
        	<div class="container">
            	<ul>
                	<li><a href="index.php">Home</a></li>
                    <li><a href="all_chapters.php?topic_id=<?php echo $_REQUEST['topic_id']; ?>">Topic</a></li>
                    <li><a href="#">Chapter details</a></li>
                </ul>
            </div>
        </section>
        <div class="course-details">
        	<div class="container">
			
            	<h2><?php
				 $chapter_name ="select chapter_name from chapter_master where chapter_id=".$chapter_id;
				 $exec1 = $conn->Execute($chapter_name);
				 $row1 = $exec1->FetchRow();
				 echo $row1['chapter_name']; ?></h2>
	            <div class="course-details-main">
                   
                    <div class="course-info">
                        <div class="course-box">
                            <div class="icon"><i class="fa fa-leanpub" aria-hidden="true"></i>	</div>
                            <?php
                      $count_lession = "select count(training_material_id) as counts from training_material_master WHERE chapter_id=$chapter_id";	
                      $exec2 = $conn->Execute($count_lession);
				      $row2 = $exec2->FetchRow(); ?><div class="box"><?php echo $row2['counts'];  ?> Lession</div>
                        </div>
						<div class="course-box">
                            <div class="icon"><i class="fa fa-file-text" aria-hidden="true"></i></div>
                            <?php
                      $count_lession = "select material_file_type, count(training_material_id) as counts from training_material_master WHERE chapter_id=$chapter_id group by material_file_type";	
                      $exec2 = $conn->Execute($count_lession);
					  $count_total=0;
					  $count_document=0;
					  $count_video=0;
					  $count_audio=0;
					  $count_others=0;
					  while($row2 = $exec2->FetchRow())
					  {
						if($row2['material_file_type'] == "Document")
							$count_document = $row2['counts'];
						else if($row2['material_file_type'] == "Video")
							$count_video = $row2['counts'];
						else if($row2['material_file_type'] == "Audio")
							$count_audio = $row2['counts'];
						else if($row2['material_file_type'] == "Others")
							$count_others = $row2['counts'];
					  }
					  
				      ?><div class="box"><?php echo $count_document;  ?> Documents</div>
                        </div>
                       <div class="course-box">
                            <div class="icon"><i class="fa fa-video-camera" aria-hidden="true"></i></div>
                            <p><?php echo $count_video;  ?> video</p>
                        </div>
						 <div class="course-box">
                            <div class="icon"><i class="fa fa-volume-up" aria-hidden="true"></i></div>
                            <p><?php echo $count_audio;  ?> Audio</p>
                        </div>
						 <div class="course-box">
                            <div class="icon"><i class="fa fa-picture-o" aria-hidden="true"></i></div>
                            <p><?php echo $count_others;  ?> Others </p>
                        </div>
                    </div>
                </div>
                <div class="info">
                	<h4>Chapter Overview</h4>
                    
                </div>
                <div class="syllabus">
				<?php
				$ctr=1;
				while($row = $exec->FetchRow())
				{ ?>
                    <div class="syllabus-box">
                    	<div class="syllabus-title">Lesson <?php print $ctr; ?></div>
                        <div class="syllabus-view <?php if($ctr == 1){echo " first";} ?>">
                        	<div class="main-point active"><?php print $row['material_title']   ?></div>
                            <div class="point-list">
							<p><?php print local_content($row['material_text'])   ?></p>
                            	
								<?php 
									if($row['material_file_type']=="Video")
									{ ?>
								   <ul><li>
								   <a class="fancybox" href="#light<?php print $row['training_material_id']; ?>" >Watch Video<span class="hover-text"><i class="fa fa-angle-right"></i></span></a>
                                <div style="display:none;" id="light<?php print $row['training_material_id']; ?>">
							    <video id="video<?php print $row['training_material_id']; ?>" width="800" controls>
								  <source src="<?php print UPLOADS_URL; ?>material/<?php print $row['material_file'];?>" >
								  <!--Browser does not support <video> tag -->
								</video>

							  </div>
									</li></ul>
									<?php
									}
									else if($row['material_file_type']=="Audio")
									{
									?>
										<ul>   <li>
								   <a class="fancybox" href="#light<?php print $row['training_material_id']; ?>" >Audio<span class="hover-text"><i class="fa fa-angle-right"></i></span></a>
                                <div style="display:none;" id="light<?php print $row['training_material_id']; ?>">
							    <audio id="audio<?php print $row['training_material_id']; ?>" width="800" controls>
								  <source src="<?php print UPLOADS_URL; ?>material/<?php print $row['material_file'];?>">
								  <!--Browser does not support <video> tag -->
								</audio>
							  </div>
									</li></ul>
								<?php
									}
									else if(isset($row['material_file']) && $row['material_file']!="")
									{
										$file_ext = trim(strtolower(strrchr($row['material_file'],'.')));
										
										if($file_ext == '.pdf1')
										{ ?> 
											<object data='<?php print UPLOADS_URL; ?>material/<?php print $row['material_file'];?>#toolbar=0&statusbar=0' 
													type='application/pdf' 
													width='100%' 
													height='1000px'>
											<p><ul><li><a target="_blank" href="<?php print UPLOADS_URL; ?>material/<?php print $row['material_file'];?>"> Download File (Your browsers does not support PDF embed)<span class="hover-text"><i class="fa fa-angle-right"></i></span></a></li></ul></p>
											</object>
										<?php }
										else
										{
									?>
										<ul>
											<li>

												<a target="_blank" href="download_file.php?file=<?php echo urlencode($row['material_file']); ?>">
													Download File <span class="hover-text"><i class="fa fa-angle-right"></i></span>
												</a>


											
											</li>
										</ul>
										<?php 
										}
									}
									?>
								<?php if(isset($row['material_video']) && $row['material_video'] !=""){ ?>
									
								<video id="video<?php print $row['training_material_id']; ?>" width="800" controls>
								  <source src="<?php print UPLOADS_URL; ?><?php print $row['material_video'];?>" >
								  <!--Browser does not support <video> tag -->
								</video>
								<?php } ?>
                                
                            </div>
                        </div>
                    </div>
				<?php $ctr++; } ?>  
                </div>
				<?php
				 $chapter_name ="select topic_id,chapter_name,chapter_id from chapter_master where chapter_id=".$chapter_id;
				 $exec1 = $conn->Execute($chapter_name);
				 $row1 = $exec1->FetchRow();
				 //two test attempt check
				 $sql = "SELECT chapter_test_id FROM user_chapter_test_master WHERE chapter_id=".$chapter_id." AND user_id=".$user_id." AND test_date LIKE '".date('Y-m-d')."%'";
				 $check = $conn->Execute($sql);
				 
				 
				 /*if($check->RowCount()<=2 )
				 {
				 ?>
				 <div class="submit-slide">
                        	<center><a href="start_test.php?chapter_id=<?php print $row1['chapter_id']; ?>&topic_id=<?php print $row1['topic_id']; ?>"><input type="submit" value="Test" class="btn"></a></center>
                </div>
				 <?php }
				else{ ?>
					<div class="submit-slide">
                        	<center>You have already given 2 tests for this chapter today. You need to wait for tomorrow to give another test.</center>
                </div>
				<?php } */?>
				<!-- <div class="submit-slide">
                        	<center><a href="start_test.php?chapter_id=<?php print $row1['chapter_id']; ?>&topic_id=<?php print $row1['topic_id']; ?>"><input type="submit" value="Test" class="btn"></a></center>
                </div> -->
            </div>
        </div>
<?php include '_footer.php';?>        