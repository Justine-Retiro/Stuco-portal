$(document).ready(function(){
    // console.log('ready');
    $('#show_password').change(function() {
        if($(this).is(":checked")) {
            $('#password').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
        }
    });

    $('#loginForm').on('submit', function(event) {
        console.log('the nigga has been triggered')
        event.preventDefault();
        $.ajax({
            url: '../api/new.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    sessionStorage.setItem('toastr', data.message);
                    window.location.href = '../manager.php';
                } else if ( data.status === 'has_account' || data.status === 'fail') {
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