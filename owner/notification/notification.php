<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // user is not logged in, redirect them to the login page
    header('Location: ../../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Archives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
  <?php include "../components/sidebar.php";?>
  <div class="container ms-2 mt-5 fs-4">
        <div class="row ">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <h1 class="fs-1">Document notification</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 p-3 bg-light">
                            <table id="archive_table" class="table table-striped table-hover">
                                <!-- Reserved -->
                            </table>

                            <div class="modal fade" id="logTransaction" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Transaction log</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="bs-stepper">
                                                        <div class="bs-stepper-header">
                                                            <div class="step" data-target="#log-1">
                                                                <button type="button" class="step-trigger">
                                                                    <span class="bs-stepper-circle">1</span>
                                                                    <span class="bs-stepper-label">Start</span>
                                                                </button>
                                                            </div>
                                                            <div class="line"></div>
                                                            <div class="step" data-target="#log-2">
                                                                <button type="button" class="step-trigger">
                                                                    <span class="bs-stepper-circle">2</span>
                                                                    <span class="bs-stepper-label">Processing</span>
                                                                </button>
                                                            </div>
                                                            <div class="line"></div>
                                                            <div class="step" data-target="#log-3">
                                                                <button type="button" class="step-trigger">
                                                                    <span class="bs-stepper-circle">3</span>
                                                                    <span class="bs-stepper-label">Completed</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="bs-stepper-content">
                                                            <div id="log-1" class="content">
                                                                <p>Transaction started...</p>
                                                            </div>
                                                            <div id="log-2" class="content">
                                                                <p>Transaction is being processed...</p>
                                                            </div>
                                                            <div id="log-3" class="content">
                                                                <p>Transaction completed!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
  // Function to fetch and display user data
  function displayArchive() {
      $.ajax({
          url: '/Stuco/owner/notification/api/fetchdocument.php', // Replace with the correct URL
          method: 'GET',
          dataType: 'html', // Assuming the response is HTML
          success: function(data) {
              $('#archive_table').html(data); // Assuming you have a container with id 'user-data-container' to display the fetched data
          },
          error: function(xhr, status, error) {
              console.error('Error fetching user data: ' + error);
          }
      });
  }    
  displayArchive();

});
</script>
</body>
</html>