<?php
include_once '../includes/startup.php';
include_once 'authenticate.php';
$page = "manage_topics";
$material_setting = true;
include_once '_header.php';
?>

<div id="page-wrapper">
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Add Topic</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Add Topic </li>
                </ol>
                <a class="col-lg-2 breadcrumb" href="manage_topics.php">Back</a>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="add_topic_exec.php" method="post" enctype='multipart/form-data'>
                <div class="col-lg-6">
                    
					<div class="form-group">
                        <label for = "topic_name">Topic</label>
                        <input required type="text" class="form-control" name="topic_name" id="topic_name" >
                    </div>

                      <div class="form-group">
                    <label for = "material_file">Round 1</label>
                    <input type="file" class="form-control" name="files[]" id="option_1"/>
                    </div>

                    <div class="form-group">
                    <label for = "material_file">Round 2</label>
                    <input type="file" class="form-control" name="files[]" id="option_2" />
                    </div>


                    <div class="form-group">
                    <label for = "material_file">Round 3</label>
                    <input type="file" class="form-control" name="files[]" id="option_3" />
                    </div>

					
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                        <input required type="number" class="form-control" name="sort_order" id="sort_order" >
                    </div>
					<div class="form-group">
                        <label for = "is_communication">Is Communication</label>&nbsp;
                        <input type="checkbox" name="is_communication" value="1" id="is_communication"><br>
                    </div>
                    <div class="form-group">
                        <label for = "file_test">Files Test</label>&nbsp;
                        <input type="checkbox" name="file_test" value="1" id="file_test"><br>
                    </div>
                    <button class="btn btn-default" type="submit">Submit</button>
                    <button class="btn btn-default" type="reset">Reset </button>
                </div>					

            </form>

        </div>
        <!-- /.row --> 
        <br/>
    </div>
    <!-- /.container-fluid --> 

</div>
<?php include '_footer.php'; ?>