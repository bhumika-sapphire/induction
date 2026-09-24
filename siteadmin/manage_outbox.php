<?php 
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once('restrict_employee.php');
	$page_name="manage_Stores";
	include '_header.php'; ?>
<section id="content">
<form>
    <fieldset>
        <div><label>Manage Outbox </label></div>
    </fieldset>
</form>
<p align="center"><?php print getMsg('error'); ?></p><table class="datatable">
      <thead>
        <tr>
        <th style="width:5%">S.No.</th>
        <th style="width:5%">Job.id</th>
          <th style="width:10%">User Name</th>
          <th style="width:15%">Client Name</th>
          <th style="width:15%">Job Description</th>
		  <th style="width:15%">Upload Date</th>
          <th style="width:15%">Uploaded By</th>
         <?php if(!$mobile_device){ ?>   <th style="width:15%">Download</th>  <?php } ?>
           <?php if($_SESSION[SESSION_PREFIX.'USER_TYPE']!='Sub-Admin'){ ?>  
		  <th style="width:10%">Delete</th>
		   <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
		$ctr=1;
		if($_SESSION[SESSION_PREFIX.'USER_TYPE']=='Sub-Admin'){
	 $sql="select u.user_name,f.file_id,f.file_title,f.file_desc,f.upload_date,f.uploaded_by_name from user_master as u,file_master as f,sub_admin_client_master AS sac where u.user_id=f.recipient_id AND u.user_type_id=2 AND u.user_id = sac.client_id AND sac.sub_admin_id ='".$_SESSION[SESSION_PREFIX.'ADMIN_ID']."' order by f.upload_date desc";
		
		}
		else
		
		{
			 $sql="select u.user_name,f.file_id,f.file_title,f.file_desc,f.upload_date,f.uploaded_by_name from user_master as u,file_master as f where u.user_id=f.recipient_id AND u.user_type_id=2  order by f.upload_date desc";
		}
              $res=$conn->Execute($sql);
				while($data=$res->FetchRow()){
				?>
               
        <tr class="gradeX">
          <td><?php print $ctr; ?></td>
           <td><?php print $data['file_id']; ?></td>
         <td><?php print $data['user_name']; ?></td>
         <td><?php print $data['file_title']; ?></td>
         <td><?php print $data['file_desc']; ?></td>
         <td><?php print date("d-m-Y H:i:s",strtotime($data['upload_date'])); ?></td>
		 <td><?php print $data['uploaded_by_name']; ?></td>
		 
          <?php if(!$mobile_device){ ?>
		  <td class="c">
		  <?php 
				$sql_file="SELECT file_name FROM file_detail_master WHERE file_id = ".$data['file_id']." ORDER BY file_name";
				$res_file=$conn->Execute($sql_file);
				while($file=$res_file->FetchRow()) {
		  ?>
		  
		  <a class="btn i_download" href="download.php?file=<?php print $file['file_name']; ?>" title="<?php echo $file['file_name'];?>" ></a>
		  
		  <?php }?>
		  </td>
		  <?php } ?>
           <?php if($_SESSION[SESSION_PREFIX.'USER_TYPE']!='Sub-Admin'){ ?>  
		  <td class="c"><a class="btn i_access_denied" href="delete_file.php?source=outbox&file_id=<?php print $data['file_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this file?');"></a></td>
		   <?php } ?>
        </tr>
        <?php $ctr++; }?>
      </tbody>
    </table>
</section>
<?php include '_footer.php'; ?>