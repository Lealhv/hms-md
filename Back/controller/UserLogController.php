<?php
header("Content-Type: application/json");

require '../models/UserLog.php';
require '../config/database.php'; // This will include the file and create $conn

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

    public function updateLog($Lg_user) {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['Lg_status'], $input['Lg_timestmpin'], $input['Lg_timestmpiout'])) {
            echo json_encode(["error" => "Missing parameters"]);
            return;
        }

        $query = "UPDATE userlog SET Lg_status = ?, Lg_timestmpin = ?, Lg_timestmpiout = ? WHERE Lg_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", 
            $input['Lg_status'], 
            $input['Lg_timestmpin'], 
            $input['Lg_timestmpiout'], 
            $Lg_user
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Log updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update log: " . $stmt->error]);
        }
    }

    public function partialUpdateLog($Lg_user) {
        $input = json_decode(file_get_contents("php://input"), true);
        $fields = [];
        $params = [];

        if (isset($input['Lg_status'])) {
            $fields[] = "Lg_status = ?";
            $params[] = $input['Lg_status'];
        }
        if (isset($input['Lg_timestmpin'])) {
            $fields[] = "Lg_timestmpin = ?";
            $params[] = $input['Lg_timestmpin'];
        }
        if (isset($input['Lg_timestmpiout'])) {
            $fields[] = "Lg_timestmpiout = ?";
            $params[] = $input['Lg_timestmpiout'];
        }

        if (empty($fields)) {
            echo json_encode(["error" => "No fields to update"]);
            return;
        }

        $query = "UPDATE userlog SET " . implode(", ", $fields) . " WHERE Lg_user = ?";
        $stmt = $this->conn->prepare($query);
        $params[] = $Lg_user;
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Log partially updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update log: " . $stmt->error]);
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
    } elseif ($requestUri[0] === "log" && $_SERVER['REQUEST_METHOD'] === "PUT" && isset($requestUri[1])) {
        $controller->updateLog($requestUri[1]); // PUT /log/{user}
    } elseif ($requestUri[0] === "log" && $_SERVER['REQUEST_METHOD'] === "PATCH" && isset($requestUri[1])) {
        $controller->partialUpdateLog($requestUri[1]); // Post /log/{user}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>