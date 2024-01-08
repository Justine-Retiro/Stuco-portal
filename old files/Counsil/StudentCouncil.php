<?php

$mysqli = new mysqli("localhost", "root", "", "StucoPortal");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$login_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $adminType = $_POST['adminType'];

    $query = "SELECT * FROM council_user WHERE username = ? AND password = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['admin_type'] == $adminType) {

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['adminType'] = $adminType;
            header('Location: http://localhost/stuco/CouncilLanding/CouncilLanding.html');
            exit();
        } else {
            $login_error = "Incorrect username, password, or admin type!";
        }
    } else {
        $login_error = "Incorrect username, password, or admin type!";
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="StudentCouncil.css">
</head>
<body>
    <header class="headings">
        <img src="logo.png" alt="StuCo Logo">
        <h1>Student Council Account<br>Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="StudentCouncil.php">
            <div class="form-content">
            <?php
                if (!empty($login_error)) {
                    echo "<p class='error'>$login_error</p>";
                }
                ?>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <select id="adminType" name="adminType">
                    <option value="Cma">Cma</option>
                    <option value="Coe">Coe</option>
                    <option value="Cit">Cit</option>
                    <option value="Ccje">Ccje</option>
                    <option value="Cahs">Cahs</option>
                </select>
                
                <button type="submit" class="btn btn-primary">Log In</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
