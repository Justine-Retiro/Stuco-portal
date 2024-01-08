<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuCo Requests</title>
    <link rel="stylesheet" href="requestStyle.css">
   
</head>
<body>
    <header>
        <div class="user">
            <img src="logo.png" alt="Picture">
        </div>
    
        <nav class="navbar">
            <ul>
                <li><a href="http://localhost/stuco/AdminLanding/AdminLanding.html">Dashboard</a></li>
                <li><a href="http://localhost/stuco/AdminLanding/Notifications.php">Notification</a></li>
                <li><a href="http://localhost/stuco/AdminLanding/DocumentArchives.html">Document Archives</a></li>
                <li><a href="http://localhost/stuco/AdminLanding/Calendar.html">Calendar of Events</a></li>
                <li><a href="http://localhost/stuco/Counsil/">Sign Out</a></li>   
            </ul>
        </nav>
    </header> 
    
    <div class="form-background">
        <div class = "form-container">
            <form action="request.php" method="post">
                <label for="from">From:</label>
                <input type="text" id="from" name="from" required><br><br>
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required><br><br>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required><br><br>
                <input type="file" id="file" name="file" multiple>
                <select name="admin_type" id="adminType">
                    <option value="Branch Manager">Branch Manager</option>
                    <option value="Adviser">Adviser</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
                    <option value="GSD">GSD</option>
                    <option value="COO">COO</option>
                </select>
                <button type="submit">submit</button>
            </form>
         </div>
    </div>
    
      
</body>
</html>