<?php 
	require_once('includes/startup.php');
	require_once('authenticate.php');
	require_once('restrict_employee.php');
	$page_name="Client";
 	$tmp = time();
	if($mobile_device){ header('location:feature_info.php'); } 
include '_header.php'; ?>
<script>
$(document).ready(function() {
	$("#recipient_id").change(function() {
		var recipient_id = $(this).val();
		window.location.href = "send_file.php?recipient_id="+recipient_id;
		//var result = "";
		
		//result +='upload.php?recipient_id=' + recipient_id + '&tmp=<?php print $tmp; ?>';
		//$("#file_upload_multiple").attr("data-url",result);
		//alert(result);
	});
});
</script>

<section id="content"> 
  <form id="form" action="send_file_exec.php" method="post" autocomplete="off" enctype="multipart/form-data">
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

         <section> 
      <label for="Title">Client Name</label>
                <div>
          <input type="text" name="file_title" id="file_title" required data-errortext="Name Required!">
                </div>
         </section>
      <section>
		<label for="file_upload_multiple">Attach File</label>
				<div><input type="file" data-url="admin_upload.php?tmp=<?php print $tmp."&recipient_id=".$_REQUEST['recipient_id']; ?>" id="file_upload_multiple" required data-errortext="File Required!" name="file_upload_multiple" multiple>
				<input type="hidden" id="tmp" name="tmp" value="<?php print $tmp; ?>">
			</div>            
	  </section>

         <section> 
      <label for="File Description">Job Description</label>
                <div>
           <textarea id="file_desc" class="html uniform" data-autogrow="true" name="file_desc" style="overflow: hidden; height: 70px;"></textarea>
                </div>
            </section>
      
   
      <section>  <!-------start section------------>
        <div>
          <button class="reset">Reset</button>
          <button class="submit">Upload</button>
        </div>
      </section>
    </fieldset>
  </form>
</section>
<script>
$(document).ready(function() {
var auto_response = "";

var user_id = $('#recipient_id').val();
if(!isNaN(user_id)){
 $.ajax({
            url: 'clientQuery.php',
            data: {user_id:user_id},
			success: function (response){
				response = $.parseJSON(response);
				auto_response = response;
				$("#file_title").wl_Autocomplete({source:response});
			}
        });
}
$( document ).delegate( "#form", "submit", function(e) {
	
	var val = $('#file_title').val();
	console.log(val);
	if($.inArray( val, auto_response ) != -1)
	{
		console.log("Yes");
	}
	else
	{
		$('#overlay').fadeOut(0);
		if(confirm("Do you want to use custom text for Client Name?"))
		{
			console.log("Accepted");
		}
		else{
			e.preventDefault();
			console.log("Rejected");
			return false;
		}
	}
	
	//console.log("Stopping form!");
	//return false;
});

	
});
</script>
<?php include '_footer.php'; ?>