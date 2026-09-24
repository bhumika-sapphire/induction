<?php
require("includes/startup.php");

require_once(INCLUDES_DIR . 'parser.php');
require_once(LIB_DIR . 'mail-wrapper.php');

$topic_id=$_POST['topic_id'];
$user_id=($_SESSION[SESSION_PREFIX.'USER_ID']);

$req_user = array();

$req_user["user_id"] = $user_id;
$req_user["topic_id"] = $topic_id;
$req_user["description"] = str_prepare($_POST["description"]);
$req_user["request_date"] = date('Y-m-d H:i:s');

$status = $conn->Autoexecute("user_request", $req_user,"INSERT",true, false, MAGIC_QUOTES);


if ($status) {

            $emailMsg = parse_template(file_get_contents(MAIL_TEMPLATES_DIR . 'final_test_approval.php'), array('USER' => $_SESSION[SESSION_PREFIX.'FIRST_NAME'],
                'APP_NAME' => APP_NAME));
            
            sendmail($emailMsg, FROM_EMAIL, APP_NAME, ADMIN_EMAIL, 'Approval for Final Re-Appear');
            setMsg("Request sent successfully.");
            header("location:user_request_admin.php");
            exit();
        }
     else {
        setMsg("Sorry! Could not send the request. Please try again.");
        header("location:user_request_admin.php");
        exit();
	 }

?>