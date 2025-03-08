<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Método antiguo (mantener para compatibilidad)
    public function get_user($email)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('email', $email);
        $this->db->where('estado', 1); // Asegurar que el usuario esté activo
        $query = $this->db->get();
        
        return $query->row(); // Devuelve la primera fila encontrada
    }
    
    // Nuevo método para obtener usuario por login
    public function get_user_by_login($login)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('login', $login);
        $this->db->where('estado', 1); // Asegurar que el usuario esté activo
        $query = $this->db->get();
        
        return $query->row();
    }
    
    // Método para buscar usuario por login o email
    public function get_user_by_login_or_email($login_or_email)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->group_start()
                 ->where('login', $login_or_email)
                 ->or_where('email', $login_or_email)
                 ->group_end();
        $this->db->where('estado', 1);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    // Verificar si existe un login
    public function login_exists($login)
    {
        $this->db->where('login', $login);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
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
    
    // Actualizar usando ID en lugar de email
    public function update_verification_status($id_usuario)
    {
        $this->db->set('sesion_verificada', 'si');
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuarios');
    }
    
    public function email_exists2($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        
        // Devuelve true si existe al menos un resultado
        return $query->num_rows() > 0;
    }
    
    public function is_account_verified($email) {
        $this->db->select('sesion_verificada');
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        
        // Devuelve true si el usuario está verificado
        return $query->num_rows() > 0 && $query->row()->sesion_verificada === 'si';
    }
    
    // Actualizado para usar ID en lugar de email
    public function store_reset_token($id_usuario, $token)
    {
        $data = array(
            'reset_token' => $token,
            'token_expiration' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuarios', $data);
    }
    
    public function update_password($token, $new_password)
    {
        // Verificar el token
        $this->db->where('reset_token', $token);
        return $this->db->update('usuarios', array('password' => $new_password, 'reset_token' => null));
    }
    
    public function is_token_valid($token) {
        $this->db->where('reset_token', $token);
        $this->db->where('token_expiration >=', date('Y-m-d H:i:s'));
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }
}
?>