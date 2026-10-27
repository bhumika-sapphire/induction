<?php
// Copy to config_file.php on the server and fill in real values.
// config_file.php is git-ignored; never commit it.

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'induction');
define('DB_PASSWORD', 'CHANGE_ME');
define('DB_DATABASE', 'sapphzgv_induction');

define('SERVER_URL', 'https://induction.example.com');
define('APP_FOL', '/');
define('APP_NAME', 'Sapphire Induction');
define('SESSION_PREFIX', 'SAPPHIRE_INDUCTION');
define('TABLE_PREFIX', '');

define('ADMINEMAIL', 'info@sapphireinfo.net');
define('ADMIN_EMAIL', 'info@sapphireinfo.net');
define('FROM_EMAIL', 'info@sapphireinfo.net');

// Outgoing mail. A fresh VPS has no mail server, so use SMTP
// (e.g. Google Workspace, Zoho, or your old cPanel mailbox).
define('USE_MAILER', 'SMTP');
define('SMTP_SERVER', 'smtp.example.com');
define('SMTP_USERNAME', 'info@sapphireinfo.net');
define('SMTP_PASSWORD', 'CHANGE_ME');
define('SMTP_SECURITY', 'tls');
define('SMTP_PORT', 587);

define('CHAPTER_TEST_QUESTIONS', 5);
define('CHAPTER_TEST_PASS', 60);

define('TOTAL_TIME_ALL_CHAPTER', 30);
define('FINAL_TEST_PASS', 60);

define('FINAL_TEST_QUESTIONS', 12);
define('FINAL_COMM_TEST_QUESTIONS', 12);
define('FINAL_COMM_TEST_PASS', 60);

define('UPLOADS_CLIENT_DIR', __DIR__ . '/../uploads/client/');
