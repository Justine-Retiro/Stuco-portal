<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "StucoPortal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM signup WHERE username=?");
    $stmt->bind_param("s", $enteredUsername);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($enteredPassword === $row["password"]) {

            $_SESSION["username"] = $enteredUsername;
            
            header("Location: http://localhost/stuco/StudentLanding/studentLanding.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Username not found. Please sign up.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Portal</title>
    <link rel="stylesheet" href="student.css">
</head>
<body>
    <header class="headings">
        <img src="logo.png" alt="StuCo Logo">
        <h1>Student Account<br>Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="student.php">
            <div class="form-content">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Log In</button>
            </div>
        </form>
    </div>
</body>
</html>
