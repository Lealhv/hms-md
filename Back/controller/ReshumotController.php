<?php
header("Content-Type: application/json");

require '../models/Reshumot.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class ReshumotController
{
    private $conn;

    public function __construct()
    {
        global $conn; // Use the connection created in Database.php
        $this->conn = $conn;
    }

    private function supplierExists($supplierId)
    {
        $query = "SELECT COUNT(*) FROM suppliers WHERE SP_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $supplierId);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];

        return $count > 0;
    }

    public function create()
    {
        // קבלת הנתונים מה-BODY של הבקשה
        $data = json_decode(file_get_contents("php://input"));

        // בדוק אם הנתונים הושגו כראוי
        if (
            !isset($data->Rsh_date) || !isset($data->Rsh_mchlaka) || !isset($data->Rsh_sapak) ||
            !isset($data->Rsh_schoom) || !isset($data->Rsh_aspaka) ||
            !isset($data->Rsh_proyktnam) || !isset($data->Rsh_sochen) || !isset($data->Rsh_takziv) ||
            !isset($data->Rsh_cname) || !isset($data->Rsh_cnametl) || !isset($data->Rsh_cemail)
        ) {
            echo json_encode(["error" => "All fields are required."]);
            return;
        }

        // בדוק אם ה-Supplier קיים
        if (!$this->supplierExists($data->Rsh_sapak)) {
            echo json_encode(["error" => "Supplier does not exist."]);
            return;
        }

        // הסר את הבדיקה אם ה-SP_id קיים כבר במערכת
        // if ($this->spIdExists($data->Rsh_sapak)) {
        //     echo json_encode(["error" => "Error: Value already exists."]);
        //     return;
        // }

        $query = "INSERT INTO reshumot (Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_aspaka, Rsh_proyktnam, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        // Convert values to ensure proper types
        $schoom = floatval($data->Rsh_schoom);
        $aspaka = strval($data->Rsh_aspaka);
        $proyktnam = strval($data->Rsh_proyktnam);
        $sochen = strval($data->Rsh_sochen);
        $takziv = strval($data->Rsh_takziv);
        $stmt->bind_param(
            "sssisssssss", // 11 תווים
            $data->Rsh_date,
            $data->Rsh_mchlaka,
            $data->Rsh_sapak,
            $schoom,
            $aspaka,
            $proyktnam,
            $sochen,
            $takziv,
            $data->Rsh_cname,
            $data->Rsh_cnametl,
            $data->Rsh_cemail
        );

        if ($stmt->execute()) {
            $new_id = $stmt->insert_id; // קבלת ה-ID החדש שנוצר
            echo json_encode(["message" => "Reshumot created successfully", "Rsh_id" => $new_id]);
        } else {
            echo json_encode(["error" => "Failed to create reshumot: " . $stmt->error]);
        }
    }

    // פונקציה לבדוק אם ה-SP_id קיים במערכת
    private function spIdExists($sp_id)
    {
        // הפונקציה הזו לא נדרשת יותר, אז אפשר להשאיר אותה ריקה או למחוק
        return false; // מחזיר false תמיד
    }

    public function upDate($id)
    {
        // קבלת הנתונים מה-BODY של הבקשה
        $data = json_decode(file_get_contents("php://input"));

        // ודא שכל הנתונים הנדרשים קיימים
        if (
            !isset($data->Rsh_date) || !isset($data->Rsh_mchlaka) || !isset($data->Rsh_sapak) ||
            !isset($data->Rsh_schoom) || !isset($data->Rsh_aspaka) ||
            !isset($data->Rsh_proyktnam) || !isset($data->Rsh_sochen) || !isset($data->Rsh_takziv) ||
            !isset($data->Rsh_cname) || !isset($data->Rsh_cnametl) || !isset($data->Rsh_cemail)
        ) {
            echo json_encode(["error" => "All fields are required."]);
            return;
        }

        // בדוק אם ה-Supplier קיים
        if (!$this->supplierExists($data->Rsh_sapak)) {
            echo json_encode(["error" => "Supplier does not exist."]);
            return;
        }

        $query = "UPDATE reshumot SET 
                        Rsh_date = ?, 
                        Rsh_mchlaka = ?, 
                        Rsh_sapak = ?, 
                        Rsh_schoom = ?, 
                        Rsh_aspaka = ?, 
                        Rsh_proyktnam = ?, 
                        Rsh_sochen = ?, 
                        Rsh_takziv = ?, 
                        Rsh_cname = ?, 
                        Rsh_cnametl = ?, 
                        Rsh_cemail = ? 
                    WHERE Rsh_id = ?";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        // המרת סוגים
        $schoom = floatval($data->Rsh_schoom); // המרה ל-float
        $takziv = intval($data->Rsh_takziv); // המרה ל-integer
        $id_param = intval($id); // המרת ה-ID למספר שלם

        // טיפול בערכים שיכולים להיות NULL
        $aspaka = isset($data->Rsh_aspaka) ? strval($data->Rsh_aspaka) : null;
        $proyktnam = isset($data->Rsh_proyktnam) ? strval($data->Rsh_proyktnam) : null;
        $sochen = isset($data->Rsh_sochen) ? strval($data->Rsh_sochen) : null;

        $stmt->bind_param(
            "sssissssssss", // 12 תווים, כולל i ל-Rsh_id
            $data->Rsh_date,
            $data->Rsh_mchlaka,
            $data->Rsh_sapak,
            $schoom,
            $aspaka,
            $proyktnam,
            $sochen,
            $takziv,
            $data->Rsh_cname,
            $data->Rsh_cnametl,
            $data->Rsh_cemail,
            $id_param // ה-ID צריך להיות האחרון
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Reshumot updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update reshumot: " . $stmt->error]);
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM reshumot WHERE Rsh_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // ה-ID של ההזמנה למחיקה

        if ($stmt->execute()) {
            echo json_encode(["message" => "Reshumot deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete reshumot: " . $stmt->error]);
        }
    }

    public function listAll()
    {
        $query = "SELECT * FROM reshumot";
        $result = $this->conn->query($query);

        $reshumotList = [];
        while ($row = $result->fetch_assoc()) {
            $reshumotList[] = $row;
        }

        echo json_encode($reshumotList);
    }

    public function read($Rsh_id)
    {
        $query = "SELECT * FROM reshumot WHERE Rsh_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $Rsh_id); // שים לב שה-ID הוא מספרי
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reshumot = $result->fetch_assoc();
            echo json_encode($reshumot);
        } else {
            echo json_encode(["error" => "Reshumot not found"]);
        }
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/ReshumotController.php', '', $requestUri);
$basePath = '/project/hms-md/Back/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new ReshumotController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "reshumot" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->read($requestUri[1]); // GET /reshumot/{id}
    } elseif ($requestUri[0] === "reshumots" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /reshumots
    } elseif ($requestUri[0] === "reshumot" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /reshumot
    } elseif ($requestUri[0] === "reshumot" && $_SERVER['REQUEST_METHOD'] === "PUT" && isset($requestUri[1])) {
        $controller->upDate($requestUri[1]); // PUT /reshumot/{id}
    } elseif ($requestUri[0] === "reshumot" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1])) {
        $controller->delete($requestUri[1]); // DELETE /reshumot/{id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
