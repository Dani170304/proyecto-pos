<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventos_model extends CI_Model {

    //INICIO CRUD USUARIOS
    public function listaeventos()
    {
        $this->db->select('*');
        $this->db->from('eventos');
        $this->db->where('estado','1');
        return $this->db->get(); // devuelve resultados
    }
    public function recuperarevento($id_evento)
    {
        $this->db->select('*');
        $this->db->from('eventos');
        $this->db->where('id_evento', $id_evento);
        return $this->db->get();
    }
    public function get_user_by_id($user_id) {
        $this->db->where('id_usuario', $user_id);
        $query = $this->db->get('usuarios'); 
        return $query->row_array();
    }
    public function insertar_evento($data) {
        // Intentar insertar los datos en la tabla 'productos'
        return $this->db->insert('eventos', $data);
    }
    public function modificarevento($id_evento, $data)
    {
        // Suponiendo que estás utilizando Active Record de CodeIgniter
        $this->db->where('id_evento', $id_evento);
        return $this->db->update('eventos', $data); // Esto devuelve true o false
    }
    public function eliminarevento($id_evento)
    {
        $this->db->where('id_evento', $id_evento);
        return $this->db->delete('eventos'); // Esto debería devolver true o false
    }
    public function listaeventoseliminados()
    {
        $this->db->select('*');
        $this->db->from('eventos');
        $this->db->where('estado','0');
        return $this->db->get(); // devuelve resultados
    }
}
?>
