<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Usuarios extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('Model_usuarios');
    }


    public function index_post()
    {
        $data = array(
            'email' => $this->post('email'),
            'password' => $this->post('password'),
            'rol' => $this->post('rol'),
        );

        $rol = $this->post('rol');

        $rol_data = array();

        if ($rol == 0) { //Paciente
            $rol_data = array(
                "nombre_completo" => $this->post('nombre'),
                "telefono" => $this->post('telefono')
            );
        } else if ($rol == 1) { //Médico
            $rol_data = array(
                "nombre_completo" => $this->post('nombre'),
                "cedula_profesional" => $this->post('cedula'),
                "id_especialidad" => $this->post('id_especialidad'),
            );
        } else {
            return $this->response(array('status' => 'failure', 'message' => "Campos incompletos", REST_Controller::HTTP_BAD_REQUEST));
        }


        $user_id = $this->Model_usuarios->create($data, $rol, $rol_data);

        if (!$user_id) {
            $this->response(array('status' => 'failure', 'message' => 'error al crear el usuario'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $this->response(array('status' => 'success', 'data' => $user_id, 'message' => 'Usuario creado'), REST_Controller::HTTP_CREATED);
        }
    }

    public function login_post()
    {

        $registro = $this->Model_usuarios->login($this->post('email'), $this->post('password'));

        if ($registro) {
            $this->response($registro, REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'status' => false,
                'data' => $registro,
                'message' => 'The Specified user could not be found'
            ), REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function doctor_get($user_id)
    {
        $doctor = $this->Model_usuarios->getDoctor($user_id);

        if ($doctor) {
            $this->response($doctor, REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'status' => false,
                'data' => $doctor,
                'message' => 'The Specified user could not be found'
            ), REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
