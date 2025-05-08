<?php
header("Content-Type: application/json");

require '../models/Mnilvim.php';
require '../config/Database.php';

class MnilvimController
{
    private $conn;

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Constructor
     *
     * @uses global $conn The connection created in Database.php
     */
/*******  8422a7ba-d32a-435e-97ea-d0980d11eacf  *******/    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

public function create() 
{ 
    if (!isset($_POST['MN_pratim'], $_POST['MN_shyooch'], $_POST['MN_status'], $_POST['MN_dateAdd'], $_POST['MN_type'])) { 
        echo json_encode(['error' => 'Missing required parameters']); 
        return; 
    } 

    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) { 
        $fileTmpPath = $_FILES['document']['tmp_name']; 
        $fileName = $_FILES['document']['name']; 
        $fileSize = $_FILES['document']['size']; 
        $fileType = $_FILES['document']['type']; 

        $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/uploadFile'; 
        $dest_path = $uploadFileDir . '/' . $fileName; 

        if (move_uploaded_file($fileTmpPath, $dest_path)) { 
            $relativePath = '/wp-content/uploads/uploadFile/' . $fileName; 
            $query = "INSERT INTO mnilvim (MN_pratim, MN_location, MN_shyooch, MN_status, MN_dateAdd, MN_type) VALUES (?, ?, ?, ?, ?, ?)"; 
            $stmt = $this->conn->prepare($query); 
            $stmt->bind_param("ssisss", $_POST['MN_pratim'], $relativePath, $_POST['MN_shyooch'], $_POST['MN_status'], $_POST['MN_dateAdd'], $_POST['MN_type']); 

            if ($stmt->execute()) { 
                $new_id = $stmt->insert_id; 
                echo json_encode([ 
                    "message" => "Mnilvim created successfully", 
                    "MN_id" => $new_id, 
                    "uploaded_file" => $relativePath 
                ]); 
            } else { 
                echo json_encode(["error" => "Failed to create Mnilvim: " . $stmt->error]); 
            } 
        } else { 
            echo json_encode(["error" => "Failed to move uploaded file"]); 
        } 
    } else { 
        echo json_encode(["error" => "No file uploaded or there was an upload error"]); 
    } 
}


    public function read($MN_shyooch)
    {
        $query = "SELECT * FROM mnilvim WHERE MN_shyooch = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $MN_shyooch);
        $stmt->execute();
        $result = $stmt->get_result();
        $mnilvimArray = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $mnilvimArray[] = $row;
            }
            echo json_encode($mnilvimArray);
        } else {
            echo json_encode(["error" => "Mnilvim not found"]);
        }
    }

    public function update($MN_id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['MN_pratim'], $data['MN_location'], $data['MN_shyooch'], $data['MN_status'], $data['MN_dateAdd'], $data['MN_type'])) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        $query = "UPDATE mnilvim SET MN_pratim = ?, MN_location = ?, MN_shyooch = ?, MN_status = ?, MN_dateAdd = ?, MN_type = ? WHERE MN_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssi", $data['MN_pratim'], $data['MN_location'], $data['MN_shyooch'], $data['MN_status'], $data['MN_dateAdd'], $data['MN_type'], $MN_id);

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
        $stmt->bind_param("i", $MN_id);

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

    public function error($msg)
    {
        echo json_encode(['error' => $msg]);
    }
}

$requestUri = str_replace('/MnilvimController.php', '', $_SERVER['REQUEST_URI']);
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new MnilvimController();

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $rawBody = file_get_contents('php://input');
    $body = json_decode($rawBody, true);

    if (isset($body['_method'])) {
		
        $fake = strtoupper($body['_method']);
        if ($fake === 'PUT' && isset($requestUri[1])) {
            $controller->update($requestUri[1]);
        } elseif ($fake === 'DELETE' && isset($requestUri[1])) {
            $controller->delete($requestUri[1]);
        } else {
            $controller->error('שיטת בקשה לא חוקית');
        }
        exit;
    } else {
        // Call create method with proper data
        $controller->create($body);
        exit;
    }
}

if ($method === 'GET') {
    if (isset($requestUri[1])) {
        $controller->read($requestUri[1]);
    } else {
        $controller->listAll();
    }
} else {
    $controller->error('שיטת בקשה לא נתמכת');
}
?>
