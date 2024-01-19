<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// error_log("Session defaultpass_used: " . $_SESSION["defaultpass_used"]);
// error_log(print_r($admin_user, true));
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = trim($_POST['password']);
    $adminType = $_POST['adminType'];
    $table = "owner_users";

    // Sanitize the username input
    $username = trim($username); // Remove whitespace from the beginning and end
    $stmt = $conn->prepare("SELECT * FROM {$table} WHERE username = ? and admin_type = ?");
    $stmt->bind_param("ss", $username, $adminType ); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin_user = $result->fetch_assoc();
        error_log(print_r($admin_user, true));

        $hashed_password = $admin_user["password"];
        $hashed_default_password = $admin_user["default_password"];
        $defaultpass_used = $admin_user["defaultpass_used"];

        // Check if defaultpass_used is 0 or false
        if ($defaultpass_used === 0) {
            // Check if the password is the default password
            if (password_verify($password, $hashed_default_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $admin_user["id"];
                $_SESSION["username"] = $username;
                $_SESSION["table"] = $table;

                $_SESSION["adminType"] = $admin_user["admin_type"];
                $_SESSION["defaultpass_used"] = $admin_user["defaultpass_used"]; 

                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;

                $response['status'] = 'change_password';
                echo json_encode($response);
                exit;
            }
        } else if ($defaultpass_used === 1) {
            // If defaultpass_used is true, check the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set the session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $admin_user["id"];
                $_SESSION["username"] = $username;
                $_SESSION["table"] = $table;
        
                $_SESSION["adminType"] = $admin_user["admin_type"];
        
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
        
                // Update the user's token in the database
                $updateQuery = "UPDATE {$table} SET token = ? WHERE username = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ss", $token, $username);
                $updateStmt->execute();
        
                $response['status'] = 'success';
            } else {
                // Password is not correct
                $response['status'] = 'fail';
                $response['message'] = 'Invalid Password.';
            }
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Invalid Password.';
            echo json_encode($response);
        }
    } 
    $response['status'] = 'fail';
    $response['message'] = 'Invalid Credentials.';
    $stmt->close();
}
echo json_encode($response);
$conn->close();
?>