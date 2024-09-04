<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    //INICIO CRUD USUARIOS
    public function listausuarios()
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('estado','1');
        return $this->db->get(); // devuelve resultados
    }
    public function listausuarioseliminados()
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('estado','0');
        return $this->db->get(); // devuelve resultados
    }

    public function agregarUsuario($data)
    {
        // Intenta insertar los datos en la base de datos
        $insert = $this->db->insert('usuarios', $data);
        return $insert; // Retorna true si la inserción fue exitosa, de lo contrario false
    }

    public function verificarEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }
    public function eliminarusuario($id_usuario)
    {
        $this->db->where('id_usuario', $id_usuario);
        $this->db->delete('usuarios');
    }
    public function recuperarusuario($id_usuario)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->get();
    }
    public function modificarusuario($id_usuario, $data)
    {
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios', $data);
    }
    public function get_user_by_id($user_id) {
        $this->db->where('id_usuario', $user_id);
        $query = $this->db->get('usuarios'); 
        return $query->row_array();
    }

    // Get total ganancias
    public function get_ganancias() {
        $this->db->select_sum('precio');
        $query = $this->db->get('detalle_ventas');
        $result = $query->row();
        return $result->precio ? $result->precio : 0;
    }

    // Get total ventas
    public function get_ventas() {
        $this->db->select('COUNT(id_orden) as total_ventas');
        $query = $this->db->get('ventas_cabeza');
        $result = $query->row();
        return $result->total_ventas ? $result->total_ventas : 0;
    }

    // Get total clientes
    public function get_clientes() {
        $this->db->where('rol', 'usuario');
        $this->db->where('sesion_verificada', 'si');
        $this->db->from('usuarios');
        return $this->db->count_all_results();
    }
    public function obtener_ultimas_ventas() {
        $this->db->select('v.id_orden, p.nombre AS producto, dv.cantidad, dv.precio, (dv.cantidad * dv.precio) AS total, u.nombres AS usuario');
        $this->db->from('detalle_ventas dv');
        $this->db->join('productos p', 'dv.id_producto = p.id_producto');
        $this->db->join('ventas_cabeza v', 'dv.id_orden = v.id_orden');
        $this->db->join('usuarios u', 'v.id_mesero = u.id_usuario');
        $this->db->order_by('dv.fecha', 'DESC');
        $this->db->limit(5); // Limita a las últimas 5 ventas
        $query = $this->db->get();
        return $query->result(); // Make sure this returns an array of objects
    }
    //FIN CRUD USUARIOS

    //INICIO CRUD PRODUCTOS
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
