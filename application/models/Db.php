<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db extends CI_Model
{
    public function getEspecialidades()
    {
        return $this->db->query("SELECT * from especialidades")->result_array();
    }

    public function createCita($data)
    {
        $this->db->set($data)->insert('citas');
        if ($this->db->affected_rows() === 1) {
            $id = $this->db->insert_id();
            return $id;
        }
        return null;
    }

    public function createHorario($data)
    {

        $this->db->set($data)->insert('horarios');
        if ($this->db->affected_rows() === 1) {
            $id = $this->db->insert_id();
            return $id;
        }
        return null;
    }

    public function getHorarios($medico_id)
    {
        return $this->db->query("SELECT * from horarios where id_medico = $medico_id")->result_array();
    }

    public function getCitasPorMedico($medico_id)
    {
        return $this->db->query("SELECT 
        c.id_cita,c.status,c.hora,h.fecha, p.nombre_completo paciente 
        from citas c 
        natural join horarios h
        natural join pacientes p
        where id_medico = $medico_id")->result_array();
    }

    public function getCitasPorPaciente($id_paciente)
    {
        return $this->db->query("SELECT 
        c.id_cita,c.status,c.hora,h.fecha, m.nombre_completo medico, e.nombre especialidad
        from citas c 
        natural join horarios h
        natural join medicos m
        natural join especialidades e
        where id_paciente = $id_paciente")->result_array();
    }

    public function cancelarCita($id_cita)
    {
        $this->db->set(array("status" => "Cancelado"))->where('id_cita', $id_cita)->update('citas');
        return $this->db->affected_rows() === 1;

    }
}
