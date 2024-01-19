<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php'); 

$response = array();

if (isset($_GET['document_id'])) {

  $documentId = $_GET['document_id'];

  $query = "SELECT tl.log_id, tl.document_id, tl.doc_type, tl.doc_description, tl.admin_id, tl.admin_username, tl.admin_admin_type, tl.admin_feedback, tl.prefix_message, tl.admin_department, tl.created_at, au.first_name, au.last_name, au.department
            FROM transaction_log tl
            JOIN admin_users au ON tl.admin_username = au.username
            WHERE tl.document_id = ?";
            
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $documentId);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result && $result->num_rows > 0) {

    $html = '';
    
    while ($row = $result->fetch_assoc()) {
      $formattedDate = date('M j Y, h:i A', strtotime($row["created_at"]));
      $adminName = $row['first_name'] . ' ' . $row['last_name'];
      $html .= "<span>" . " <b> [ " .  $formattedDate . " ] </b>" . " Feedback: " . $row["admin_feedback"] . " - " . $adminName . " " . $row["admin_admin_type"] . " " . $row["department"] . "</span><br>";
    }

    $response["status"] = 'success';
    $response["html"] = $html;

  } else {

    $response["status"] = 'info';
    $response["html"] = "<span>The document is currently on view.</span><br>";
  
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
