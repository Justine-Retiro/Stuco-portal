<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');


error_log("Username: " . $_SESSION["username"]);
error_log("Admin Type: " . $_SESSION["adminType"]);
error_log("Default Password Used: " . $_SESSION["defaultpass_used"]);


function redirectToMainPage() {
    // header("Location: index.php"); // Replace 'main_page.php' with the actual main page or dashboard
    error_log("Username: " . $_SESSION["username"]);
    error_log("Admin Type: " . $_SESSION["adminType"]);
    error_log("Default Password Used: " . $_SESSION["defaultpass_used"]);
    // exit;
}

// Check if the session variable for username is set
if(isset($_SESSION["username"]) && isset($_SESSION["adminType"])) {
    // Session variable is set, you can use it
    $username = $_SESSION["username"];
    $table = $_SESSION["table"];

    $stmt = $conn->prepare("SELECT * FROM {$table} WHERE username = ?");
    $stmt->bind_param("s", $username ); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        if(isset($_SESSION["defaultpass_used"]) && $_SESSION["defaultpass_used"] == false) {
            // The default password is still in use, allow access to change password
        } else {
            // The password has already been changed, redirect to main page
            echo "Nigga did not changed";
            // header("Location: index.php");
            // exit();
        }
    }
} else {
    // Session variable is not set, handle accordingly
    header("Location: index.php");
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

    <link rel="stylesheet" href="global_static/css/change_password.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>StuCo Account
            <br> Change Password</h1>
    </header>

    <div class="Container my-5"> 
        <form id="changeForm" method="post" action="globalapi/password_change.php">
            <div class="form-content">
                <div id="errorAlert" class="alert alert-danger" role="alert" style="display: none;">
                <!-- Reserved for error messages -->
                </div>
                <input class="form-control password_input" type="password"  name="password" placeholder="Password" required>
                <input class="form-control password_input" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <div class="form-control" id="password_container" style="display: none;">
                    <small id="passwordValid" class="form-text text-start text-muted" ></small>
                </div>
                

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
<script src="global_static/js/change_password/validation.js"></script>
</body>
</html>