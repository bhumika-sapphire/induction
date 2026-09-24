<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id = current_user_id();
$final_test_id = isset($_POST['final_test_id']) ? (int)$_POST['final_test_id'] : 0;
$pending = isset($_SESSION[SESSION_PREFIX . 'FINAL_TEST']) ? $_SESSION[SESSION_PREFIX . 'FINAL_TEST'] : null;

$test = $conn->Execute("SELECT * FROM user_final_test_master WHERE final_test_id = ? AND user_id = ?", array($final_test_id, $user_id))->FetchRow();

if (!$test || !$pending || $pending['final_test_id'] != $final_test_id || $test['correct_answers'] !== null) {
    log_issue("Invalid final test submission for test: " . $final_test_id);
    header("location: error.php");
    exit();
}

$answers = array();
foreach ($pending['questions'] as $i => $question_id) {
    $answers[$question_id] = 0;
    $key = 'question_' . ($i + 1);
    if (!empty($_POST[$key])) {
        list($qid, $option) = array_map('intval', explode('_', $_POST[$key]) + array(0, 0));
        if ($qid == $question_id && $option >= 1 && $option <= 4) {
            $answers[$question_id] = $option;
        }
    }
}

$ids = implode(',', array_map('intval', array_keys($answers)));
$correct = array();
$rs = $conn->Execute("SELECT question_id, correct_answer FROM question_bank_master WHERE question_id IN ($ids)");
while ($row = $rs->FetchRow()) {
    $correct[$row['question_id']] = (int)$row['correct_answer'];
}

$correct_count = 0;
foreach ($answers as $question_id => $option) {
    $is_correct = ($option && isset($correct[$question_id]) && $correct[$question_id] == $option) ? 1 : 0;
    $correct_count += $is_correct;
    $conn->AutoExecute(TABLE_PREFIX . 'user_final_test_details', array(
        'final_test_id' => $final_test_id,
        'question_id'   => $question_id,
        'answer_option' => $option,
        'is_correct'    => $is_correct,
    ), 'INSERT');
}

$total = count($answers);
$time_taken = min((int)$_POST['time_taken'], FINAL_TEST_MINUTES * 60);
$conn->AutoExecute(TABLE_PREFIX . 'user_final_test_master', array(
    'total_questions' => $total,
    'correct_answers' => $correct_count,
    'time_taken'      => $time_taken ? $time_taken : time() - $pending['started'],
    'is_pass'         => ($total && $correct_count * 100 / $total >= CHAPTER_TEST_PASS) ? 1 : 0,
), 'UPDATE', 'final_test_id = ' . $final_test_id);

unset($_SESSION[SESSION_PREFIX . 'FINAL_TEST']);
header("location: final_test_result.php?final_test_id=" . $final_test_id);
exit();
