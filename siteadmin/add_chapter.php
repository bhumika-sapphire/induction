<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = 'manage_chapters';
$material_setting = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Add Chapter</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add Chapter </li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_chapters.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="add_chapter_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
                    				
					<div class="form-group">
                        <label for = "topic_id">Topic Name</label>
						<?php
						$sql="select * from topic_master WHERE is_active = 1 order by sort_order";
						$exec = $conn->Execute($sql);?>
						<select required name="topic_id" id="topic_id" class="form-control" >
						<option value="">Select Topic</option>
						<?php while($row=$exec->FetchRow()) {?>
						<option value="<?php echo $row['topic_id']; ?>"><?php echo $row['topic_name']; ?></option>
						<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
                        <label for = "chapter_name">Chapter Name</label>
                        <input required type="text" class="form-control" name="chapter_name" id="chapter_name" >
                    </div>


                  
					
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                        <input required type="number" class="form-control" name="sort_order" id="sort_order" >
                    </div>

                   
             
					
					<div class="form-group">
                        
						<button class="btn btn-default" type="submit">Submit</button>
						<button class="btn btn-default" type="reset">Reset </button>
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