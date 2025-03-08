
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productos_model extends CI_Model
{ //INICIO CRUD PRODUCTOS

    public function listaproductos()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('estado', '1');
        return $this->db->get(); // devuelve resultados
    }
    public function recuperarproducto($id_producto)
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('id_producto', $id_producto);
        return $this->db->get();
    }
    public function get_user_by_id($user_id)
    {
        $this->db->where('id_usuario', $user_id);
        $query = $this->db->get('usuarios');
        return $query->row_array();
    }
    public function listaproductoseliminados()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('estado', '0');
        return $this->db->get(); // devuelve resultados
    }
    public function eliminarproducto($id_producto)
    {
        $this->db->where('id_producto', $id_producto);
        return $this->db->delete('productos'); // Esto debería devolver true o false
    }

    public function modificarproducto($id_producto, $data)
    {
        // Suponiendo que estás utilizando Active Record de CodeIgniter
        $this->db->where('id_producto', $id_producto);
        return $this->db->update('productos', $data); // Esto devuelve true o false
    }

    public function insertar_producto($data)
    {
        // Intentar insertar los datos en la tabla 'productos'
        return $this->db->insert('productos', $data);
    }
    public function verificar_producto_existente($nombre, $categoria, $id_producto = null,)
    {
        $this->db->where('nombre', $nombre);
        $this->db->where('categoria', $categoria);
        $this->db->where('estado', 1);

        // Si estamos en el caso de modificación, excluimos el producto actual de la búsqueda
        if ($id_producto !== null) {
            $this->db->where('id_producto !=', $id_producto);
        }

        $query = $this->db->get('productos');

        if ($query->num_rows() > 0) {
            return true; // El producto ya existe
        } else {
            return false; // El producto no existe
        }
    }
}
?>