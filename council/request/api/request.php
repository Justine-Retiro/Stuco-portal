<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Function to handle file upload
function handleFileUpload($file, $department) {
    $targetDirectory = "uploads/"; // Specify the directory where files will be stored
    $prefix = $department . "_"; // Prefix the file name with the department
    $targetFile = $targetDirectory . $prefix . basename($file["name"]);
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
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        echo "Sorry, only PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile; // Return the path to the uploaded file
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $recipient = $_POST['recipient'];
    $fileType = $_POST['file_type'];
    $adminType = $_POST['admin_type'];
    $description = $_POST['description'];

    $sender_name = $firstName . $lastName;

    echo $sender_name;
    
    // // Handle file upload
    // $fileUrl = handleFileUpload($_FILES['file_url'], $adminType);

    // if ($fileUrl) {
    //     // Prepare an insert statement
    //     $sql = "INSERT INTO document_archives (recipient_username, sender_username, file_type, recipient_adminType, document_description, file_url, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    //     $stmt = $conn->prepare($sql);

    //     // Bind variables to the prepared statement as parameters
    //     $stmt->bind_param("ssssss", $recipient, $username, $fileType, $adminType, $description, $fileUrl);
        
    //     // Attempt to execute the prepared statement
    //     if ($stmt->execute()) {
    //         // Redirect or send a success response
    //         header("Location: success_page.php");
    //         exit();
    //     } else {
    //         // Handle error
    //         echo "Error: " . $stmt->error;
    //     }

    //     // Close statement
    //     $stmt->close();
    // }
}

$conn->close();
?>
