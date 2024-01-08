<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="global_static/css/admin.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Administrator Account<br>Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="globalapi/admin.php">
            <div class="form-content">
                <?php
                if (isset($login_error)) {
                    echo "<p class='error'>$login_error</p>";
                }
                ?>
                <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                <select class="form-control" name="adminType" id="adminType">
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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