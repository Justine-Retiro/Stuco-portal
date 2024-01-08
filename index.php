<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Portal</title>
    <link rel="stylesheet" href= "global_static/css/index.css">
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

        <div class="button-group">
            <button onclick="Student()">Student</button>
        </div>

        <div class="button-group">
            <button onclick="SignUp()">Sign Up</button>
        </div>
    </div>

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
        function Student() {
            window.location.href = "student.php";
        }
        function SignUp() {
            window.location.href = "signup.php";
        }
    </script>
</body>
</html>
