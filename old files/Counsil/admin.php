<?php

$mysqli = new mysqli("localhost", "root", "", "StucoPortal");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


    $username = $_POST['username'];
    $password = $_POST['password'];
    $adminType = $_POST['adminType'];

    $query = "SELECT * FROM admin_users WHERE username = '$username' AND password = '$password' AND admin_type = '$adminType'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['adminType'] = $adminType;
        header('Location: http://localhost/stuco/AdminLanding/AdminLanding.html');
        exit();
    } else {
        $login_error = "Incorrect username, password, or admin type!";
    }


$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="headings">
        <img src="logo.png" alt="StuCo Logo">
        <h1>Administrator Account<br>Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="admin.php">
            <div class="form-content">
                <?php
                if (isset($login_error)) {
                    echo "<p class='error'>$login_error</p>";
                }
                ?>
                <input type="text" name="username" id="username" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <select name="adminType" id="adminType">
                    <option value="Branch Manager">Branch Manager</option>
                    <option value="Adviser">Adviser</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
                    <option value="GSD">GSD</option>
                    <option value="COO">COO</option>
                </select>
                
                <button type="submit">Log In</button>
            </div>
        </form>
    </div>

    <script>
        <?php
        if (isset($_SESSION['username']) && isset($_SESSION['adminType'])) {
            echo "setTimeout(function() { alert('Login successful!'); }, 2000);";
            unset($_SESSION['username']);
            unset($_SESSION['adminType']);
        }
        ?>
    </script>
</body>
</html>