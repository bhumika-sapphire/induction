<?php
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_chapters';
$material_setting = true;

$chapter_id=$_REQUEST['chapter_id'];
$sql="select * FROM chapter_master where chapter_id=".$chapter_id;
$exec = $conn->Execute($sql);
$result = $exec->FetchRow();
include_once '_header.php';
?>


<div id="page-wrapper">
  <div class="container-fluid"> 
    
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Edit Chapter</h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-edit"></i> Edit Chapter </li>
        </ol>
        <a class="col-lg-2 breadcrumb " href="manage_chapters.php">Back</a>
      </div>
    </div>
    <!-- /.row -->
    
     <div class="row">

            <p style="color:red"><?php echo getMsg('error'); ?></p>
            <form role="form" action="edit_chapter_exec.php" method="post"  enctype='multipart/form-data'>
                <div class="col-lg-6">
                    					
					<div class="form-group">
						 <label>Topic Name</label>
						<?php $sql="select * from topic_master WHERE is_active = 1 order by topic_id";
                         $exec = $conn->Execute($sql);  ?>
						<select required name="topic_id" id="topic_id" class="form-control" >
						<option value="">Select Topic</option>
						<?php while($row=$exec->FetchRow()) { ?>
						<option value="<?php echo $row['topic_id']; ?>"  <?php if(isset($result['topic_id']) && 
						$result['topic_id']==$row['topic_id']) { echo 'selected'; } ?> ><?php echo $row['topic_name']; ?></option>
						<?php } ?>
						</select>
                    </div>
					
					<div class="form-group">
                        <label for = "chapter_name">Chapter Name</label>
                        <input required type="text" class="form-control" value="<?php if(isset($result['chapter_name'])) echo $result['chapter_name']; ?>" name="chapter_name" id="chapter_name" >
                    </div>
					
					<div class="form-group">
                        <label for = "sort_order">Sort Order</label>
                        <input required type="number" class="form-control" value="<?php if(isset($result['sort_order'])) echo $result['sort_order']; ?>" name="sort_order" id="sort_order" >
                    </div>
					
               				
										
					<div class="form-group">
                        <label for = "is_active">Is Active</label>&nbsp;
                        <input type="checkbox" <?php if(isset($result['is_active']) && $result['is_active']==1) echo 'checked="checked"'; ?>  name="is_active" value="1" id="is_active"><br>
						<button class="btn btn-default" type="submit">Submit</button>
                    </div>
					<input type="hidden" value="<?php echo $result["chapter_id"];?>" id="chapter_id" name="chapter_id" />
                    
                </div>
            </form>
<br> &nbsp; 
        </div>
		
      </div>
    </div>
    <!-- /.row --> 
      
  <!-- /.container-fluid --> 
  

<?php include '_footer.php'; ?>