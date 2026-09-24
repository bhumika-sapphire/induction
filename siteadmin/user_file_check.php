<?php
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = "manage_topics";
$material_setting = true;
include_once '_header.php';
$id=$_REQUEST['file_id'];
$sql="select * FROM user_files_upload_master where id=".$id;
$exec = $conn->Execute($sql);
$result = $exec->FetchRow();

?>


<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Check File</h1>
                <ol class="breadcrumb col-lg-10">
                    <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                    <li class="active"> <i class="fa fa-edit"></i> Check File </li>
                </ol>
                <a class="col-lg-2 breadcrumb " href="user_all_perfomance.php">Back</a>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">

            <p style="color:red">
                <?php echo getMsg('error'); ?>
            </p>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="topic_name">Download File</label>
                        <br>
                        <a class="btn btn-success" href="admin_download_user_file.php?file_path=<?php echo $result['file_path']; ?>&file_id=<?php echo $result['id'];  ?>">Download File</a>
                    </div>



                    <form action="user_file_check_exec.php" method="post" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label for="topic_name">Select Result</label>

                            <select required name="pass" id="pass" class="form-control">
                                <option value="">Please Select</option>
                                <option value="1" <?php if($result['is_pass']==1){ echo "selected"; } ?>>Pass</option>
                                <option value="0" <?php if($result['is_pass']==0){ echo "selected"; } ?>>Fail</option>
                                
                            </select>
                        
                        
                    </div>

                    <label for="is_active">Try Again</label>&nbsp;
                    <input type="checkbox" <?php if(isset($result['try_again']) && $result['try_again']==1) echo 'checked="checked"' ; ?>
                    name="try_again" value="1" id="try_again"><br><br>
                    <input type="hidden" name="file_id" value="<?php echo $id; ?>">
                    <button class="btn btn-default" type="submit">Submit</button>


                    </form>
                </div>
            

        </div>

    </div>
</div>
<!-- /.row -->

<!-- /.container-fluid -->


<?php include '_footer.php'; ?>