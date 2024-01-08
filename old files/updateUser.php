<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['roleID'])) {
        $roleID = $_POST['roleID'];
        
        $sql = "SELECT * FROM users WHERE roleID = ?";
        $stmt = $connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $roleID);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            
            if ($user) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $roles = $_POST['roles'];

                $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "UPDATE users SET roles=?, username=?, password=? WHERE roleID = ?";
                $stmt = $connection->prepare($sql);
                
                if ($stmt) {
                    $stmt->bind_param("sssi", $roles, $username, $hashedpassword, $roleID);
                    if ($stmt->execute()) {
                        
                        header("Location: http://localhost/stucco%20webpage/static/profileManagement.php");
                        exit();
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing the SQL statement.";
                }
            } else {
                echo "User not found.";
            }
        } else {
            echo "Error preparing the SQL statement.";
        }
    } else {
        echo "User ID not provided.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User Details</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/stucco%20webpage/static/loginStyle.css">
</head>
<body>
    <h1>Edit User Details</h1>
    <form action="" method="post">
        <label for="roleID">User ID:</label>
        <input type="text" id="roleID" name="roleID" value="<?php echo isset($user) ? $user['roleID'] : ''; ?>" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($user) ? $user['username'] : ''; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo isset($user) ? $user['password'] : ''; ?>" required><br><br>

        <label for="roles">Roles:</label>
        <select id="roles" name="roles">
            <!-- Use the 'selected' attribute to pre-select the user's role -->
            <?php
            $userRoles = isset($user) ? $user['roles'] : '';
            $rolesList = array("Branch Manager", "CSDL Director", "Finance", "Marketing", "GSD", "COO", "Student");
            foreach ($rolesList as $role) {
                echo "<option value=\"$role\"";
                if ($userRoles === $role) {
                    echo ' selected';
                }
                echo ">$role</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
