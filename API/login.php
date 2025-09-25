<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) && !empty($data->password)) {
    $user->username = $data->username;
    
    if($user->usernameExists()) {
        if($user->verifyPassword($data->password)) {
            // Create session token
            $session_token = bin2hex(random_bytes(32));
            $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));
            
            // Store session in database
            $query = "INSERT INTO user_sessions (user_id, session_token, expires_at) 
                     VALUES (:user_id, :session_token, :expires_at)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":user_id", $user->id);
            $stmt->bindParam(":session_token", $session_token);
            $stmt->bindParam(":expires_at", $expires_at);
            $stmt->execute();
            
            http_response_code(200);
            echo json_encode(array(
                "message" => "Login successful.",
                "session_token" => $session_token,
                "user_id" => $user->id,
                "username" => $user->username
            ));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid password."));
        }
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "User not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to login. Data is incomplete."));
}
?>