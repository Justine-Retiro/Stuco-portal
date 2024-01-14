$(document).ready(function() {
    var deleteData = {}; // Object to store data for deletion

    $(document).on('click', '.viewTransaction', function(e) {
        e.preventDefault(); // Prevent the default button action

        // Store the data attributes in deleteData
        transactionData.documentId = $(this).data('docu_id');
        transactionData.role = $(this).data('sender_username');
                
        // Show the modal
        $('#logTransaction').modal('show');
    });
    
    // console.log(deleteData);
    $(document).ready(function(e) {
        // Perform the deletion
        $.ajax({
            url: 'Stuco/council/request/api/fetchtransactionlog.php',
            type: 'GET',
            data: deleteData,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error); // Alert the error if any
            }
        });
    });
});