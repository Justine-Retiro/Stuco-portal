<?php

    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "stucoportal";

    $connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

    try {
        $dbname = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
        $dbname->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

    



?>