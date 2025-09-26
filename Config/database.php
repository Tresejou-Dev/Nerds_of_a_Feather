<?php
class Database {
    private $db_file = __DIR__ . "/../nerds_feather.db";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            // Create database file if it doesn't exist
            $this->conn = new PDO("sqlite:" . $this->db_file);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Initialize database schema if needed
            $this->initializeSchema();
            
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
    
    private function initializeSchema() {
        $sql_file = __DIR__ . "/../database_setup.sql";
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            $this->conn->exec($sql);
        }
    }
}
?>