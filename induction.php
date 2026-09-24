<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$page_id = isset($_REQUEST['page_id']) ? (int)$_REQUEST['page_id'] : 1;

if (in_array($page_id, array(7, 8, 9))) {
    header("location: " . onboarding_step_url($page_id));
    exit();
}

$rs = $conn->Execute("SELECT * FROM cms_master WHERE page_id = ? AND is_policy = 0", array($page_id));
$page = $rs->FetchRow();
if (!$page) {
    header("location: induction.php?page_id=1");
    exit();
}

$active_page_id = $page_id;
$page_title = $page['page_title'];
include_once '_header.php';
?>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="induction.php?page_id=1">Onboarding</a></li>
            <li><?php echo h($page['nav_title']); ?></li>
        </ul>
    </div>
</section>
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include 'includes/onboarding_nav.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="panel-card">
                    <h2 class="page-heading"><?php echo h($page['page_title']); ?></h2>
                    <div class="cms-content">
                        <?php echo local_content($page['page_content']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include '_footer.php'; ?>
