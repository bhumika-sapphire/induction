<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id = current_user_id();
$topic_id = isset($_REQUEST['topic_id']) ? (int)$_REQUEST['topic_id'] : 0;

$topic = $conn->Execute("SELECT topic_id, topic_name FROM topic_master WHERE topic_id = ?", array($topic_id))->FetchRow();
if (!$topic) {
    header("location: index.php");
    exit();
}

// Re-use an unfinished attempt (e.g. after a page refresh) instead of burning a new one
$pending = isset($_SESSION[SESSION_PREFIX . 'FINAL_TEST']) ? $_SESSION[SESSION_PREFIX . 'FINAL_TEST'] : null;
if ($pending && ($pending['topic_id'] != $topic_id || time() - $pending['started'] > FINAL_TEST_MINUTES * 60)) {
    $pending = null;
}

if (!$pending) {
    if (!check_final_eligibility($user_id, $topic_id)) {
        log_issue("Tried to open final test without eligibility for Topic: " . $topic_id);
        header("location: all_chapters.php?topic_id=" . $topic_id);
        exit();
    }

    $question_ids = array();
    $rs = $conn->Execute("SELECT question_id FROM question_bank_master WHERE topic_id = ? AND is_active = 1 ORDER BY RAND() LIMIT " . (int)FINAL_TEST_QUESTIONS, array($topic_id));
    while ($row = $rs->FetchRow()) {
        $question_ids[] = (int)$row['question_id'];
    }

    if ($question_ids) {
        $conn->AutoExecute(TABLE_PREFIX . 'user_final_test_master', array(
            'user_id'         => $user_id,
            'topic_id'        => $topic_id,
            'test_date'       => date('Y-m-d H:i:s'),
            'total_questions' => count($question_ids),
        ), 'INSERT');
        $final_test_id = $conn->Insert_Id();

        $request_id = approved_reappear_request($user_id, $topic_id);
        if ($request_id) {
            $conn->Execute("UPDATE user_request SET request_status = 'Used' WHERE user_request_id = ?", array($request_id));
        }

        $pending = array(
            'final_test_id' => $final_test_id,
            'topic_id'      => $topic_id,
            'questions'     => $question_ids,
            'started'       => time(),
        );
        $_SESSION[SESSION_PREFIX . 'FINAL_TEST'] = $pending;
    }
}

$questions = array();
if ($pending) {
    $ids = implode(',', array_map('intval', $pending['questions']));
    $rs = $conn->Execute("SELECT * FROM question_bank_master WHERE question_id IN ($ids) ORDER BY FIELD(question_id, $ids)");
    $questions = $rs->GetRows();
    $minutes_left = max(FINAL_TEST_MINUTES - (time() - $pending['started']) / 60, 0);
}

$page_title = 'Final Test';
include_once '_header.php';
?>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="all_chapters.php?topic_id=<?php echo $topic_id; ?>"><?php echo h($topic['topic_name']); ?></a></li>
            <li>Final Test</li>
        </ul>
    </div>
</section>
<section class="quiz-view">
    <div class="container">
        <div class="quiz-title">
            <h2>Final Test: <?php echo h($topic['topic_name']); ?></h2>
        </div>
        <?php if (!$questions) { ?>
            <div class="panel-card">
                <h3>Sorry! No questions have been added for this topic yet.</h3>
                <p><a href="all_chapters.php?topic_id=<?php echo $topic_id; ?>" class="btn">Back to topic</a></p>
            </div>
        <?php } else { ?>
        <form method="post" action="final_answer_exec.php" id="final_form" data-minutes="<?php echo round($minutes_left, 2); ?>">
            <div class="row">
                <div class="col-md-9">
                    <p class="text-muted"><?php echo count($questions); ?> questions &middot; <?php echo FINAL_TEST_MINUTES; ?> minutes &middot; pass mark <?php echo CHAPTER_TEST_PASS; ?>%. The test is submitted automatically when time runs out.</p>
                    <?php foreach ($questions as $i => $q) { $n = $i + 1; ?>
                        <div class="qustion-box">
                            <div class="qustion"><strong>Question <?php echo $n; ?>.</strong> <?php echo $q['question_text']; ?></div>
                            <div class="ans">
                                <?php for ($opt = 1; $opt <= 4; $opt++) {
                                    if ($q['option' . $opt] === '' || $q['option' . $opt] === null) continue;
                                    $input_id = 'q' . $q['question_id'] . '_' . $opt; ?>
                                    <div class="ans-slide">
                                        <label class="label_radio" for="<?php echo $input_id; ?>">
                                            <input type="radio" name="question_<?php echo $n; ?>" id="<?php echo $input_id; ?>" value="<?php echo $q['question_id'] . '_' . $opt; ?>">
                                            <?php echo $q['option' . $opt]; ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="final_test_id" value="<?php echo (int)$pending['final_test_id']; ?>">
                    <input type="hidden" name="time_taken" id="tss" value="0">
                    <div class="btn-slide text-center">
                        <button type="submit" class="btn btn-accent" onclick="return confirm('Submit your answers?');">Submit Test</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="countdown" class="countdown"></div>
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
</section>
<?php include '_footer.php'; ?>
