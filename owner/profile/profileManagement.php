<!DOCTYPE html>
<html>
<head>
    <title>Diary Listing Result</title>
    <style>
        body {
            background-color: wheat;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 20px;
        }

        h1 {
            text-align: center;

        }

        .container {
            max-width: 90%;
            margin: 20px;
            padding: 20px 30px 20px 30px;
            background-color: #1c3360;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            text-align: center;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .back-button {
            display: inline;
            margin-top: 20px;
            text-align: center;
        }

        .back-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .back-button a:hover {
            background-color: #555;
        }

        @media (max-width: 768px) {
            .container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h1>User Management</h1><br>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "stucoportal";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            function displayTable($data) {
                echo '<table>';
                echo '<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Surname</th><th>Gender</th><th>Gmail</th><th>Username</th><th>Password</th><th>Actions</th>';

                foreach ($data as $row) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["firstname"] . '</td>';
                    echo '<td>' . $row["middlename"] . '</td>';
                    echo '<td>' . $row["surname"] . '</td>';
                    echo '<td>' . $row["gender"] . '</td>';
                    echo '<td>' . $row["gmail"] . '</td>';
                    echo '<td>' . $row["username"] . '</td>';
                    echo '<td>' . $row["password"] . '</td>';
                    echo '<td>';
                    echo '<button onclick="editUser(' . $row["id"] . ')">Edit</button>';
                    echo '<button onclick="deleteUser(' . $row["id"] . ')">Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            }

            $sql = "SELECT * FROM signup";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }

                // Sort the data based on roleID (you can modify the sorting logic)
                usort($data, function ($a, $b) {
                    return $a['id'] - $b['id'];
                });

                displayTable($data);
            } else {
                echo "No records found.";
            }

            $conn->close();
            ?>
        </div>
        <div class="back-button">
            <a href="http://localhost/stucco%20webpage/static/addUser.php">Add</a>
        </div>

        <script>
            function editUser(roleID) {
                // Implement your edit logic, e.g., redirect to edit page with roleID
                window.location.href = 'http://localhost/stucco%20webpage/static/editUser.php?roleID=' + roleID;
            }

            function deleteUser(roleID) {
                // Implement your delete logic, e.g., show confirmation and then delete
                var confirmDelete = confirm('Are you sure you want to delete this user?');

                if (confirmDelete) {


                    if (confirmDelete) {
                        // Redirect to deleteUser.php with user ID
                        window.location.href = 'http://localhost/Stuco/OwnerLanding/deleteUser.php?id=' + userID;
                }
            }
        }
        </script>
    </div>
</body>
</html>
