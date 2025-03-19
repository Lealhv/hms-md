<?php

class ReshumotController {
    private $reshumotList = [];

    // Create
    public function create($Rsh_id, $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_maam, $Rsh_schmaam, $Rsh_schtotal, $Rsh_pratim, $Rsh_proyktnam, $Rsh_status, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail) {
        $reshumot = new Reshumot($Rsh_id, $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_maam, $Rsh_schmaam, $Rsh_schtotal, $Rsh_pratim, $Rsh_proyktnam, $Rsh_status, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail);
        $this->reshumotList[$Rsh_id] = $reshumot; 
        return $reshumot;
    }

    // Read
    public function read($Rsh_id) {
        return isset($this->reshumotList[$Rsh_id]) ? $this->reshumotList[$Rsh_id] : null;
    }

    // Update
    public function update($Rsh_id, $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_maam, $Rsh_schmaam, $Rsh_schtotal, $Rsh_pratim, $Rsh_proyktnam, $Rsh_status, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail) {
        if (isset($this->reshumotList[$Rsh_id])) {
            $this->reshumotList[$Rsh_id]->Rsh_date = $Rsh_date;
            $this->reshumotList[$Rsh_id]->Rsh_mchlaka = $Rsh_mchlaka;
            $this->reshumotList[$Rsh_id]->Rsh_sapak = $Rsh_sapak;
            $this->reshumotList[$Rsh_id]->Rsh_schoom = $Rsh_schoom;
            $this->reshumotList[$Rsh_id]->Rsh_maam = $Rsh_maam;
            $this->reshumotList[$Rsh_id]->Rsh_schmaam = $Rsh_schmaam;
            $this->reshumotList[$Rsh_id]->Rsh_schtotal = $Rsh_schtotal;
            $this->reshumotList[$Rsh_id]->Rsh_pratim = $Rsh_pratim;
            $this->reshumotList[$Rsh_id]->Rsh_proyktnam = $Rsh_proyktnam;
            $this->reshumotList[$Rsh_id]->Rsh_status = $Rsh_status;
            $this->reshumotList[$Rsh_id]->Rsh_sochen = $Rsh_sochen;
            $this->reshumotList[$Rsh_id]->Rsh_takziv = $Rsh_takziv;
            $this->reshumotList[$Rsh_id]->Rsh_cname = $Rsh_cname;
            $this->reshumotList[$Rsh_id]->Rsh_cnametl = $Rsh_cnametl;
            $this->reshumotList[$Rsh_id]->Rsh_cemail = $Rsh_cemail;
            return $this->reshumotList[$Rsh_id];
        }
        return null;
    }

    // Delete
    public function delete($Rsh_id) {
        if (isset($this->reshumotList[$Rsh_id])) {
            unset($this->reshumotList[$Rsh_id]);
            return true;
        }
        return false;
    }

    // List all
    public function listAll() {
        return $this->reshumotList;
    }
}
