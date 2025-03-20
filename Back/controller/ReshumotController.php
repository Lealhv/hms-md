<?php

class ReshumotController
{
    private $reshumotList = [];

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if all required keys exist
        if (!isset(
            $data['Rsh_id'],
            $data['Rsh_date'],
            $data['Rsh_mchlaka'],
            $data['Rsh_sapak'],
            $data['Rsh_schoom'],
            $data['Rsh_maam'],
            $data['Rsh_schmaam'],
            $data['Rsh_schtotal'],
            $data['Rsh_pratim'],
            $data['Rsh_proyktnam'],
            $data['Rsh_status'],
            $data['Rsh_sochen'],
            $data['Rsh_takziv'],
            $data['Rsh_cname'],
            $data['Rsh_cnametl'],
            $data['Rsh_cemail']
        )) {
            http_response_code(400); // Return 400 error code
            return json_encode(['error' => 'Missing required parameters']);
        }

        // Create the Reshumot object
        $reshumot = new Reshumot($data);
        $this->reshumotList[$data['Rsh_id']] = $reshumot;

        return json_encode($reshumot); // Return the result as JSON
    }

    // Read
    public function read($Rsh_id)
    {
        return isset($this->reshumotList[$Rsh_id]) ? $this->reshumotList[$Rsh_id] : null;
    }

    // Update
    public function update($Rsh_id, $Rsh_date, $Rsh_mchlaka, $Rsh_sapak, $Rsh_schoom, $Rsh_maam, $Rsh_schmaam, $Rsh_schtotal, $Rsh_pratim, $Rsh_proyktnam, $Rsh_status, $Rsh_sochen, $Rsh_takziv, $Rsh_cname, $Rsh_cnametl, $Rsh_cemail)
    {
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
    public function delete($Rsh_id)
    {
        if (isset($this->reshumotList[$Rsh_id])) {
            unset($this->reshumotList[$Rsh_id]);
            return true;
        }
        return false;
    }

    // List all
    public function listAll()
    {
        echo "List all Reshumot:";
        return $this->reshumotList;
    }
}
