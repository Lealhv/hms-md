<?php

class Maam {
    public $maam_v;
    public $maam_value;
    public $maam_Strtdate;
    public $maam_Enddate;

    public function __construct($maam_v, $maam_value, $maam_Strtdate, $maam_Enddate) {
        $this->maam_v = $maam_v;
        $this->maam_value = $maam_value;
        $this->maam_Strtdate = $maam_Strtdate;
        $this->maam_Enddate = $maam_Enddate;
    }
}