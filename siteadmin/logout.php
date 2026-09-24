<?php
    include_once('../includes/startup.php');
    require_once('authenticate.php');
    unset($_SESSION[SESSION_PREFIX.'ADMIN_ID']);
    unset($_SESSION);
    session_destroy();
    setMsg('You have been logged out!');
    header("location:login.php");
    exit();
?>