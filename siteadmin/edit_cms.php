<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "cms";
$cms_setting = true;
$wysiwyg = true;

$page_id=$_REQUEST['page_id'];
$sql="select * FROM cms_master where page_id=".$page_id;
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
                <h1 class="page-header"> Edit Content Management System </h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Edit CMS</li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="cms.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_cms_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-12">
					<div class="form-group">
                        <label for = "nav_title">Navbar Title</label>
                        <input required type="text" class="form-control" name="nav_title" id="nav_title" value="<?php echo $row['nav_title']; ?>" >
                    </div>
					<div class="form-group">
                        <label for = "page_title">Page Title</label>
                        <input required type="text" class="form-control" name="page_title" id="page_title" value="<?php echo $row['page_title']; ?>" >
                    </div>
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                       <input required type="number" class="form-control" name="sort_order" id="sort_order" value="<?php echo $row['sort_order']; ?>" >
                    </div>
					<div class="form-group">
                        <label for = "page_content">Page Content</label>
                        <textarea class="form-control wysiwyg" name="page_content" id="page_content" ><?php echo $row['page_content']; ?></textarea>
                    </div>
					
					<div class="form-group">
						<input type="hidden" name="page_id" id="page_id" value="<?php echo $row['page_id']; ?>" >
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