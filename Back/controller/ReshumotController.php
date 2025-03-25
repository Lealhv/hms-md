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

    public function create()
    {
        // קבלת הנתונים מה-BODY של הבקשה
        $data = json_decode(file_get_contents("php://input"));

        $query = "INSERT INTO reshumot (Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_patoor, Rsh_schoom, Rsh_maam, Rsh_schmaam, Rsh_schtotal, Rsh_aspaka, Rsh_proyktnam, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $this->conn->error]);
            return;
        }

        $stmt->bind_param(
            "ssssisddddsssss",
            $data->Rsh_date,
            $data->Rsh_mchlaka,
            $data->Rsh_sapak,
            $data->Rsh_patoor,
            $data->Rsh_schoom,
            $data->Rsh_maam,
            $data->Rsh_schmaam,
            $data->Rsh_schtotal,
            $data->Rsh_aspaka,
            $data->Rsh_proyktnam,
            $data->Rsh_sochen,
            $data->Rsh_takziv,
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





    public function read($Rsh_id)
    {
        $query = "SELECT * FROM reshumot WHERE Rsh_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $Rsh_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reshumot = $result->fetch_assoc();
            echo json_encode($reshumot);
        } else {
            echo json_encode(["error" => "Reshumot not found"]);
        }
    }
    public function upDate($id)
    {
        // קבלת הנתונים מה-BODY של הבקשה
        $data = json_decode(file_get_contents("php://input"));
    
        // Debug output to check the data
        error_log("Data received: " . print_r($data, true));
    
        $query = "UPDATE reshumot SET 
                    Rsh_date = ?, 
                    Rsh_mchlaka = ?, 
                    Rsh_sapak = ?, 
                    Rsh_patoor = ?, 
                    Rsh_schoom = ?, 
                    Rsh_maam = ?, 
                    Rsh_schmaam = ?, 
                    Rsh_schtotal = ?, 
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
    
        // Explicitly convert numeric values to ensure proper binding
        $schoom = floatval($data->Rsh_schoom);
        $maam = floatval($data->Rsh_maam);
        $schmaam = floatval($data->Rsh_schmaam);
        $schtotal = floatval($data->Rsh_schtotal);
        $sochen = strval($data->Rsh_sochen);
        $takziv = strval($data->Rsh_takziv);
        $id_param = intval($id);
    
        $stmt->bind_param(
            "ssssddddsssssssi",
            $data->Rsh_date,
            $data->Rsh_mchlaka,
            $data->Rsh_sapak,
            $data->Rsh_patoor,
            $schoom,
            $maam,
            $schmaam,
            $schtotal,
            $data->Rsh_aspaka,
            $data->Rsh_proyktnam,
            $sochen,
            $takziv,
            $data->Rsh_cname,
            $data->Rsh_cnametl,
            $data->Rsh_cemail,
            $id_param
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

        $stmt->bind_param("i", $id); // ה-ID של הרשומה למחיקה

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
