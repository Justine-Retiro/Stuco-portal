$(document).ready(function(){
    $('#show_password').change(function() {
        if($(this).is(":checked")) {
            $('#password').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
        }
    });

    $('form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'globalapi/admin-login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response); // Log the full response
                var data = JSON.parse(response);
                console.log(data.status); // Log the status from the response
                if (data.status === 'success') {
                    sessionStorage.setItem('toastr', data.message);
                    window.location.href = '/stuco/admin/dashboard/dashboard.php';
                } else if (data.status === 'change_password') {
                    window.location.href = '/stuco/password_change.php';
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
})