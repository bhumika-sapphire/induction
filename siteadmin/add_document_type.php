<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "document_type";
$doc_setting = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Add Document Type</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add Document Type</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="document_type.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form"  action="add_document_type_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
					<div class="form-group">
                        <label for = "document_type">Document Type</label>
                        <input required type="text" class="form-control" name="document_type" id="document_type" >
                    </div>
                </div>
				<div class="col-lg-6">
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                       <input required type="number" class="form-control" name="sort_order" id="sort_order" value="1" >
                    </div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
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