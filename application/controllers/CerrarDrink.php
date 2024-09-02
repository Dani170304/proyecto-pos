<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CerrarDrink extends CI_Controller
{

    public function index()
    {
        // Cerrar la sesión del usuario
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();

        // Redirigir a la página de login
        redirect('inicio');
    }
    
}
?>