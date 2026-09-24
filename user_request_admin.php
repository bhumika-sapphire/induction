<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id = current_user_id();
$topic_id = isset($_REQUEST['topic_id']) ? (int)$_REQUEST['topic_id'] : 0;

// final_test_result.php links here without a topic: use the latest attempted one
if (!$topic_id) {
    $row = $conn->Execute("SELECT topic_id FROM user_final_test_master WHERE user_id = ? ORDER BY final_test_id DESC LIMIT 1", array($user_id))->FetchRow();
    $topic_id = $row ? (int)$row['topic_id'] : 0;
}

$topic = $conn->Execute("SELECT topic_id, topic_name FROM topic_master WHERE topic_id = ?", array($topic_id))->FetchRow();
if (!$topic || !check_final_reappear($user_id, $topic_id)) {
    header("location: index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !check_user_pass_reappear_btn_hide($user_id, $topic_id)) {
    $description = str_prepare($_POST['description']);
    if ($description == '') {
        $error = 'Please enter a reason for your request.';
    } else {
        $last = $conn->Execute("SELECT MAX(final_test_id) AS id FROM user_final_test_master WHERE user_id = ? AND topic_id = ?", array($user_id, $topic_id))->FetchRow();
        $conn->AutoExecute(TABLE_PREFIX . 'user_request', array(
            'user_id'        => $user_id,
            'final_test_id'  => $last['id'],
            'topic_id'       => $topic_id,
            'description'    => substr($description, 0, 200),
            'request_date'   => date('Y-m-d H:i:s'),
            'request_status' => 'Pending',
        ), 'INSERT');
        header("location: user_request_admin.php?topic_id=" . $topic_id);
        exit();
    }
}

$pending = check_user_pass_reappear_btn_hide($user_id, $topic_id);
$approved = approved_reappear_request($user_id, $topic_id);

$page_title = 'Request Re-Appear';
include_once '_header.php';
?>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="all_chapters.php?topic_id=<?php echo $topic_id; ?>"><?php echo h($topic['topic_name']); ?></a></li>
            <li>Request Re-Appear</li>
        </ul>
    </div>
</section>
<section class="page-section">
    <div class="container">
        <div class="panel-card" style="max-width:640px;margin:0 auto;">
            <h2 class="page-heading">Request Re-Appear</h2>
            <p>Topic: <strong><?php echo h($topic['topic_name']); ?></strong></p>
            <?php if ($approved) { ?>
                <div class="alert alert-success">Your request has been approved. You can take the final test again.</div>
                <a href="final_start_test.php?topic_id=<?php echo $topic_id; ?>" class="btn btn-accent">Start Final Test</a>
            <?php } else if ($pending) { ?>
                <div class="alert alert-info">Your request has been sent and is waiting for admin approval.</div>
                <a href="all_chapters.php?topic_id=<?php echo $topic_id; ?>" class="btn btn-light">Back to topic</a>
            <?php } else { ?>
                <?php if ($error) { ?><div class="alert alert-danger"><?php echo h($error); ?></div><?php } ?>
                <form method="post" action="user_request_admin.php?topic_id=<?php echo $topic_id; ?>">
                    <div class="form-group">
                        <label for="description">Why would you like to re-appear?</label>
                        <textarea class="form-control" rows="4" id="description" name="description" maxlength="200" required></textarea>
                    </div>
                    <button type="submit" class="btn">Send Request</button>
                </form>
            <?php } ?>
        </div>
    </div>
</section>
<?php include '_footer.php'; ?>
