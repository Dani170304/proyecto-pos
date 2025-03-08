<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();  // Carga la base de datos
    }

    public function get_eventos()
    {
        // Obtiene solo las fechas sin hora
        $hoy = date('Y-m-d');
        $ayer = date('Y-m-d', strtotime('-1 day'));

        // Realiza la consulta
        $this->db->select('*');
        $this->db->from('eventos');
        $this->db->where("DATE(fecha_inicio) >=", $ayer); // Convierte fecha_inicio a solo fecha
        $this->db->where("DATE(fecha_inicio) <=", $hoy);  // Convierte fecha_inicio a solo fecha
        $query = $this->db->get();

        return $query->result_array();
    }
}
