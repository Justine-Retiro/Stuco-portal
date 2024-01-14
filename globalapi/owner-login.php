<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $adminType = $_POST['adminType'];
    $table = "owner_users";

    // Sanitize the username input
    $username = trim($username); // Remove whitespace from the beginning and end
    $stmt = $conn->prepare("SELECT * FROM {$table} WHERE username = ? and admin_type = ?");
    $stmt->bind_param("ss", $username, $adminType ); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $owner_user = $result->fetch_assoc();
        $hashed_password = $owner_user["password"];
        $hashed_default_password = $owner_user["default_password"];
        $defaultpass_used = $owner_user["defaultpass_used"];

        // Check if defaultpass_used is 0 or false
        if (!$defaultpass_used || $defaultpass_used == 0) {
            // Check if the password is the default password
            if (password_verify($password, $hashed_default_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $owner_user["id"];
                $_SESSION["username"] = $username;
                $_SESSION["table"] = $table;

                $_SESSION["adminType"] = $owner_user["admin_type"];
                $_SESSION["defaultpass_used"] = 0; 

                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;

                $response['status'] = 'change_password';
                echo json_encode($response);
                exit;
            }
        } else if (password_verify($password, $hashed_password)) {
            // If defaultpass_used is true, check the password
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $owner_user["id"];
            $_SESSION["username"] = $username;
            $_SESSION["table"] = $table;

            $_SESSION["adminType"] = $owner_user["admin_type"];
            

            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;

            // Update the user's token in the database
            $updateQuery = "UPDATE {$table} SET token = ? WHERE username = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $token, $username);
            $updateStmt->execute();

            $response['status'] = 'success';
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