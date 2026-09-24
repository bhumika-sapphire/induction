<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SWEC">
    <meta name="author" content="Web Supplements">
    <title>Admin Panel - <?php echo APP_NAME; ?></title>
    <!-- Bootstrap Core CSS 
    <link href="css/bootstrap.min.css" rel="stylesheet">-->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet" media='screen,print'>
    <link href="css/datepicker3.css" rel="stylesheet">
	<?php if($datatable){ ?>
   <link href="css/jquery.dataTables.css" rel="stylesheet">
	<?php } ?>
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">

	<!-- Custom Fonts -->
    
	<!--<link href="css/summernote.css" rel="stylesheet">-->
	<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
	
	<link href="js/plugins/select2/select2.css" rel="stylesheet">
	<link href="js/plugins/select2-bootstrap-css/select2-bootstrap.min.css" rel="stylesheet">
	<link href="css/jquery.fancybox.min.css" rel="stylesheet">

	<script src="js/jquery.js"></script>
<!--	<script src="js/bootstrap.min.js"></script>-->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
   	<script src="js/validator.min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	
   
	<?php if($page == "manage_timetable"){ ?>	
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/redips-drag-min.js"></script>
	<?php } ?>
	
	<?php if($datatable){ ?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#example').DataTable({"deferRender": true ,"lengthMenu": [ 50, 100,150,200,250,500]});
			$('#example1').DataTable({"deferRender": true ,"lengthMenu": [ 50, 100,150,200,250,500]});
        });
	</script>
	<?php } ?>

<!--<script src="js/summernote.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>  
<script src="js/plugins/jscolor/jscolor.min.js"></script>   
<script src="js/bootstrap-datepicker.js"></script> 
<script src="js/plugins/select2/select2.js"></script>   
<script>
$(document).ready(function() {

 
   $('.wysiwyg').summernote({
    height: 130
	});
   
  $('#change_password').validator();
  
 ////////////////////////////// date picker
 
 $('#sandbox-container input').datepicker({
    autoclose: true,
	format: 'yyyy-mm-dd'
	});

	$('#sandbox-container input').on('show', function(e){
		console.debug('show', e.date, $(this).data('stickyDate'));
		
		if ( e.date ) {
			 $(this).data('stickyDate', e.date);
		}
		else {
			 $(this).data('stickyDate', null);
		}
	});

	$('#sandbox-container input').on('hide', function(e){
		console.debug('hide', e.date, $(this).data('stickyDate'));
		var stickyDate = $(this).data('stickyDate');
		
		if ( !e.date && stickyDate ) {
			console.debug('restore stickyDate', stickyDate);
			$(this).datepicker('setDate', stickyDate);
			$(this).data('stickyDate', null);
		}
	});
	////////////////////////////// date picker

	$(".select2").each(function () {
		$(this).select2({theme:'bootstrap'});
	});

	$(document).ready(function() {
		$(".iframe").fancybox({
			type: 'iframe'
		});
	});
});
</script>
</head>
<body>
<div id="wrapper">
<?php include '_leftmenu.php'; ?>