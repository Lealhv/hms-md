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

$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/MnilvimController.php', '', $requestUri);

$basePath = '/project/hms-md/Back/controller';
$requestUri = str_replace($basePath, '', $requestUri);

$requestUri = explode("/", trim($requestUri, "/"));

$controller = new MnilvimController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "mnilvim" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->readMnilvim($requestUri[1]);
    } elseif ($requestUri[0] === "mnilvims" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getAllMnilvim();
    } elseif ($requestUri[0] === "mnilvim" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->addMnilvim();
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>