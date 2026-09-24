<?php
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = "manage_topics";
$material_setting = true;
include_once '_header.php';
$topic_id=$_REQUEST['topic_id'];
$sql="select * FROM topic_master where topic_id=".$topic_id;
$exec = $conn->Execute($sql);
$result = $exec->FetchRow();

?>


<div id="page-wrapper">
  <div class="container-fluid"> 
    
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Edit Topic</h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-edit"></i> Edit Topic </li>
        </ol>
        <a class="col-lg-2 breadcrumb " href="manage_topics.php">Back</a>
      </div>
    </div>
    <!-- /.row -->
    
     <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_topic_exec.php" method="post"  enctype='multipart/form-data'>
                <div class="col-lg-6">
                    
					<div class="form-group">
                        <label for = "topic_name">Topic</label>
                        <input required type="text" class="form-control" value="<?php if(isset($result['topic_name'])) echo $result['topic_name']; ?>" name="topic_name" id="topic_name" >
                    </div>

                    <?php
                    $file_data= array();
                    $ctr="";
                   $sql_1="select id,file_name from user_files_master where topic_id=".$topic_id;
                    $exec1 = $conn->Execute($sql_1);
                    if($exec1->RowCount() >0)
                    {



                    while($row = $exec1->FetchRow()){
                      $ctr++;
                      ?>

                    <div class="form-group">
                    <label for = "material_file">Round <?php echo $ctr; ?></label>
                    <input type="file" class="form-control" name="files[<?php echo $row['id'] ?>]" id="option_1"/>
                    <p style="color:red"><?php echo $row['file_name'] ?></p>
                    </div>
                    <?php
                    }
                    }
                    else{
                    ?>

                    <div class="form-group">
                    <label for = "material_file">Round 1</label>
                    <input type="file" class="form-control" name="files[1]" id="option_1"/>
                    </div>

                    <div class="form-group">
                    <label for = "material_file">Round 2</label>
                    <input type="file" class="form-control" name="files[2]" id="option_2" />
                    </div>


                    <div class="form-group">
                    <label for = "material_file">Round 3</label>
                    <input type="file" class="form-control" name="files[3]" id="option_3" />
                    </div>
                      <input type="hidden" name="insert_files" value="1">

                   <?php } ?>

					
					          <div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                        <input required type="number" class="form-control" value="<?php if(isset($result['sort_order'])) echo $result['sort_order']; ?>" name="sort_order" id="sort_order" >
                    </div>
					          <div class="form-group">
                        <label for = "is_communication">Is Communication</label>&nbsp;
                        <input type="checkbox" <?php if(isset($result['is_communication']) && $result['is_communication']==1) echo 'checked="checked"'; ?>  name="is_communication" value="1" id="is_communication"><br>
						          <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($result['is_active']) && $result['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active">
                    </div>

                     <div class="form-group">
                        <label for = "file_test">Files Test</label>&nbsp;
                        <input type="checkbox" name="file_test" <?php if(isset($result['file_test']) && $result['file_test']==1) echo 'checked="checked"'; ?> value="1" id="file_test"><br>
                    </div>
					            <input type="hidden" value="<?php echo $result["topic_id"];?>" id="topic_id" name="topic_id" />
                    <button class="btn btn-default" type="submit">Submit</button>
                </div>					
            </form>

        </div>
		
      </div>
    </div>
    <!-- /.row --> 
      
  <!-- /.container-fluid --> 
  

<?php include '_footer.php'; ?>