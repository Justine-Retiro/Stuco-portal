<?php
include '../../../connection/connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $admin_type = $_POST["roles"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'has_account';
        $response['message'] = 'It looks like this user already have an account.';
    } else {
        // Prepare the SQL statement
        $default_password = 0; 

        $stmt = $conn->prepare("INSERT INTO admin_users (username, default_password, admin_type, defaultpass_used) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $hashedPassword, $admin_type, $default_password);

        // Execute the statement
        if ($stmt->execute()) {
            $signupMessage = "Add user successfully";
            $response['status'] = 'success';      
            $response['message'] = $signupMessage;            
        } else {
            $response['status'] = 'fail';
            $message['message'] = $signupMessage = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
// header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>