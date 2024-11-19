<?php
class Database {
    // Database connection parameters
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'ecommerce_db';

    // Connection variable
    private $conn;

    // Method to establish the connection
    public function getConnection() {
        // Create connection
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>
