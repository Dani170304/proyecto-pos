<?php
class Menu_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_all_products() {
        $query = $this->db->get('productos');
        return $query->result_array();
    }
    
}
