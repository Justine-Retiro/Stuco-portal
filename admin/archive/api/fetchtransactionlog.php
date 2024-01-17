<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Check if 'document_id' is provided
if (isset($_GET['document_id'])) {
    $documentId = $_GET['document_id'];

    // SQL query to fetch transactions for a specific document_id
    $query = "SELECT log_id, document_id, doc_type, doc_description, admin_id, admin_username, admin_admin_type, admin_feedback, prefix_message, admin_department, created_at FROM transaction WHERE document_id = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($query);

    // Bind the 'document_id' parameter to the query
    $stmt->bind_param("i", $documentId);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<b>" . " [ " . $row["created_at"] . " ] " . " " . $row["prefix_message"] . "<b>";
        }
    }

    // Close the statement
    $stmt->close();
} else {
    $transactions = array('error' => 'No document_id provided');
}

// Close the database connection
$conn->close();

// Set header to return JSON
header('Content-Type: application/json');

// Encode the array to JSON and output the results
echo json_encode($transactions);

exit();
?>