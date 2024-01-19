<?php
function password($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }
    return $password;
}

$default_password = password();
// echo $default_password;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="bg-light">
    <?php include "../../components/sidebar.php";?>

    <div class="container ps-5 ms-2 mt-5 ">
        <h1>Add User</h1>
        <row class="fs-4">
            <div class="col-lg-12 d-flex align-items-center ">
                <nav class="d-flex align-items-center" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="../manager.php">Manage user</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add user</li>
                    </ol>
                </nav>
            </div>
        </row>
        
        <div class="row pt-4">
            <hr>
                <div class="col-lg-12 mt-3">
                    <form id="loginForm" action="/stuco/owner/account-manager/api/new.php" method="post">
                        <div id="errorAlert" class="alert alert-danger fs-5" role="alert" style="display: none;">
                        <!-- Reserved for error messages -->
                        </div>

                        <div class="input-group mb-3 input-group-lg">
                            <span class="input-group-text">First name</span>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>

                        <div class="input-group mb-3 input-group-lg">
                            <span class="input-group-text">Last name</span>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>

                        <div class="input-group mb-3 input-group-lg">
                            <span class="input-group-text">Username</span>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <div class="input-group mb-3 input-group-lg">
                            <span class="input-group-text">Default Password</span>
                            <input type="password" id="password" class="form-control" name="password" value="<?php echo $default_password;?>">
                        </div>
                        <label class="form-control mb-3">
                            <div class="p-2 d-flex fs-5 align-items-center">
                                <input type="checkbox" id="show_password" class="me-3">
                                <label for="show_password" class="text-dark mb-0">Show Password</label>
                            </div>
                        </label>
                        
                        <div class="input-group mb-3 input-group-lg">
                            <label class="input-group-text text-dark mb-0" for="roles">Roles:</label>
                            <select class="form-select" id="roles" name="roles">
                                <option value="Branch Manager" >Branch Manager</option>
                                <option value="CSDL Director">CSDL Director</option>
                                <option value="Finance">Finance</option>
                                <option value="Marketing">Marketing</option>
                                <option value="GSD">GSD</option>
                                <option value="COO">COO</option>
                                <option value="Adviser">Adviser</option>
                                <option value="Owner">Owner</option>
                                <option value="Student Council">Student Head Council</option>
                            </select>                            
                        </div>

                        <div class="input-group mb-3 input-group-lg">
                            <label class="input-group-text text-dark mb-0" for="user_type">User type:</label>
                            <select class="form-select" id="user_type" name="user_type" readonly>
                                <option value="owner" >Owner</option>    
                                <option value="admin" >Admin</option>
                                <option value="council">Council</option>
                            </select>       
                            <input type="hidden" name="user_type" id="hidden_user_type" value="">                     
                        </div>
                        
                        <div class="input-group mb-3 input-group-lg" id="branch">
                            <label class="input-group-text text-dark mb-0" for="branch">Branch:</label>
                            <select class="form-select" id="branch" name="branch">
                                <option value="Main Campus">Main Campus</option>
                                <option value="San Jose Campus">San Jose Campus</option>
                                <option value="South Campus">South Campus</option>
                            </select>                            
                        </div>

                        <div class="input-group mb-3 input-group-lg" id="department" style="display: none;">
                            <label class="input-group-text text-dark mb-0" for="department">Department:</label>
                            <select class="form-select" id="department" name="department">
                                <option value="" selected>Select one</option>
                                <option value="CASSC">CASSC</option>
                                <option value="CELASC">CELASC</option>
                                <option value="CMASC">CMASC</option>
                                <option value="CAHSSC">CAHSSC</option>
                                <option value="CITESC">CITESC</option>
                                <option value="CCJESC">CCJESC</option>
                                <option value="CENTRALSC">CENTRALSC</option>
                                <option value="SOUTHSC">SOUTHSC</option>
                                <option value="SANJOSESC">SANJOSESC</option>
                            </select>                            
                        </div> <br>

                        <button class="btn btn-success btn-lg" type="submit">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="../static/validation.js"></script>
<script>
$(document).ready(function(){
    
    $('#roles').change(function(){
        var role = $(this).val();

        if(role === 'Student Council'){
            $('#department').show().prop('disabled', false);
            $('#branch').show().prop('disabled', false);
            $('#user_type').val('council').prop('disabled', true); // Set user type to 'council' and disable selection
        } else if (role === 'Adviser') {
            $('#department').show().prop('disabled', false);
            $('#branch').show().prop('disabled', true);
            $('#user_type').val('admin').prop('disabled', true); // Set user type to 'student' and disable selection
        } else if (role === 'Owner') {
            $('#department').hide().prop('disabled', true);
            $('#branch').show().prop('disabled', false);
            $('#user_type').val('owner').prop('disabled', true); 
        } else {
            $('#department').hide().val('').prop('disabled', false);
            $('#branch').show().prop('disabled', false);
            $('#user_type').val('admin').prop('disabled', true); 
        }

        $('#hidden_user_type').val($('#user_type').val());
    });

    $('#branch').change(function(){
        var branch = $(this).val();

        if(branch === 'South'){
            $('#department').show().prop('disabled', false);
            $('#branch').show().prop('disabled', false);
            $('#user_type').val('council').prop('disabled', true); // Set user type to 'council' and disable selection
        } else if (role === 'Adviser') {
            $('#department').show().prop('disabled', false);
            $('#branch').show().prop('disabled', true);
            $('#user_type').val('admin').prop('disabled', true); // Set user type to 'student' and disable selection
        } else if (role === 'Owner') {the
            $('#department').hide().prop('disabled', true);
            $('#branch').show().prop('disabled', false);
            $('#user_type').val('owner').prop('disabled', true); 
        } else {
            $('#department').hide().val('').prop('disabled', false);
            $('#branch').show().prop('disabled', false);
            $('#user_type').val('admin').prop('disabled', true); 
        }

        $('#hidden_user_type').val($('#user_type').val());

    });

    // Trigger the change event on page load to set the initial state
    $('#roles').trigger('change');
});
</script>

</body>
</html>
