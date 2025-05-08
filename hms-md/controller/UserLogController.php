<?php
header("Content-Type: application/json");

require '../models/UserLog.php';
require '../config/database.php';

class UserLogController {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function create($data) {
        // בדוק את הנתונים הנדרשים כאן
    }

    public function read($Lg_user) {
        // פונקציה לקריאה
    }

    public function update($Lg_user) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['Lg_status'], $data['Lg_timestmpin'], $data['Lg_timestmpiout'])) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        $Lg_status = $data['Lg_status'];
        $Lg_timestmpin = $data['Lg_timestmpin'];
        $Lg_timestmpiout = $data['Lg_timestmpiout'];

        $query = "UPDATE userlog SET Lg_status=?, Lg_timestmpin=?, Lg_timestmpiout=? WHERE Lg_user=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $Lg_status, $Lg_timestmpin, $Lg_timestmpiout, $Lg_user);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Log updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update log']);
        }
    }

    public function listAll() {
        // פונקציה לרשימה
    }

    public function error($msg) {
        echo json_encode(['error' => $msg]);
    }
}

// שיפור ה-routing
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/UserLogController.php', '', $requestUri);
$basePath = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$requestUri = str_replace($basePath, '', $requestUri);
$requestUri = explode("/", trim($requestUri, "/"));

$controller = new UserLogController();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $rawBody = file_get_contents('php://input');
    $body = json_decode($rawBody, true);

    if (isset($body['_method'])) {
        $fake = strtoupper($body['_method']);
        if ($fake === 'PUT' && isset($requestUri[1])) {
            $controller->update($requestUri[1]);
        } else {
            $controller->error('שיטת בקשה לא חוקית');
        }
        exit;
    } else {
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
