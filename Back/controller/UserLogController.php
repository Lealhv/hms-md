<?php

class UserLogController {
    private $userLogList = [];

    // Create
    public function createLog($Lg_user, $Lg_status, $Lg_timestmpin, $Lg_timestmpiout) {
        $userLog = new UserLog();
        $userLog->Lg_user = $Lg_user;
        $userLog->Lg_status = $Lg_status;
        $userLog->Lg_timestmpin = $Lg_timestmpin;
        $userLog->Lg_timestmpiout = $Lg_timestmpiout;
        $this->userLogList[] = $userLog;
        return $userLog;
    }

    // Read
    public function readLog($index) {
        if (isset($this->userLogList[$index])) {
            $data = $this->userLogList[$index];
            echo json_encode($data);
        } else {
            echo json_encode(null);
        }
    }
    // Update
    public function updateLog($index, $Lg_user, $Lg_status, $Lg_timestmpin, $Lg_timestmpiout) {
        if (isset($this->userLogList[$index])) {
            $this->userLogList[$index]->Lg_user = $Lg_user;
            $this->userLogList[$index]->Lg_status = $Lg_status;
            $this->userLogList[$index]->Lg_timestmpin = $Lg_timestmpin;
            $this->userLogList[$index]->Lg_timestmpiout = $Lg_timestmpiout;
            return $this->userLogList[$index];
        }
        return null;
    }
    // Update partial
    public function updatePartialLog($index, $Lg_user = null, $Lg_status = null, $Lg_timestmpin = null, $Lg_timestmpiout = null) {
        if (isset($this->userLogList[$index])) {
            if ($Lg_user !== null) {
                $this->userLogList[$index]->Lg_user = $Lg_user;
            }
            if ($Lg_status !== null) {
                $this->userLogList[$index]->Lg_status = $Lg_status;
            }
            if ($Lg_timestmpin !== null) {
                $this->userLogList[$index]->Lg_timestmpin = $Lg_timestmpin;
            }
            if ($Lg_timestmpiout !== null) {
                $this->userLogList[$index]->Lg_timestmpiout = $Lg_timestmpiout;
            }
            return $this->userLogList[$index];
        }
        return null;
    }
    
    // Delete
    public function deleteLog($index) {
        if (isset($this->userLogList[$index])) {
            unset($this->userLogList[$index]);
            return true;
        }
        return false;
    }

    // List all
    public function listAllLogs() {
        return $this->userLogList;
    }
}
?>