<?php 
include '../api/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
  <?php include "../components/sidebar.php";?>
  <div class="container ms-2 mt-5 fs-4 w-100">
        <div class="row ">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <h1 class="fs-1">Document Archive</h1>
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
                            <table id="archive_table" class="table table-striped table-hover">
                                <thead>
                                    <!-- Reserved -->
                                </thead>
                                <tbody>
                                    <!-- Reserved -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>

function displayTransactionLog(documentId) {
    $.ajax({
        url: '/Stuco/council/archives/api/fetchtransactionlog.php',
        method: 'GET',
        data: { document_id: documentId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modal_body').html(response.html);
                $('#logTransaction').modal('show');
            } else if (response.status === 'info') {
                // Handle the case where the document is on view but has no transaction logs
                $('#modal_body').html(response.html);
                $('#logTransaction').modal('show');
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Error fetching transaction log: ' + error);
        }
    });
}

$(document).ready(function() {
    
    $('#search-input').on('keyup', function() {
        var query = $(this).val();
        search_bar(query);
    });

    function search_bar(query) {
    $.ajax({
        url: '/Stuco/council/archives/api/searchdocu.php',
        type: 'GET',
        data: { query: query },
        success: function(data) {
            $('#archive_table').html(data);
        },
        error: function(xhr, status, error) {
            console.error('An error occurred:', error);
        }
    });
}
  // Function to fetch and display user data
  function displayRequest() {
      $.ajax({
          url: '/Stuco/council/archives/api/fetchdocument.php', // Replace with the correct URL
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
  displayRequest();
});
</script>
</body>
</html>