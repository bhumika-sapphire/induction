<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "manage_comm_question";
$question_setting = true;
$wysiwyg = true;
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
                <a class="col-lg-2 breadcrumb" href="manage_comm_question.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="add_comm_question_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "topic_id">Topic</label>
						
						<select class="form-control select2" name="topic_id" id="topic_id" required>
						<option value="">Select Topic</option>
						
						<?php
							$sql="select * from topic_master WHERE is_active = 1 AND is_communication=1 ORDER BY sort_order";
							$exec = $conn->Execute($sql);
							$ctr = 0;
							while($result = $exec->FetchRow())
							{ 
								$ctr++;
							?>
								<option value="<?php echo $result["topic_id"]; ?>"><?php echo $result["topic_name"]; ?> </option>
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
                        <label for ="chapter_id">Chapter Name</label>
						
						<select required class="form-control select2" name="chapter_id" id="chapter_id" >
						<option value="">Please select Topic from above </option>
						</select>
                    </div>
					
				
				
                </div>
				<div class="col-lg-6">
                       <div class="form-group">
                        <label for ="audio_id">Audio Name</label>
						<select required class="form-control select2" name="audio_id" id="audio_id" >
						<option value="">Please select chapter from above </option>
						</select>
                    </div>
						<div class="form-group">
                        <label for = "correct_answer">Correct option</label>
                        <select required class="form-control " name="correct_answer" id="correct_answer">
						<option value="1">Option 1</option>
						<option value="2">Option 2</option>
						<option value="3">Option 3</option>
						<option value="4">Option 4</option>
						</select>
                    </div>
					
	
					
				</div>
					<div class="col-lg-12">
						<div class="form-group">
                        <label for = "question_text">Question Title</label>
                         <textarea class="form-control wysiwyg" name="question_title" id="question_title" required></textarea>
                    </div>
						<div class="form-group">
					<label for = "option1">Option 1</label>
					 <textarea class="form-control wysiwyg" name="material_text_option1" id="material_text_option1" required></textarea>
                    </div>
					
					<div class="form-group">
                       <label for = "option2">Option 2</label>
					 <textarea class="form-control wysiwyg" name="material_text_option2" id="material_text_option2" required></textarea>
                    </div>
					
					<div class="form-group">
                        <label for = "option3">Option 3</label>
					 <textarea class="form-control wysiwyg" name="material_text_option3" id="material_text_option3" required></textarea>
                    </div>
					
						<div class="form-group">
                        <label for = "option4">Option 4</label>
					 <textarea class="form-control wysiwyg" name="material_text_option4" id="material_text_option4" required></textarea>
                    </div>
					</div>
				<div class="col-lg-12">
				<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" checked="checked" name="is_active" value="1" id="is_active"><br>
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