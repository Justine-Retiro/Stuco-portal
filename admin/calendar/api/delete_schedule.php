<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$response = ['success' => false, 'message' => ''];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $response['message'] = 'Undefined or invalid Schedule ID.';
} else {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM calendar WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Event has been deleted successfully.'];
    } else {
        $response['message'] = 'An Error occurred. Error: ' . htmlspecialchars($stmt->error);
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>