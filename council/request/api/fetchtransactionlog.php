<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$response = array();

// Check if 'document_id' is provided
if (isset($_GET['document_id'])) {
    $documentId = $_GET['document_id'];

    // SQL query to fetch transactions for a specific document_id
    $query = "SELECT log_id, document_id, doc_type, doc_description, admin_id, admin_username, admin_admin_type, admin_feedback, prefix_message, admin_department, created_at FROM transaction_log WHERE document_id = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($query);

    // Bind the 'document_id' parameter to the query
    $stmt->bind_param("i", $documentId);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $html = '';
    if($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $formattedDate = date('M j Y, h:i A', strtotime($row["created_at"]));
            $html .= "<span>" . " <b> [ " .  $formattedDate . " ] </b>" . " " . $row["prefix_message"] . "</span><br>";
        }
        $response["status"] = 'success';
        $response["html"] = $html;
    } else {
        $html .= "<span>No transaction logs for this document.</span><br>";
        $response["status"] = 'fail';
        $response["html"] = $html;
    }

    // Close the statement
    $stmt->close();
} else {
    $response = array('status' => 'fail', 'message' => 'No document_id provided');
}

// Close the database connection
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);

exit();
?>