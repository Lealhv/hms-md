<?php

class MaamController {
    private $maamList = [];

    // Create
    public function create($maam_v, $maam_value, $maam_Strtdate, $maam_Enddate) {
        $maam = new Maam($maam_v, $maam_value, $maam_Strtdate, $maam_Enddate);
        $this->maamList[$maam_v] = $maam; // משתמשים ב-maam_v כמפתח
        return $maam;
    }

    // Read
    public function read($maam_v) {
        return isset($this->maamList[$maam_v]) ? $this->maamList[$maam_v] : null;
    }

    // Update
    public function update($maam_v, $maam_value, $maam_Strtdate, $maam_Enddate) {
        if (isset($this->maamList[$maam_v])) {
            $this->maamList[$maam_v]->maam_value = $maam_value;
            $this->maamList[$maam_v]->maam_Strtdate = $maam_Strtdate;
            $this->maamList[$maam_v]->maam_Enddate = $maam_Enddate;
            return $this->maamList[$maam_v];
        }
        return null;
    }

    // Delete
    public function delete($maam_v) {
        if (isset($this->maamList[$maam_v])) {
            unset($this->maamList[$maam_v]);
            return true;
        }
        return false;
    }

    // List all
    public function listAll() {
        return $this->maamList;
    }
}
