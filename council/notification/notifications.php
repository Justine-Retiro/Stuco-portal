<?php
include '../api/session.php';
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $adminType = $_SESSION['adminType'];
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Notification</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php include "../components/sidebar.php";?>
    
    <div class="tabl-background">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Notification #</th>
                    <th scope="col">From</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                // Establish a new database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "stucoportal";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check for connection errors
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the database
                $sql = "SELECT * FROM notifications WHERE admin_type = '$adminType'";
                $result = $conn->query($sql);

                // Check for SQL query errors
                if ($result === false) {
                    echo "Error executing SQL query: " . $conn->error;
                    exit;
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $row["id"] . "</th>";
                        echo "<td>" . $row["from_field"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-success'>Approve</button>";
                        echo "<button class='btn btn-danger'>Reject</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No notifications found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
