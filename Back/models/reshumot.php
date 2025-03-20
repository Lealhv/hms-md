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

    public function __construct($data) {
        $this->Rsh_id = $data['Rsh_id'];
        $this->Rsh_date = $data['Rsh_date'];
        $this->Rsh_mchlaka = $data['Rsh_mchlaka'];
        $this->Rsh_sapak = $data['Rsh_sapak'];
        $this->Rsh_schoom = $data['Rsh_schoom'];
        $this->Rsh_maam = $data['Rsh_maam'];
        $this->Rsh_schmaam = $data['Rsh_schmaam'];
        $this->Rsh_schtotal = $data['Rsh_schtotal'];
        $this->Rsh_pratim = $data['Rsh_pratim'];
        $this->Rsh_proyktnam = $data['Rsh_proyktnam'];
        $this->Rsh_status = $data['Rsh_status'];
        $this->Rsh_sochen = $data['Rsh_sochen'];
        $this->Rsh_takziv = $data['Rsh_takziv'];
        $this->Rsh_cname = $data['Rsh_cname'];
        $this->Rsh_cnametl = $data['Rsh_cnametl'];
        $this->Rsh_cemail = $data['Rsh_cemail'];
    }

}
