<?php
header("Content-Type: application/json");

require '../models/Maam.php';
require '../config/Database.php'; // This will include the file and create $conn

class MaamController {
    private $conn;
    
    public function __construct() {
        global $conn; // Use the connection created in Database.php
        $this->conn = $conn;
    }
    
    public function getAllMaams() {
        $query = "SELECT * FROM maam"; // Adjust the table name according to your database
        $result = $this->conn->query($query);
        
        $maams = [];
        while ($row = $result->fetch_assoc()) {
            $maams[] = $row;
        }
        
        echo json_encode($maams);
    }
    
    public function readMaam($maam_v) {
        $query = "SELECT * FROM maam WHERE maam_v = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $maam_v);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $maam = $result->fetch_assoc();
            echo json_encode($maam);
        } else {
            echo json_encode(["error" => "Maam not found"]);
        }
    }
    
    public function addMaam() {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['maam_v'], $input['maam_value'], $input['maam_Strtdate'], $input['maam_Enddate'])) {
            echo json_encode(["error" => "Missing parameters"]);
            return;
        }
        
        $query = "INSERT INTO maam (maam_v, maam_value, maam_Strtdate, maam_Enddate) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", 
            $input['maam_v'], 
            $input['maam_value'], 
            $input['maam_Strtdate'], 
            $input['maam_Enddate']
        );
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Maam added successfully"]);
        } else {
            echo json_encode(["error" => "Failed to add maam: " . $stmt->error]);
        }
    }
}

// Improved routing
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/MaamController.php', '', $requestUri);

$basePath = '/project/hms-md/Back/controller'; // Adjust to your project's base path

$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new MaamController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "maam" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->readMaam($requestUri[1]); // GET /maam/{id}
    } elseif ($requestUri[0] === "maams" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getAllMaams(); // GET /maams
    } elseif ($requestUri[0] === "maam" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->addMaam(); // POST /maam
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>