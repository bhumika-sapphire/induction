<?php 
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once('restrict_employee.php');
	$page_name="holiday_calendar";
	include '_header.php'; ?>
<section id="content">
<form>
    <fieldset>
        <div  style="width:100%;float:left"><label>Manage Inbox </label></div><div style="width:20%;float:left"> 
          </div>
    </fieldset>
</form>
<p align="center"><?php print getMsg('error'); ?></p><table class="datatable">
      <thead>
        <tr>
          <th style="width:10%">S.No.</th>
          <th style="width:10%">Job.id</th>
          <th style="width:15%">User Name</th>
          <th style="width:10%">Client Name</th>
          <th style="width:15%">Job Description</th> 
          <th style="width:15%">Date</th>
          <th style="width:15%">Budget Description</th>
          <th style="width:10%">TAT Extension</th>
       <?php 
          if(!$mobile_device)
          { 
            ?>
            <th style="width:15%">Download</th> 
          <?php 
          } 
         ?>
         <?php 
         if($_SESSION[SESSION_PREFIX.'USER_TYPE']!='Sub-Admin')
          { 
            ?>    
           		<!-- 	<th style="width:10%">Edit</th>     
          		 <th style="width:10%">Delete</th> -->
               <th width="20%">Action</th>
           <?php 
          }else if($_SESSION[SESSION_PREFIX.'USER_TYPE']=='Sub-Admin'){
            ?>

            <th width="20%">Edit</th>
            <?php
          } 
        ?>
        </tr>
      </thead>
      <tbody>
        <?php
/* $sql="SELECT u.user_name,f.file_id,f.file_title,f.file_desc,f.upload_date,f.file_name
FROM user_master AS u,file_master AS f
WHERE u.user_id=f.user_id AND f.recipient_id=1
ORDER BY f.upload_date DESC";*/
			 if($_SESSION[SESSION_PREFIX.'USER_TYPE']=='Sub-Admin'){
				 
				 
				 // Get client_id, implode and create a comma sep string of ids ($str)
				 
				/* $sql="SELECT u.user_name,f.file_id,f.file_title,f.file_desc,f.upload_date
				FROM user_master AS u,file_master AS f
				WHERE u.user_id=f.user_id AND f.recipient_id=1 AND f.user_id IN ($str)
				ORDER BY f.upload_date DESC"; */ 
				$sql="SELECT u.user_name,f.file_id,f.file_title,f.file_desc,f.upload_date,f.job_tat,
        f.job_budget_client,f.job_budget_sapphire,f.job_start_date,f.job_tat_date,f.job_tat_date_original,f.tat_flag,sm.status_title
				FROM status_master as sm, user_master AS u,file_master AS f, sub_admin_client_master AS sac
				WHERE u.user_id=f.user_id AND f.status_id = sm.status_id AND f.recipient_id=1 AND f.user_id = sac.client_id AND sac.sub_admin_id ='".$_SESSION[SESSION_PREFIX.'ADMIN_ID']."' AND f.status_id!=8
				ORDER BY f.upload_date DESC"; 
				
			 }
			 else
			 {
			$sql="SELECT u.user_name,f.file_id,f.*,sm.* FROM status_master as sm, user_master AS u,file_master AS f WHERE u.user_id=f.user_id AND f.status_id = sm.status_id AND f.recipient_id=1 AND f.status_id!=8 ORDER BY f.upload_date DESC";
			 }
      $res=$conn->Execute($sql);
			$ctr=1;
			while($data=$res->FetchRow()){
				?>
        <tr class="gradeX">
        <td><?php print $ctr; ?></td>
        <td><?php print $data['file_id']; ?></td>
         <td><?php print $data['user_name']; ?></td>
         <td><?php print $data['file_title']; ?></td>
         <td><?php print $data['file_desc']; ?></td>
         <td>

          <table width="100%">
            <tr>
              <td>Start Date</td>
              <td><?php 
              if(isset($data['job_start_date']) && $data['job_start_date']!=""){
              print date("d-m-Y",strtotime($data['job_start_date'])); }
              ?>
              </td>
            </tr>
             <tr <?php if($data['tat_flag'] == 1){echo 'class="remark_date"';} ?>>
              <td>TAT Date</td>
              <td>
              <?php 
              if(isset($data['job_tat_date']) && $data['job_tat_date']!=""){
                 print date("d-m-Y",strtotime($data['job_tat_date'])); 
              }
             ?>
              </td>
            </tr>
            <tr>
              <td>Original Date</td>
              <td>
              <?php
              if(isset($data['job_tat_date_original']) && $data['job_tat_date_original']!=""){
              print date("d-m-Y",strtotime($data['job_tat_date_original']));
              }
               ?>
              </td>
            </tr>
             <tr>
              <td>Upload Date</td>
              <td><?php print date("d-m-Y H:i:s",strtotime($data['upload_date'])); ?>
              </td>
            </tr>
          </table>
          </td>
         <td>
          <table width="100%">
            <tr>
               <td align="left">
                TAT (Days) :
              </td>
              <td>
                <?php print $data['job_tat']; ?>
              </td>
            </tr>
           <tr>
               <td>
                Client Budget:
              </td>
              <td>
                <?php print $data['job_budget_client']; ?>
              </td>
            </tr>
            <tr>
               <td>
                Sapphire Budget:
              </td>
              <td>
                <?php print $data['job_budget_sapphire']; ?>
              </td>
            </tr>
            <tr>
               <td>
                Status:
              </td>
              <td>
               <?php print $data['status_title']; ?>
              </td>
            </tr>
          </table>
        </td>
          <td>
            <?php if($data['tat_flag'] == 1){
              ?>
              <a href="edit_tat_extension.php?file_id=<?php print $data['file_id'];?>" class="btn" title="Edit">TAT Extension</a>
              <?php

            } 
            if($data['job_tat_date'] == $data['job_tat_date_original']){
               ?>
              <a href="edit_tat_extension.php?file_id=<?php print $data['file_id'];?>" class="btn" title="Edit" style="display:none;">TAT Extension</a>
              <?php

            }?>
            
            </td>
		  <?php if(!$mobile_device){ ?>
		  <td class="c" width="15%">
		  <?php 
				$sql_file="SELECT file_name FROM file_detail_master WHERE file_id = ".$data['file_id']." ORDER BY file_name";
				$res_file=$conn->Execute($sql_file);
				while($file=$res_file->FetchRow()) {
		  ?>
		  
		  <a class="btn i_download" href="download.php?file=<?php print $file['file_name']; ?>" title="<?php echo $file['file_name'];?>" style="clear:both" ></a>
		  
		  <?php }?>
		  </td>
		  <?php }?>
		  <td>
          <a href="edit_inbox.php?file_id=<?php print $data['file_id'];?>" class="btn i_pencil" title="Edit"></a>&nbsp;
          <?php if($_SESSION[SESSION_PREFIX.'USER_TYPE']!='Sub-Admin'){ ?>
        <a class="btn i_access_denied" href="delete_file.php?source=inbox&file_id=<?php print $data['file_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this file?');" ></a>
        <?php } ?>
        </td>
			   </tr>
        <?php $ctr++; } ?>
      </tbody>
    </table>
</section>
<?php include '_footer.php'; ?>