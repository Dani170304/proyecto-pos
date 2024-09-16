// application/controllers/ContactController.php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Contact_model'); // Cargar el modelo
        $this->load->library('form_validation'); // Cargar la librería de validación
    }

    public function index() {
        $this->load->view('ini'); // Cargar la vista del formulario
    }

    public function submit() {
        // Configurar las reglas de validación
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required|min_length[4]');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('contact_form'); // Volver a cargar el formulario si la validación falla
        } else {
            // Aquí puedes procesar los datos del formulario, como enviarlos por correo
            $this->load->library('email');
            $this->email->from($this->input->post('email'), $this->input->post('name'));
            $this->email->to('example@example.com'); // Cambia a la dirección a la que quieres enviar el correo
            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('message'));

            if ($this->email->send()) {
                $data['message'] = 'Your message has been sent. Thank you!';
            } else {
                $data['message'] = 'There was a problem sending your message. Please try again.';
            }
            
            $this->load->view('contact_form', $data);
        }
    }
}
