<?php
// Copy this file to config.php and fill in your database settings
// Local development settings

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', '');   // set your local MySQL password
define('DB_NAME', 'sapphzgv_induction');

define('SITE_NAME', 'Sapphire Induction');
define('SESSION_PREFIX', 'SAPPHIRE_INDUCTION_');
define('TABLE_PREFIX', '');
define('MAGIC_QUOTES', false);

define('SITE_DIR', dirname(__DIR__) . '/');
define('UPLOADS_DIR', SITE_DIR . 'uploads/');
define('UPLOADS_URL', 'uploads/');
// Files published by the admin panel for the "Files Download/Upload" round
define('SITE_ADMIN_UPLOADS_DIR', UPLOADS_DIR);

define('CHAPTER_TEST_QUESTIONS', 12);
define('CHAPTER_TEST_PASS', 60);          // percentage
define('FINAL_TEST_QUESTIONS', 12);
define('FINAL_TEST_MINUTES', 60);
define('TOTAL_TIME_ALL_CHAPTER', 30);     // hours
