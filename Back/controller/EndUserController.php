
<?php
header("Content-Type: application/json");

require '../models/EndUser.php';
require '../config/Database.php'; // זה יכלול את הקובץ ויצור את $conn

class EndUserController {
    private $conn;
    
    public function __construct() {
        global $conn; // השתמש בחיבור שנוצר בקובץ Database.php
        $this->conn = $conn;
    }
    
    public function getAllUsers() {
        $query = "SELECT * FROM enduser"; // התאם את שם הטבלה לפי מסד הנתונים שלך
        $result = $this->conn->query($query);
        
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        echo json_encode($users);
    }
    
    public function readUser($EU_PW) {
        $query = "SELECT * FROM enduser WHERE EU_PW = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $EU_PW);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode($user);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    }
    
    public function addUser() {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['EU_ID'], $input['EU_Name'], $input['EU_PW'], $input['EU_PR'], $input['EU_TZ'], $input['EU_TL'], $input['EU_Stat'])) {
            echo json_encode(["error" => "Missing parameters"]);
            return;
        }
        
        $query = "INSERT INTO enduser (EU_ID, EU_Name, EU_PW, EU_PR, EU_TZ, EU_TL, EU_Stat) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssss", 
            $input['EU_ID'], 
            $input['EU_Name'], 
            $input['EU_PW'], 
            $input['EU_PR'], 
            $input['EU_TZ'], 
            $input['EU_TL'], 
            $input['EU_Stat']
        );
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "User added successfully"]);
        } else {
            echo json_encode(["error" => "Failed to add user: " . $stmt->error]);
        }
    }
}

// שיפור הניתוב
$requestUri = $_SERVER['REQUEST_URI'];
// הדפס את ה-URI המלא לצורכי דיבוג
// echo "Full URI: " . $requestUri . "<br>";

// הסר את שם הקובץ מה-URI אם הוא קיים
$requestUri = str_replace('/EndUserController.php', '', $requestUri);

$basePath = '/project/hms-md/Back/controller'; // התאם לנתיב הבסיס של הפרויקט שלך

// הסר את נתיב הבסיס מה-URI
$requestUri = str_replace($basePath, '', $requestUri);
// הדפס את ה-URI אחרי הסרת הנתיב הבסיסי לצורכי דיבוג
// echo "URI after base path removal: " . $requestUri . "<br>";

$requestUri = explode("/", trim($requestUri, "/"));
// הדפס את המערך של חלקי ה-URI לצורכי דיבוג
// echo "URI parts: "; print_r($requestUri); echo "<br>";

$controller = new EndUserController();

if (count($requestUri) >= 1) {
    if ($requestUri[0] === "user" && $_SERVER['REQUEST_METHOD'] === "GET" && isset($requestUri[1])) {
        $controller->readUser($requestUri[1]); // GET /user/{id}
    } elseif ($requestUri[0] === "users" && $_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getAllUsers(); // GET /users
    } elseif ($requestUri[0] === "user" && $_SERVER['REQUEST_METHOD'] === "POST") {
        $controller->addUser(); // POST /user
    } else {
        echo json_encode(["error" => "Invalid endpoint: " . implode('/', $requestUri)]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
