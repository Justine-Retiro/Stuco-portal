<?php
session_start();

// Check if the file parameter is set
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];

    // Perform security checks here to ensure the file is within a safe directory
    // and the user has permission to download it

    // If checks pass, proceed with download
    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        flush(); // Flush system output buffer
        readfile($filePath);
        exit;
    }
}

// If the file parameter is not set or the file does not exist, handle the error
header("HTTP/1.0 404 Not Found");
echo "File not found.";
exit;
?>