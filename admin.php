<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="global_static/css/admin.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Administrator Account<br>Log In</h1>
    </header>

    <div class="Container my-5"> 
        <form id="loginForm" action="globalapi/admin.php"  method="post" >
            <div class="form-content">
                <div id="errorAlert" class="alert alert-danger" role="alert" style="display: none;">
                <!-- Reserved for error messages -->
                </div>

                <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                
                <div class="d-flex align-items-center form-check">
                    <input class="form-check-input" type="checkbox" id="show_password">
                    <label for="show_password" class="form-check-label ms-2 mb-0">Show Password</label>
                </div>

                <div class="form-floating">
                    <select class="form-control" name="adminType" id="adminType">
                        <option value="Branch Manager">Branch Manager</option>
                        <option value="Adviser">Adviser</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="GSD">GSD</option>
                        <option value="COO">COO</option>
                    </select>
                    <label for="adminType">Role</label>
                </div>
                
                <button type="submit">Log In</button>
            </div>
        </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="global_static/js/admin/validation.js"></script>

</body>
</html>