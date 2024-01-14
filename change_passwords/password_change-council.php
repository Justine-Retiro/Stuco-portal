<?php 
session_start();
// Check if the session variable for username is set
if(isset($_SESSION["username"])) {
    // Session variable is set, you can use it
    $username = $_SESSION["username"];
} else {
    // Session variable is not set, handle accordingly
    // For example, redirect to login page
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="../global_static/css/student.css">
</head>
<body>
    <header class="headings">
    <?php include "../components/logo.php"; ?> 
        <h1>Student Account<br>Change password</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="globalapi/council-login.php">
            <div class="form-content">
                <input class="form-control password_show" type="password"  name="password" placeholder="Password" required>
                <input class="form-control password_show" type="password" id="confirm_password" name="password" placeholder="Confirm Password" required>
                
                <div class="d-flex align-items-center form-check">
                    <input class="form-check-input" type="checkbox" id="show_password">
                    <label for="show_password" class="form-check-label ms-2 mb-0">Show Password</label>
                </div>

                <button type="submit" class="btn btn-success w-100">Change password</button>
            </div>
        </form>
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="../global_static/js/change_password/validation.js"></script>
</body>
</html>