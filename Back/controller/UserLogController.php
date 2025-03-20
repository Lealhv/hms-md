<?php
header("Content-Type: application/json");

require '../models/UserLog.php';
require '../config/Database.php'; // This will include the file and create $conn

class UserLogController {
    private $conn;
    
    public function __construct() {
        global $conn; // Use the connection created in Database.php
        $this->conn = $conn;
    }
    
    public function getAllLogs() {
        $query = "SELECT * FROM userlog"; // Adjust the table name according to your database
        $result = $this->conn->query($query);
        
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        
        echo json_encode($logs);
    }
    
    public function readLog($Lg_user) {
        $query = "SELECT * FROM userlog WHERE Lg_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $Lg_user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $log = $result->fetch_assoc();
            echo json_encode($log);
        } else {
            echo json_encode(["error" => "Log not found"]);
        }
    }
    
    public function addLog() {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['Lg_user'], $input['Lg_status'], $input['Lg_timestmpin'], $input['Lg_timestmpiout'])) {
            echo json_encode(["error" => "Missing parameters"]);
            return;
        }
        
        $query = "INSERT INTO userlog (Lg_user, Lg_status, Lg_timestmpin, Lg_timestmpiout) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", 
            $input['Lg_user'], 
            $input['Lg_status'], 
            $input['Lg_timestmpin'], 
            $input['Lg_timestmpiout']
        );
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Log added successfully"]);
        } else {
            echo json_encode(["error" => "Failed to add log: " . $stmt->error]);
        }
    }
}

// Improved routing
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/UserLogController.php', '', $requestUri);

$basePath = '/project/hms-md/Back/controller'; // Adjust to your project's base path

$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new UserLogController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "log" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->readLog($requestUri[1]); // GET /log/{user}
    } elseif ($requestUri[0] === "logs" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getAllLogs(); // GET /logs
    } elseif ($requestUri[0] === "log" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->addLog(); // POST /log
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>