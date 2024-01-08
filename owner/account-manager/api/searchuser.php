<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$searchQuery = $_GET['query'] ?? '';

$sql = "SELECT * FROM (
    SELECT 'admin_users' as source_table, username, branch, department, admin_type FROM admin_users WHERE username LIKE ? OR branch LIKE ? OR department LIKE ? OR admin_type LIKE ?
    UNION ALL
    SELECT 'council_user' as source_table, username, branch, department, admin_type FROM council_user WHERE username LIKE ? OR branch LIKE ? OR department LIKE ? OR admin_type LIKE ?
    UNION ALL
    SELECT 'users' as source_table, username, branch, '' as department, admin_type FROM users WHERE username LIKE ? OR branch LIKE ? OR admin_type LIKE ?
) as combined";

$stmt = $conn->prepare($sql);
$searchParam = '%' . $searchQuery . '%';
$stmt->bind_param("sssssssssss",
    $searchParam, $searchParam, $searchParam, $searchParam, // for admin_users params
    $searchParam, $searchParam, $searchParam, $searchParam, // for council_user params
    $searchParam, $searchParam, $searchParam                // for users params
);
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
$counter = 1;

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    echo "<tr class='fs-4'>";
    echo "<td>" . $counter . "</td>";
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
    $counter++;
}
} else {
echo "<tr><td colspan='5'>No records found.</td></tr>";
}
 
?>