<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Citas extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('Db');
    }

    public function index_post()
    {
        $data = array(
            'hora' => $this->post('hora'),
            'id_horario' => $this->post('id_horario'),
            'id_medico' => $this->post('id_medico'),
            'id_paciente' => $this->post('id_paciente')
        );
        $item_id = $this->Db->createCita($data);

        if (!$item_id) {
            $this->response(array('status' => 'failure', 'message' => 'error al crear el item'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $this->response(array('status' => 'success', 'data' => $item_id, 'message' => 'Item creado'), REST_Controller::HTTP_CREATED);
        }
    }

    public function medico_get($id_medico)
    {
        $this->response($this->Db->getCitasPorMedico($id_medico), REST_Controller::HTTP_OK);
    }

    public function paciente_get($id_paciente)
    {
        $this->response($this->Db->getCitasPorPaciente($id_paciente), REST_Controller::HTTP_OK);
    }

    public function cancelar_delete($id_cita)
    {
        $response = $this->Db->cancelarCita($id_cita);
        if (!$response) {
            $this->response(array('status' => 'failure', 'message' => 'Error al cancelar la cita'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $this->response(array('status' => 'success', 'message' => 'Cita cancelada'), REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
    }
}
