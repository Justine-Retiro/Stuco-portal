<?php
 session_start();
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
    <link rel="stylesheet" href="notificationStyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <header>
        <div class="user">
            <img src="logo.png" alt="Picture">
        </div>
    
        <nav class="navbar">
            <ul>
                <li><a href="http://localhost/stuco/AdminLanding/AdminLanding.html">Dashboard</a></li>
                <li><a href="http://localhost/stuco/AdminLanding/Request.html">Requests</a></li>
                <li><a href="http://localhost/stuco/AdminLanding/DocumentArchives.html">Document Archives</a></li>
                <li><a href="http://localhost/stuco/AdminLanding/Calendar.html">Calendar Of Events</a></li>
                <li><a href="http://localhost/stuco/Counsil/">Sign Out</a></li>
            </ul>
        </nav>
    </header> 
    
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
