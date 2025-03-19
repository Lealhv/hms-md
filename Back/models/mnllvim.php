<?php

class Mnllvim {
    public $MN_id;
    public $MN_pratim;
    public $MN_location;

    public function __construct($MN_id, $MN_pratim, $MN_location) {
        $this->MN_id = $MN_id;
        $this->MN_pratim = $MN_pratim;
        $this->MN_location = $MN_location;
    }
}
