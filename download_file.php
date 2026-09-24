<?php
include_once 'includes/startup.php';

$file = $_GET['file'];
$filepath = __DIR__ . '/uploads/material/' . basename($file);

if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    exit;
} else {
    echo "File not found.";
}
