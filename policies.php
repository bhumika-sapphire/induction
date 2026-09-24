<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id = current_user_id();
$columns = policy_columns();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $policy = isset($_POST['policy']) ? $_POST['policy'] : '';
    if (in_array($policy, $columns, true)) {
        $conn->Execute("UPDATE user_master SET `$policy` = 1 WHERE user_id = ?", array($user_id));
        setMsg('Thank you. Your agreement has been recorded.', 'success');
    } else {
        setMsg('Please tick the checkbox to agree to the policy.');
    }
    header("location: policies.php");
    exit();
}

$page = $conn->Execute("SELECT * FROM cms_master WHERE page_id = 9")->FetchRow();
$policies = $conn->Execute("SELECT page_id, nav_title, page_title, page_content FROM cms_master WHERE is_policy = 1 ORDER BY sort_order, page_id")->GetRows();
$agreed = $conn->Execute("SELECT " . implode(', ', $columns) . " FROM user_master WHERE user_id = ?", array($user_id))->FetchRow();

$all_agreed = true;
foreach ($policies as $policy) {
    if (in_array($policy['nav_title'], $columns) && empty($agreed[$policy['nav_title']])) {
        $all_agreed = false;
    }
}

$success = getMsg('success');
$error = getMsg('error');
$active_page_id = 9;
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
                    <?php if ($success) { ?>
                        <div class="alert alert-success"><?php echo h($success); ?></div>
                    <?php } ?>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger"><?php echo h($error); ?></div>
                    <?php } ?>
                    <p>Open each policy, read it and click <strong>Agree</strong> at the end.</p>
                    <ul class="policy-list">
                        <?php foreach ($policies as $i => $policy) { $done = !empty($agreed[$policy['nav_title']]); ?>
                            <li>
                                <a class="fancybox" href="#<?php echo $i + 1; ?>"><?php echo h($policy['page_title']); ?></a>
                                <span class="policy-status <?php echo $done ? 'done' : 'todo'; ?>">
                                    <?php echo $done ? '<i class="fa fa-check-circle"></i> Agreed' : '<i class="fa fa-clock-o"></i> Pending'; ?>
                                </span>
                            </li>
                        <?php } ?>
                    </ul>

                    <?php foreach ($policies as $i => $policy) {
                        $content = local_content($policy['page_content']);
                        if (!empty($agreed[$policy['nav_title']])) {
                            // Replace the agree form with a confirmation
                            $content = preg_replace('#<p id="[a-z_]+_form">.*?</p>#s', '', $content)
                                . '<div class="alert alert-success"><i class="fa fa-check-circle"></i> You have agreed to this policy.</div>';
                        } else {
                            $content = preg_replace('#(<p id="[a-z_]+_form">.*?</p>)#s', '<form method="post" action="policies.php" class="policy-form">$1</form>', $content);
                        }
                        ?>
                        <div id="<?php echo $i + 1; ?>" class="cms-content" style="display:none;">
                            <?php echo $content; ?>
                        </div>
                    <?php } ?>

                    <div class="step-nav">
                        <a href="employee_documents.php" class="prevButton">Prev</a>
                        <?php if ($all_agreed) { ?>
                            <a href="induction.php?page_id=10" class="nextButton">Next</a>
                        <?php } else { ?>
                            <span class="pull-right text-muted">Agree to all policies to continue</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include '_footer.php'; ?>
