<?php
header("Content-Type: application/json");

require '../models/department_agents.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class AgentDepartmentsController
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

        if (!is_array($data)) {
            echo json_encode(["error" => "Invalid input, expected an array of agent departments."]);
            return;
        }

        $responses = []; // Array to store responses for each agent department

        // Start transaction
        $this->conn->begin_transaction();

        try {
            foreach ($data as $agentDepartment) {
                $department_id = $agentDepartment['department_id'] ?? null;
                $agent_id = $agentDepartment['agent_id'] ?? null;

                if ($department_id === null || $agent_id === null) {
                    $responses[] = ["error" => "Missing required parameters department_id or agent_id."];
                    continue; // Continue to the next agent department
                }

                // Ensure both IDs are numbers
                if (!is_numeric($department_id) || !is_numeric($agent_id)) {
                    $responses[] = ["error" => "Invalid IDs: must be numbers."];
                    continue; // Continue to the next agent department
                }

                $query = "INSERT INTO department_agents (department_id, agent_id) VALUES (?, ?)";
                $stmt = $this->conn->prepare($query);

                if ($stmt === false) {
                    $responses[] = ["error" => "Prepare failed: " . $this->conn->error];
                    continue; // Continue to the next agent department
                }

                $stmt->bind_param("ii", $department_id, $agent_id);

                if ($stmt->execute()) {
                    $responses[] = ["message" => "Agent department created successfully", "department_id" => $department_id, "agent_id" => $agent_id];
                } else {
                    $responses[] = ["error" => "Failed to create agent department: " . $stmt->error];
                }
            }

            // If everything succeeded, commit the transaction
            $this->conn->commit();
        } catch (Exception $e) {
            // On error, rollback the transaction
            $this->conn->rollback();
            $responses[] = ["error" => "Transaction failed: " . $e->getMessage()];
        }

        echo json_encode($responses);
    }

    public function readAgentsByDepartmentIds($departmentIds)
    {
        // המרת רשימת department_id למחרוזת עבור השאילתה
        $ids = implode(',', array_map('intval', $departmentIds));
        
        $query = "SELECT agent_id FROM agents WHERE department_id IN ($ids)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $agentIds = [];
        while ($row = $result->fetch_assoc()) {
            $agentIds[] = $row['agent_id'];
        }
    
        if (count($agentIds) > 0) {
            echo json_encode($agentIds);
        } else {
            echo json_encode(["error" => "No agents found for the provided department_ids."]);
        }
    }
    
    
    public function delete($department_id, $agent_id)
    {
        $query = "DELETE FROM department_agents WHERE department_id = ? AND agent_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $department_id, $agent_id); // The department ID and agent ID for deletion

        if ($stmt->execute()) {
            echo json_encode(["message" => "Agent department deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete agent department: " . $stmt->error]);
        }
    }

    public function listAll()
    {
        $query = "SELECT * FROM department_agents";
        $result = $this->conn->query($query);

        $agentDepartmentsList = [];
        while ($row = $result->fetch_assoc()) {
            $agentDepartmentsList[] = $row;
        }

        echo json_encode($agentDepartmentsList);
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/AgentDepartmentsController.php', '', $requestUri);
// Update the base path to match WordPress structure
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new AgentDepartmentsController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "agent_department" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->readAgentsByDepartmentIds($requestUri[1]); // GET /agent_department/{agent_id}
    } elseif ($requestUri[0] === "agent_departments" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /agent_departments
    } elseif ($requestUri[0] === "agent_department" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /agent_department
    } elseif ($requestUri[0] === "agent_department" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1]) && isset($requestUri[2])) {
        $controller->delete($requestUri[1], $requestUri[2]); // DELETE /agent_department/{department_id}/{agent_id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
