<?php
// Start the session
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/globalapi/middleware.php'); 

// Check if the user is logged in and has a valid token
if(!isset($_SESSION['loggedin']) || !isset($_SESSION['token']) || $_SESSION['loggedin'] !== true) {
    error_log('Session variables for loggedin or token are not set or loggedin is not true');
    session_destroy();
    header("Location: ../../index.php"); // Redirect to login page
    exit();
}

// Verify the token
$token = $_SESSION['token'];
$isValidToken = verifyToken($token);

if(!$isValidToken || $_SESSION['adminType'] != 'Student Council' || !isset($_SESSION['username']) || !isset($_SESSION["department"])) {
    error_log('Username is not set in the session');
    error_log('User is not a Student Council member');

    // If the token is invalid, or the user is not a Student Council member, or there is no username
    // End the session and redirect them
    session_destroy();
    header("Location: ../../index.php"); // Redirect to login page
    exit();
}

// Set session lifetime to 1 hour
$inactive = 3600;

// Check if the "timeout" variable exists
if(isset($_SESSION['timeout'])) {
    // Calculate the session's "life" in seconds
    $session_life = time() - $_SESSION['timeout'];
    
    // If it has been inactive for too long
    if($session_life > $inactive) {
        // End the session
        session_destroy();
        header("Location: ../../logout.php"); // Redirect to logout page
        exit();
    }
}

// Update the "timeout" variable with the current time
$_SESSION['timeout'] = time();

function verifyToken($token) {
    // Get the username from the session
    $username = $_SESSION['username'];
    $table = $_SESSION['table'];
    // Create a new User object
    $user = new User($username, $table);

    // Get the token for the user from the database
    $storedToken = $user->getToken();

    // Check if the provided token matches the stored token
    if($token === $storedToken) {
        return true;
    } else {
        return false;
    }
}

?>