<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "manage_comm_material";
$material_setting = true;
$wysiwyg = true;

$comm_material_id=$_REQUEST['comm_material_id'];
$sql="select * FROM comm_material_master where comm_material_id=".$comm_material_id;
$exec = $conn->Execute($sql);
$row = $exec->FetchRow();

include_once '_header.php';
?>
<link href="css/select2.min.css" rel="stylesheet" />
<script src="js/select2.min.js"></script>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Edit Communication Material</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Edit Communication Material</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_comm_material.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_comm_material_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "topic_id">Topic</label>
						
						<select required class="form-control select2" name="topic_id" id="topic_id">
						<option value="">Select Topic</option>
						
						<?php
							$sql="select * from topic_master WHERE is_active = 1  AND is_communication=1 ORDER BY sort_order";
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
                        <label for = "material_title">Audio Title</label>
                        <input required type="text" class="form-control" name="audio_title" id="audio_title" value="<?php echo $row['audio_title']; ?>" >
                    </div>
					
					
										
                </div>
				<div class="col-lg-6">

					<div class="form-group">
					<label for = "material_file">Material File</label>
					<input type="file" class="form-control" name="material_file" id="material_file" />
					 <p style="color:red"><?php echo $row['material_file'] ?></p>
                    </div>
					
					<div class="form-group">
                        <label for = "material_time_duration">Material Duration</label>
                       <input required type="number" class="form-control" name="material_time_duration" id="material_time_duration" value="<?php echo $row['file_duration']; ?>" >
                    </div>
					
					<!--<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                       <input required type="number" class="form-control" name="sort_order" id="sort_order" value="<?php echo $row['sort_order']; ?>" >
                    </div>-->
	
					
				</div>
				<div class="col-lg-12">
					<div class="form-group">
                        <label for = "material_text">Material Text</label>
                        <textarea class="form-control wysiwyg" name="audio_material_text" id="audio_material_text" ><?php echo $row['audio_material_text']; ?></textarea>
                    </div>
					
					<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($row['is_active']) && $row['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active">
                    </div>
					
					<div class="form-group">
						<input type="hidden" name="comm_material_id" id="comm_material_id" value="<?php echo $row['comm_material_id']; ?>" >
						<input type="hidden" name="old_material_file" id="old_material_file" value="<?php echo $row['audio_file']; ?>" >
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
		var ext = $('#material_file').val().split('.').pop().toLowerCase();
		//Allowed file types
		if($.inArray(ext, ['gif','png','jpg','jpeg', 'docx', 'doc', 'pdf', 'rtf', 'ppt', 'txt', 'odt','avi','mp3','mp4','wmv','xls','xlsx']) == -1) {
			alert('The file type is invalid!');
			$('#material_file').val("");
		}
		else
		{
			//Tested in Firefox and Google Chorme
			sizee = $("#material_file")[0].files[0].size; //file size in bytes
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