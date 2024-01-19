<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

function redirectToLogin() {
    header("Location: index.php"); // Redirect to login page
    exit();
}

function isUserLoggedIn() {
    return isset($_SESSION['loggedin'], $_SESSION['id'], $_SESSION['username'], $_SESSION['adminType'], $_SESSION["table"]);
}

function changePassword($newPassword) {
    global $conn; // Assuming $connection is your database connection variable from connection.php

    // Sanitize the new password
    $newPassword = mysqli_real_escape_string($conn, $newPassword);

    // Hash the new password before storing it
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Prepare the SQL statement to update the password
    $table = $_SESSION["table"];
    $userId = $_SESSION["id"];
    $adminType = $_SESSION["adminType"];
    $defaultpass_used = true;

    // Prepare the SQL statement to update the password
    $sql = "UPDATE {$table} SET password = ?, defaultpass_used = ? WHERE id = ? AND admin_type = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $stmt->bind_param("siss", $hashedPassword, $defaultpass_used, $userId, $adminType); 
    $stmt->execute();

    // Check if the password update was successful
    if ($stmt->affected_rows > 0) {
        return true; // Password change was successful
    } else {
        return false; // Password change failed
    }
}

if (!isUserLoggedIn()) {
    redirectToLogin();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST["password"];
    if (changePassword($password) == true) {
        $response["status"] = "success";
        $response["role"] = $_SESSION["adminType"];
    } else {
        $response["status"] = "fail";
        $response["message"] = "Password change failed";
    }
}
echo json_encode($response);
