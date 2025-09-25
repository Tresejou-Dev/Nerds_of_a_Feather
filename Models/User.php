<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password_hash;
    public $email;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET username=:username, password_hash=:password_hash, email=:email";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        // Bind parameters
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password_hash", $this->password_hash);
        $stmt->bindParam(":email", $this->email);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function usernameExists() {
        $query = "SELECT id, username, password_hash 
                FROM " . $this->table_name . " 
                WHERE username = ? 
                LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password_hash = $row['password_hash'];
            return true;
        }
        return false;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password_hash);
    }
}
?>