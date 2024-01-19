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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="global_static/css/signup.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Create Account</h1>
    </header>

    <div class="Container my-5"> 
        <form id="loginForm" method="post" action="globalapi/signup.php">
            <div class="form-content">
                <div id="errorAlert" class="alert alert-danger" role="alert" style="display: none;">
                <!-- Reserved for error messages -->
                </div>
                <input class="form-control" type="text" name="firstname" placeholder="First Name" required>
                <input class="form-control" type="text" name="middlename" placeholder="Middle Name">
                <input class="form-control" type="text" name="surname" placeholder="Surname" required>
                <div class="form-floating">
                    <select class="form-select" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="department">Gender</label>
                </div>

                <div class="form-floating">
                    <select class="form-select" id="department" name="department" required>
                        <option value="CMA">CMA</option>
                        <option value="COE">COE</option>
                        <option value="CIT">CIT</option>
                        <option value="CAHS">CAHS</option>
                        <option value="CCJE">CCJE</option>
                    </select>    
                    <label for="department">Department</label>
                </div>
                
                <div class="form-floating">
                    <select class="form-select" id="branch" name="branch" required>
                        <option value="Main Campus">Main Campus</option>
                        <option value="San Jose Campus">San Jose Campus</option>
                        <option value="South Campus">South Campus</option>
                    </select>   
                    <label for="branch">Branch</label>
                </div>
                  

                <input type="email" class="form-control" name="gmail" placeholder="Gmail" required>

                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <button type="submit" class="btn btn-success">Sign Up</button>
                <div class="my-2">
                    <p class="mb-0">Already have an account? <br><a class="text-primary" href="student.php">Login here</a>.</p>
                </div>
            </div>
        </form>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="global_static/js/signup/validation.js"></script>
</body>
</html>
