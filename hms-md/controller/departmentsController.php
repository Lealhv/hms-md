<?php
header("Content-Type: application/json");

require '../models/departments.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class DepartmentsController
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
            echo json_encode(["error" => "Invalid input, expected an array of departments."]);
            return;
        }

        $responses = []; // מערך לאחסון תגובות לכל מחלקה

        // התחלת טרנזקציה
        $this->conn->begin_transaction();

        try {
            foreach ($data as $department) {
                $DP_name = $department['DP_name'] ?? null;

                if ($DP_name === null) {
                    $responses[] = ["error" => "Missing required parameter DP_name."];
                    continue; // המשך למחלקה הבאה
                }

                $query = "INSERT INTO departments (DP_name) VALUES (?)";
                $stmt = $this->conn->prepare($query);

                if ($stmt === false) {
                    $responses[] = ["error" => "Prepare failed: " . $this->conn->error];
                    continue; // המשך למחלקה הבאה
                }

                $stmt->bind_param("s", $DP_name);

                if ($stmt->execute()) {
                    $responses[] = ["message" => "Department created successfully", "DP_id" => $this->conn->insert_id];
                } else {
                    $responses[] = ["error" => "Failed to create department: " . $stmt->error];
                }
            }

            // אם הכל הצליח, אשר את הטרנזקציה
            $this->conn->commit();
        } catch (Exception $e) {
            // במקרה של שגיאה, ביטול הטרנזקציה
            $this->conn->rollback();
            $responses[] = ["error" => "Transaction failed: " . $e->getMessage()];
        }

        echo json_encode($responses);
    }

    public function read($DP_ids)
    {
        $ids = explode(',', $DP_ids);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
        $query = "SELECT DP_id, DP_name FROM departments WHERE DP_id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $departments = [];
    
        while ($row = $result->fetch_assoc()) {
            $departments[] = [
                'DP_id' => $row['DP_id'],
                'DP_name' => $row['DP_name']
            ];
        }
    
        return json_encode($departments); // החזרת התוצאה
    }
    

    public function upDate($id)
    {
        // קבלת הנתונים מה-BODY של הבקשה
        $data = json_decode(file_get_contents("php://input"));

        $query = "UPDATE departments SET DP_name = ? WHERE DP_id = ?";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        $stmt->bind_param("si", $data->DP_name, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Department updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update department: " . $stmt->error]);
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM departments WHERE DP_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $id); // ה-ID של המחלקה למחיקה

        if ($stmt->execute()) {
            echo json_encode(["message" => "Department deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete department: " . $stmt->error]);
        }
    }

    public function listAll()
    {
        $query = "SELECT * FROM departments";
        $result = $this->conn->query($query);

        $departmentsList = [];
        while ($row = $result->fetch_assoc()) {
            $departmentsList[] = $row;
        }

        echo json_encode($departmentsList);
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/DepartmentsController.php', '', $requestUri);
// Update the base path to match WordPress structure
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new DepartmentsController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "department" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->read($requestUri[1]); // GET /department/{id}
    } elseif ($requestUri[0] === "departments" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /departments
    } elseif ($requestUri[0] === "department" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /department
    } elseif ($requestUri[0] === "department" && $_SERVER['REQUEST_METHOD'] === "PUT" && isset($requestUri[1])) {
        $controller->upDate($requestUri[1]); // PUT /department/{id}
    } elseif ($requestUri[0] === "department" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1])) {
        $controller->delete($requestUri[1]); // DELETE /department/{id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
