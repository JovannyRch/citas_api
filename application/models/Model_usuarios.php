<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_usuarios extends MY_Model
{

    protected $_table = 'usuarios';
    protected $primary_key = 'id_usuario';
    protected $return_type = 'array';

    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Db');
    }


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
                $id_medico = $this->db->insert_id();
                $this->crearHorariosMedico($id_medico);
            }

            return $id_usuario;
        }
        return null;
    }


    public function crearHorariosMedico($id_medico){
        $data = array(
            'id_medico' => $id_medico,
            'fecha' => '2021-11-29',
            'hora_ingreso' => '9:00:00',
            'hora_salida' => '18:00:00'
        );

        $this->Db->createHorario($data);
        $data = array(
            'id_medico' => $id_medico,
            'fecha' => '2021-11-30',
            'hora_ingreso' => '9:00:00',
            'hora_salida' => '18:00:00'
        );

        $this->Db->createHorario($data);

        $data = array(
            'id_medico' => $id_medico,
            'fecha' => '2021-12-01',
            'hora_ingreso' => '9:00:00',
            'hora_salida' => '18:00:00'
        );

        $this->Db->createHorario($data);

        $data = array(
            'id_medico' => $id_medico,
            'fecha' => '2021-12-02',
            'hora_ingreso' => '9:00:00',
            'hora_salida' => '18:00:00'
        );

        $this->Db->createHorario($data);

        $data = array(
            'id_medico' => $id_medico,
            'fecha' => '2021-12-03',
            'hora_ingreso' => '9:00:00',
            'hora_salida' => '18:00:00'
        );

        $this->Db->createHorario($data);
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
