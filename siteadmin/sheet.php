<?php
require_once('includes/startup.php');
	require_once('authenticate.php');

$value="VAT";
 $sql="select job_type from job_type_master where job_type='".$value."' ";

 $id=$_SESSION[SESSION_PREFIX.'ADMIN_ID'];
 echo $id;
;
$res=$conn->Execute($sql);

        while($row = $res->FetchRow())
        {
        	echo $row['job_type'];
        }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Excel Uploading PHP</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>


<div class="container">
	<h1>Excel Upload</h1>


	<form method="POST" action="excel_exec.php" enctype="multipart/form-data">
		<div class="form-group">
			<label>Upload Excel File</label>
			<input type="file" name="file" class="form-control">
		</div>
		<div class="form-group">
			<button type="submit" name="Submit" class="btn btn-success">Upload</button>
		</div>

	</form>
</div>


</body>
</html> 
