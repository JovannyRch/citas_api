<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_usuarios extends MY_Model
{

    protected $_table = 'usuarios';
    protected $primary_key = 'id_usuario';
    protected $return_type = 'array';


    public function create($data, $rol, $rol_data)
    {
        $this->db->set($data)->insert('usuarios');
        if ($this->db->affected_rows() === 1) {
            $id_usuario = $this->db->insert_id();

            $rol_data["id_usuario"] = $id_usuario;

            if ($rol == 0) {
                $this->db->set($rol_data)->insert('pacientes');
            } else {
                $this->db->set($rol_data)->insert('medicos');
            }

            return $id_usuario;
        }
        return null;
    }

    public function login($correo, $password)
    {
        $queryRes = $this->db->query("SELECT * FROM usuarios WHERE email = '$correo' and password = '$password'");
        if ($queryRes->num_rows() > 0) {
            $usuario = $queryRes->row_array();
            unset($usuario['password']);
            return $usuario;
        }
        return null;
    }

    public function getDoctor($id_usuario)
    {
        return $this->db->query("SELECT m.*,  e.nombre especialidad from medicos m natural join especialidades e where id_usuario = $id_usuario")->row_array();
    }

    public function getPaciente($id_usuario)
    {
        return $this->db->query("SELECT * from pacientes where id_usuario = $id_usuario")->row_array();
    }

}
