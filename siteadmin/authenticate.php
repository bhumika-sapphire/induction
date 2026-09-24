<?php

  if(!isset($_SESSION[SESSION_PREFIX.'ADMIN_ID']) || $_SESSION[SESSION_PREFIX.'ADMIN_ID']=="")
    {
        setMsg('You need to login!');
        header("location: login.php");
        exit();
    }  
?>