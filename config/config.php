<?php
class DatabaseConnection {
    private $servername = "localhost";
    private $username = "root";
    private $password = ""; // Leave this empty
    private $dbname = "managemate_db"; 

    public function startConnection() {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}

// Initialize the connection
$database = new DatabaseConnection();
$conn = $database->startConnection();
?>
