<?php  
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Fetch adviser details
$adminType = 'Adviser';
$department = $_SESSION['department']; // Assuming the session variable is named 'department'

$stmt = $conn->prepare("SELECT id, first_name, last_name, username, branch FROM admin_users WHERE admin_type = ? AND department = ?");
$stmt->bind_param("ss", $adminType, $department);
$stmt->execute();
if ($stmt->execute()) {
    // Fetch results
} else {
    error_log("SQL Error: " . $stmt->error);
}
$result = $stmt->get_result();
$advisers = [];
while ($row = $result->fetch_assoc()) {
    $advisers[] = $row;
}
// Fetch user details

$username = $_SESSION["username"];
$stmt2 = $conn->prepare("SELECT id, first_name, last_name, department, username, branch FROM council_user WHERE username = ?");
$stmt2->bind_param("s", $username);
$stmt2->execute();

$result2 = $stmt2->get_result();
$data = $result2->fetch_assoc();
?>