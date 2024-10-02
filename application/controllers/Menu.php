<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/La_Paz');
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

    public function ticket_orden() {
        $cart = json_decode($this->input->post('cart'), true);
        $id_usuario = $this->session->userdata('id_usuario');
        $id_mesero = $this->session->userdata('id_usuario');
    
        // Inicializar variables
        $nuevo_id_orden = null;
        $fecha_hora_orden = null;
    
        // Verificar si ya existe un ID de orden en la sesión
        if ($this->session->userdata('id_orden')) {
            $nuevo_id_orden = $this->session->userdata('id_orden');
            $fecha_hora_orden = $this->session->userdata('fecha_hora_orden'); // Obtener la fecha y hora
        } else {
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
    
            // Guardar el ID de la orden y la fecha/hora en la sesión
            $this->session->set_userdata('id_orden', $nuevo_id_orden);
            $this->session->set_userdata('fecha_hora_orden', date('Y-m-d H:i:s')); // Almacenar la fecha y hora
    
            // Insertar en detalle_ventas y actualizar stock en productos
            foreach ($cart as $item) {
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
    
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Error al confirmar la orden.');
                redirect('menu');
            }
    
            // Ahora se puede establecer la fecha y hora ya que la orden fue creada
            $fecha_hora_orden = $this->session->userdata('fecha_hora_orden'); // Obtener la fecha y hora después de insertar
        }
    
        // Calcular el total considerando las cantidades
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['valor'] * $item['cantidad']; // Multiplicar precio por cantidad
        }
    
        // Convertir el total a literal
        $literal_total = $this->convertir_numero_a_literal($total); // Usar la función que creaste
    
        // Cargar vista de recibo después de confirmar la orden
        $data['cart'] = $cart;
        $data['total'] = $total; // Asignar el total calculado
        $data['literal_total'] = $literal_total; // Pasar el total en literal a la vista
        $data['mesero'] = $this->session->userdata('nombres');
        $data['id_orden'] = $nuevo_id_orden;
        $data['fecha_hora'] = $fecha_hora_orden; // Pasar la fecha y hora a la vista
        $this->load->view('recibo_view', $data);
    }
    
    
    public function nueva_orden() {
        // Limpiar el id_orden de la sesión
        $this->session->unset_userdata('id_orden');
        
        // Redirigir al menú para iniciar una nueva orden
        redirect('menu');
    }
    public function convertir_numero_a_literal($numero) {
        $formateador = new NumberFormatter('es_BO', NumberFormatter::SPELLOUT);
        return ucfirst($formateador->format($numero)) . ' 00/100 BOLIVIANOS';
    }
    
    
}

