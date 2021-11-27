<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Horarios extends REST_Controller
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
            'id_medico' => $this->post("id_medico"),
            'fecha' => $this->post("fecha"),
            'hora_ingreso' => $this->post("hora_ingreso"),
            'hora_salida' => $this->post("hora_salida")
        );

        $item_id = $this->Db->createHorario($data);

        if (!$item_id) {
            $this->response(array('status' => 'failure', 'message' => 'error al crear el item'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $this->response(array('status' => 'success', 'data' => $item_id, 'message' => 'Item creado'), REST_Controller::HTTP_CREATED);
        }

    }

    public function index_get()
    {
        $id_medico = null;

        if($this->get('id_medico') != null){
            $id_medico = $this->get('id_medico');
        }

        $this->response($this->Db->getHorarios($id_medico), REST_Controller::HTTP_OK);
    }
}
