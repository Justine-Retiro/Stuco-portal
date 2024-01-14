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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="global_static/css/student.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Student Account<br>Change password</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="globalapi/student.php">
            <div class="form-content">
                <input class="form-control" type="password" name="password" placeholder="Username" required>
                <input class="form-control" type="password" id="confirm_password" name="password" placeholder="Password" required>
                <label class="form-control mb-3">
                    <div class="p-2 d-flex fs-5 align-items-center">
                        <input type="checkbox" id="show_password" class="me-3">
                        <label for="show_password" class="text-dark mb-0">Show Password</label>
                    </div>
                </label>
                <button type="submit" class="btn btn-success w-100">Change password</button>
            </div>
        </form>
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="global_static/js/student/validation.js"></script>
<script>
    $(document).ready(function() {
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // Check if there's a toastr message in the cookie
    $(document).ready(function() {
    // Check if there's a toastr message in the cookie
    var toastrMessage = sessionStorage.getItem('toastr');
    if (toastrMessage) {
        toastr.success(toastrMessage);
        sessionStorage.removeItem('toastr');
    }
});
// Function to get a cookie by name
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
});

</script>

</body>
</html>