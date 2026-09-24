<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = 'manage_question';
$question_setting = true;
$wysiwyg = true;


$question_id=$_REQUEST['question_id'];
$sql="select * FROM comm_question_bank_master where question_id=".$question_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Add Question</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add Question</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_question.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_comm_question_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "topic_id">Topic</label>
						
						<select required class="form-control select2" name="topic_id" id="topic_id">
						<option value="">Select Topic</option>
						
						<?php
							$sql="select * from topic_master WHERE is_active = 1 AND is_communication ORDER BY sort_order";
							$exec = $conn->Execute($sql);
							$ctr = 0;
							while($result = $exec->FetchRow())
							{ 
								$ctr++;
							?>
								
								<option <?php if($result["topic_id"] == $row["topic_id"]){ echo "selected"; } ?> value="<?php echo $result["topic_id"]; ?>"><?php echo $result["topic_name"]; ?> </option>
					  <?php }
							if($ctr == 0){
								?>
								<option value="">No active topic found</option>
								<?php
							}
					  ?>
						</select>
                    </div>
					
					<div class="form-group">
                        <label for = "chapter_id">Chapter Name</label>
						
						<select required class="form-control select2" name="chapter_id" id="chapter_id">
						<?php
							$sql="select * from chapter_master WHERE is_active = 1 AND topic_id = ".$row['topic_id']." ORDER BY sort_order";
							$exec = $conn->Execute($sql);
							$ctr = 0;
							while($result = $exec->FetchRow())
							{ 
							?>
								<option <?php if($result["chapter_id"] == $row["chapter_id"]){ echo "selected"; } ?> value="<?php echo $result["chapter_id"]; ?>"><?php echo $result["chapter_name"]; ?> </option>
							<?php } ?> 
						</select>
                    </div>
				
                </div>
				<div class="col-lg-6">
				 <div class="form-group">
                        <label for ="audio_id">Audio Name</label>
						<select required class="form-control select2" name="audio_id" id="audio_id" >
						<?php
							$sql="select * from comm_audio_master WHERE comm_audio_id = ".$row['comm_audio_id']." AND chapter_id=".$row["chapter_id"];
							$exec1 = $conn->Execute($sql);
							$ctr = 0;
							while($result1 = $exec1->FetchRow())
							{ 
							?>
							
								<option <?php if($result1["comm_audio_id"] == $row["comm_audio_id"]){ echo "selected"; } ?> value="<?php echo $result1["comm_audio_id"]; ?>"><?php echo $result1["audio_title"]; ?> </option>
							<?php } ?> 
						<!--<option value="">Please select chapter from above </option>-->
						</select>
                    </div>
				
					<div class="form-group">
                        <label for = "correct_answer">Correct option</label>
                        <select required class="form-control " name="correct_answer" id="correct_answer" >
						<option <?php if($row['correct_answer'] == 1){echo " selected ";} ?> value="1">Option 1</option>
						<option <?php if($row['correct_answer'] == 2){echo " selected ";} ?> value="2">Option 2</option>
						<option <?php if($row['correct_answer'] == 3){echo " selected ";} ?> value="3">Option 3</option>
						<option <?php if($row['correct_answer'] == 4){echo " selected ";} ?> value="4">Option 4</option>
						</select>
                    </div>
					</div>
				<div class="col-lg-12">
				<div class="form-group">
                        <label for = "question_text">Question Title</label>
                         <textarea class="form-control wysiwyg" name="question_title" id="question_title" required ><?php  echo $row['question_title']; ?></textarea>
                    </div>
				<div class="form-group">
					<label for = "option1">Option 1</label>
					 <textarea class="form-control wysiwyg" name="material_text_option1" id="material_text_option1" required><?php  echo $row['option1']; ?></textarea>
                    </div>
					<div class="form-group">
					<label for = "option2">Option 2</label>
					 <textarea class="form-control wysiwyg" name="material_text_option2" id="material_text_option2" required ><?php  echo $row['option2']; ?></textarea>
                    </div>
					
					<div class="form-group">
					<label for = "option3">Option 3</label>
					 <textarea class="form-control wysiwyg" name="material_text_option3" id="material_text_option3" required ><?php  echo $row['option3']; ?></textarea>
                    </div>
				
				<div class="form-group">
					<label for = "option4">Option 4</label>
					 <textarea class="form-control wysiwyg" name="material_text_option4" id="material_text_option4" required ><?php  echo $row['option4']; ?></textarea>
                    </div>
					
					</div>
				
				
				<div class="col-lg-12">
				<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($row['is_active']) && $row['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active"><br>
						<input type="hidden" name = "question_id" id="question_id" value="<?php echo $row['question_id']; ?>" >
						  <button class="btn btn-default" type="submit">Submit</button>
                    </div>
				</div>
				
            </form>
        </div>
        <!-- /.row --> 
        <br/>
    </div>
    <!-- /.container-fluid --> 
</div>

<script>
$(function() { 
    $("#topic_id").change(function(){ 

		var topic_id =  $('#topic_id option:selected').val(); 
		if(topic_id != ''){
			$.ajax({
				type: 'GET',
				contentType: "application/json; charset=utf-8",
				url: 'ajax_related_chapters.php',
				data: "topic_id="+topic_id,
				success: function(result) {
					//console.log(result.length);
					$('#chapter_id').html('');
					  $("#chapter_id").select2("destroy");
					if(result.length==0 || result == '[]'){
						$('#chapter_id').html('<option value="">No related chapters found</option>');
					}else{
						result = JSON.parse(result);
						var str = '';
						$.each(result, function(chapter_id, chapter_name) {
							str +='<option value="' + chapter_id + '">' + chapter_name + '</option>';
						});
						$('#chapter_id').html(str).change();
					}
				}
			 });
		}	
	});
	
	
});
$(function() { 
    $("#chapter_id").change(function(){ 

		var chapter_id =  $('#chapter_id option:selected').val(); 
		if(chapter_id != ''){
			$.ajax({
				type: 'GET',
				contentType: "application/json; charset=utf-8",
				url: 'ajax_related_audio.php',
				data: "chapter_id="+chapter_id,
				success: function(result) {
					//console.log(result.length);
					$('#audio_id').html('');
					  $("#audio_id").select2("destroy");
					if(result.length==0 || result == '[]'){
						$('#audio_id').html('<option value="">No related Audio found</option>');
					}else{
						result = JSON.parse(result);
						var str = '';
						$.each(result, function(comm_audio_id, audio_title) {
							str +='<option value="' + comm_audio_id + '">' + audio_title + '</option>';
						});
						$('#audio_id').html(str).change();
					}
				}
			 });
		}	
	});
	
	
});
</script>
<?php include '_footer.php'; ?>