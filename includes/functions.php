<?php

function setMsg($msg, $type = 'error')
{
    $_SESSION[SESSION_PREFIX . 'MSG'][$type] = $msg;
}

function getMsg($type = 'error')
{
    if (!isset($_SESSION[SESSION_PREFIX . 'MSG'][$type])) {
        return '';
    }
    $msg = $_SESSION[SESSION_PREFIX . 'MSG'][$type];
    unset($_SESSION[SESSION_PREFIX . 'MSG'][$type]);
    return $msg;
}

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function str_prepare($value)
{
    return trim(strip_tags((string)$value));
}

function current_user_id()
{
    return isset($_SESSION[SESSION_PREFIX . 'USER_ID']) ? (int)$_SESSION[SESSION_PREFIX . 'USER_ID'] : 0;
}

function log_issue($message)
{
    global $conn;
    $conn->AutoExecute(TABLE_PREFIX . 'security_log', array(
        'user_id'   => current_user_id(),
        'log_value' => substr($message, 0, 250),
        'log_date'  => date('Y-m-d H:i:s'),
    ), 'INSERT');
    return true;
}

/* Marks the logged-in user's onboarding as finished */
function induction_complete()
{
    global $conn;
    $user_id = current_user_id();
    if (!$user_id) {
        return false;
    }
    $conn->Execute("UPDATE user_master SET induction_complete = 1 WHERE user_id = ?", array($user_id));
    $_SESSION[SESSION_PREFIX . 'INDUCTION_COMPLETE'] = true;
    return true;
}

function has_passed_final($user_id, $topic_id)
{
    global $conn;
    $rs = $conn->Execute("SELECT final_test_id FROM user_final_test_master WHERE user_id = ? AND topic_id = ? AND is_pass = 1 LIMIT 1",
        array((int)$user_id, (int)$topic_id));
    return $rs->RowCount() > 0;
}

function final_attempt_count($user_id, $topic_id)
{
    global $conn;
    $rs = $conn->Execute("SELECT COUNT(*) AS c FROM user_final_test_master WHERE user_id = ? AND topic_id = ?",
        array((int)$user_id, (int)$topic_id));
    $row = $rs->FetchRow();
    return (int)$row['c'];
}

function approved_reappear_request($user_id, $topic_id)
{
    global $conn;
    $rs = $conn->Execute("SELECT user_request_id FROM user_request WHERE user_id = ? AND topic_id = ? AND request_status = 'Approved' ORDER BY user_request_id DESC LIMIT 1",
        array((int)$user_id, (int)$topic_id));
    $row = $rs->FetchRow();
    return $row ? (int)$row['user_request_id'] : 0;
}

/* Can the user start the final test for this topic right now? */
function check_final_eligibility($user_id, $topic_id)
{
    global $conn;
    $rs = $conn->Execute("SELECT user_topic_id FROM user_topics WHERE user_id = ? AND topic_id = ?", array((int)$user_id, (int)$topic_id));
    if ($rs->RowCount() == 0 || has_passed_final($user_id, $topic_id)) {
        return false;
    }
    if (final_attempt_count($user_id, $topic_id) == 0) {
        return true;
    }
    return approved_reappear_request($user_id, $topic_id) > 0;
}

/* Has the user failed the final test (and not passed since), so a re-appear request makes sense? */
function check_final_reappear($user_id, $topic_id = null)
{
    global $conn;
    if ($topic_id === null) {
        $rs = $conn->Execute("SELECT topic_id FROM user_final_test_master WHERE user_id = ? ORDER BY final_test_id DESC LIMIT 1", array((int)$user_id));
        $row = $rs->FetchRow();
        if (!$row) {
            return false;
        }
        $topic_id = $row['topic_id'];
    }
    return final_attempt_count($user_id, $topic_id) > 0 && !has_passed_final($user_id, $topic_id);
}

/* Hide the "Request Re-Appear" button while a request is already pending */
function check_user_pass_reappear_btn_hide($user_id, $topic_id)
{
    global $conn;
    $rs = $conn->Execute("SELECT user_request_id FROM user_request WHERE user_id = ? AND topic_id = ? AND request_status = 'Pending'",
        array((int)$user_id, (int)$topic_id));
    return $rs->RowCount() > 0;
}

/* Topics with a practical file round unlock it once the final test is passed */
function check_test_files($user_id, $topic_id)
{
    global $conn;
    $rs = $conn->Execute("SELECT file_test FROM topic_master WHERE topic_id = ?", array((int)$topic_id));
    $row = $rs->FetchRow();
    return $row && $row['file_test'] == 1 && has_passed_final($user_id, $topic_id);
}

function latest_file_round($user_id, $topic_id = null)
{
    global $conn;
    if ($topic_id === null) {
        $rs = $conn->Execute("SELECT * FROM user_files_upload_master WHERE user_id = ? ORDER BY id DESC LIMIT 1", array((int)$user_id));
    } else {
        $rs = $conn->Execute("SELECT * FROM user_files_upload_master WHERE user_id = ? AND topic_id = ? ORDER BY id DESC LIMIT 1",
            array((int)$user_id, (int)$topic_id));
    }
    return $rs->FetchRow();
}

/* True while the user may still download / upload files for this topic */
function check_files_result($user_id, $topic_id)
{
    $row = latest_file_round($user_id, $topic_id);
    if (!$row) {
        return true;
    }
    if ($row['upload_date'] == '') {
        return true;
    }
    return $row['is_pass'] !== null && $row['is_pass'] == 0 && $row['try_again'] == 1;
}

/* "pass", "fail" or "wait" for the user's latest uploaded file */
function display_files_result($user_id)
{
    $row = latest_file_round($user_id);
    if (!$row || $row['is_pass'] === null || $row['is_pass'] === '') {
        return 'wait';
    }
    return $row['is_pass'] == 1 ? 'pass' : 'fail';
}

/* Policy columns on user_master, keyed by cms_master.nav_title */
function policy_columns()
{
    return array('it_policy', 'leave_policy', 'list_of_holidays_policy', 'travel_policy', 'increment_policy',
        'productivity_policy', 'office_rules_policy', 'referral_policy', 'posh_policy');
}

/* Onboarding pages 7-9 are interactive forms with their own scripts */
function onboarding_step_url($page_id)
{
    $special = array(7 => 'employee_details.php', 8 => 'employee_documents.php', 9 => 'policies.php');
    return isset($special[$page_id]) ? $special[$page_id] : 'induction.php?page_id=' . (int)$page_id;
}

function onboarding_steps()
{
    global $conn;
    $rs = $conn->Execute("SELECT page_id, nav_title FROM cms_master WHERE is_policy = 0 ORDER BY sort_order, page_id");
    return $rs->GetRows();
}

/*
 * Content saved in the admin panel embeds media from old live URLs
 * (the jobportal.sapphireinfo.net host no longer resolves). Serve those
 * files from this site's uploads folder instead, and drop images that
 * point at the author's local disk (pasted from Word).
 */
function local_content($html)
{
    $html = preg_replace('#https?://(jobportal\.sapphireinfo\.net/induction-training-portal|induction\.sapphireinfo\.net)/uploads/#i', UPLOADS_URL, $html);
    return preg_replace('#<img[^>]+src=["\']file:///[^>]*>#i', '', $html);
}
