<?php
require_once('../includes/startup.php');
require_once('authenticate.php');

if (isset($_POST['admin_password']) && $_POST['admin_password'] != '') {

    $old_password = str_prepare($_POST['admin_password']);
    $new_password = str_prepare($_POST['new_password']);

    $q = " SELECT admin_id from " . TABLE_PREFIX . "admin_master where admin_id='" . $_SESSION[SESSION_PREFIX . 'ADMIN_ID'] . "' and admin_password='" . md5($old_password) . "'";

    $res = $conn->Execute($q);

    if (!$res || $res->RecordCount() == 0) {
        setMsg('Old Password Not Correct!');
        header('location: change_password.php');
        exit();
    } else {
        $select = "select admin_id from admin_master where admin_password='" . md5($new_password) . "'";
        $result = $conn->Execute($select);
        if (isset($result) && $result->RecordCount()) {
            setMsg('You have used old password again! Try some different');
            header('location: change_password.php');
            exit();
        } else {
            $q = " UPDATE " . TABLE_PREFIX . " admin_master set admin_password='" . md5($new_password) . "' where admin_id='" . $_SESSION[SESSION_PREFIX . 'ADMIN_ID'] . "'";
            $res = $conn->Execute($q);
            if ($res) {
                setMsg('Password changed successfully!');
                header('location: change_password.php');
                exit();
            } else {
                setMsg('Could not change password!');
                header('location: change_password.php');
                exit();
            }
        }
    }
} else {
    setMsg('Enter your old and new password!');
    header('location: change_password.php');
    exit();
}
?>