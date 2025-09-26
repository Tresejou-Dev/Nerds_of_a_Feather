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
            
            // Initialize database schema only if tables don't exist
            $this->initializeSchemaIfNeeded();
            
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
    
    private function initializeSchemaIfNeeded() {
        // Check if users table exists
        $table_check = $this->conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
        if (!$table_check->fetch()) {
            $sql_file = __DIR__ . "/../database_setup.sql";
            if (file_exists($sql_file)) {
                $sql = file_get_contents($sql_file);
                $this->conn->exec($sql);
                error_log("Database schema initialized from: " . $sql_file);
            } else {
                error_log("Schema file not found: " . $sql_file);
            }
        }
    }
}
?>