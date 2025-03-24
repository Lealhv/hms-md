<?php
header("Content-Type: application/json");

require '../models/Mnilvim.php'; // Ensure the model exists
require '../config/database.php'; // This will include the file and create $conn

class MnilvimController
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
            $data['MN_id'],
            $data['MN_pratim'],
            $data['MN_location']
        )) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        // Create the Mnilvim object and save to database
        $query = "INSERT INTO mnilvim (MN_id, MN_pratim, MN_location) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sss",
            $data['MN_id'],
            $data['MN_pratim'],
            $data['MN_location']
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Mnilvim created successfully"]);
        } else {
            echo json_encode(["error" => "Failed to create Mnilvim: " . $stmt->error]);
        }
    }

    public function read($MN_id)
    {
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

    public function update($MN_id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if all required keys exist
        if (!isset(
            $data['MN_pratim'],
            $data['MN_location']
        )) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        $query = "UPDATE mnilvim SET MN_pratim = ?, MN_location = ? WHERE MN_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sss",
            $data['MN_pratim'],
            $data['MN_location'],
            $MN_id
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Mnilvim updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update Mnilvim: " . $stmt->error]);
        }
    }

    public function delete($MN_id)
    {
        $query = "DELETE FROM mnilvim WHERE MN_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $MN_id);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Mnilvim deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete Mnilvim: " . $stmt->error]);
        }
    }

    public function listAll()
    {
        $query = "SELECT * FROM mnilvim";
        $result = $this->conn->query($query);

        $mnilvimList = [];
        while ($row = $result->fetch_assoc()) {
            $mnilvimList[] = $row;
        }

        echo json_encode($mnilvimList);
    }
}

// Request handling
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/MnilvimController.php', '', $requestUri);
$basePath = '/project/hms-md/Back/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new MnilvimController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "mnilvim" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->read($requestUri[1]); // GET /mnilvim/{id}
    } elseif ($requestUri[0] === "mnilvims" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->listAll(); // GET /mnilvims
    } elseif ($requestUri[0] === "mnilvim" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->create(); // POST /mnilvim
    } elseif ($requestUri[0] === "mnilvim" && $_SERVER['REQUEST_METHOD'] === "PUT" && isset($requestUri[1])) {
        $controller->update($requestUri[1]); // PUT /mnilvim/{id}
    } elseif ($requestUri[0] === "mnilvim" && $_SERVER['REQUEST_METHOD'] === "DELETE" && isset($requestUri[1])) {
        $controller->delete($requestUri[1]); // DELETE /mnilvim/{id}
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}


// http://localhost/project/hms-md/Back/controller/EndUserController.php/users

// http://localhost/project/hms-md/Back/controller/MnilvimController.php/mnilvims