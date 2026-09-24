<?php 
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once('restrict_employee.php');
	$page_name="manage_Stores";
	include '_header.php'; ?>
<section id="content">
<form>
    <fieldset>
        <div  style="width:100%;float:left"><label>Manage Inbox </label></div><div style="width:20%;float:left"> 
          </div>
    </fieldset>
</form>
<p align="center"><?php print getMsg('error'); ?></p>
<br />
    <table class="datatable">
      <thead>
        <tr>
           <th style="width:10%">S.No.</th>
           <th style="width:5%">Job.id</th>
          <th style="width:30%">Client Name</th>
          <th style="width:30%">Job Description</th> 
          <th style="width:15%">Upload Date</th>
          <?php if(!$mobile_device){ ?><th style="width:15%">Download</th><?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
			 $sql="select u.user_name,f.file_id,f.recipient_id,f.file_title,f.file_desc,f.upload_date,f.file_name from user_master as u,file_master as f where u.user_id=f.recipient_id AND f.recipient_id=".$_SESSION[SESSION_PREFIX.'ADMIN_ID']."  order by f.upload_date desc";
              $res=$conn->Execute($sql);
			  $ctr=1;
				while($data=$res->FetchRow()){
				?>
        <tr class="gradeX">
          <td><?php print $ctr; ?></td>
           <td><?php print $data['file_id']; ?></td>
         <td><?php print $data['file_title']; ?></td>
         <td><?php print $data['file_desc']; ?></td>
         <td><?php print date("d-m-Y H:i:s",strtotime($data['upload_date'])); ?></td>
        <?php if(!$mobile_device){ ?>  <td class="c">
		  <?php 
				$sql_file="SELECT file_name FROM file_detail_master WHERE file_id = ".$data['file_id']." ORDER BY file_name";
				$res_file=$conn->Execute($sql_file);
				while($file=$res_file->FetchRow()) {
		  ?>
		  
		  <a class="btn i_download" href="download.php?file=<?php print $file['file_name']; ?>" title="<?php echo $file['file_name'];?>" style="clear:both" ></a>
		  
		  <?php }?>
		  </td> <?php } ?>
        <?php $ctr++;  }?>
      </tbody>
    </table>
</section>
<?php include '_footer.php'; ?>