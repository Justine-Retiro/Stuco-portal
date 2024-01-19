<?php
$response = array();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Function to handle file upload
function handleFileUpload($file, $department, $senderName, $documentId) {
    $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/stuco/documents/'; // Store files in the 'documents' directory at the document root
    $dateOfRequest = date("Ymd"); // Format: YYYYMMDD
    $prefix = $senderName . "-" . $department . $dateOfRequest . "-" . $documentId . "_"; // Prefix the file name with the sender name, date of request, and document ID
    $filename = preg_replace('/\s+/', '_', basename($file["name"])); // Replace spaces with underscores
    $targetFile = $targetDirectory . $prefix . $filename;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 500000) { // Limit file size to 500KB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx" && $fileType != "xlsx" ) {
        echo "Sorry, only PDF, Excel, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true); // Create the directory with the correct permissions
        }
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile; // Return the path to the uploaded file
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}

function generateDocumentId() {
    // $timestamp = time(); // Current timestamp
    $randomNumber = rand(1000, 9999); // Random number for additional uniqueness
    return $randomNumber; // Concatenate them to form the document ID
}

function getRecipientDetails($recipientUsername) {
    global $conn;

    if (empty($recipientUsername)) {
        error_log("Recipient username is empty.");
        return false;
    }

    $sql = "SELECT id, username, admin_type, department, branch FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $recipientUsername);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        error_log("No recipient_username found with username: $recipientUsername");
        return false;
    }

    return $result->fetch_assoc(); // Fetch and return the recipient_username details as an associative array
}

function getSenderDetails($sender_username) {
    global $conn;

    if (empty($sender_username)) {
        error_log("Sender username is empty.");
        return false;
    }

    $sql = "SELECT id, first_name, last_name, department, username, branch, admin_type FROM council_user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $sender_username);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        error_log("No sender found with username: $sender_username");
        return false;
    }

    return $result->fetch_assoc(); // Fetch and return the sender details as an associative array
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug output
    error_log(print_r($_POST, true));

    // Retrieve form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $sender_username = $_POST['username'];
    $recipientUsername = $_POST['recipient_username']; // Use $recipientUsername instead of $recipient_username
    $fileType = $_POST['file_type'];
    $recipientDepartment = $_POST['recipient_department'];
    $description = $_POST['description'];
    


    // Generate a unique document ID
    $documentId = generateDocumentId();
    
    $senderName = $firstName . "_" . $lastName; // Use underscore to separate first and last name

    // Fetch recipient_username details based on the provided username
    $recipientDetails = getRecipientDetails($recipientUsername);
    $sender_details = getSenderDetails($sender_username);


    // error_log(print_r($recipientDetails, true));
    
    if ($recipientDetails === false) {
        $response["status"] = 'fail';
        $response["message"] = 'Recipient details not found.';
    }

    if (isset($_FILES['file_url']) && $_FILES['file_url']['error'] == UPLOAD_ERR_OK) {
        // Recipient extra detail
        $recipient_id = $recipientDetails['id'];
        $recipient_username = $recipientDetails['username'];
        $recipient_adminType = $recipientDetails['admin_type'];
        // $recipient_department = $recipientDetails['department'];
        $recipient_branch = $recipientDetails['branch'];

        // Sender extra detail

        $sender_id = $sender_details["id"];
        $sender_username = $sender_details["username"];
        $sender_firstname = $sender_details["first_name"];
        $sender_lastname = $sender_details["last_name"];
        $sender_adminType = $sender_details["admin_type"];

        $sender_department = $sender_details["department"];
        
        $sender_branch = $sender_details["branch"];
        // Handle file upload
        $fileUrl = handleFileUpload($_FILES['file_url'], $sender_department, $senderName, $documentId);

        if ($fileUrl === false) {
            $response["status"] = 'fail';
            $response["message"] = "File upload failed.";
        }

        // Prepare an insert statement
        $sql = "INSERT INTO document_transaction (docu_id, recipient_id, sender_id, recipient_username, recipient_adminType, recipient_department, recipient_branch, sender_username, sender_department, sender_branch, sender_adminType, file_type, document_description, file_url, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $response["status"] = 'fail';
            $response["message"] = "Prepare failed: " . $conn->error;
            exit;
        }

        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssssssssssss", $documentId, $recipient_id, $sender_id, $recipient_username, $recipient_adminType, $recipientDepartment, $recipient_branch, $sender_username, $sender_department, $sender_branch, $sender_adminType, $fileType, $description, $fileUrl);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $response["status"] = 'success';
            $response["message"] = 'Successfully Submitted';
        } else {
            $response["status"] = 'fail';
            $response["message"] = "Execute failed: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Handle the case where file upload is not successful or not set
        $response["status"] = 'fail';
        if (isset($_FILES['file_url'])) {
            $response["message"] = 'File upload error: ' . $_FILES['file_url']['error'];
        } else {
            $response["message"] = 'File not provided.';
        }
    }
}

// Close the connection only once, here at the end of the script
$conn->close();

echo json_encode($response);
exit();
?>
