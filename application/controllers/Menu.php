<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->helper('url');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('rol') !== 'usuario') {
            redirect('login');
        }
    }

    public function index() {
        $data['nombres'] = $this->session->userdata('nombres');
        $data['id_usuario'] = $this->session->userdata('id_usuario');
        $data['products'] = $this->Menu_model->get_all_products(); // Obtener productos desde el modelo
        $this->load->view('menu_view', $data); // Pasar datos a la vista
    }
    
}
