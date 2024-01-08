<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stucoportal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $from = $_POST["from"];
    $type = $_POST["type"];
    $description = $_POST["description"];
    $admin_type = $_POST["admin_type"];

    $sql = "INSERT INTO notifications (from_field, type, description, admin_type) VALUES ('$from', '$type', '$description', '$admin_type')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/stuco/AdminLanding/Notifications.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
