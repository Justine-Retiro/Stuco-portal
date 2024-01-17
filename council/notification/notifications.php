<?php
include '../api/session.php';
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $adminType = $_SESSION['adminType'];
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Notification</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php include "../components/sidebar.php";?>
    
    <div class="container ps-5 ms-2 mt-5">
        <div class="col-lg-12 d-flex justify-content-between">
            <h1>Notification</h1>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-12 fs-4" >
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-between">
                        <div class="col-lg-12" id="notification-container"></div>
                            <!-- <div class="col-lg-11 d-flex justify-content-between" id="top" >

                            </div>

                            <div class="col-lg-7" id="desc">
                            </div> -->
                        <div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="static/getnotif.js"></script>
</body>
</html>
