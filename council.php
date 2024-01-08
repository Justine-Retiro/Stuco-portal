<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="global_static/css/council.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Student Council <br> Account Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="globalapi/council-login.php">
            <div class="form-content w-auto">
                <div id="errorAlert" class="alert alert-danger" role="alert" style="display: none;">
                <!-- Reserved for error messages -->
                </div>
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required>
                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                <select id="adminType" class="form-control" name="adminType">
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="global_static/js/council/validation.js"></script>

</body>
</html>
