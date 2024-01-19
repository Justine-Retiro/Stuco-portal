<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$admin_type = $_SESSION["adminType"];
$page = $_GET['page'] ?? 1; // Get the current page number, default to 1 if not set
$items_per_page = 5; // Set the number of items to display per page
$offset = ($page - 1) * $items_per_page; // Calculate the offset
$stmt = null;
$result = null;

$sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.on_process = true
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);

if ($sql) {
    $stmt->execute();
    $result = $stmt->get_result();
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

echo "<thead>";
echo "<tr>";
echo "<th colspan='9'>Latest Requests</th>";
echo "</tr>";
echo "<tr>";
echo "<th>Index</th>";
echo "<th>Document ID</th>";
echo "<th>Sender</th>";
echo "<th>Recipient</th>";
echo "<th>Date</th>";
echo "<th>Type</th>";
echo "<th>Description</th>";
// echo "<th>Adviser Status</th>";
// echo "<th>Branch Manager Status</th>";
// echo "<th>Final Status</th>";
// echo "<th colspan='2'>Actions</th>";
echo "<th></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$date = new DateTime($row["created_at"]);

$count = 1;
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . htmlspecialchars($row["docu_id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["sender_first_name"]) . " " . htmlspecialchars($row["sender_last_name"]) . "<br>" . htmlspecialchars($row["sender_branch"]) . "<br>" . htmlspecialchars($row["sender_department"]) .  "<br>" . htmlspecialchars($row["sender_adminType"]) ."</td>";
        echo "<td>" . htmlspecialchars($row["recipient_first_name"]) . " " . htmlspecialchars($row["recipient_last_name"]) . "<br>" . htmlspecialchars($row["recipient_branch"]) . "<br>" . htmlspecialchars($row["recipient_department"]) .  "<br>" . htmlspecialchars($row["recipient_adminType"]) ."</td>";
        echo "<td>" . $date->format('F d Y') . "</td>"; // Formats the date as Mon/d/yyyy
        echo "<td>" . htmlspecialchars($row["file_type"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["document_description"]) . "</td>";
        echo "</td>";
        // echo "<td>" . '<button class="btn btn-outline-primary me-1 btn-lg viewTransaction" data-bs-toggle="modal" data-bs-target="#logTransaction" data-documentId="' . htmlspecialchars($row["docu_id"]) . '" data-sender_username="' . htmlspecialchars($row["sender_username"]) . '">Details</button>' . "</td>";
        echo "<td>" . time_elapsed_string($row["created_at"]) . "</td>";

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