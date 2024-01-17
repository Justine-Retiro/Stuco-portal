<?php 
session_start();
header('Content-Type: application/json'); // Specify the content type as JSON
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Fetch user id from council_user using session["username"]
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM council_user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Fetch unread notifications for the logged-in user
$fetch_stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? AND read_at IS NULL ORDER BY created_at DESC");
$fetch_stmt->bind_param("i", $user_id);
$fetch_stmt->execute();
$notifications_result = $fetch_stmt->get_result();
$notifications = $notifications_result->fetch_all(MYSQLI_ASSOC);


echo json_encode($notifications); // Encode the notifications as JSON and output
?>