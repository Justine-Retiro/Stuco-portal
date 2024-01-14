<?php 
// include '../api/session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
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
                            <h1 class="fs-1">Document Status</h1>
                            <row class="fs-4">
                                <div class="col-lg-12 d-flex align-items-center ">
                                    <nav class="d-flex align-items-center" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a class="text-decoration-none" href="request.php">Request</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Document Status</li>
                                        </ol>
                                    </nav>
                                </div>
                            </row>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 p-3 bg-light">
                            <div class="row rounded-top">
                                <div class="col-lg-12 ">
                                    <!-- Whole top bar -->
                                    <div class="row d-flex justify-content-between ">
                                        <div class="col-lg-12 pb-3 w-100 bg-light d-flex justify-content-between align-items-center ">
                                            <div class="col-lg-3  d-flex justify-content-end" id="search-top-bar">
                                                <div class="input-group" >
                                                    <input class="form-control border rounded" type="text" placeholder="Search" id="search-input">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Search bar -->
                                        
                                        <!-- /Search bar -->
                                    </div>
                                </div>
                            </div>
                            <table id="status_table" class="table table-striped table-hover">
                                <thead>
                                    <!-- <tr>
                                        <th>Document ID</th>
                                        <th>From</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                            // include 'api/fetchdocument.php';
                                        ?>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="modal fade" id="logTransaction" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Transaction log</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="modal_body">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
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
<!-- <script src="static/modal.js"></script> -->
<script>
// Define displayTransactionLog in the global scope
function displayTransactionLog(documentId) {
    $.ajax({
        url: '/Stuco/council/request/api/fetchtransactionlog.php',
        method: 'GET',
        data: { document_id: documentId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modal_body').html(response.html);
                $('#logTransaction').modal('show'); // Make sure to show the modal if it's not already being shown
            } else {
                toastr.error(response.message || 'An error occurred');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Error fetching transaction log: ' + error);
        }
    });
}

$(document).ready(function() {
  // Function to fetch and display user data
  function displayStatus() {
    $.ajax({
        url: '/Stuco/council/request/api/fetchdocument.php', // Replace with the correct URL
        method: 'GET',
        dataType: 'json', // Change this to 'json' as the response is now a JSON object
        success: function(data) {
            if (data.status === 'success') {
                $('#status_table').html(data.html); // Use 'data.html' to update the HTML content
            } else {
                toastr.error(data.message || 'An error occurred'); // Show error message from response or a default one
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Error fetching user data: ' + error); // Show the error
        }
    });
}

  // Call displayStatus when the document is ready
  displayStatus();
});
</script>
</body>
</html>
