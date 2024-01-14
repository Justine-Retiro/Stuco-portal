$(document).ready(function(){
    $('#requestForm').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this); // Use FormData instead of serialize
        $.ajax({
            url: '/stuco/council/request/api/request.php',
            type: 'POST',
            data: formData,
            processData: false, // These two settings are required for file upload with FormData
            contentType: false,
            success: function(response) {
                // console.log(response);
                // var data = response;
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    toastr.success(data.message);
                } else if (data.status === 'fail') {
                    $('#errorAlert').text(data.message).show();
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    toastr.error(xhr.responseText);
                }
            }
        });
    });
});