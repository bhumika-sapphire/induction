<?php
$logged_in = current_user_id() > 0;
$induction_done = !empty($_SESSION[SESSION_PREFIX . 'INDUCTION_COMPLETE']);
$current_page = basename($_SERVER['SCRIPT_NAME']);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? h($page_title) . ' | ' : ''; ?><?php echo SITE_NAME; ?></title>
    <link rel="icon" href="images/Favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="page-<?php echo h(pathinfo($current_page, PATHINFO_FILENAME)); ?>">
<header class="site-header">
    <div class="container">
        <a class="site-logo" href="index.php"><img src="images/logo/logo.png" alt="Sapphire Info Solutions"></a>
        <?php if ($logged_in) { ?>
        <button type="button" class="nav-toggle" aria-label="Menu"><i class="fa fa-bars"></i></button>
        <nav class="site-nav">
            <a href="index.php" <?php if ($current_page == 'index.php') echo 'class="active"'; ?>>Home</a>
            <a href="induction.php?page_id=1" <?php if (in_array($current_page, array('induction.php', 'landing.php', 'employee_details.php', 'employee_documents.php', 'policies.php'))) echo 'class="active"'; ?>>Onboarding</a>
            <?php if ($induction_done) { ?>
            <a href="index.php#section2">Training</a>
            <?php } ?>
            <span class="nav-user"><i class="fa fa-user-circle"></i> <?php echo h($_SESSION[SESSION_PREFIX . 'FIRST_NAME']); ?></span>
            <a href="logout.php" class="nav-logout"><i class="fa fa-sign-out"></i> Logout</a>
        </nav>
        <?php } ?>
    </div>
</header>
<main class="site-main">
