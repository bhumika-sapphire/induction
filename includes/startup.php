<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');

// Legacy pages read many optional request keys directly; only surface real errors
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', '1');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$conn = new DBConnection(DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME);
