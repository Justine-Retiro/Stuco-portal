<?php
include '../../../connection/connection.php';
session_start();
$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user_type is provided and set default response for missing user_type
    if (!isset($_POST["user_type"])) {
        $response['status'] = 'fail';
        $response['message'] = 'User type not provided.';
        header('Content-Type: application/json');
        echo json_encode($response);
        $conn->close();
        exit();
    }

    $user_type = $_POST["user_type"];
    $username = $_POST["username"] ?? null; // Use null coalescing operator as default if not provided

    // Initialize variables for optional fields
    $first_name = $_POST["first_name"] ?? null;
    $last_name = $_POST["last_name"] ?? null;
    $password = $_POST["password"] ?? null;
    $admin_type = $_POST["roles"] ?? null;
    $branch = $_POST["branch"] ?? null;
    $department = $_POST["department"] ?? null;


    // Conditional logic based on user_type
    switch ($user_type) {
        case 'owner':
            $updateFields = array();
            $params = array();
            $paramTypes = '';

            if (!empty($first_name)) {
                $updateFields[] = "first_name = ?";
                $params[] = $first_name;
                $paramTypes .= 's';
            }
            if (!empty($last_name)) {
                $updateFields[] = "last_name = ?";
                $params[] = $last_name;
                $paramTypes .= 's';
            }
            if (!empty($password)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateFields[] = "password = ?";
                $params[] = $hashedPassword;
                $paramTypes .= 's';
                // Include logic to update defaultpass_used field
                $updateFields[] = "defaultpass_used = 0";
            }
            if (!empty($admin_type)) {
                $updateFields[] = "admin_type = ?";
                $params[] = $admin_type;
                $paramTypes .= 's';
            }

            // Assuming 'users' table is used for all user types
            $sql = "UPDATE owner_users SET " . implode(', ', $updateFields) . " WHERE username = ?";
            $params[] = $username;
            $paramTypes .= 's';

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['status'] = 'fail';
                $response['message'] = "Error preparing statement: " . $conn->error;
            } else {
                $stmt->bind_param($paramTypes, ...$params);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'User updated successfully.';
                } else {
                    $response['status'] = 'fail';
                    $response['message'] = "Error executing statement: " . $stmt->error;
                }
                $stmt->close();
            }
        case 'admin':
            $updateFields = array();
            $params = array();
            $paramTypes = '';

            if (!empty($first_name)) {
                $updateFields[] = "first_name = ?";
                $params[] = $first_name;
                $paramTypes .= 's';
            }
            if (!empty($last_name)) {
                $updateFields[] = "last_name = ?";
                $params[] = $last_name;
                $paramTypes .= 's';
            }
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateFields[] = "password = ?";
                $params[] = $hashedPassword;
                $paramTypes .= 's';
            }
            if (!empty($admin_type)) {
                $updateFields[] = "admin_type = ?";
                $params[] = $admin_type;
                $paramTypes .= 's';
            }
            if (!empty($branch)) {
                $updateFields[] = "branch = ?";
                $params[] = $branch;
                $paramTypes .= 's';
            }
            if (!empty($department)) {
                $updateFields[] = "department = ?";
                $params[] = $department;
                $paramTypes .= 's';
            }

            // Assuming 'users' table is used for all user types
            $sql = "UPDATE admin_users SET " . implode(', ', $updateFields) . " WHERE username = ?";
            $params[] = $username;
            $paramTypes .= 's';

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['status'] = 'fail';
                $response['message'] = "Error preparing statement: " . $conn->error;
            } else {
                $stmt->bind_param($paramTypes, ...$params);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'User updated successfully.';
                } else {
                    $response['status'] = 'fail';
                    $response['message'] = "Error executing statement: " . $stmt->error;
                }
                $stmt->close();
            }
        case 'council':
            $updateFields = array();
            $params = array();
            $paramTypes = '';

            if (!empty($first_name)) {
                $updateFields[] = "first_name = ?";
                $params[] = $first_name;
                $paramTypes .= 's';
            }
            if (!empty($last_name)) {
                $updateFields[] = "last_name = ?";
                $params[] = $last_name;
                $paramTypes .= 's';
            }
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateFields[] = "password = ?";
                $params[] = $hashedPassword;
                $paramTypes .= 's';
            }
            if (!empty($admin_type)) {
                $updateFields[] = "admin_type = ?";
                $params[] = $admin_type;
                $paramTypes .= 's';
            }
            if (!empty($branch)) {
                $updateFields[] = "branch = ?";
                $params[] = $branch;
                $paramTypes .= 's';
            }
            if (!empty($department)) {
                $updateFields[] = "department = ?";
                $params[] = $department;
                $paramTypes .= 's';
            }

            // Assuming 'users' table is used for all user types
            $sql = "UPDATE council_user SET " . implode(', ', $updateFields) . " WHERE username = ?";
            $params[] = $username;
            $paramTypes .= 's';

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['status'] = 'fail';
                $response['message'] = "Error preparing statement: " . $conn->error;
            } else {
                $stmt->bind_param($paramTypes, ...$params);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'User updated successfully.';
                } else {
                    $response['status'] = 'fail';
                    $response['message'] = "Error executing statement: " . $stmt->error;
                }
                $stmt->close();
            }
        
            break;
        default:
            $response['status'] = 'fail';
            $response['message'] = 'Invalid user type.';
            break;
    }

    // Send the response
    header('Content-Type: application/json');
    echo json_encode($response);
    $conn->close();
} else {
    $response['status'] = 'fail';
    $response['message'] = 'Invalid request method.';
    header('Content-Type: application/json');
    echo json_encode($response);
    $conn->close();
}
?>