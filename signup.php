<?php 
if (isset($_SESSION['toastr'])) {
    echo '<script>sessionStorage.setItem("toastr", "'.$_SESSION['toastr'].'");</script>';
    unset($_SESSION['toastr']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="global_static/css/signup.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Create Account</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="globalapi/signup.php">
            <div class="form-content">
                <div id="errorAlert" class="alert alert-danger" role="alert" style="display: none;">
                <!-- Reserved for error messages -->
                </div>
                <input class="form-control" type="text" name="firstname" placeholder="First Name" required>
                <input class="form-control" type="text" name="middlename" placeholder="Middle Name">
                <input class="form-control" type="text" name="surname" placeholder="Surname" required>
                <select class="form-control" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <input type="email" class="form-control" name="gmail" placeholder="Gmail" required>

                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <button type="submit" class="btn btn-success">Sign Up</button>
                <div class="my-3">
                    <p>Already have an account? <br><a class="text-primary" href="student.php">Login here</a>.</p>
                </div>
            </div>
        </form>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="global_static/js/signup/validation.js"></script>
</body>
</html>
