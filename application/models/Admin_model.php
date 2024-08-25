<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
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
}
?>
