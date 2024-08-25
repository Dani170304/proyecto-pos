<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user($email)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('email', $email);
        $this->db->where('estado', 1); // Asegurar que el usuario esté activo
        $query = $this->db->get();

        return $query->row(); // Devuelve la primera fila encontrada
    }

    public function insert_user($data)
    {
        $this->db->insert('usuarios', $data);
        $id_usuario = $this->db->insert_id();
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios', array('idUsuario_auditoria' => $id_usuario));
        return $id_usuario;
    }
    

    public function email_exists($email)
    {
        $this->db->select('id_usuario');
        $this->db->from('usuarios');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
    public function update_verification_status($email)
    {
        $this->db->set('sesion_verificada', 'si');
        $this->db->where('email', $email);
        return $this->db->update('usuarios');
    }
    
}
?>