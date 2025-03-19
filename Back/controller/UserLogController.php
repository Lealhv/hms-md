<?php
class UserController {
    private $db;

    public function __construct($database) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // אם הבקשה היא OPTIONS, פשוט מחזירים תשובה ריקה
            exit(0);
        }
        $this->db = $database;
    }

    public function create($lg_user, $lg_status, $lg_timestmpin, $lg_timestmpiout) {
        $stmt = $this->db->prepare("INSERT INTO users (Lg_user, Lg_status, Lg_timestmpin, Lg_timestmpiout) VALUES (?, ?, ?, ?)");
        $stmt->execute([$lg_user, $lg_status, $lg_timestmpin, $lg_timestmpiout]);
    }

    public function read($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(); 
    }

    public function update($id, $lg_user, $lg_status, $lg_timestmpin, $lg_timestmpiout) {
        $stmt = $this->db->prepare("UPDATE users SET Lg_user = ?, Lg_status = ?, Lg_timestmpin = ?, Lg_timestmpiout = ? WHERE id = ?");
        $stmt->execute([$lg_user, $lg_status, $lg_timestmpin, $lg_timestmpiout, $id]);
    }
    public function PartialUpdate($id, $userData) {
        $fields = [];
        $params = [];
    
        if (isset($userData['lg_user'])) {
            $fields[] = "Lg_user = ?";
            $params[] = $userData['lg_user'];
        }
        if (isset($userData['lg_status'])) {
            $fields[] = "Lg_status = ?";
            $params[] = $userData['lg_status'];
        }
        if (isset($userData['lg_timestmpin'])) {
            $fields[] = "Lg_timestmpin = ?";
            $params[] = $userData['lg_timestmpin'];
        }
        if (isset($userData['lg_timestmpiout'])) {
            $fields[] = "Lg_timestmpiout = ?";
            $params[] = $userData['lg_timestmpiout'];
        }
    
        if (empty($fields)) {
            return;
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
        $params[] = $id; 
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        }
        
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
