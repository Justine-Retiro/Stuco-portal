$(document).ready(function() {
    var deleteData = {}; // Object to store data for deletion

    $(document).on('click', '.delete-user', function(e) {
        e.preventDefault(); // Prevent the default button action

        // Store the data attributes in deleteData
        deleteData.username = $(this).data('username');
        deleteData.role = $(this).data('role');
        deleteData.source_table = $(this).data('source-table');
        deleteData.csrf_token = $(this).data('csrf-token');

        // Show the modal
        $('#deleteModal').modal('show');
    });
    
    // console.log(deleteData);

    $(document).on('click', '#confirmDelete', function(e) {
        e.preventDefault(); // Prevent the default button action

        // Perform the deletion
        $.ajax({
            url: '/stuco/owner/account-manager/api/delete.php',
            type: 'POST',
            data: deleteData,
            success: function(response) {
                alert(response); // Alert the response from the server
                location.reload(); // Reload the page
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error); // Alert the error if any
            }
        });
    });
});