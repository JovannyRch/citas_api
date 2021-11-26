<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Especialidades extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('Db');
    }

    public function index_get(){
        $this->response($this->Db->getEspecialidades(), REST_Controller::HTTP_OK);
    }


}