<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "StucoPortal"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM owner_users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: http://localhost/stuco/OwnerLanding/OwnerLanding.html");
        exit(); 
    } else {
        echo "Invalid username or password";
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
    <link rel="stylesheet" href="owner.css">
</head>
<body>
    <header class="headings">
        <img src="logo.png" alt="StuCo Logo">
        <h1>Owner Account Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-content">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit">Log In</button>
            </div>
        </form>
    </div>
</body>
</html>
