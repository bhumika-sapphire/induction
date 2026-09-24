<?php 
include_once('../includes/startup.php');
require_once 'authenticate.php';
$page = 'manage_users';
$user_setting = true;
$datatable = true;
include '_header.php';
$user_id = $_REQUEST['user_id'];
?>
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12" >
                        <h1 class="page-header">User Documents</h1>
						<ol class="breadcrumb col-lg-10">
						  <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
						  <li class="active"> <i class="fa fa-table"></i> User Documents</li>
						  
						</ol>
						<a class="col-lg-2 breadcrumb" href="manage_users.php" >Back</a>
                    </div>
              </div>
			
                <div class="row">
					<div class="col-sm-12 col-md-12">
						<center><h3 class="pageTitle">Uploaded Files</h3></center>
							<div class="table-responsive">
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
									  <tr>
										<th class="text-center">S.No.</th>
										<th class="text-center">Document Type</th>
										<th class="text-center">File Name</th>
										<th class="text-center">Uploaded On</th>		
										<th class="text-center">Download</th>		
										<th class="text-center">Delete</th>		
									  </tr>
									</thead>
									<tfoot>
									  <tr>
										<th class="text-center">S.No.</th>
										<th class="text-center">Document Type</th>
										<th class="text-center">File Name</th>
										<th class="text-center">Uploaded On</th>		
										<th class="text-center">Download</th>		
										<th class="text-center">Delete</th>		
									  </tr>
									</tfoot>
									<tbody>
									<?php $sql = "SELECT ud.*,dtm.document_type FROM user_documents ud, document_type_master dtm WHERE ud.document_type_id=dtm.document_type_id AND ud.user_id=".$user_id." ORDER BY user_document_id"; 
									
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
										<td  class="text-center"><a href="../uploads/documents/<?php echo $result["file_name"];?>" download rel="noopener noreferrer" target="_blank" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Downoad</button></a></td>
										<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document?')" href="delete_doc.php?user_document_id=<?php echo $result["user_document_id"];?>&user_id=<?php echo $user_id;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
									</tr>
									<?php 
									
									}
										
									$userDetailsTable = "SELECT * FROM user_details WHERE user_id =".$user_id;
									$execccc = $conn->Execute($userDetailsTable);
									$values = $execccc->FetchRow();
										
										if (isset($values['address_copy']) && $values['address_copy'] != "") {
									
									?>
										<tr>
											<td class="text-center"><?php echo $ctr++; ?></td>
											<td class="text-center"> Permanent Address Copy </td>
											<td class="text-center"><?php echo $values['address_copy']; ?></td>
											<td class="text-center"> Not Available </td>
											
											<td  class="text-center"><a href="../uploads/employeeDetails/<?php echo $values["address_copy"];?>" download rel="noopener noreferrer" target="_blank" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Downoad</button></a></td>
											<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document?')" href="delete_detail_doc.php?user_document_id=address_copy&user_id=<?php echo $user_id;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
										</tr>
									<?php
										}
										if (isset($values['pan_copy']) && $values['pan_copy'] != "") {
									?>
										<tr>
											<td class="text-center"><?php echo $ctr++; ?></td>
											<td class="text-center"> PAN Card Copy </td>
											<td class="text-center"><?php echo $values['pan_copy']; ?></td>
											<td class="text-center"> Not Available </td>
											
											<td  class="text-center"><a href="../uploads/employeeDetails/<?php echo $values["pan_copy"];?>" download rel="noopener noreferrer" target="_blank" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Downoad</button></a></td>
											<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document?')" href="delete_detail_doc.php?user_document_id=pan_copy&user_id=<?php echo $user_id;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
										</tr>
									<?php 
										}
										if (isset($values['adhar_copy']) && $values['adhar_copy'] != "") {
									?>
										<tr>
											<td class="text-center"><?php echo $ctr++; ?></td>
											<td class="text-center"> Adhar Card Copy </td>
											<td class="text-center"><?php echo $values['adhar_copy']; ?></td>
											<td class="text-center"> Not Available </td>
											
											<td  class="text-center"><a href="../uploads/employeeDetails/<?php echo $values["adhar_copy"];?>" download rel="noopener noreferrer" target="_blank" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Downoad</button></a></td>
											<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document?')" href="delete_detail_doc.php?user_document_id=adhar_copy&user_id=<?php echo $user_id;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
										</tr>
									<?php 
									}
									?>
									<?php 
										if (isset($values['passbook_copy']) && $values['passbook_copy'] != "") {
									?>
										<tr>
											<td class="text-center"><?php echo $ctr++; ?></td>
											<td class="text-center"> Passbook Copy </td>
											<td class="text-center"><?php echo $values['passbook_copy']; ?></td>
											<td class="text-center"> Not Available </td>
											
											<td  class="text-center"><a href="../uploads/employeeDetails/<?php echo $values["passbook_copy"];?>" download rel="noopener noreferrer" target="_blank" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Downoad</button></a></td>
											<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document?')" href="delete_detail_doc.php?user_document_id=passbook_copy&user_id=<?php echo $user_id;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
										</tr>
									<?php 
									}
									?>
									<?php 
										if (isset($values['profile_pic']) && $values['profile_pic'] != "") {
									?>
										<tr>
											<td class="text-center"><?php echo $ctr++; ?></td>
											<td class="text-center"> Profile Picture </td>
											<td class="text-center"><?php echo $values['profile_pic']; ?></td>
											<td class="text-center"> Not Available </td>
											
											<td  class="text-center"><a href="../uploads/employeeDetails/<?php echo $values["profile_pic"];?>" download rel="noopener noreferrer" target="_blank" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Downoad</button></a></td>
											<td  class="text-center"><a onclick="return confirm('Are you sure you want to delete this Document?')" href="delete_detail_doc.php?user_document_id=profile_pic&user_id=<?php echo $user_id;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>
										</tr>
									<?php 
									}
									?>
									
										
									</tbody>
								</table>
							</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<center><h3 class="pageTitle">Upload Documents</h3></center>
						<div class="course-post">
							<div class="info contentBg">
								<div class="name">
									
									<form id="employee_docs"  class="inited" role="form" action="upload_docs_exec.php" method="post" enctype='multipart/form-data'>
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
												
											<div class="result sc_infobox"></div>
											<div class="sc_contact_form_item sc_contact_form_button">
												<input type="hidden" id="userID" name="userID" value="<?php echo $user_id; ?>">
												<center><button>Upload Documents</button></center>
											</div>
											<div class="result sc_infobox"></div>
										</div>
									</form>
								
								</div>
							</div>	
						</div>
					</div>
				</div>
				
			</div>
        </div>
            <!-- /.container-fluid -->  
        <!-- /#page-wrapper -->
    </div>


<?php include '_footer.php'; ?>

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