<?php
include_once 'includes/startup.php';

if (!current_user_id()) {
    header("location: login.php");
    exit();
}
include_once 'authenticate.php';

$user_id = current_user_id();
$induction_done = !empty($_SESSION[SESSION_PREFIX . 'INDUCTION_COMPLETE']);

$sql = "SELECT tm.topic_id, tm.topic_name, tm.is_communication, ut.topic_completed,
            (SELECT COUNT(*) FROM chapter_master cm WHERE cm.topic_id = tm.topic_id) AS chapter_count,
            (SELECT MAX(is_pass) FROM user_final_test_master ft WHERE ft.topic_id = tm.topic_id AND ft.user_id = ut.user_id) AS final_pass
        FROM user_topics ut
        INNER JOIN topic_master tm ON ut.topic_id = tm.topic_id
        WHERE ut.user_id = ? AND tm.is_active = 1
        ORDER BY tm.is_communication, tm.sort_order, tm.topic_name";
$topics = $conn->Execute($sql, array($user_id));

$page_title = 'Home';
include_once '_header.php';
?>
<section class="banner" id="section1">
    <div class="banner-img"><img src="images/slider-3-slide-2.jpg" alt=""></div>
    <div class="banner-text">
        <div class="container">
            <p>Welcome to Sapphire, <?php echo h($_SESSION[SESSION_PREFIX . 'FIRST_NAME']); ?></p>
            <h1>NEW JOINEE ONBOARDING</h1>
            <?php if ($induction_done) { ?>
                <p>Your onboarding is complete. Continue with your training modules below.</p>
                <p><a href="#section2" class="btn btn-accent">Go to training</a> &nbsp; <a href="induction.php?page_id=1" class="btn btn-light">Review onboarding</a></p>
            <?php } else { ?>
                <p>Get to know the company, fill in your details and read the work policies.</p>
                <p><a href="induction.php?page_id=1" class="btn btn-accent">Click here to continue</a></p>
            <?php } ?>
        </div>
    </div>
</section>

<section class="courses-view" id="section2">
    <div class="container">
        <div class="section-heading">
            <h2>Your Training Topics</h2>
            <?php if (!$induction_done) { ?>
                <p>Training unlocks once you finish the onboarding pages.</p>
            <?php } ?>
        </div>
        <?php if ($induction_done) { ?>
        <div class="row">
            <?php if ($topics->RowCount() == 0) { ?>
                <h2 class="chapter">No topics have been assigned to you yet.</h2>
            <?php } ?>
            <?php while ($topic = $topics->FetchRow()) {
                $link = ($topic['is_communication'] ? 'comm_all_chapters.php' : 'all_chapters.php') . '?topic_id=' . $topic['topic_id'];
                if ($topic['final_pass'] === '1') {
                    $status = '<span class="status-tag pass">Final test passed</span>';
                } else if ($topic['final_pass'] === '0') {
                    $status = '<span class="status-tag fail">Final test not cleared</span>';
                } else {
                    $status = '<span class="status-tag">In progress</span>';
                }
                ?>
                <div class="col-sm-6 col-md-4">
                    <div class="course-post">
                        <div class="img"><div class="icon"><i class="fa fa-graduation-cap"></i></div></div>
                        <div class="info">
                            <div class="name"><?php echo h($topic['topic_name']); ?></div>
                            <div class="meta"><?php echo (int)$topic['chapter_count']; ?> chapters</div>
                        </div>
                        <div class="product-footer">
                            <?php echo $status; ?>
                            <div class="view-btn"><a href="<?php echo $link; ?>" class="btn">Open</a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php } else { ?>
            <p><a href="induction.php?page_id=1" class="btn">Continue onboarding</a></p>
        <?php } ?>
    </div>
</section>
<?php include '_footer.php'; ?>
