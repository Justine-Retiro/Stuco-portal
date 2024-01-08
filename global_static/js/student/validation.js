$(document).ready(function(){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    
    // Check if there's a toastr message in the cookie
    var toastrMessage = getCookie('toastr');
    if (toastrMessage) {
        // If there is, show the toastr and delete the cookie
        toastr.error(decodeURIComponent(toastrMessage));
        var now = new Date();
        now.setTime(now.getTime() - 1);
        document.cookie = 'toastr=; expires=' + now.toUTCString() + '; path=/;';
    }

    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'globalapi/student-login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var data = response;
                if (data.status === 'success') {
                    toastr.success(data.message);
                    window.location.href = '/student/dashboard.php';
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

    // Function to get a cookie by name
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
});