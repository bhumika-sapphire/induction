<?php 
	require_once('includes/startup.php');
	require_once('authenticate.php');

	if($mobile_device){ header('location:feature_info.php'); } 
include '_header.php'; ?>


<section id="content"> 
  <form method="POST" action="excel_exec.php" autocomplete="off" enctype="multipart/form-data">
    <fieldset>
     <div style="width:90%;float:left"><label>Upload File</label></div><div style="width:10%;float:left"><a href="javascript:history.back(1)"><label>Back</label></a></div>
     <div style="color:#892F2F !important; font-size:14px; text-align:center"><?php getMsg("error"); ?></div>
         <section>
 <label for="select_user">Select User</label>
    <div>
      <select name="recipient_id" id="recipient_id">
		<option>Select User</option>
         <?php 
		   if($_SESSION[SESSION_PREFIX.'USER_TYPE']=='Sub-Admin'){     
          $sql="select u.user_id, u.user_name, sac.client_id from user_master u, sub_admin_client_master sac where sac.client_id = u.user_id AND sac.sub_admin_id='".$_SESSION[SESSION_PREFIX.'ADMIN_ID']."' AND  u.user_type_id=2 AND u.is_active=1";
		  }
		  else
		  {
		  $sql="select user_id, user_name from user_master where user_type_id=2 and is_active=1";	  
		  }
		 $res=$conn->Execute($sql);
        while($row = $res->FetchRow())
        {
    ?>
        <option value="<?php print $row['user_id']; ?>"> <?php print $row['user_name']; ?></option>
        <?php } ?>
      </select>
    </div>
  </section>

<!--          <section> 
      <label for="Title">Client Name</label>
                <div>
          <input type="text" name="file_title" id="file_title" required data-errortext="Name Required!">
                </div>
         </section> -->
      <section>
		<label for="excel_file">Attach File</label>
				<div><input type="file" class="simple" name="excel_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

			</div>            

	  </section>

<!--          <section> 
      <label for="File Description">Job Description</label>
                <div>
           <textarea id="file_desc" class="html uniform" data-autogrow="true" name="file_desc" style="overflow: hidden; height: 70px;"></textarea>
                </div>
            </section> -->
      
   
      <section>  <!-------start section------------>
        <div>
          <button class="reset" onClick="window.location.reload();">Reset</button>
          <button type="submit" name="Submit" class="submit">Submit</button>
        </div>
      </section>
    </fieldset>
  </form>
</section>
<?php include '_footer.php'; ?>