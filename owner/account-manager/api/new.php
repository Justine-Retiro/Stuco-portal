<?php
include '../../../connection/connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["username"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $password = $_POST["password"];
    $admin_type = $_POST["roles"];
    $branch = $_POST["branch"];
    $department = $_POST["department"];
    $user_type = $_POST["user_type"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $defaultpass_used = 0; 


    // Check if the user already exists in any of the tables
    $usercheck = "SELECT * FROM (
        SELECT 'admin_users' as source_table, username, admin_type FROM admin_users
        UNION ALL
        SELECT 'owner_users', username, admin_type FROM owner_users
        UNION ALL
        SELECT 'council_user', username, admin_type FROM council_user
        UNION ALL
        SELECT 'users', username, admin_type FROM users
    ) as combined WHERE username = ?";

    $stmt = $conn->prepare($usercheck);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'has_account';
        $response['message'] = 'It looks like this user already has an account.';
    } else {
        // Insert user into the correct table based on role
        if ($user_type == 'admin') {
            $insertQuery = "INSERT INTO admin_users (username, first_name, last_name, branch, department, admin_type, default_password, defaultpass_used) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        } elseif ($user_type == 'owner') {
            $insertQuery = "INSERT INTO owner_users (username, admin_type, default_password, defaultpass_used) VALUES (?, ?, ?, ?)";
        } elseif ($user_type == 'council') {
            $insertQuery = "INSERT INTO council_user (username, first_name, last_name, branch, department, admin_type, default_password, defaultpass_used) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        } else {
            $insertQuery = "INSERT INTO users (username, first_name, last_name, branch, department, admin_type, default_password, defaultpass_used) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        }

        $stmt = $conn->prepare($insertQuery);


        if ($user_type == 'admin') {
            $stmt->bind_param("sssssssi", $username, $first_name, $last_name, $branch, $department, $admin_type, $hashedPassword, $defaultpass_used);
        } elseif ($user_type == 'council') {
            $stmt->bind_param("sssssssi", $username, $first_name, $last_name, $branch, $department, $admin_type, $hashedPassword, $defaultpass_used);
        } elseif ($user_type== 'owner') {
            $stmt->bind_param("sssi", $username, $admin_type, $hashedPassword, $defaultpass_used);
        }else {
            $stmt->bind_param("sssssssi", $username, $first_name, $last_name, $branch, $department ,$admin_type, $hashedPassword, $defaultpass_used);
        }

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'User added successfully.';
        } else {
            $response['status'] = 'fail';
            $response['message'] = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
// header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>