<?php
	ob_start('ob_gzhandler');
	error_reporting(E_ALL^E_DEPRECATED);
	//error_reporting(0);
	require_once('config_file.php');

	define('APP_URL',SERVER_URL.APP_FOL);
	define('SERVER_DOC_ROOT',$_SERVER['DOCUMENT_ROOT']);
	//die(SERVER_DOC_ROOT);
	define('APP_DIR',SERVER_DOC_ROOT.APP_FOL);
	define('INCLUDES_DIR',APP_DIR.'includes/');
	define('LIB_DIR',APP_DIR.'lib/');
	define('REL_LIB_DIR',APP_FOL.'lib/');
	
	define('MAIL_TEMPLATES_DIR',APP_DIR.'templates_mails/');
	
	define('UPLOADS_DIR',APP_DIR.'uploads/');
	define('SITE_ADMIN_UPLOADS_DIR',APP_DIR.'siteadmin/uploads/');
	define('UPLOADS_THUMB_DIR',APP_DIR.'uploads/thumbs/');
	define('UPLOADS_URL',APP_URL.'uploads/');
	define('UPLOADS_THUMB_URL',APP_URL.'uploads/thumbs/');
	
	define('UPLOADS_DOCS_DIR',UPLOADS_DIR.'documents/');
	define('UPLOADS_DOCS_URL',UPLOADS_URL.'documents/');
	
	define('UPLOADS_DETAILS_DIR',UPLOADS_DIR.'employeeDetails/');
	define('UPLOADS_DETAILS_URL',UPLOADS_URL.'employeeDetails/');
	
	define('THUMB_WIDTH',265);
	define('THUMB_HEIGHT',266);
	
	define('ADDITIONAL_THUMB_WIDTH',60);
	define('ADDITIONAL_THUMB_HEIGHT',60);
	
		
	define('SLIDE_THUMB_WIDTH',900);
	define('SLIDE_THUMB_HEIGHT',525);
     

	include_once(LIB_DIR.'adodb/adodb.inc.php');
	
	$conn = &ADONewConnection('mysqli');
	$ADODB_COUNTRECS = true;
	$conn_status=$conn->Connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	$conn->Execute("set names 'utf8'"); 
	if(!$conn_status) {
		die("FATAL Error!<br>Database connection failed");
	}
	if (!function_exists('session_start')) {
		die("FATAL Error!<br>Sessions not supported on this server");
	}
	if (PHP_VERSION < 5) {
		die("FATAL Error!<br>At least PHP 5 is required");
	} 
	include_once(INCLUDES_DIR.'functions.php');
	
	session_name(SESSION_PREFIX);
	session_start();
	if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc(): bool
    {
        return false;
    }
}

	define('MAGIC_QUOTES',get_magic_quotes_gpc());
	define('PARSER_DEBUG',true);
	define('SEO_LINKS',false);

	//**************** System Variable *************************
	$_debugMessages=array();
	$_systemTags=array();
	define('DEMO',false);
	define('DEBUG',false);
	$datatable = false;
?>