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

    public function confirmar_orden() {
        // Obtener los datos enviados por POST
        $cart = json_decode($this->input->post('cart'), true);
        $id_usuario = $this->session->userdata('id_usuario');
        $id_mesero = $this->session->userdata('id_usuario'); // Asegúrate de que este dato esté en la sesión

        // Iniciar transacción
        $this->db->trans_start();

        // Obtener el próximo id_orden
        $this->db->select_max('id_orden');
        $query = $this->db->get('ventas_cabeza');
        $result = $query->row();
        $nuevo_id_orden = $result->id_orden ? $result->id_orden + 1 : 1;

        // Insertar en ventas_cabeza
        $data_cabeza = array(
            'id_orden' => $nuevo_id_orden,
            'id_mesero' => $id_mesero,
            'idUsuario' => $id_usuario
        );
        $this->db->insert('ventas_cabeza', $data_cabeza);

        // Insertar en detalle_ventas y actualizar stock en productos
        foreach ($cart as $item) {
            // Insertar detalle de venta
            $data_detalle = array(
                'id_orden' => $nuevo_id_orden,
                'id_producto' => $item['id'],
                'cantidad' => $item['cantidad'],
                'nombre_producto' => $item['nombre'],
                'precio' => $item['valor'],
                'idUsuario' => $id_usuario
            );
            $this->db->insert('detalle_ventas', $data_detalle);

            // Actualizar el stock del producto
            $this->db->set('stock', 'stock - ' . $item['cantidad'], FALSE);
            $this->db->where('id_producto', $item['id']);
            $this->db->update('productos');
        }

        // Completar la transacción
        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === FALSE) {
            // Manejar el error
            $this->session->set_flashdata('error', 'Error al confirmar la orden.');
            redirect('menu'); // Redirigir a la vista de menú
        } else {
            // Exito
            $this->session->set_flashdata('success', 'Orden confirmada con éxito.');
            redirect('menu'); // Redirigir a la vista de menú
        }
    }
}

