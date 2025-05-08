<?php
header("Content-Type: application/json");

require '../models/Supplier.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class SuppliersController
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
        echo json_encode(["error" => "Invalid input, expected an array of suppliers."]);
        return;
    }

    $responses = []; // מערך לאחסון תגובות לכל ספק

    // התחלת טרנזקציה
    $this->conn->begin_transaction();

    try {
        foreach ($data as $supplier) {
            $SP_id   = $supplier['SP_id'] ?? null;
            $SP_name = $supplier['SP_name'] ?? null;

            if ($SP_id === null || $SP_name === null) {
                $responses[] = ["error" => "Missing required parameters for supplier."];
                continue; // המשך לספק הבא
            }

            // ודא ש-SP_id הוא מספר
            if (!is_numeric($SP_id) || $SP_id <= 0) {
                $responses[] = ["error" => "Invalid SP_id: must be a positive number."];
                continue; // המשך לספק הבא
            }

            $query = "INSERT INTO suppliers (SP_id, SP_name) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt === false) {
                $responses[] = ["error" => "Prepare failed: " . $this->conn->error];
                continue; // המשך לספק הבא
            }

            $stmt->bind_param("is", $SP_id, $SP_name);

            if ($stmt->execute()) {
                $responses[] = ["message" => "Supplier created successfully", "SP_id" => $SP_id];
            } else {
                $responses[] = ["error" => "Failed to create supplier: " . $stmt->error];
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



    public function read($SP_id)
    {
        $query = "SELECT * FROM suppliers WHERE SP_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $SP_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $supplier = $result->fetch_assoc();
            echo json_encode($supplier);
        } else {
            echo json_encode(["error" => "Supplier not found"]);
        }
    }

    public function upDate($id)
    {
        // קבלת הנתונים מה-BODY של הבקשה
        $data = json_decode(file_get_contents("php://input"));

        $query = "UPDATE suppliers SET SP_name = ? WHERE SP_id = ?";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        $stmt->bind_param("si", $data->SP_name, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Supplier updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update supplier: " . $stmt->error]);
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM suppliers WHERE SP_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $id); // ה-ID של ההזמנה למחיקה

        if ($stmt->execute()) {
            echo json_encode(["message" => "Supplier deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete supplier: " . $stmt->error]);
        }
    }


    public function listAll()
    {
        $query = "SELECT * FROM suppliers";
        $result = $this->conn->query($query);

        $suppliersList = [];
        while ($row = $result->fetch_assoc()) {
            $suppliersList[] = $row;
        }

        echo json_encode($suppliersList);
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/SuppliersController.php', '', $requestUri);
// Update the base path to match WordPress structure
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new SuppliersController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "supplier" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->read($requestUri[1]); // GET /supplier/{id}
    } elseif ($requestUri[0] === "suppliers" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /suppliers
    } elseif ($requestUri[0] === "supplier" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /supplier
    } elseif ($requestUri[0] === "supplier" && $_SERVER['REQUEST_METHOD'] === "PUT" && isset($requestUri[1])) {
        $controller->upDate($requestUri[1]); // PUT /supplier/{id}
    } elseif ($requestUri[0] === "supplier" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1])) {
        $controller->delete($requestUri[1]); // DELETE /supplier/{id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
} 