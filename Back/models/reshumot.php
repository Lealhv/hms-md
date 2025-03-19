<?php

class Reshumot {
    public $Rsh_id;
    public $Rsh_date;
    public $Rsh_mchlaka;
    public $Rsh_sapak;
    public $Rsh_schoom;
    public $Rsh_maam;
    public $Rsh_schmaam;
    public $Rsh_schtotal;
    public $Rsh_pratim;
    public $Rsh_proyktnam;
    public $Rsh_status;
    public $Rsh_sochen;
    public $Rsh_takziv;
    public $Rsh_cname;
    public $Rsh_cnametl;
    public $Rsh_cemail;

    public function __construct($Rsh_id, $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_maam, $Rsh_schmaam, $Rsh_schtotal, $Rsh_pratim, $Rsh_proyktnam, $Rsh_status, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail) {
        $this->Rsh_id = $Rsh_id;
        $this->Rsh_date = $Rsh_date;
        $this->Rsh_mchlaka = $Rsh_mchlaka;
        $this->Rsh_sapak = $Rsh_sapak;
        $this->Rsh_schoom = $Rsh_schoom;
        $this->Rsh_maam = $Rsh_maam;
        $this->Rsh_schmaam = $Rsh_schmaam;
        $this->Rsh_schtotal = $Rsh_schtotal;
        $this->Rsh_pratim = $Rsh_pratim;
        $this->Rsh_proyktnam = $Rsh_proyktnam;
        $this->Rsh_status = $Rsh_status;
        $this->Rsh_sochen = $Rsh_sochen;
        $this->Rsh_takziv = $Rsh_takziv;
        $this->Rsh_cname = $Rsh_cname;
        $this->Rsh_cnametl = $Rsh_cnametl;
        $this->Rsh_cemail = $Rsh_cemail;
    }
}
