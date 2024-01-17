<?php
include '../api/session.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');


$documentId = $_GET["documentid"]; // Assuming you're getting the document ID from the query string

$stmt = $conn->prepare("
    SELECT dt.*, 
           sender.first_name AS sender_first_name, 
           sender.last_name AS sender_last_name, 
           recipient.first_name AS recipient_first_name, 
           recipient.last_name AS recipient_last_name
    FROM document_transaction dt
    LEFT JOIN council_user sender ON dt.sender_username = sender.username
    LEFT JOIN admin_users recipient ON dt.recipient_username = recipient.username
    WHERE dt.docu_id = ?
");
$stmt->bind_param("s", $documentId);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

// $documentId = $_GET["documentid"];

// $stmt = $conn->prepare("
//     SELECT dt.recipient_username, dt.recipient_adminType, dt.file_type, cu.first_name, cu.last_name 
//     FROM document_transaction dt
//     INNER JOIN council_user cu ON dt.sender_username = cu.username
//     WHERE dt.docu_id = ?
// ");
// $stmt->bind_param("s", $documentId);
// $stmt->execute();

// $result = $stmt->get_result();
// $row = $result->fetch_assoc();

// $documentId = $_GET["documentid"];

// $stmt = $conn->prepare("SELECT * FROM document_transaction WHERE docu_id = ?");
// $stmt->bind_param("s", $documentId);
// $stmt->execute();

// $result = $stmt->get_result();
// $row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php include "../components/sidebar.php";?>
    
    <div class="container ps-5 ms-2 mt-5 ">
        <div class="col-lg-12">
            <h1>Document View</h1>
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
       
        <div class="row pt-4">
            <hr>
                <div class="col-lg-12 mt-3">
                    <form id="requestForm" action="/stuco/admin/request/api/processdocument.php" method="post" enctype="multipart/form-data">
                        <div id="errorAlert" class="alert alert-danger fs-5" role="alert" style="display: none;">
                        <!-- Reserved for error messages -->
                        </div>   

                        <div class="container">
                            <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label fs-4 text-dark">Sender First Name</label>
                                <input type="text" class="form-control form-control fs-4" name="sender_first_name" value="<?php echo htmlspecialchars($row["sender_first_name"]); ?>" disabled readonly>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label fs-4 text-dark">Sender Last Name</label>
                                <input type="text" class="form-control form-control fs-4" name="sender_last_name" value="<?php echo htmlspecialchars($row["sender_last_name"]); ?>" disabled readonly>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label fs-4 text-dark">Recipient First Name</label>
                                <input type="text" class="form-control form-control fs-4" name="recipient_first_name" value="<?php echo htmlspecialchars($row["recipient_first_name"]); ?>" disabled readonly>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label fs-4 text-dark">Recipient Last Name</label>
                                <input type="text" class="form-control form-control fs-4" name="recipient_last_name" value="<?php echo htmlspecialchars($row["recipient_last_name"]); ?>" disabled readonly>
                            </div>

                                <div class="col-lg-6">
                                    <input type="hidden" class="form-control form-control fs-4" name="docu_id" value="<?php echo $row["docu_id"] ?>" readonly>
                                </div>


                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Sender Username</label>
                                    <input type="text" class="form-control form-control fs-4" name="username" value="<?php echo $row["sender_username"] ?>" disabled readonly>
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Recipient Username</label>
                                    <input type="text" class="form-control form-control fs-4" name="recipient" value="<?php echo $row["recipient_username"] ?>" disabled readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Document Type</label>
                                    <input type="text" class="form-control form-control fs-4" name="file_type" value="<?php echo $row["file_type"] ?>" disabled readonly>
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Council Department</label>
                                    <input type="text" class="form-control form-control fs-4" name="file_type" value="<?php echo $row["sender_department"] ?>" disabled readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label fs-4 text-dark">Attachment Document</label>
                                    <a href="api/download.php?file_url=<?php echo urlencode($row["file_url"]); ?>" class="form-control form-control-lg text-decoration-none">Download Document</a>
                                    <!-- <button type="button" class="btn btn-primary btn-lg my-3" data-bs-toggle="modal" data-bs-target="#documentView">
                                        View Document
                                    </button> -->
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label fs-4 text-dark">Description</label>
                                    <textarea type="text" class="form-control form-control-lg" name="description" disabled readonly><?php echo $row["document_description"] ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12 mb-3 on_process" style="display: none;">
                                    <label class="form-label fs-4 text-dark" for="on_process">Final destination?</label>
                                    <select class="form-control form-control-lg" name="on_process" id="on_process">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 pass_admin">
                                    <label class="form-label fs-4 text-dark" for="pass_admin">Pass to admin</label>
                                    <select class="form-control form-control-lg" name="pass_admin" id="pass_admin">
                                        <option value="CSDL Director">CSDL Director</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="GSD">GSD</option>
                                        <option value="COO">COO</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label fs-4 text-dark" for="feedback">Feedback</label>
                                    <textarea type="text" class="form-control form-control-lg" name="feedback"></textarea>
                                </div>
                            </div>

                            <br>

                            <button class="btn btn-success btn-lg approved-docu" value="Approve">Approve</button>
                            <button class="btn btn-danger btn-lg reject-docu" value="Reject">Reject</button>
                                                        
                        </div>
                    </form>
                </div>
                <!-- <div class="modal fade" id="documentView" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Document Viewer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed src="/documents/asdczxc_zxcasd-CIT20240108-17047257296139_5_Project_Proposals_.pdf" width="100%" height="400px">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- <script src="static/validation.js"></script> -->
<script>
$(document).ready(function(){
    var is_approve = "<?php echo $row['adviserStatus']; ?>";
    var on_process = "<?php echo $row['on_process']; ?>";
    var docu_id = "<?php echo $row["docu_id"]; ?>";

    // Admin Identifier
    var admin_type = "<?php echo $_SESSION["adminType"] ?>";
    
    console.log(admin_type);

    if (admin_type === "Adviser") {
        $('.on_process').hide();
        $('.pass_admin').hide();
    } else {
        $('.on_process').show();
        $('.pass_admin').show();

        $('#on_process').change(function() {
            var on_process_status = $(this).val();
            if (on_process_status === "Yes") {
                $('.pass_admin').hide()
                $('#pass_admin').hide().val(false).prop('disabled', true);
            } else {
                $('.pass_admin').show();
                $('#pass_admin').show().prop('disabled', false, 'required', true);
            }
        }).trigger('change'); // Trigger the change event on page load to set the initial state
    } 


    // Function to process the loan action
    function processdocument(docu_id, feedback, pass_admin, final_destination, action, btn_container) {
      $.ajax({
        type: 'POST',
        url: '/stuco/admin/request/api/processdocument.php',
        data: { docu_id: docu_id, feedback: feedback, 
            pass_admin: pass_admin, final_destination: final_destination, action: action },
        success: function(response) {    
            var data = response;   
            // var data = JSON.parse(response);
            if (data.status == 'success'){
                window.location.href = 'admin/request/request.php';
            } else {
                console.log(data.message);
            }
        },
        error: function(xhr, status, error) {
          // Handle errors, if any
        }
      });
    }


    if (is_approve == 'Rejected' && on_process == false) {
        $('.approved-docu, .reject-docu').hide();
    } else {
        $('.approved-docu, .reject-docu').show();
    }

    $('.approved-docu, .reject-docu').click(function(event) {
        event.preventDefault(); // This prevents the default form submission
        var docu_id = $('input[name="docu_id"]').val(); // Get the document ID from the form
        var action = $(this).hasClass('approved-docu') ? 'approve' : 'reject'; // Corrected 'rejected' to 'reject'
        var feedback = $('textarea[name="feedback"]').val();
        var pass_admin = $('select[name="pass_admin"]').val();
        var final_destination = $('select[name="on_process"]').val();
    processdocument(docu_id, feedback, pass_admin, final_destination, action, $(this));
});
});
</script>
</body>
</html>