<?php
session_start();

header('Content-Type: application/json'); // Set correct content type for JSON response

$response = array(
    "table" => $_SESSION["table"] ?? null,
    "loggedin" => $_SESSION["loggedin"] ?? null,
    "id" => $_SESSION["id"] ?? null,
    "username" => $_SESSION["username"] ?? null,
    "adminType" => $_SESSION["adminType"] ?? null,
    "defaultpass_used" => $_SESSION["defaultpass_used"] ?? null
);

echo json_encode($response);
?>