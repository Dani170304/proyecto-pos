<?php
class Menu_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_all_products() {
        // Añadir la condición donde el estado sea igual a 1
        $this->db->where('estado', 1);  
        
        // Ejecutar la consulta
        $query = $this->db->get('productos');
        
        return $query->result_array();
    }
    
    
}
