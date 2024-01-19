<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$admin_type = $_SESSION["adminType"];
$page = $_GET['page'] ?? 1;
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

// Initialize total_records variable
$total_records = 0;

switch ($admin_type) {
    case "Adviser":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.adviserStatus = 'Approved' 
                      AND dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    case "Branch Manager":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.adviserStatus = 'Approved' 
                      AND dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    case "CSDL Director":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.pass_to_admin_type = 'CSDL Director' AND 
                      dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    case "Marketing":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.pass_to_admin_type = 'Marketing' AND 
                      dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    case "Finance":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.pass_to_admin_type = 'Finance' AND 
                      dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    case "GSD":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.pass_to_admin_type = 'GSD' AND 
                      dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    case "COO":
        $sql_total = "SELECT COUNT(*) as total FROM document_transaction dt 
                      WHERE dt.pass_to_admin_type = 'COO' AND 
                      dt.on_process = true";
        $stmt_total = $conn->prepare($sql_total);
        break;
    default:
        echo json_encode(['total_pages' => 0]);
        exit();
}

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
