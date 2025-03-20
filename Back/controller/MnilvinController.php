<?php
header("Content-Type: application/json");

require '../models/Mnilvim.php';
require '../config/Database.php';

class MnilvimController {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    public function getAllMnilvim() {
        $query = "SELECT * FROM mnilvim";
        $result = $this->conn->query($query);
        
        if ($result === false) {
            // Query failed
            echo json_encode([
                "error" => "Database query failed", 
                "message" => $this->conn->error
            ]);
            return;
        }
        
        $mnilvim = [];
        while ($row = $result->fetch_assoc()) {
            $mnilvim[] = $row;
        }
        
        echo json_encode($mnilvim);
    }
    
    
    public function readMnilvim($MN_id) {
        $query = "SELECT * FROM mnilvim WHERE MN_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $MN_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $mnilvim = $result->fetch_assoc();
            echo json_encode($mnilvim);
        } else {
            echo json_encode(["error" => "Mnilvim not found"]);
        }
    }
    
    public function addMnilvim() {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['MN_id'], $input['MN_pratim'], $input['MN_location'])) {
            echo json_encode(["error" => "Missing parameters"]);
            return;
        }
        
        $query = "INSERT INTO mnilvim (MN_id, MN_pratim, MN_location) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", 
            $input['MN_id'], 
            $input['MN_pratim'], 
            $input['MN_location']
        );
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Mnilvim added successfully"]);
        } else {
            echo json_encode(["error" => "Failed to add mnilvim: " . $stmt->error]);
        }
    }
}

// Get the request path info
$pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Split the path into segments
$pathSegments = explode('/', trim($pathInfo, '/'));

$controller = new MnilvimController();

// Simple routing based on path segments
if ($requestMethod === 'GET' && isset($pathSegments[0]) && $pathSegments[0] === 'mnilvims') {
    $controller->getAllMnilvim();
} elseif ($requestMethod === 'GET' && isset($pathSegments[0]) && $pathSegments[0] === 'mnilvim' && isset($pathSegments[1])) {
    $controller->readMnilvim($pathSegments[1]);
} elseif ($requestMethod === 'POST' && isset($pathSegments[0]) && $pathSegments[0] === 'mnilvim') {
    $controller->addMnilvim();
} else {
    echo json_encode(["error" => "Invalid endpoint or method", "path" => $pathInfo, "method" => $requestMethod]);
}
?>
