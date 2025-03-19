<?php

class EndUser {
    public $id;
    public $EU_ID;
    public $EU_Name;
    public $EU_PW;
    public $EU_PR;
    public $EU_TZ;
    public $EU_TL;
    public $EU_Stat;

    public function __construct($id, $EU_ID, $EU_Name, $EU_PW, $EU_PR, $EU_TZ, $EU_TL, $EU_Stat) {
        $this->id = $id;
        $this->EU_ID = $EU_ID;
        $this->EU_Name = $EU_Name;
        $this->EU_PW = $EU_PW;
        $this->EU_PR = $EU_PR;
        $this->EU_TZ = $EU_TZ;
        $this->EU_TL = $EU_TL;
        $this->EU_Stat = $EU_Stat;
    }
}
