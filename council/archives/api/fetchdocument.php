<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$admin_type = $_SESSION["adminType"];
$page = $_GET['page'] ?? 1; // Get the current page number, default to 1 if not set
$items_per_page = 10; // Set the number of items to display per page
$offset = ($page - 1) * $items_per_page; // Calculate the offset
$stmt = null;
$result = null;


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
        WHERE dt.sender_id = ? AND dt.sender_department = ? AND on_process = 0 ORDER BY dt.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $sender_id, $sender_department);
$result = $stmt->execute();
$result = $stmt->get_result();

echo "<thead>";
echo "<tr>";
echo "<th>Index #</th>";
echo "<th>Document ID</th>";
echo "<th>Sender</th>";
echo "<th>Recipient</th>";
echo "<th>Date</th>";
echo "<th>Type</th>";
echo "<th>Description</th>";
echo "<th>Adviser Status</th>";
echo "<th>Branch Manager Status</th>";
echo "<th>Final Status</th>";
echo "<th>Actions</th>";
echo "<th></th>";

echo "</tr>";
echo "</thead>";
echo "<tbody>";

$count = 1;
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . htmlspecialchars($row["docu_id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["sender_first_name"]) . " " . htmlspecialchars($row["sender_last_name"]) . "<br>" . htmlspecialchars($row["sender_branch"]) . "<br>" . htmlspecialchars($row["sender_department"]) .  "<br>" . htmlspecialchars($row["sender_adminType"]) ."</td>";
        echo "<td>" . htmlspecialchars($row["recipient_first_name"]) . " " . htmlspecialchars($row["recipient_last_name"]) . "<br>" . htmlspecialchars($row["recipient_branch"]) . "<br>" . htmlspecialchars($row["recipient_department"]) .  "<br>" . htmlspecialchars($row["recipient_adminType"]) ."</td>";
        echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["file_type"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["document_description"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["adviserStatus"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["branchmanager_status"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["final_status"]) . "</td>";
        echo "<td>" . '<button class="btn btn-outline-primary me-1 btn-lg viewTransaction"  data-bs-toggle="modal" data-bs-target="#logTransaction" onclick="displayTransactionLog(' . $row["docu_id"] . ')" data-document-id="' . $row["docu_id"] . '">Details</button>' . "</td>";
        echo "</tr>";
        $count++;
    }
} else {
    echo "<tr>";
    echo "<td colspan='10'>No documents found</td>";
    echo "</tr>";
}
echo "</tbody>";
?>