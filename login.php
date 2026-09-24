<?php
include_once 'includes/startup.php';

if (current_user_id()) {
    header("location: index.php");
    exit();
}

$user_login = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_login = trim($_POST['user_login']);
    $password = (string)$_POST['user_password'];

    $rs = $conn->Execute("SELECT user_id, first_name, last_name, is_active, induction_complete FROM user_master WHERE user_login = ? AND user_password = ?",
        array($user_login, md5($password)));
    $user = $rs->FetchRow();

    if (!$user) {
        setMsg('Invalid username or password.');
    } else if (!$user['is_active']) {
        setMsg('Your account is inactive. Please contact HR.');
    } else {
        session_regenerate_id(true);
        $now = date('Y-m-d H:i:s');
        $conn->AutoExecute(TABLE_PREFIX . 'user_login_history', array(
            'user_id'     => $user['user_id'],
            'login_time'  => $now,
            'logout_time' => $now,
        ), 'INSERT');

        $_SESSION[SESSION_PREFIX . 'USER_ID'] = $user['user_id'];
        $_SESSION[SESSION_PREFIX . 'USER_LOGIN'] = $user_login;
        $_SESSION[SESSION_PREFIX . 'FIRST_NAME'] = $user['first_name'];
        $_SESSION[SESSION_PREFIX . 'LAST_NAME'] = $user['last_name'];
        $_SESSION[SESSION_PREFIX . 'LOGIN_HISTORY_ID'] = $conn->Insert_Id();
        $_SESSION[SESSION_PREFIX . 'INDUCTION_COMPLETE'] = (bool)$user['induction_complete'];

        header("location: " . ($user['induction_complete'] ? "index.php" : "landing.php"));
        exit();
    }
}

$page_title = 'Login';
$msg = getMsg('error');
include_once '_header.php';
?>
<div class="login-wrap">
    <div class="login-card">
        <h1>New Joinee Onboarding</h1>
        <p class="sub">Sign in with the username and password shared by HR.</p>
        <?php if ($msg) { ?>
            <div class="alert alert-<?php echo $msg == 'You have been logged out!' ? 'info' : 'danger'; ?>"><?php echo h($msg); ?></div>
        <?php } ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="user_login">Username</label>
                <input type="text" class="form-control" id="user_login" name="user_login" value="<?php echo h($user_login); ?>" required autofocus>
            </div>
            <div class="form-group">
                <label for="user_password">Password</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>
            <button type="submit" class="btn">Sign in</button>
        </form>
    </div>
</div>
<?php include '_footer.php'; ?>
