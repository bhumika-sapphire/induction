<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "manage_material";
$material_setting = true;
$wysiwyg = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Add Material</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add Material</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_material.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form"  action="add_material_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "topic_id">Topic</label>
						
						<select required class="form-control select2" name="topic_id" id="topic_id">
						<option value="">Select Topic</option>
						
						<?php
							$sql="select * from topic_master WHERE is_active = 1 AND is_communication= 0 ORDER BY sort_order";
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
                        <label for = "chapter_id">Chapter Name</label>
						
						<select required class="form-control select2" name="chapter_id" id="chapter_id">
						<option value="">Please select Topic from above </option>
						</select>
                    </div>
					
					<div class="form-group">
                        <label for = "material_title">Material Title</label>
                        <input required type="text" class="form-control" name="material_title" id="material_title" >
                    </div>
					
					
										
                </div>
				<div class="col-lg-6">

					<div class="form-group">
					<label for = "material_file">Material File</label>
					<input type="file" class="form-control" name="material_file" id="material_file" />
                    </div>
					
					<div class="form-group">
                        <label for = "material_time_duration">Material Duration</label>
                       <input required type="number" class="form-control" name="material_time_duration" id="material_time_duration" >
                    </div>
					
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                       <input required type="number" class="form-control" name="sort_order" id="sort_order" value="1" >
                    </div>
	
					
				</div>
				<div class="col-lg-12">
					<div class="form-group">
					<label for = "material_file">Video File upload</label>
					<input type="file" class="form-control" name="video" id="video" />
                    </div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
                        <label for = "material_text">Material Text</label>
                        <textarea class="form-control wysiwyg" name="material_text" id="material_text" ></textarea>
                    </div>
					<div class="form-group">
						<input type="hidden" name="add_date" id="add_date" value="<?php echo date('Y-m-d, h:i:s'); ?>" >
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
	
	$('#material_file').change(function(){
		var ext = $('').val().split('.').pop().toLowerCase();
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
			 
console.log("rrrr");
			//file size more than 10Mb
			if (sizee > 60) {
				alert("Maximum file size is 60Mb");
				return false;
			}  else {
			//Ajax code to upload file to server
			}
		}
	});
});
</script>
<?php include '_footer.php'; ?>