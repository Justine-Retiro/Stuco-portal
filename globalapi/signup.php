<?php
include '../connection/connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $surname = $_POST['surname'];
    $gender = $_POST['gender'];
    $gmail = $_POST["gmail"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'has_account';
        $response['message'] = 'It looks like you already have an account. Please log in to access your account.';
    } else {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (firstname, middlename, surname, gender, gmail, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstname, $middlename, $surname, $gender, $gmail, $username, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            $accountCreated = true;
            $signupMessage = "Signup successfully";
            $response['status'] = 'success';      
            $response['message'] = $signupMessage;            
        } else {
            $response['status'] = 'fail';
            $message['message'] = $signupMessage = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>