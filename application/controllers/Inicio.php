<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // date_default_timezone_set('America/La_Paz'); // Zona horaria de Bolivia (UTC-4)
        $this->load->database();
        $this->load->model('Inicio_model');
    }
    public function index()
    {
        $data['eventos'] = $this->Inicio_model->get_eventos();  // Recupera los eventos
        $this->load->view('inicio_view', $data);  // Pasa los datos a la vista
    }
}

?>
