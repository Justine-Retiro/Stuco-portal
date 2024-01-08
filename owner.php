
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="global_static/css/owner.css">
</head>
<body>
    <header class="headings">
    <?php include "components/logo.php"; ?> 
        <h1>Owner Account Log In</h1>
    </header>

    <div class="Container"> 
        <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-content">
                <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit">Log In</button>
            </div>
        </form>
    </div>
    
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
