<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$page = $_GET['page'] ?? 1;
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

// Initialize total_records variable
$total_records = 0;

$sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
    WHERE dt.on_process = false";
    $stmt_total = $conn->prepare($sql_total);

    
if (isset($stmt_total) && $stmt_total->execute()) {
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    $total_records = $row_total['total'];
} else {
    // Handle error, the statement couldn't be executed
    die("Error executing statement: " . ($stmt_total->error ?? 'Statement could not be prepared'));
}

$total_pages = ceil($total_records / $items_per_page);

echo json_encode(['total_pages' => $total_pages]);
?>
