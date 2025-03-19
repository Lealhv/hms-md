<?php
class EndUserController {
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



    public function create($eu_id, $eu_name, $eu_pw, $eu_pr, $eu_tz, $eu_tl) {
        $stmt = $this->db->prepare("INSERT INTO enduser (EU_ID, EU_Name, EU_PW, EU_PR, EU_TZ, EU_TL) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$eu_id, $eu_name, $eu_pw, $eu_pr, $eu_tz, $eu_tl]);
    }

    
    public function read($id) {
        $stmt = $this->db->prepare("SELECT * FROM enduser WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(); 
    }
    //מחזיר את רמת ההרשאה של ה //USER
    // public function read($id) {
    //     $stmt = $this->db->prepare("SELECT EU_PR FROM enduser WHERE id = ?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetchColumn(); // מחזיר את הערך של העמודה EU_PR
    // }

    public function update($id, $eu_id, $eu_name, $eu_pw, $eu_pr, $eu_tz, $eu_tl) {
        $stmt = $this->db->prepare("UPDATE enduser SET EU_ID = ?, EU_Name = ?, EU_PW = ?, EU_PR = ?, EU_TZ = ?, EU_TL = ? WHERE id = ?");
        $stmt->execute([$eu_id, $eu_name, $eu_pw, $eu_pr, $eu_tz, $eu_tl, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM enduser WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>