<?php
	include_once 'includes/startup.php';
	include_once 'authenticate.php';
	
	$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);
	$page_id=8;
	
	$_SESSION[SESSION_PREFIX.'pageViewed'][$page_id]="true";
	
	$training = "SELECT * FROM cms_master WHERE page_id =".$page_id;
	$execc = $conn->Execute($training);
	$roww = $execc->FetchRow();
	$shortcode = true;
	$skin = true;
	$datatable = true;
	
	include_once '_header.php';
	?>
<section class="breadcrumb">
	<div class="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Induction</a></li>
		</ul>
	</div>
</section>
<section class="courses-view">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="right-slide left">
					<h3 class="colorBlue">Induction Process</h3>
					<ul class="catagories-list cmsList">
						<?php
						
					
							$sql="select page_id,page_title,nav_title FROM cms_master WHERE is_policy=0 ORDER BY sort_order";
							$exec = $conn->Execute($sql);
							while($row = $exec->FetchRow())
							{ ?>
						
						<li <?php if($row['page_id'] == $page_id) echo "class='active'"; ?>>	
							<a <?php if(array_key_exists($row['page_id'],$_SESSION[SESSION_PREFIX.'pageViewed'])){print "class='listViewed'"; }print "class='notViewed'"; ?> <?php if($row['page_id'] == 7){ ?> href="employee_details.php"<?php }else if($row['page_id'] == 8){?> href="employee_documents.php" <?php }else if($row['page_id'] == 9){?> href="policies.php" <?php }else{?> href="induction.php?page_id=<?php print $row['page_id']; ?>" <?php } ?> ><?php print $row['nav_title']; ?></a>
							
						</li>
						<?php
							}
							?>
					
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<center><h3 class="pageTitle"><?php print $roww['page_title']; ?></h3></center>
						<div class="course-post">
							<?php echo getMsg('error'); ?>
							<div class="info contentBg">
								<div class="name">
									
									<form id="employee_docs"  class="inited" role="form" action="employee_documents_exec.php" method="post" enctype='multipart/form-data'>
										<div class="sc_contact_form_info">
										
											<?php 
											    $ids = array();
											    $ids_str = "";
												$sql="SELECT * FROM document_type_master WHERE is_active=1 ORDER BY sort_order";
												$exec = $conn->Execute($sql);
												$ctr = 1;
												while($result = $exec->FetchRow())
												{
													$ids[] = "filepond_".$result['document_type_id'];
																		
											?>
											
												<div class="col-sm-12 col-md-12">
													<label for="<?php echo $result['document_type_id']; ?>"><?php echo $result["document_type"]; ?></label>
													<input id="filepond_<?php echo $result['document_type_id']; ?>" class="filepond" multiple data-max-file-size="5MB" data-max-files="5" type="file" name="document_<?php echo $result['document_type_id']; ?>[]" >
												</div>
											
												<?php
													
												} 
												$ids_str = implode(",",$ids);
												
												?>
												
											<div class="sc_contact_form_item sc_contact_form_button">
												<center><button class="margin10">Upload Documents</button></center>
											</div>
										</div>
									</form>
									<p><a href="employee_details.php" class="prevButton">Prev</a><a href="policies.php" class="nextButton">Next</a></p>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div style="display:none;" class="row">
					<div class="col-sm-12 col-md-12">
						<center><h3 class="pageTitle">Uploaded Files</h3></center>
						<div class="course-post">
							<div class="info">
								<div class="name">
									<div class="table-responsive">
										<table id="example" class="display" cellspacing="0" width="100%">
											<thead>
											  <tr>
												<th class="text-center">S.No.</th>
												<th class="text-center">Document Type</th>
												<th class="text-center">File Name</th>
												<th class="text-center">Uploaded On</th>		
											  </tr>
											</thead>
											<tfoot>
											  <tr>
												<th class="text-center">S.No.</th>
												<th class="text-center">Document Type</th>
												<th class="text-center">File Name</th>
												<th class="text-center">Uploaded On</th>		
											  </tr>
											</tfoot>
											<tbody>
											<?php $sql = "SELECT ud.*,dtm.document_type FROM user_documents ud, document_type_master dtm WHERE ud.document_type_id=dtm.document_type_id AND ud.user_id=".$_SESSION[SESSION_PREFIX.'USER_ID']." ORDER BY user_document_id"; 
											$exec = $conn->Execute($sql);
											$ctr = 1;
											while($result = $exec->FetchRow())
											{
											?>
											<tr>
												<td class="text-center"><?php echo $ctr++; ?></td>
												<td class="text-center"><?php echo $result['document_type']; ?></td>
												<td class="text-center"><?php echo $result['orig_name']; ?></td>
												<td class="text-center"><?php echo date("d-m-Y H:i", strtotime($result['upload_date'])); ?></td>
												
											</tr>
											<?php } ?>
											</tbody>
										</table>
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</section>

<?php include '_footer.php';?>
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<link href="" rel="stylesheet">
<style>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
	color: #4c4e53;
}

.filepond--label-action {
	text-decoration-color: #babdc0;
}

.filepond--panel-root {
	border-radius: 2em;
	background-color: #edf0f4;
	height: 1em;
}

.filepond--item-panel {
	background-color: #595e68;
}

.filepond--drip-blob {
	background-color: #7f8a9a;
}

</style>
<script type="text/javascript" src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script>
/*
We want to preview images, so we need to register the Image Preview plugin
*/
FilePond.registerPlugin(
	
	// encodes the file as base64 data
  FilePondPluginFileEncode,
	
	// validates the size of the file
	FilePondPluginFileValidateSize,
	
	// corrects mobile image orientation
	FilePondPluginImageExifOrientation,
	
	// previews dropped images
  FilePondPluginImagePreview
);
var ids = <?php echo "'".$ids_str."'"; ?>;
console.log(ids);
var arrIds = ids.split(",");
// Select the file input and use create() to turn it into a pond
for(var id in arrIds){
	FilePond.create(
	document.querySelector("#"+arrIds[id])
);
}


</script>