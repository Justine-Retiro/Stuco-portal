$(document).ready(function(){
   
    $('#show_password').change(function() {
        if($(this).is(":checked")) {
            $('.password_input').attr('type', 'text');
        } else {
            $('.password_input').attr('type', 'password');
        }
    });

    // Debug purposes
    // $.ajax({
    //     url: 'globalapi/get_session_data.php',
    //     type: 'GET',
    //     success: function(response) {
    //         if (response) {
    //             var data = response;
    //             // var data = JSON.parse(response);
    //             console.log('Session Data:', data);
    //         } else {
    //             console.log('Session Data is empty.');
    //         }
    //     },
    //     error: function(xhr, status, error) {
    //         console.error('Error fetching session data:', xhr.responseText);
    //     }
    // });

    var passwordRegex = /^(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

    // Check if the password matches the input
    $('.password_input').on('input', function() {
        $('#password_container').show();
        var password = $(this).val();
        var confirmPassword = $('#confirm_password').val();
        if (password === confirmPassword) {
            if (passwordRegex.test(password)) {
                // If the password is valid, show a success message
                $('#passwordValid').show().removeClass('text-muted text-danger').addClass('text-success').text('Password is matched!');
            } else {
                // If the password is invalid, show an error message
                $('#passwordValid').show().removeClass('text-muted text-success').addClass('text-danger').text('Password must be at least 8 characters long and include at least one special character.');
            }
        } else {
            // If the passwords do not match, show an error message
            $('#passwordValid').show().removeClass('text-muted text-success').addClass('text-danger').text('Passwords do not match.');
        }
    });


    $('form').on('submit', function(event) {
        event.preventDefault();
        
        $.ajax({
            url: 'globalapi/password_change.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // var data = response;
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    
                    switch(data.role){
                        case "owner":
                            sessionStorage.setItem('toastr', data.message);
                            window.location.href = '/stuco/owner.php';
                            break;
                        case "admin":
                                sessionStorage.setItem('toastr', data.message);
                                window.location.href = '/stuco/admin.php';
                                break;
                        case "Student Council":
                            sessionStorage.setItem('toastr', data.message);
                            window.location.href = '/stuco/council.php';
                            break;
                        case "student":
                            sessionStorage.setItem('toastr', data.message);
                            window.location.href = '/stuco/student.php';
                            break;
                        default:
                            sessionStorage.setItem('toastr', data.message);
                            window.location.href = '/stuco/index.php';
                            break;
                    }
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