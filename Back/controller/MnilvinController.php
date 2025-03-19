<?php

class MnllvimController {
    private $mnllvimList = [];

    // Create
    public function create($MN_id, $MN_pratim, $MN_location) {
        $mnllvim = new Mnllvim($MN_id, $MN_pratim, $MN_location);
        $this->mnllvimList[$MN_id] = $mnllvim;
        return $mnllvim;
    }

    // Read
    public function read($MN_id) {
        return isset($this->mnllvimList[$MN_id]) ? $this->mnllvimList[$MN_id] : null;
    }

    // Update
    public function update($MN_id, $MN_pratim, $MN_location) {
        if (isset($this->mnllvimList[$MN_id])) {
            $this->mnllvimList[$MN_id]->MN_pratim = $MN_pratim;
            $this->mnllvimList[$MN_id]->MN_location = $MN_location;
            return $this->mnllvimList[$MN_id];
        }
        return null;
    }

    // Delete
    public function delete($MN_id) {
        if (isset($this->mnllvimList[$MN_id])) {
            unset($this->mnllvimList[$MN_id]);
            return true;
        }
        return false;
    }

    // List all
    public function listAll() {
        return $this->mnllvimList;
    }
}
