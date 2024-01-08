<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "StucoPortal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$signupMessage = "";
$usernameExists = false;
$accountCreated = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $surname = $_POST["surname"];
    $gender = $_POST["gender"];
    $gmail = $_POST["gmail"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM signup WHERE username='$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $usernameExists = true;
    } else {
        $sql = "INSERT INTO signup (firstname, middlename, surname, gender, gmail, username, password) VALUES ('$firstname', '$middlename', '$surname', '$gender', '$gmail', '$username', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            $accountCreated = true;
            $signupMessage = "Signup successful! You can now log in.";
        } else {
            $signupMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <link rel="stylesheet" href="signup.css">
    <script>
        <?php if ($usernameExists): ?>
            alert("Username already exists. Please choose a different username.");
        <?php elseif ($accountCreated): ?>
            alert("Account created successfully! You can now log in.");
        <?php endif; ?>
    </script>
</head>
<body>
    <header class="headings">
        <img src="logo.png" alt="StuCo Logo">
        <h1>Create Account</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="signup.php">
            <div class="form-content">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="middlename" placeholder="Middle Name">
                <input type="text" name="surname" placeholder="Surname" required>
                <select name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <input type="email" name="gmail" placeholder="Gmail" required>

                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="http://localhost/stuco/Counsil/student.html">Login here</a>.</p>
            </div>
        </form>
    </div>

    <div class="info-container">
        <p><?php echo $signupMessage; ?></p>
    </div>
</body>
</html>
