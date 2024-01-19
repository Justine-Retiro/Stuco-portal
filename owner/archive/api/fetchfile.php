<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php'); 

$response = array();

if (isset($_GET['document_id'])) {

  $documentId = $_GET['document_id'];

  $query = "SELECT file_url FROM document_transaction WHERE docu_id = ?";
            
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $documentId);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result && $result->num_rows > 0) {
    $file = $result->fetch_assoc();
    $filePath = $file['file_url']; // This should be the path to your file

    // Assuming your 'download.php' script is in the 'owner/archive/api/' directory
    // Create a download URL
    $downloadUrl = "/Stuco/owner/archive/api/download.php?file=" . urlencode($filePath);
    $response["downloadUrl"] = $downloadUrl;

    $response["status"] = 'success';
    // If $html is not used elsewhere, you can remove it or ensure it is defined earlier in the script
    // $response["html"] = $html; // Remove this line if $html is not defined

  } else {
    $response["status"] = 'fail';
    $response["message"] = "File not found";
  }

  $stmt->close();

} else {
  $response = array('status' => 'fail', 'message' => 'No document_id provided');
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
exit();

?>