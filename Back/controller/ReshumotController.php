<?php
class DataController {
    public function saveData() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json"); // הוספת סוג התגובה

        // אם זה בקשת OPTIONS, רק מחזירים את הכותרות
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $data = json_decode(file_get_contents('php://input'), true);

        // בדוק אם הנתונים התקבלו כראוי
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // בקשה לא חוקית
            echo json_encode(['message' => 'Invalid JSON']);
            return;
        }

        // Assuming you have a function to save data to the database
        if ($this->saveToDatabase($data)) {
            http_response_code(200);
            echo json_encode(['message' => 'Data saved successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to save data']);
        }
    }

    private function saveToDatabase($data) {
        // Database saving logic here
        return true; // Return true if successful
    }
}

// דוגמה להפעלת המתודה
$controller = new DataController();
$controller->saveData();
?>
