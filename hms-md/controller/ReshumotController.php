<?php
header("Content-Type: application/json");

require '../models/Reshumot.php';
require '../config/database.php';

class ReshumotController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function create($data)
    {
        if (!isset($data['Rsh_date'], $data['Rsh_mchlaka'], $data['Rsh_sapak'], $data['Rsh_schoom'], $data['Rsh_orderer'])) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        $Rsh_date      = $data['Rsh_date'];
        $Rsh_mchlaka   = $data['Rsh_mchlaka'];
        $Rsh_sapak     = $data['Rsh_sapak'];
        $Rsh_schoom    = $data['Rsh_schoom'];
        $Rsh_aspaka    = $data['Rsh_aspaka']    ?? '';
        $Rsh_proyktnam = $data['Rsh_proyktnam'] ?? '';
        $Rsh_sochen    = $data['Rsh_sochen']    ?? '';
        $Rsh_takziv    = $data['Rsh_takziv']    ?? '';
        $Rsh_cname     = $data['Rsh_cname']     ?? '';
        $Rsh_cnametl   = $data['Rsh_cnametl']   ?? '';
        $Rsh_cemail    = $data['Rsh_cemail']    ?? '';
        $Rsh_orderer   = $data['Rsh_orderer']   ?? '';

        $query = "INSERT INTO reshumot (Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_aspaka, Rsh_proyktnam, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail, Rsh_orderer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt  = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssssss", $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_aspaka, $Rsh_proyktnam, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail, $Rsh_orderer);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Reshumot created successfully', 'id' => $this->conn->insert_id]);
        } else {
            echo json_encode(['error' => 'Failed to create Reshumot']);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['Rsh_date'], $data['Rsh_mchlaka'], $data['Rsh_sapak'], $data['Rsh_schoom'], $data['Rsh_orderer'])) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }

        $Rsh_date      = $data['Rsh_date'];
        $Rsh_mchlaka   = $data['Rsh_mchlaka'];
        $Rsh_sapak     = $data['Rsh_sapak'];
        $Rsh_schoom    = $data['Rsh_schoom'];
        $Rsh_aspaka    = $data['Rsh_aspaka']    ?? '';
        $Rsh_proyktnam = $data['Rsh_proyktnam'] ?? '';
        $Rsh_sochen    = $data['Rsh_sochen']    ?? '';
        $Rsh_takziv    = $data['Rsh_takziv']    ?? '';
        $Rsh_cname     = $data['Rsh_cname']     ?? '';
        $Rsh_cnametl   = $data['Rsh_cnametl']   ?? '';
        $Rsh_cemail    = $data['Rsh_cemail']    ?? '';
        $Rsh_orderer   = $data['Rsh_orderer']   ?? '';

        $query = "UPDATE reshumot SET Rsh_date=?, Rsh_mchlaka=?, Rsh_sapak=?, Rsh_schoom=?, Rsh_aspaka=?, Rsh_proyktnam=?, Rsh_sochen=?, Rsh_takziv=?, Rsh_cname=?, Rsh_cnametl=?, Rsh_cemail=?, Rsh_orderer=? WHERE Rsh_id=?";
        $stmt  = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssssssi", $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_aspaka, $Rsh_proyktnam, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail, $Rsh_orderer, $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Reshumot updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update Reshumot']);
        }
    }

    public function read($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reshumot WHERE Rsh_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        echo json_encode($res->fetch_assoc() ?: ['error' => 'Reshumot not found']);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM reshumot WHERE Rsh_id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Record deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete record']);
        }
    }

    public function listAll()
    {
        $res = $this->conn->query("SELECT * FROM reshumot ORDER BY Rsh_id DESC");
        $list = [];
        while ($row = $res->fetch_assoc()) {
            $list[] = $row;
        }
        echo json_encode($list);
    }

    public function readByDepartments()
    {
        $rawBody = file_get_contents("php://input");
        $body = json_decode($rawBody, true);
        
        if (!isset($body['departments'])) {
            echo json_encode(['error' => 'Missing departments parameter']);
            return;
        }

        // המרת הסטרינג למערך של שמות מחלקות
        $departments = explode(',', $body['departments']);
        $departments = array_map('trim', $departments); // לנקות רווחים

        // יצירת השאלה עם placeholders
        $placeholders = implode(',', array_fill(0, count($departments), '?'));
        $query = "SELECT * FROM reshumot WHERE Rsh_mchlaka IN ($placeholders)";
        
        $stmt = $this->conn->prepare($query);
        
        // קישור הפרמטרים
        $stmt->bind_param(str_repeat('s', count($departments)), ...$departments);
        
        $stmt->execute();
        $res = $stmt->get_result();
        
        $list = [];
        while ($row = $res->fetch_assoc()) {
            $list[] = $row;
        }
        
        echo json_encode($list);
    }

    public function error($msg)
    {
        echo json_encode(['error' => $msg]);
    }
}

$request = str_replace('/ReshumotController.php', '', $_SERVER['REQUEST_URI']);
$base    = '/wp-content/themes/twentytwentyfour-child/hms-md/controller';
$request = explode('/', trim(str_replace($base, '', $request), '/'));
$action  = $request[0] ?? '';
$id      = $request[1] ?? null;

$controller = new ReshumotController();
$method     = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $rawBody = file_get_contents('php://input');
    $body    = json_decode($rawBody, true);

    if (isset($body['_method'])) {
        $fake = strtoupper($body['_method']);
        if ($fake === 'PUT' && isset($request[1])) {
            $controller->update($request[1]);
        } elseif ($fake === 'DELETE' && isset($request[1])) {
            $controller->delete($request[1]); // קריאה למחיקה
        } else {
            $controller->error('שיטת בקשה לא חוקית');
        }
        exit;
    } elseif (isset($body['departments'])) {
        $controller->readByDepartments();
        exit;
    } else {
        $controller->create($body);
        exit;
    }
}

if ($method === 'GET') {
    if (isset($request[1])) {
        $controller->read($request[1]);
    } else {
        $controller->listAll();
    }
} else {
    $controller->error('שיטת בקשה לא נתמכת');
}
?>
