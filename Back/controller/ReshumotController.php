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
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if all required keys exist
        if (!isset(
            $data['Rsh_id'],
            $data['Rsh_date'],
            $data['Rsh_mchlaka'],
            $data['Rsh_sapak'],
            $data['Rsh_schoom'],
            $data['Rsh_maam'],
            $data['Rsh_schmaam'],
            $data['Rsh_schtotal'],
            $data['Rsh_pratim'],
            $data['Rsh_proyktnam'],
            $data['Rsh_status'],
            $data['Rsh_sochen'],
            $data['Rsh_takziv'],
            $data['Rsh_cname'],
            $data['Rsh_cnametl'],
            $data['Rsh_cemail']
        )) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        // Create the Reshumot object and save to database
        $query = "INSERT INTO reshumot (Rsh_id, Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_maam, Rsh_schmaam, Rsh_schtotal, Rsh_pratim, Rsh_proyktnam, Rsh_status, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssssssssssssssss",
            $data['Rsh_id'],
            $data['Rsh_date'],
            $data['Rsh_mchlaka'],
            $data['Rsh_sapak'],
            $data['Rsh_schoom'],
            $data['Rsh_maam'],
            $data['Rsh_schmaam'],
            $data['Rsh_schtotal'],
            $data['Rsh_pratim'],
            $data['Rsh_proyktnam'],
            $data['Rsh_status'],
            $data['Rsh_sochen'],
            $data['Rsh_takziv'],
            $data['Rsh_cname'],
            $data['Rsh_cnametl'],
            $data['Rsh_cemail']
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Reshumot created successfully"]);
        } else {
            echo json_encode(["error" => "Failed to create Reshumot: " . $stmt->error]);
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

    public function update($Rsh_id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if all required keys exist
        if (!isset(
            $data['Rsh_date'],
            $data['Rsh_mchlaka'],
            $data['Rsh_sapak'],
            $data['Rsh_schoom'],
            $data['Rsh_maam'],
            $data['Rsh_schmaam'],
            $data['Rsh_schtotal'],
            $data['Rsh_pratim'],
            $data['Rsh_proyktnam'],
            $data['Rsh_status'],
            $data['Rsh_sochen'],
            $data['Rsh_takziv'],
            $data['Rsh_cname'],
            $data['Rsh_cnametl'],
            $data['Rsh_cemail']
        )) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        $query = "UPDATE reshumot SET Rsh_date = ?, Rsh_mchlaka = ?, Rsh_sapak = ?, Rsh_schoom = ?, Rsh_maam = ?, Rsh_schmaam = ?, Rsh_schtotal = ?, Rsh_pratim = ?, Rsh_proyktnam = ?, Rsh_status = ?, Rsh_sochen = ?, Rsh_takziv = ?, Rsh_cname = ?, Rsh_cnametl = ?, Rsh_cemail = ? WHERE Rsh_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssssssssssssss",
            $data['Rsh_date'],
            $data['Rsh_mchlaka'],
            $data['Rsh_sapak'],
            $data['Rsh_schoom'],
            $data['Rsh_maam'],
            $data['Rsh_schmaam'],
            $data['Rsh_schtotal'],
            $data['Rsh_pratim'],
            $data['Rsh_proyktnam'],
            $data['Rsh_status'],
            $data['Rsh_sochen'],
            $data['Rsh_takziv'],
            $data['Rsh_cname'],
            $data['Rsh_cnametl'],
            $data['Rsh_cemail'],
            $Rsh_id
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Reshumot updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update Reshumot: " . $stmt->error]);
        }
    }

    public function delete($Rsh_id)
    {
        $query = "DELETE FROM reshumot WHERE Rsh_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $Rsh_id);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Reshumot deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete Reshumot: " . $stmt->error]);
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
        $controller->update($requestUri[1]); // PUT /reshumot/{id}
    } elseif ($requestUri[0] === "reshumot" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1])) {
        $controller->delete($requestUri[1]); // DELETE /reshumot/{id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
