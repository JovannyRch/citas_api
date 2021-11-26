<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db extends CI_Model
{
    public function getEspecialidades()
    {
        return $this->db->query("SELECT * from especialidades")->result_array();
    }
}
