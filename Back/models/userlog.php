<?php

class UserLog {
    public $Lg_user;
    public $Lg_status;
    public $Lg_timestmpin;
    public $Lg_timestmpiout;

    public function __construct($Lg_user, $Lg_status, $Lg_timestmpin, $Lg_timestmpiout) {
        $this->Lg_user = $Lg_user;
        $this->Lg_status = $Lg_status;
        $this->Lg_timestmpin = $Lg_timestmpin;
        $this->Lg_timestmpiout = $Lg_timestmpiout;
    }
}
