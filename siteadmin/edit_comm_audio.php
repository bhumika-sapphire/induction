<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "manage_comm_audio";
$question_setting = true;

$comm_audio_id=$_REQUEST['comm_audio_id'];

$sql="select * FROM comm_audio_master where comm_audio_id=".$comm_audio_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Communication Audio</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i>Edit Communication Audio</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_comm_audio.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form"  action="edit_comm_audio_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "topic_id">Topic</label>
						
						<select required class="form-control select2" name="topic_id" id="topic_id">
						<option value="">Select Topic</option>
						
						<?php
							$sql="select * from topic_master WHERE is_active = 1 AND is_communication = 1 ORDER BY sort_order";
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
					
					<div class="form-group">
                        <label for = "audio_title">Audio Title</label>
                        <input required type="text" class="form-control" name="audio_title" id="audio_title" value="<?php echo $row['audio_title']; ?>" >
                    </div>
					<div class="form-group">
						<label for = "audio_file">Audio File</label>
						<input type="file" class="form-control" name="audio_file" id="audio_file" />
						<p style="color:red"><?php echo $row['audio_file'] ?></p>
                    </div>					
                </div>
				
				<div class="col-lg-12">
					<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($row['is_active']) && $row['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active"><br>
						<input type="hidden" name="comm_audio_id" id="comm_audio_id" value="<?php echo $row['comm_audio_id']; ?> ">
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
					//console.log(result);
					$('#chapter_id').html('');
					if(result.length==0){
						$('#chapter_id').html('<option value="">No related chapters found</option>');
					}else{
						result = JSON.parse(result);
						var str = '';
						$.each(result, function(chapter_id, chapter_name) {
							str +='<option value="' + chapter_id + '">' + chapter_name + '</option>';
						});
						$('#chapter_id').html(str);
					}
				}
			 });
		}	
	});
	
	$('input[type=file]').change(function(){
		var ext = $('#audio_file').val().split('.').pop().toLowerCase();
		//Allowed file types
		if($.inArray(ext, ['mp3','wmv']) == -1) {
			alert('The file type is invalid!');
			$('#audio_file').val("");
		}
		else
		{
			//Tested in Firefox and Google Chorme
			sizee = $("#audio_file")[0].files[0].size; //file size in bytes
			sizee = sizee / 1024; //file size in Kb
			sizee = sizee / 1024; //file size in Mb
			 
			//file size more than 10Mb
			if (sizee > 10) {
				alert("Maximum file size is 10Mb");
				return false;
			}  else {
			//Ajax code to upload file to server
			}
		}
	});
});
</script>
<?php include '_footer.php'; ?>