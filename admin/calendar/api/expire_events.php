<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Query to select events that have ended
$query = "SELECT id FROM calendar WHERE end_datetime < NOW()";
$result = $conn->query($query);

if ($result) {
    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM calendar WHERE id = ?");
    while ($row = $result->fetch_assoc()) {
        // Bind the parameter and execute the delete statement
        $stmt->bind_param("i", $row['id']);
        $stmt->execute();
    }
    $stmt->close();
}

$conn->close();
?>