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
    <link rel="stylesheet" href= "global_static/css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <header class="headings">
        <?php include "components/logo.php"; ?> 
        <h1>Student Council<br> Management Portal</h1>
    </header>

    <div class="button-background">
        <div class="button-group">
            <button onclick="MainWebsite()">Main Website</button>
        </div>

        <div class="button-group">
            <button onclick="Owner()">Owner</button>
        </div>

        <div class="button-group">
            <button onclick="Admin()">Admin</button>
        </div>

        <div class="button-group">
            <button onclick="StudentCouncil()">Student Council</button>
        </div>

        <!-- <div class="button-group">
            <button onclick="Student()">Student</button>
        </div> -->

        <!-- <div class="button-group">
            <button onclick="SignUp()">Sign Up</button>
        </div> -->
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
    function MainWebsite() {
        window.location.href = "https://www.phinma.edu.ph/";
    }
    function Owner() {
        window.location.href = "owner.php";
    }
    function Admin() {
        window.location.href = "admin.php";
    }
    function StudentCouncil() {
        window.location.href = "council.php";
    }

    $(document).ready(function() {
    // Check if there's a toastr message in the cookie
    var toastrMessage = sessionStorage.getItem('toastr');
    if (toastrMessage) {
        toastr.success(toastrMessage);
        sessionStorage.removeItem('toastr');
    }
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
