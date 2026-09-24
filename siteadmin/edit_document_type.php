<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "document_type";
$datatable = true;
$doc_setting = true;

$document_type_id=$_REQUEST['document_type_id'];
$sql="select * FROM document_type_master where document_type_id=".$document_type_id;
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
                <h1 class="page-header"> Edit Document Type </h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Edit Document Type</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="document_type.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_document_type_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					
					<div class="form-group">
                        <label for = "document_type">Document Type</label>
                        <input required type="text" class="form-control" name="document_type" id="document_type" value="<?php echo $row['document_type']; ?>" >
                    </div>
					<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($row['is_active']) && $row['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active">
                    </div>
										
                </div>
				<div class="col-lg-6">
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                       <input required type="number" class="form-control" name="sort_order" id="sort_order" value="<?php echo $row['sort_order']; ?>" >
                    </div>
					
					<div class="form-group">
						<input type="hidden" name="document_type_id" id="document_type_id" value="<?php echo $row['document_type_id']; ?>" >
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
<?php include '_footer.php'; ?>