<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $adminType = $_POST['adminType'];

    $table = "users";

    // Sanitize the username input
    $username = trim($username); // Remove whitespace from the beginning and end
    $stmt = $conn->prepare("SELECT * FROM {$table} WHERE username = ?");
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $users = $result->fetch_assoc();
        
        $hashed_password = $users["password"];
        $hashed_default_password = $users["default_password"];
        $defaultpass_used = $users["defaultpass_used"];

        // Check if defaultpass_used is 0 or false
        if (!$defaultpass_used) {
            // Check if the password is the default password
            if (password_verify($password, $hashed_default_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $users["id"];
                $_SESSION["username"] = $username;
                $_SESSION["table"] = $table;

                $_SESSION["adminType"] = $users["admin_type"];
                $_SESSION["defaultpass_used"] = $users["defaultpass_used"];

                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;

                $response['status'] = 'change_password';
                echo json_encode($response);
                exit;
            }
        } else if (password_verify($password, $hashed_password)) {
            // If defaultpass_used is true, check the password
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $users["id"];
            $_SESSION["username"] = $username;
            $_SESSION["adminType"] = $users["admin_type"];
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;

            // Update the user's token in the database
            $updateQuery = "UPDATE {$table} SET token = ? WHERE username = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $token, $username);
            $updateStmt->execute();

            $response['status'] = 'success';
            
            exit;
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Invalid Password.';
        }
    } 
    $response['status'] = 'fail';
    $response['message'] = 'Invalid Credentials.';
    $stmt->close();
}
echo json_encode($response);
$conn->close();
?>