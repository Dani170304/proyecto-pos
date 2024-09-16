
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {//INICIO CRUD PRODUCTOS

    public function listaproductos()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('estado','1');
        return $this->db->get(); // devuelve resultados
    }
    public function recuperarproducto($id_producto)
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('id_producto', $id_producto);
        return $this->db->get();
    }
    public function get_user_by_id($user_id) {
        $this->db->where('id_usuario', $user_id);
        $query = $this->db->get('usuarios'); 
        return $query->row_array();
    }
    public function listaproductoseliminados()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('estado','0');
        return $this->db->get(); // devuelve resultados
    }
    public function eliminarproducto($id_producto)
    {
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('productos');
    }
    public function modificarproducto($id_producto, $data)
    {
        $this->db->where('id_producto', $id_producto);
        $this->db->update('productos', $data);
    }
}
?>