<?php 
if (isset($_SESSION['toastr'])) {
    echo '<script>sessionStorage.setItem("toastr", "'.$_SESSION['toastr'].'");</script>';
    unset($_SESSION['toastr']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manager</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="bg-light">
    <?php include "../components/sidebar.php";?>

    <div class="container ms-2 mt-5 fs-4">
        <div class="row ">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <h1 class="fs-1">Manage User</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 p-3 bg-light">
                            <div class="row rounded-top">
                                <div class="col-lg-12 ">
                                    <!-- Whole top bar -->
                                    <div class="row d-flex justify-content-between ">
                                        <div class="col-lg-12 pb-3 w-100 bg-light d-flex justify-content-between align-items-center ">
                                            <div class="py-1 d-flex align-items-center pe-4 ">
                                                <div class="col-lg-12 d-flex align-items-center">
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('all')">All </button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('branch manager')">Branch Manager</button>                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('csdl director')">CSDL Director</button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('finance')">Finance</button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('gsd')">GSD</button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('coo')">COO</button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('adviser')">Adviser</button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('council')">Council</button>
                                                    </div>
                                                    <div class="col-md-3 pe-2 w-auto" >
                                                        <button class="btn text-primary-emphasis fs-4 fw-medium filter-btn" onclick="userfilter('student')">Student </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3  d-flex justify-content-end" id="search-top-bar">
                                                <div class="input-group" >
                                                    <input class="form-control border rounded" type="text" placeholder="Search" id="search-input">
                                                </div>
                                            </div>
                                            <div class="col-lg-13 me-5 d-flex justify-content-end">
                                            <a href="new/new.php" class="text-decoration-none text-light"><button class="btn btn-primary btn-lg float-end">Add user</button></a>
                                            </div>
                                        </div>
                                        <!-- Search bar -->
                                        
                                        <!-- /Search bar -->
                                    </div>
                                </div>
                            </div>
                            <table id="users_table" class="table table-striped table-hover">
                                <thead>
                                    <!-- <tr>
                                        <th>Index #</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Roles</th>
                                        <th></th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                            // include 'api/fetchuser.php';
                                        ?>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="modal fade" id="deleteModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete user</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you want to delete this user?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger btn-lg" id="confirmDelete">Confirm</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div id="pagination" class="pagination pagination-lg">
                                <!-- Reserved -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="text/javascript" src="static/userfilter.js"></script>
<script type="text/javascript" src="static/deletevalidation.js"></script>
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
    var toastrMessage = sessionStorage.getItem('toastr');
    if (toastrMessage) {
        toastr.success(toastrMessage);
        sessionStorage.removeItem('toastr');
    }

    // Function to fetch and display user data
    function fetchAndDisplayUserData() {
        $.ajax({
            url: '/Stuco/owner/account-manager/api/fetchuser.php', // Replace with the correct URL
            method: 'GET',
            dataType: 'html', // Assuming the response is HTML
            success: function(data) {
                $('#users_table').html(data); // Assuming you have a container with id 'user-data-container' to display the fetched data
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data: ' + error);
            }
        });
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
    
    fetchAndDisplayUserData();

});
</script>
</body>
</html>