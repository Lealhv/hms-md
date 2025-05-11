<?php
header("Content-Type: application/json");

require '../models/department_users.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class UserDepartmentsController
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
            echo json_encode(["error" => "Invalid input, expected an array of user departments."]);
            return;
        }

        $responses = []; // מערך לאחסון תגובות לכל מחלקה משתמש

        // התחלת טרנזקציה
        $this->conn->begin_transaction();

        try {
            foreach ($data as $userDepartment) {
                $department_id = $userDepartment['department_id'] ?? null;
                $user_id = $userDepartment['user_id'] ?? null;

                if ($department_id === null || $user_id === null) {
                    $responses[] = ["error" => "Missing required parameters department_id or user_id."];
                    continue; // המשך למחלקה משתמש הבאה
                }

                // ודא ש-both IDs הם מספרים
                if (!is_numeric($department_id) || !is_numeric($user_id)) {
                    $responses[] = ["error" => "Invalid IDs: must be numbers."];
                    continue; // המשך למחלקה משתמש הבאה
                }

                $query = "INSERT INTO user_departments (department_id, user_id) VALUES (?, ?)";
                $stmt = $this->conn->prepare($query);

                if ($stmt === false) {
                    $responses[] = ["error" => "Prepare failed: " . $this->conn->error];
                    continue; // המשך למחלקה משתמש הבאה
                }

                $stmt->bind_param("ii", $department_id, $user_id);

                if ($stmt->execute()) {
                    $responses[] = ["message" => "User department created successfully", "department_id" => $department_id, "user_id" => $user_id];
                } else {
                    $responses[] = ["error" => "Failed to create user department: " . $stmt->error];
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

    public function readByUserId($user_id)
    {
        $query = "SELECT department_id FROM user_departments WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $departmentIds = [];
        while ($row = $result->fetch_assoc()) {
            $departmentIds[] = $row['department_id'];
        }
    
        if (count($departmentIds) > 0) {
            echo json_encode($departmentIds);
        } else {
            echo json_encode(["error" => "No departments found for user_id: " . $user_id]);
        }
    }
    
    public function delete($department_id, $user_id)
    {
        $query = "DELETE FROM user_departments WHERE department_id = ? AND user_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $department_id, $user_id); // ה-ID של המחלקה ומשתמש למחיקה

        if ($stmt->execute()) {
            echo json_encode(["message" => "User department deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete user department: " . $stmt->error]);
        }
    }

    public function listAll()
    {
        $query = "SELECT * FROM user_departments";
        $result = $this->conn->query($query);

        $userDepartmentsList = [];
        while ($row = $result->fetch_assoc()) {
            $userDepartmentsList[] = $row;
        }

        echo json_encode($userDepartmentsList);
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/UserDepartmentsController.php', '', $requestUri);
// Update the base path to match WordPress structure
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new UserDepartmentsController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "user_department" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->readByUserId($requestUri[1]); // GET /user_department/{user_id}
    } elseif ($requestUri[0] === "user_departments" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /user_departments
    } elseif ($requestUri[0] === "user_department" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /user_department
    } elseif ($requestUri[0] === "user_department" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1]) && isset($requestUri[2])) {
        $controller->delete($requestUri[1], $requestUri[2]); // DELETE /user_department/{department_id}/{user_id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
