<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$stmt = $conn->prepare("SELECT id, first_name, last_name, username, branch FROM admin_users WHERE admin_type = ?");
$stmt->bind_param("s", $adminType);
$adminType = 'Adviser';
$stmt->execute();

$result = $stmt->get_result();
$advisers = [];
while ($row = $result->fetch_assoc()) {
    $advisers[] = $row;
}
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
        <h1>Request</h1>
       
        <div class="row pt-4">
            <hr>
                <div class="col-lg-12 mt-3">
                    <form id="requestForm" action="../api/new.php" method="post" enctype="multipart/form-data">
                        <div id="errorAlert" class="alert alert-danger fs-5" role="alert" style="display: none;">
                        <!-- Reserved for error messages -->
                        </div>   

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">First name</label>
                                    <input type="text" class="form-control form-control-lg" name="first_name" >
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Last name</label>
                                    <input type="text" class="form-control form-control-lg" name="last_name" >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Username</label>
                                    <input type="text" class="form-control form-control-lg" name="username" >
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Recipient</label>
                                    <select class="form-control form-control-lg" name="recipient">
                                        <?php foreach ($advisers as $adviser): ?>
                                            <option value="<?php echo htmlspecialchars($adviser['username']); ?>">
                                                <?php echo htmlspecialchars($adviser['first_name'] . ' ' . $adviser['last_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Document Type</label>
                                    <input type="text" class="form-control form-control-lg" name="file_type" >
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label fs-4 text-dark">Recipient's position</label>
                                    <select class="form-control form-control-lg" name="admin_type" id="adminType">
                                        <option value="Branch Manager">Branch Manager</option>
                                        <option value="Adviser">Adviser</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="GSD">GSD</option>
                                        <option value="COO">COO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label fs-4 text-dark">Attachment Document</label>
                                    <input type="file" class="form-control form-control-lg" name="file_url" multiple>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label fs-4 text-dark">Description</label>
                                    <textarea type="text" class="form-control form-control-lg" name="description" ></textarea>
                                </div>

                            </div>
                            <br>

                            <button class="btn btn-success btn-lg" type="submit">Submit request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>