<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$sql = "SELECT * FROM document_transaction";
$result = $conn->query($sql);

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
echo "<th>Final Status</th>";
echo "<th></th>";

echo "</tr>";
echo "</thead>";

$i = 1;
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
        echo "<td>" . $row["docu_id"] . "</td>";
        echo "<td>" . $row["sender_username"] . "<br>" . $row["sender_branch"] . "<br>" . $row["sender_department"] .  "<br>" . $row["sender_adminType"] ."</td>";
        echo "<td>" . $row["recipient_username"] . "<br>" . $row["recipient_branch"] . "<br>" . $row["recipient_department"] .  "<br>" . $row["recipient_adminType"] ."</td>";
        echo "<td>" . $row["created_at"] . "</td>";
        echo "<td>" . $row["file_type"] . "</td>";
        echo "<td>" . $row["document_description"] . "</td>";
        echo "<td>" . $row["adviserStatus_approval"] . "</td>";
        echo "<td>" . $row["final_destination"] . "</td>";
        echo "<td>" . '<button class="btn btn-outline-primary me-1 btn-lg viewTransaction" data-documentId="' . htmlspecialchars($row["docu_id"]) . '" data-sender_username="' . htmlspecialchars($row["sender_username"]) . '>Details</button>';
        // echo "<td>" . $row["notif_id"]. " - Recipient: " . $row["recipient_username"]. " - Sender: " . $row["sender_username"]. " - File Type: " . $row["file_type"]. " - File URL: " . $row["file_url"]. " - Description: " . $row["document_description"]. " - Created At: " . $row["created_at"]. "<br>";
        // echo "<td>" . $row["notif_id"]. " - Recipient: " . $row["recipient_username"]. " - Sender: " . $row["sender_username"]. " - File Type: " . $row["file_type"]. " - File URL: " . $row["file_url"]. " - Description: " . $row["document_description"]. " - Created At: " . $row["created_at"]. "<br>";
        echo "<tr>";
        $i++;
    }
} else {
    echo "<tbody>";
    echo "<tr>";
    echo "<td colspan='9'>" . "No niggas found" . "</td>";
    echo "</tr>";
    echo "</tbody>";
}
?>