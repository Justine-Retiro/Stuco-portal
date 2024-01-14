<?php
session_start();
// Check if a CSRF token is set in the session, if not, create one
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

// $adminType = isset($_GET["adminType"]) ? $_GET["adminType"] : null; //Use this if the js fails

$adminType = ($_GET["adminType"]) ?? 'all';
$page = $_GET['page'] ?? 1; // Get the current page number, default to 1 if not set
$items_per_page = 20; // Set the number of items to display per page
$offset = ($page - 1) * $items_per_page; // Calculate the offset
$stmt = null;
$result = null;

if ($adminType == "all") {
    $sql = "SELECT * FROM (
                SELECT 'admin_users' as source_table, username, branch, department, admin_type FROM admin_users
                UNION ALL
                SELECT 'owner_users' as source_table, username, NULL as branch, NULL as department, admin_type FROM owner_users
                UNION ALL
                SELECT 'council_user' as source_table, username, branch, department, admin_type FROM council_user
                UNION ALL
                SELECT 'users' as source_table, username, branch, NULL as department, admin_type FROM users
            ) as combined LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $offset, $items_per_page);
} else {
    $sql = "SELECT * FROM (
                SELECT 'admin_users' as source_table, username, branch, department, admin_type FROM admin_users WHERE admin_type = ?
                UNION ALL
                SELECT 'owner_users' as source_table, username, NULL as branch, NULL as department, admin_type FROM owner_users WHERE admin_type = ?
                UNION ALL
                SELECT 'council_user' as source_table, username, branch, department, admin_type FROM council_user WHERE admin_type = ?
                UNION ALL
                SELECT 'users' as source_table, username, branch, NULL as department, admin_type FROM users WHERE admin_type = ?
            ) as combined LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Handle error, possibly output $conn->error
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssssii", $adminType, $adminType, $adminType, $adminType, $offset, $items_per_page);
}
$stmt->execute();
$result = $stmt->get_result();

echo "<thead>";
echo "<tr>";
echo "<th>Index #</th>";
echo "<th scope='col'>Username</th>";
echo "<th scope='col'>Branch</th>";
echo "<th scope='col'>Department</th>";
echo "<th scope='col'>Roles</th>";
echo "<th></th>";
echo "</tr>";
echo "</thead>";

$i = 1;
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    echo "<tr class='fs-4'>";
    echo "<td>" . $i . "</td>";
    echo "<td> <a class='text-decoration-none text-primary' href='/stuco/owner/account-manager/edit/edit.php?username=" . $row["username"] . "'>" . $row["username"] . "</td>";
    echo "<td>" . $row["branch"] . "</td>";
    echo "<td>" . $row["department"] . "</td>";
    echo "<td>" . $row["admin_type"] . "</td>";

    echo "<td class='text-center d-flex'>";
    echo '<a href="/stuco/owner/account-manager/edit/edit.php?username=' . $row["username"] . '"><button class="btn btn-success me-1 btn-lg">Edit</button></a>';
    // Delete form
    echo '<form action="/stuco/owner/account-manager/api/delete.php" method="post">';
    echo '<input type="hidden" name="username" value="' . htmlspecialchars($row["username"]) . '">';
    echo '<input type="hidden" name="role" value="' . htmlspecialchars($row["admin_type"]) . '">';
    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    echo '<button type="button" class="btn btn-danger btn-lg delete-user" data-username="' . htmlspecialchars($row["username"]) . '" data-role="' . htmlspecialchars($row["admin_type"]) . '" data-source-table="' . htmlspecialchars($row["source_table"]) . '" data-csrf-token="' . $_SESSION['csrf_token'] . '">Delete</button>';
    echo '</form>';
    echo "</td>";
    echo "</tr>";
    $i++;
}
} else {
echo "<tr><td colspan='5'>No records found.</td></tr>";
}
?>