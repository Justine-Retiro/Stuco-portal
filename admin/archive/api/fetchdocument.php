<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$admin_type = $_SESSION["adminType"];
$page = $_GET['page'] ?? 1; // Get the current page number, default to 1 if not set
$items_per_page = 5; // Set the number of items to display per page
$offset = ($page - 1) * $items_per_page; // Calculate the offset
$stmt = null;
$result = null;

switch ($admin_type) {
    case "Adviser":
        $sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE au_recipient.admin_type = 'adviser' AND 
        cu_sender.department = ? AND
        au_recipient.department = ?
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $_SESSION["department"], $_SESSION["department"], $items_per_page, $offset);
        break;

    case "Branch Manager":
        $sql = "SELECT dt.*, 
        cu_sender.first_name as sender_first_name, 
        cu_sender.last_name as sender_last_name, 
        au_recipient.first_name as recipient_first_name, 
        au_recipient.last_name as recipient_last_name,
        dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.adviserStatus = 'Approved' 
        AND dt.on_process = false
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        break;

    case "CSDL Director": 
        $sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.pass_to_admin_type = 'CSDL Director' AND 
        dt.on_process = false
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        break;

    case "Marketing": 
        $sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.pass_to_admin_type = 'Marketing' AND 
        dt.on_process = false
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        break;

    case "Finance": 
        $sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.pass_to_admin_type = 'Finance' AND 
        dt.on_process = false
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        break;

    case "GSD": 
        $sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
            FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.pass_to_admin_type = 'GSD' AND 
        dt.on_process = false
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        break;

    case "COO": 
        $sql = "SELECT dt.*, 
            cu_sender.first_name as sender_first_name, 
            cu_sender.last_name as sender_last_name, 
            au_recipient.first_name as recipient_first_name, 
            au_recipient.last_name as recipient_last_name,
            dt.on_process as on_process
        FROM document_transaction dt 
        LEFT JOIN council_user cu_sender ON dt.sender_username = cu_sender.username 
        LEFT JOIN admin_users au_recipient ON dt.recipient_username = au_recipient.username 
        WHERE dt.pass_to_admin_type = 'COO' AND 
        dt.on_process = false
        ORDER BY dt.created_at DESC
        LIMIT ? OFFSET ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        break;

    default:
        $sql = "";
        echo "This user is not authorized to see the records.";
        exit();
}

if ($sql) {
    $stmt->execute();
    $result = $stmt->get_result();
}

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
        // echo "<td>";
        // if ($row["adviserStatus"] == "Approved" && $row["on_process"]) {
        //     echo "<span> </span>";
        
        //     if ($row["branchmanager_status"] == "Approved" || $row["branchmanager_status"] == "Rejected") {
        //         echo "<span> </span>";
        
        //         if ($row["final_status"] == "Approved" || $row["final_status"] == "Rejected") {
        //             echo "<span> </span>";
        //         } else {
        //             // Check if user is not an adviser before displaying the "View" button
        //             if ($admin_type !== 'Adviser') {
        //                 echo "<a href='document.php?documentid={$row["docu_id"]}&sender={$row["sender_username"]}'><button class='btn btn-lg btn-outline-success me-2'>View</button></a>";
        //             }
        //         }
        //     } else {
        //         // Check if user is not an adviser before displaying the "View" button
        //         if ($admin_type !== 'Adviser') {
        //             echo "<a href='document.php?documentid={$row["docu_id"]}&sender={$row["sender_username"]}'><button class='btn btn-lg btn-outline-success me-2'>View</button></a>";
        //         }
        //     }
        // } elseif ($row["adviserStatus"] == "Rejected" && !$row["on_process"]) {
        //     echo "<span> </span>";
        // } else {
        //     echo "<a href='document.php?documentid={$row["docu_id"]}&sender={$row["sender_username"]}'><button class='btn btn-lg btn-outline-success me-2'>View</button></a>";
        // }
        // echo "</td>";
        echo "<td>" . '<button class="btn btn-outline-primary me-1 btn-lg viewTransaction" data-bs-toggle="modal" data-bs-target="#logTransaction" data-documentId="' . htmlspecialchars($row["docu_id"]) . '" data-sender_username="' . htmlspecialchars($row["sender_username"]) . '">Details</button>' . "</td>";
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