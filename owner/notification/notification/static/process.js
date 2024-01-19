$(document).ready(function(){
    $('.accept-docu').on('click', function(event) {
        event.preventDefault();
        // Add your document processing logic here
        $.ajax({
            url: 'admin/request/api/processdocument.php',
            type: 'POST',
            data: { action: 'approve', documentId: 'your_document_id' },
            success: function(response) {
                // Handle success
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });
    });

    $('.reject-docu').on('click', function(event) {
        event.preventDefault();
        // Add your document processing logic here
        $.ajax({
            url: 'admin/request/api/processdocument.php',
            type: 'POST',
            data: { action: 'reject', documentId: 'your_document_id' },
            success: function(response) {
                // Handle success
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });
    });
});