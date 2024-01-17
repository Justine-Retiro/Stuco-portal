<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// Define how many items to show on each page
$items_per_page = 2;

$admin_type = $_SESSION["adminType"];
$page = $_GET['page'] ?? 1; // Get the current page number, default to 1 if not set
$items_per_page = 10; // Set the number of items to display per page
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
        dt.on_process = true
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
        dt.on_process = true
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

// Prepare a new SQL statement to count the total number of records
$sql_total = "SELECT COUNT(*) as total FROM document_transaction dt";

// Depending on the complexity of your WHERE clause, you may need to add it here as well
// For example:
// $sql_total .= " WHERE au_recipient.admin_type = ? AND cu_sender.department = ?";

$stmt_total = $conn->prepare($sql_total);

if (!$stmt_total) {
    // Handle error, the statement couldn't be prepared
    die("Error preparing statement: " . $conn->error);
}

// Bind the same parameters as the previous statement
switch ($admin_type) {
    case "Adviser":
        $stmt_total->bind_param("ss", $_SESSION["department"], $_SESSION["department"]);
        break;
    // Add other cases as necessary
}

if (!$stmt_total->execute()) {
    // Handle error, the statement couldn't be executed
    die("Error executing statement: " . $stmt_total->error);
}

$result_total = $stmt_total->get_result();
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];

$total_pages = ceil($total_records / $items_per_page);

echo json_encode(['total_pages' => $total_pages]);
?>