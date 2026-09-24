<?php 
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once('restrict_employee.php');
	$page_name="manage_Stores";
	include '_header.php'; ?>
<section id="content">
<form>
    <fieldset>
        <div  style="width:100%;float:left"><label>Manage Outbox </label></div><div style="width:20%;float:left"> 
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
          <th style="width:20%">Client Name</th>
          <th style="width:30%">Job Description</th> 
          <th style="width:15%">Upload Date</th>
          <th style="width:15%">Budget Description</th>
          <?php if(!$mobile_device){ ?> <th style="width:15%">Download</th><?php } ?>
          <th style="width:10%">Edit</th>
          <th style="width:10%">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
			 $sql="select u.user_name,f.*,sm.* from user_master as u,file_master as f,status_master as sm WHERE u.user_id=f.user_id AND f.status_id = sm.status_id AND f.recipient_id=1 AND f.user_id=".$_SESSION[SESSION_PREFIX.'ADMIN_ID']."  order by f.upload_date desc";
        $res=$conn->Execute($sql);
			  $ctr=1;
				while($data=$res->FetchRow()){
				?>
        &nbsp;
        <tr class="gradeX">
         <td><?php print $ctr; ?></td>
          <td><?php print $data['file_id']; ?></td>
         <td><?php print $data['file_title']; ?></td>
         <td><?php print $data['file_desc']; ?></td>
         <td><?php print date("d-m-Y H:i:s",strtotime($data['upload_date'])); ?></td>
         <td>
          <table width="100%">
            <?php 
            if($data['status_id'] == 2)
            {
              ?>
              <tr>
                 <td align="left">
                  TAT DATE
                </td>
                <td>
                  <?php print $data['job_tat']; ?>
                </td>
              </tr>
              <?php
            }
            else if($data['status_id'] == 3)
            {
              ?>
                <tr>
                   <td align="left">
                    TAT DATE
                  </td>
                  <td>
                    <?php print $data['job_tat']; ?>
                  </td>
                </tr>
              <?php

            }
            else if($data['status_id'] == 4)
            {
              ?>
                <tr>
                   <td align="left">
                    TAT DATE
                  </td>
                  <td>
                    <?php print $data['job_tat']; ?>
                  </td>
                </tr>
              <?php
            }

            ?>
            
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
         <?php if(!$mobile_device){ ?> <td class="c">
		  <?php 
				$sql_file="SELECT file_name FROM file_detail_master WHERE file_id = ".$data['file_id']." ORDER BY file_name";
				$res_file=$conn->Execute($sql_file);
				while($file=$res_file->FetchRow()) {
		  ?>
		  <a class="btn i_download" href="download.php?file=<?php print $file['file_name']; ?>" title="<?php echo $file['file_name'];?>" style="clear:both;"></a>
		  <?php }?>
		  </td><?php } ?>
       <td>
        <?php 
         if($data['status_id'] == 5){

          ?>
          <form id="form" action="client_edit_budget_exec.php" method="POST" autocomplete="off">
          <input type="hidden" id="job_budget_sapphire" name="job_budget_sapphire" value="<?php echo $data['job_budget_sapphire']; ?>" >
          <input type="hidden" name="file_id" id="file_id" value="<?php echo $data['file_id']; ?>">
         <button class="submit">Approve Budget</button>
          </form>

          <?php

         }

         ?>
     <!--  <form id="form" action="client_edit_budget_exec.php" method="POST" autocomplete="off">
        <input type="hidden" id="job_budget_sapphire" name="job_budget_sapphire" value="<?php echo $data['job_budget_sapphire']; ?>">
        <input type="hidden" name="file_id" id="file_id" value="<?php echo  $data['file_id']; ?>">
       <button class="submit">Approve Budget</button>
      </form> -->
      </td>
          <td class="c">
            <a class="btn i_access_denied" href="client_delete_file_outbox.php?file_id=<?php print $data['file_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this File  ?');"></a>
          </td>
        </tr>
        <?php $ctr++; }?>
      </tbody>
    </table>
</section>
<?php include '_footer.php'; ?>