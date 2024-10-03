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
    
        // Devolver true si se eliminó al menos una fila
        return $this->db->affected_rows() > 0;
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
        return $this->db->update('usuarios', $data); // Retorna true o false si fue exitoso
    }
    

    public function get_user_by_id($user_id) {
        $this->db->where('id_usuario', $user_id);
        $query = $this->db->get('usuarios'); 
        return $query->row_array();
    }
    public function get_total_ganancias() {
        $this->db->select('SUM(dv.precio * dv.cantidad) AS total_ganancias');
        $this->db->from('detalle_ventas dv');
        $this->db->join('ventas_cabeza vc', 'dv.id_orden = vc.id_orden');
        $this->db->where('DATE(vc.fechaCreacion) IN (CURDATE(), CURDATE() - INTERVAL 1 DAY)');
        $this->db->where('vc.estado', 1);
        
        $query = $this->db->get();
        $result = $query->row();

        return $result->total_ganancias ? $result->total_ganancias : 0; // Retorna 0 si no hay ganancias
    }
    

    // Get total ventas
    public function get_ventas() {
        $this->db->select('COUNT(id_orden) as total_ventas');
        $this->db->from('ventas_cabeza');
        $this->db->where('DATE(fechaCreacion) IN (CURDATE(), CURDATE() - INTERVAL 1 DAY)');
        $this->db->where('estado', 1); // Asegúrate de contar solo las ventas activas o válidas
        $query = $this->db->get();
        $result = $query->row();
        return $result->total_ventas ? $result->total_ventas : 0;
    }

    // Get total clientes
    public function get_clientes() {
        $this->db->where('rol', 'usuario');
        $this->db->where('sesion_verificada', 'si');
        $this->db->where('estado', '1');
        $this->db->from('usuarios');
        return $this->db->count_all_results();
    }
    public function obtener_ultimas_ventas() {
        // Paso 1: Obtener los últimos IDs de orden de ayer y hoy
        $this->db->select('id_orden');
        $this->db->from('ventas_cabeza');
        $this->db->where('fechaCreacion >=', date('Y-m-d 00:00:00', strtotime('-1 day'))); // Desde el inicio de ayer
        $this->db->where('fechaCreacion <=', date('Y-m-d 23:59:59')); // Hasta el final de hoy
        $this->db->order_by('fechaCreacion', 'DESC'); // Ordenar por fecha de creación
        $this->db->limit(5); // Limitar a las últimas 5 órdenes
        $subquery = $this->db->get();
    
        // Extraer los IDs de orden de la subconsulta
        $orden_ids = [];
        foreach ($subquery->result() as $row) {
            $orden_ids[] = $row->id_orden;
        }
    
        // Paso 2: Usar los IDs de orden para obtener los detalles de venta
        if (!empty($orden_ids)) {
            $this->db->select('v.id_orden, p.nombre AS producto, dv.cantidad, dv.precio, (dv.cantidad * dv.precio) AS total, u.nombres AS usuario');
            $this->db->from('detalle_ventas dv');
            $this->db->join('productos p', 'dv.id_producto = p.id_producto');
            $this->db->join('ventas_cabeza v', 'dv.id_orden = v.id_orden');
            $this->db->join('usuarios u', 'v.id_mesero = u.id_usuario');
            $this->db->where_in('v.id_orden', $orden_ids); // Filtrar solo las órdenes obtenidas
            $this->db->order_by('dv.fecha', 'DESC'); // Suponiendo que 'fecha' es una columna de 'detalle_ventas'
    
            $query = $this->db->get();
            return $query->result(); // Asegúrate de que esto devuelva un array de objetos
        } else {
            return []; // Retornar un array vacío si no hay órdenes
        }
    }
    
    
    public function obtenerVentasDelDia()
    {
        $fecha_hoy = date('Y-m-d'); // Obtiene la fecha actual
        $fecha_ayer = date('Y-m-d', strtotime('-1 day')); // Obtiene la fecha de ayer
    
        // Selecciona las ventas de ayer y hoy
        $this->db->select('vc.fechaCreacion, dc.id_orden, dc.nombre_producto, dc.cantidad, dc.precio');
        $this->db->from('ventas_cabeza vc');
        $this->db->join('detalle_ventas dc', 'vc.id_orden = dc.id_orden');
        $this->db->where('DATE(vc.fechaCreacion) >=', $fecha_ayer);
        $this->db->where('DATE(vc.fechaCreacion) <=', $fecha_hoy);
        
        $query = $this->db->get();
        return $query->result_array(); // Devuelve un array con los resultados
    }
    public function get_ventas_por_fecha($fecha_desde, $fecha_hasta)
    {
        $this->db->select('*');
        $this->db->from('ventas'); // Cambia 'ventas' al nombre correcto de tu tabla
        $this->db->where('fechaCreacion >=', $fecha_desde);
        $this->db->where('fechaCreacion <=', $fecha_hasta);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function obtener_ventas_por_fecha($fecha_desde, $fecha_hasta)
    {
        $this->db->select('*');
        $this->db->from('detalle_ventas');
    
        // Verifica si $fecha_desde no es nulo o vacío
        if (!empty($fecha_desde)) {
            $this->db->where('fechaCreacion >=', $fecha_desde);
        }
    
        // Verifica si $fecha_hasta no es nulo o vacío
        if (!empty($fecha_hasta)) {
            $this->db->where('fechaCreacion <=', $fecha_hasta);
        }
    
        $query = $this->db->get();
        return $query->result_array(); // O 'result()' según lo que necesites
    }
    
    
    
    //FIN CRUD USUARIOS

    
}
?>
