<?php
include '../connection/connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashed_password = $user["password"];

        if (password_verify($password, $hashed_password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user["id"];
            $_SESSION["username"] = $username;

            $response['status'] = 'success';

            // header("Location: StudentLanding/student-landing.php");
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