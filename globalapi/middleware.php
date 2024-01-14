<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');
class User {
    private $username;
    private $db;
    private $table;

    public function __construct($username, $table) {
        $this->username = $username;
        $this->table = $table;
        $this->db = new PDO('mysql:host=localhost;dbname=stucoportal', 'root', ''); // blanks [database-name] - [username] - [password]
    }

    public function getToken() {
        // Prepare the SQL query
        $stmt = $this->db->prepare("SELECT token FROM {$this->table} WHERE username = :username");

        // Bind the username parameter to the prepared statement
        $stmt->bindParam(':username', $this->username);

        // Execute the statement
        $stmt->execute();

        // Fetch the token
        $token = $stmt->fetchColumn();

        return $token;
    }
}
?>