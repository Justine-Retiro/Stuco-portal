<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Define how many items to show on each page
$items_per_page = 20;

$status = $_GET['adminType'] ?? 'all';

if ($status === 'all') {
    $sql = "SELECT COUNT(*) as total FROM (
    SELECT 'admin_users' as source_table, username, admin_type FROM admin_users
    UNION ALL
    SELECT 'owner', username, admin_type FROM owner_users
    UNION ALL
    SELECT 'council_user', username, admin_type FROM council_user
    UNION ALL
    SELECT 'users', username, admin_type FROM users
    ) as combined";
} else {
    $sql = "SELECT COUNT(*) as total FROM (
        SELECT username, admin_type FROM admin_users WHERE admin_type = ?
        UNION ALL
        SELECT username, admin_type FROM owner_users WHERE admin_type = ?
        UNION ALL
        SELECT username, admin_type FROM council_user WHERE admin_type = ?
        UNION ALL
        SELECT username, admin_type FROM users WHERE admin_type = ?
    ) as combined";
}

$stmt = $conn->prepare($sql);

if ($status !== "all") {
    $stmt->bind_param("ssss", $status, $status, $status, $status);
}

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_records = $row['total'];

$items_per_page = 20;
$total_pages = ceil($total_records / $items_per_page);

echo json_encode(['total_pages' => $total_pages]);
?>