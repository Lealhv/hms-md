<?php
header("Content-Type: application/json");

require '../models/agents.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class AgentsController
{
    private $conn;

    public function __construct()
    {
        global $conn; // Use the connection created in Database.php
        $this->conn = $conn;
    }

    public function create()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);
        error_log("Data received: " . json_encode($data));

        if (!isset($data['AG_name'])) {
            echo json_encode(["error" => "Missing required parameter AG_name."]);
            return;
        }

        $AG_name = $data['AG_name'];

        $query = "INSERT INTO agent (AG_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        $stmt->bind_param("s", $AG_name);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Agenda created successfully", "AG_id" => $this->conn->insert_id]);
        } else {
            echo json_encode(["error" => "Failed to create agenda: " . $stmt->error]);
        }
    }


    public function read($AG_id)
    {
        $query = "SELECT * FROM agent WHERE AG_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $AG_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // החזרת האובייקט
        } else {
            return ["error" => "agent not found"];
        }
    }
    

    public function update($AG_id)
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->AG_name)) {
            echo json_encode(["error" => "Missing required parameter AG_name."]);
            return;
        }

        $query = "UPDATE agent SET AG_name = ? WHERE AG_id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        $stmt->bind_param("si", $data->AG_name, $AG_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "agent updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update agent: " . $stmt->error]);
        }
    }

    public function delete($AG_id)
    {
        $query = "DELETE FROM agent WHERE AG_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $AG_id); // ה-ID של האג'נדה למחיקה

        if ($stmt->execute()) {
            echo json_encode(["message" => "agent deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete agent: " . $stmt->error]);
        }
    }

    public function listAll()
    {
        $query = "SELECT * FROM agents";
        $result = $this->conn->query($query);

        $agendaList = [];
        while ($row = $result->fetch_assoc()) {
            $agendaList[] = $row;
        }

        echo json_encode($agendaList);
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/AgentsController.php', '', $requestUri);
// Update the base path to match WordPress structure
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new AgentsController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "agent" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->read($requestUri[1]); // GET /agenda/{id}
    } elseif ($requestUri[0] === "agents" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /agendas
    } elseif ($requestUri[0] === "agent" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /agenda
    } elseif ($requestUri[0] === "agent" && $_SERVER['REQUEST_METHOD'] === "PUT" && isset($requestUri[1])) {
        $controller->update($requestUri[1]); // PUT /agenda/{id}
    } elseif ($requestUri[0] === "agent" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1])) {
        $controller->delete($requestUri[1]); // DELETE /agenda/{id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
