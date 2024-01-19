<?php
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error.log');
error_log('This is a test error log');
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$response = array(); // Initialize $response as an array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['docu_id'], $_POST['action'], $_POST['feedback'], $_POST['pass_admin'])) {
        $docu_id = $_POST['docu_id'];
        $action = $_POST['action'];
        $feedback = $_POST["feedback"];
        if (isset($_POST['on_process'])) {
            $final_destination = $_POST["on_process"];
        } else {
            $final_destination = 'No'; // or some default value
        }
        $pass_to_admin = $_POST["pass_admin"];
        $username_admin = $_SESSION["username"];

        $stmnt = $conn->prepare("SELECT id, admin_type FROM admin_users WHERE username = ?");
        $stmnt->bind_param("s", $username_admin);
        $stmnt->execute();
        $result = $stmnt->get_result()->fetch_assoc();

        $admin_id = $result["id"];
        $admin_adminType = $_SESSION["adminType"];

        if ($admin_adminType == 'Adviser'){
            if ($action == 'approve') { // Change 'approved' to 'approve'
                $action_taken = 'Approved'; // Change 'approved' to 'Approved'
                $on_process = true;
                
                $stmt = $conn->prepare("UPDATE document_transaction SET adviserStatus = ?, adviser_feedback = ?, pass_to_admin_type = ?, on_process = ? WHERE docu_id = ?");
                $stmt->bind_param("sssii", $action_taken, $feedback, $pass_to_admin, $on_process, $docu_id);
        
                if ($stmt->execute()) {
                    error_log("Affected rows: " . $stmt->affected_rows);
                    if ($stmt->affected_rows > 0) {
                        $response["status"] = 'success';
                        // $response["message"] = "Adviser status updated successfully and affected rows.";
                    } else {
                        $response["status"] = 'success';
                        // $response["message"] = "Adviser status updated successfully but no rows affected.";
                    }
                } else {
                    $response["status"] = 'error';
                    // $response["message"] = "The query did not execute.";
                }
            } else if ($action == 'reject') { // Change 'rejected' to 'reject'
                $action_taken = 'Rejected'; // Change 'rejected' to 'Rejected'
                $on_process = false;
                $stmt = $conn->prepare("UPDATE document_transaction SET adviserStatus = ?, adviser_feedback = ?, final_admin_id = ?, final_adminType, final_response_time = NOW() , final_status = ?, final_response_message = ?, on_process = ? WHERE docu_id = ?");
                $stmt->bind_param("sssssii", $action_taken, $feedback, $admin_id, $final_adminType, $action_taken, $feedback, $on_process, $docu_id);
        
                if ($stmt->execute()) {
                    error_log("Affected rows: " . $stmt->affected_rows);
                    if ($stmt->affected_rows > 0) {
                        $response["status"] = 'success';
                        // $response["message"] = "Adviser status updated successfully and affected rows.";
                    } else {
                        $response["status"] = 'success';
                        // $response["message"] = "Adviser status updated successfully but no rows affected.";
                    }
                } else {
                    $response["status"] = 'error';
                    // $response["message"] = "The query did not execute.";
                }
            }
        } else{
            if ($final_destination === "Yes") {
                if ($action == 'approve') { // Change 'approved' to 'approve'
                    $action_taken = 'Approved'; // Change 'approved' to 'Approved'
                    $on_process = true;
                    
                    $stmt = $conn->prepare("UPDATE document_transaction SET final_admin_id = ?, final_adminType = ?, final_response_time = NOW() , final_status = ?, final_response_message = ?, on_process = ? WHERE docu_id = ?");
                    $stmt->bind_param("ssssii", $admin_id, $final_adminType, $action_taken, $feedback, $on_process, $docu_id);
            
                    if ($stmt->execute()) {
                        error_log("Affected rows: " . $stmt->affected_rows);
                        if ($stmt->affected_rows > 0) {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully and affected rows.";
                        } else {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully but no rows affected.";
                        }
                    } else {
                        $response["status"] = 'error';
                        // $response["message"] = "The query did not execute.";
                    }
                } else if ($action == 'reject') { // Change 'rejected' to 'reject'
                    $action_taken = 'Rejected'; // Change 'rejected' to 'Rejected'
                    $on_process = false;
                    $stmt = $conn->prepare("UPDATE document_transaction SET final_admin_id = ?, final_adminType = ?, final_response_time = NOW() , final_status = ?, final_response_message = ?, on_process = ? WHERE docu_id = ?");
                    $stmt->bind_param("ssssii", $admin_id, $final_adminType, $action_taken, $feedback, $on_process, $docu_id);
            
                    if ($stmt->execute()) {
                        error_log("Affected rows: " . $stmt->affected_rows);
                        if ($stmt->affected_rows > 0) {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully and affected rows.";
                        } else {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully but no rows affected.";
                        }
                    } else {
                        $response["status"] = 'error';
                        // $response["message"] = "The query did not execute.";
                    }
                }
            } elseif ($final_destination === "No") {
                if ($action == 'approve') { // Change 'approved' to 'approve'
                    $action_taken = 'Approved'; // Change 'approved' to 'Approved'
                    $on_process = true;
                    
                    $stmt = $conn->prepare("UPDATE document_transaction SET on_process = ?, pass_to_admin_type = ?, WHERE docu_id = ?");
                    $stmt->bind_param("sss", $on_process, $pass_to_admin, $docu_id);
            
                    if ($stmt->execute()) {
                        error_log("Affected rows: " . $stmt->affected_rows);
                        if ($stmt->affected_rows > 0) {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully and affected rows.";
                        } else {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully but no rows affected.";
                        }
                    } else {
                        $response["status"] = 'error';
                        // $response["message"] = "The query did not execute.";
                    }
                } else if ($action == 'reject') { // Change 'rejected' to 'reject'
                    $action_taken = 'Rejected'; // Change 'rejected' to 'Rejected'
                    $on_process = false;
                    $stmt = $conn->prepare("UPDATE document_transaction SET final_admin_id = ?, final_adminType, final_response_time = NOW() , final_status = ?, final_response_message = ?, on_process = ? WHERE docu_id = ?");
                    $stmt->bind_param("sssii", $admin_id, $final_adminType, $action_taken, $feedback, $on_process, $docu_id);
            
                    if ($stmt->execute()) {
                        error_log("Affected rows: " . $stmt->affected_rows);
                        if ($stmt->affected_rows > 0) {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully and affected rows.";
                        } else {
                            $response["status"] = 'success';
                            // $response["message"] = "Adviser status updated successfully but no rows affected.";
                        }
                    } else {
                        $response["status"] = 'error';
                        // $response["message"] = "The query did not execute.";
                    }
                }
            }
        }
        $sql = $conn->prepare("SELECT * FROM document_transaction WHERE docu_id = ?");
        $sql->bind_param("s", $docu_id);
        
        if ($sql->execute()) {
            // Fetch the result
            $result = $sql->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        
                // Get the necessary values from the fetched row
                $doc_type = $row["file_type"];
                $on_process = $row["on_process"];
                $doc_description = $row["document_description"];
                $admin_username = $_SESSION["username"];
                $admin_admin_type = $_SESSION["adminType"];
                $admin_department = $_SESSION["department"];
                $admin_branch = $_SESSION["branch"];

                
                $adminQuery = $conn->prepare("SELECT first_name, last_name, admin_type FROM admin_users WHERE username = ?");
                $adminQuery->bind_param("s", $admin_username);
                $adminQuery->execute(); // You need to execute the query before getting the result
                $result = $adminQuery->get_result(); // Now you can get the result
                $adminRow = $result->fetch_assoc(); // Fetch the data into an associative array


                
                if ($action == "approve" && $on_process == true) {
                    $prefix_message = "Your document has been approved by " . $adminRow["first_name"] . " " . $adminRow["last_name"] . ", " . $adminRow["admin_type"] . ", " . $adminRow["branch"];
                    if (!empty($pass_to_admin)) {
                        $prefix_message .= " and passed to " . $pass_to_admin;
                    }
                } elseif ($action == "reject") {
                    $prefix_message = "Your document has been rejected by " . $adminRow["first_name"] . " " . $adminRow["last_name"] . ", " . $adminRow["admin_type"] . ", " . $adminRow["branch"];
                } elseif (!empty($pass_to_admin)) {
                    $prefix_message = "Your document has been passed to " . $pass_to_admin . " by " . $adminRow["first_name"] . " " . $adminRow["last_name"] . ", " . $adminRow["admin_type"] . ", " . $adminRow["branch"];
                } else {
                    $prefix_message = "An unknown action has been taken on your document by " . $adminRow["first_name"] . " " . $adminRow["last_name"] . ", " . $adminRow["admin_type"] . ", " . $adminRow["branch"];
                }

                // After successfully inserting into transaction_log
                $notification_title = "New Document Update";
                $notification_message = $prefix_message; // Use the prefix_message from the transaction log
                $user_id = $row["sender_id"];

                $notification_stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message, docu_id) VALUES (?, ?, ?, ?)");
                $notification_stmt->bind_param("issi", $user_id, $notification_title, $notification_message, $docu_id);
                $notification_stmt->execute();

                // Prepare and execute the INSERT query for transaction_log
                $stmt_log = $conn->prepare("INSERT INTO transaction_log (document_id, doc_type, doc_description, admin_id, admin_username, admin_admin_type, admin_feedback, prefix_message, admin_department, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt_log->bind_param("sssssssss", $docu_id, $doc_type, $doc_description, $admin_id, $admin_username, $admin_admin_type, $feedback, $prefix_message, $admin_department);
                if ($stmt_log->execute()) {
                    // Log entry inserted successfully
                    $response["log_status"] = 'log_success';
                    $response["log_message"] = "Log entry added successfully.";
                } else {
                    // Log entry failed to insert
                    $response["log_status"] = 'log_error';
                    $response["log_message"] = "Failed to add log entry.";
                }
            } else {
                // No rows found for the given docu_id
                $response["log_status"] = 'log_error';
                $response["log_message"] = "No document found for the given docu_id.";
            }
        } else {
            // Query execution failed
            $response["log_status"] = 'log_error';
            $response["log_message"] = "Failed to execute the SELECT query.";
        }
    } else {
        $response["status"] = 'error'; // Define an error message for missing parameters
        $response["message"] = 'Missing required parameters.';
    }
} else {
    $response["status"] = 'error'; // Define an error message for incorrect request method
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
exit();
