<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$username = $_GET['username'] ?? null;

if ($username) {
    $sql = "SELECT * FROM (
                SELECT 'admin_users' as source_table, username, branch, NULL as department, admin_type FROM admin_users WHERE username = ?
                UNION ALL
                SELECT 'owner_users' as source_table, username, NULL as branch, NULL as department, admin_type FROM owner_users WHERE username = ?
                UNION ALL
                SELECT 'council_user' as source_table, username, branch, department, admin_type FROM council_user WHERE username = ?
                UNION ALL
                SELECT 'users' as source_table, username, branch, NULL as department, admin_type FROM users WHERE username = ?
            ) as combined LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    echo json_encode($user);
}
?>