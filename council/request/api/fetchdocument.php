<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$username = $_SESSION["username"];
$stmt2 = $conn->prepare("SELECT id, first_name, last_name, department, username, branch FROM council_user WHERE username = ?");
$stmt2->bind_param("s", $username);

$stmt2->execute();
$result2 = $stmt2->get_result();
$data = $result2->fetch_assoc();

$sender_id = $data['id']; // or another source
$sender_department = $data['department']; // or another source

$sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.sender_id = ? AND dt.sender_department = ? ORDER BY dt.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $sender_id, $sender_department);
$result = $stmt->execute();
$result = $stmt->get_result();

$html = "<thead>";
$html .= "<tr>";
$html .= "<th>Index #</th>";
$html .= "<th>Document ID</th>";
$html .= "<th>Sender</th>";
$html .= "<th>Recipient</th>";
$html .= "<th>Date</th>";
$html .= "<th>Type</th>";
$html .= "<th>Description</th>";
$html .= "<th>Adviser Status</th>";
$html .= "<th>Branch Manager Status</th>";
$html .= "<th>Final Status</th>";
$html .= "<th>Actions</th>";
$html .= "<th></th>";

$html .= "</tr>";
$html .= "</thead>";
$html .= "<tbody>";

$count = 1;
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $html .= "<tr>";
        $html .= "<td>" . $count . "</td>";
        $html .= "<td>" . htmlspecialchars($row["docu_id"]) . "</td>";
        $html .= "<td>" . htmlspecialchars($row["sender_first_name"]) . " " . htmlspecialchars($row["sender_last_name"]) . "<br>" . htmlspecialchars($row["sender_branch"]) . "<br>" . htmlspecialchars($row["sender_department"]) .  "<br>" . htmlspecialchars($row["sender_adminType"]) ."</td>";
        $html .= "<td>" . htmlspecialchars($row["recipient_first_name"]) . " " . htmlspecialchars($row["recipient_last_name"]) . "<br>" . htmlspecialchars($row["recipient_branch"]) . "<br>" . htmlspecialchars($row["recipient_department"]) .  "<br>" . htmlspecialchars($row["recipient_adminType"]) ."</td>";
        $html .= "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
        $html .= "<td>" . htmlspecialchars($row["file_type"]) . "</td>";
        $html .= "<td>" . htmlspecialchars($row["document_description"]) . "</td>";
        $html .= "<td>" . htmlspecialchars($row["adviserStatus"]) . "</td>";
        $html .= "<td>" . htmlspecialchars($row["branchmanager_status"]) . "</td>";
        $html .= "<td>" . htmlspecialchars($row["final_status"]) . "</td>";
        $html .= "<td>" . '<button class="btn btn-outline-primary me-1 btn-lg viewTransaction"  data-bs-toggle="modal" data-bs-target="#logTransaction" onclick="displayTransactionLog(' . $row["docu_id"] . ')" data-document-id="' . $row["docu_id"] . '">Details</button>' . "</td>";

    }
    
    $response["status"] = 'success';
    $response["message"] = 'Successfully loaded!';
} else {
    $html .= "<tr>";
    $html .= "<td colspan='10'>No documents found</td>";
    $html .= "</tr>";
    $response["status"] = 'fail';
    $response["message"] = 'An error occured: Not found';
}
$html .= "</tbody>";

$response["html"] = $html;

echo json_encode($response);
?>
