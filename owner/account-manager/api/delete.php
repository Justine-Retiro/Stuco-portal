<?php
session_start(); // Start the session to access the CSRF token

require_once($_SERVER['DOCUMENT_ROOT'] . '/stuco/connection/connection.php');

function deleteUser($username, $role, $source_table) {
    global $conn; // Use the existing database connection

    // The table name is dynamic, so we need to whitelist the possible table names to prevent SQL injection
    $allowed_tables = ['admin_users', 'council_user', 'owner_users','users'];
    if (!in_array($source_table, $allowed_tables)) {
        die("Invalid source table");
    }

    // Prepare the delete statement using the correct column name for the role
    $stmt = $conn->prepare("DELETE FROM {$source_table} WHERE username = ? AND admin_type = ?"); // Assuming 'admin_type' is the correct column name
    $stmt->bind_param("ss", $username, $role);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Check if the request is a POST request and the 'username', 'role', 'source_table', and 'csrf_token' parameters are set
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["username"], $_POST["role"], $_POST["source_table"], $_POST["csrf_token"])) {
        // Verify the CSRF token
        if ($_POST["csrf_token"] === $_SESSION['csrf_token']) {
            $username = $_POST["username"];
            $role = $_POST["role"];
            $source_table = $_POST["source_table"];
            
            // error_log("Username: " . $username);
            // error_log("Role: " . $role);
            // error_log("Source Table: " . $source_table);
        
            deleteUser($username, $role, $source_table);
        } else {
            die("CSRF token mismatch.");
        }
    } else {
        // Log which variables are not set
        $missing = ['username', 'role', 'source_table', 'csrf_token'];
        foreach ($missing as $param) {
            if (!isset($_POST[$param])) {
                error_log("Missing parameter: " . $param);
            }
        }
        echo "Invalid request. Missing parameters.";
    }
} else {
    echo "Invalid request. This script only accepts POST requests.";
}
?>