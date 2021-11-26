<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Usuarios extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('');
    }
}