<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor_model extends CI_Model {

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
        // Paso 1: Obtener los últimos IDs de orden de ayer y hoy con estado activo
        $this->db->select('id_orden');
        $this->db->from('ventas_cabeza');
        $this->db->where('fechaCreacion >=', date('Y-m-d 00:00:00', strtotime('-1 day'))); // Desde el inicio de ayer
        $this->db->where('fechaCreacion <=', date('Y-m-d 23:59:59')); // Hasta el final de hoy
        $this->db->where('estado', 1); // Solo ventas activas
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
            $this->db->where('v.estado', 1); // Solo ventas activas en la cabecera
            $this->db->where('dv.estado', 1); // Solo detalles activos
            $this->db->order_by('dv.fecha', 'DESC');
    
            $query = $this->db->get();
            return $query->result();
        } else {
            return []; // Retornar un array vacío si no hay órdenes
        }
    }
    //FIN CRUD USUARIOS

    public function get_ticket_by_order($order_id) {
        // Obtener la cabecera de la venta
        $this->db->select('vc.*, u.nombres, u.apellidos');
        $this->db->from('ventas_cabeza vc');
        $this->db->join('usuarios u', 'vc.id_mesero = u.id_usuario');
        $this->db->where('vc.id_orden', $order_id);
        $this->db->where('vc.estado', '1');
        $cabecera = $this->db->get()->row_array();
        
        if (!$cabecera) {
            return null;
        }
        
        // Obtener los detalles de la venta
        $this->db->select('*');
        $this->db->from('detalle_ventas');
        $this->db->where('id_orden', $order_id);
        $detalles = $this->db->get()->result_array();
        
        // Formatear los datos para el ticket
        $mesero_nombres = explode(' ', $cabecera['nombres']);
        $mesero_apellidos = explode(' ', $cabecera['apellidos']);
        
        return [
            'fecha_hora' => $cabecera['fechaCreacion'],
            'mesero' => $mesero_nombres[0] . ' ' . $mesero_apellidos[0],
            'id_orden' => $order_id,
            'cart' => array_map(function($item) {
                return [
                    'cantidad' => $item['cantidad'],
                    'nombre' => $item['nombre_producto'],
                    'valor' => $item['precio'],
                ];
            }, $detalles),
            'literal_total' => $this->numero_a_letras(array_sum(array_map(function($item) {
                return $item['cantidad'] * $item['precio'];
            }, $detalles)))
        ];
    }
    private function numero_a_letras($numero) {
        // Separar parte entera y decimal
        $partes = explode('.', number_format($numero, 2, '.', ''));
        $entero = $partes[0];
        $decimal = isset($partes[1]) ? $partes[1] : '00';
    
        // Convertir la parte entera a letras
        $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        $letras = ucfirst($formatter->format($entero));
    
        // Formatear el resultado
        return $letras . ' con ' . $decimal . '/100 Bolivianos';
    }
    public function eliminarOrdenYRestaurarStock($orden_id) {
        try {
            // Obtener el ID del usuario de la sesión
            $usuario_id = $this->session->userdata('id_usuario');
            
            if (!$usuario_id) {
                return ['success' => false, 'message' => 'No hay una sesión de usuario válida'];
            }
    
            // 1. Obtener los detalles de la venta antes de eliminar
            $detalles = $this->db->where('id_orden', $orden_id)
                                ->where('estado', 1)
                                ->get('detalle_ventas')
                                ->result_array();
    
            if (empty($detalles)) {
                return ['success' => false, 'message' => 'No se encontraron detalles de la orden'];
            }
    
            // 2. Restaurar el stock de cada producto
            foreach ($detalles as $detalle) {
                $this->db->set('stock', 'stock + ' . $detalle['cantidad'], false)
                         ->where('id_producto', $detalle['id_producto'])
                         ->update('productos');
            }
    
            // 3. Marcar los detalles como eliminados (estado = 0) y registrar quien lo eliminó
            $this->db->where('id_orden', $orden_id)
                     ->update('detalle_ventas', [
                         'estado' => 0,
                         'idUsuario' => $usuario_id,
                         'ultimaActualizacion' => date('Y-m-d H:i:s')
                     ]);
    
            // 4. Marcar la cabecera como eliminada (estado = 0) y registrar quien lo eliminó
            $this->db->where('id_orden', $orden_id)
                     ->update('ventas_cabeza', [
                         'estado' => 0,
                         'idUsuario' => $usuario_id,
                         'ultimaActualizacion' => date('Y-m-d H:i:s')
                     ]);
    
            return ['success' => true, 'message' => 'Orden eliminada y stock restaurado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al procesar la eliminación: ' . $e->getMessage()];
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

    public function obtenerReporteMeseros() {
        $this->db->select('u.id_usuario, 
                           CONCAT(u.nombres, " ", u.apellidos) as nombre_mesero,
                           COUNT(DISTINCT vc.id_orden) as total_ordenes,
                           SUM(dv.cantidad * dv.precio) as total_venta');
        $this->db->from('ventas_cabeza vc');
        $this->db->join('usuarios u', 'u.id_usuario = vc.id_mesero');
        $this->db->join('detalle_ventas dv', 'dv.id_orden = vc.id_orden');
        $this->db->where('vc.estado', 1);
        $this->db->group_by('u.id_usuario, u.nombres, u.apellidos');
        $this->db->order_by('u.nombres', 'ASC');
        
        return $this->db->get()->result_array();
    }
    public function obtenerOrdenesEliminadas() {
        $this->db->select('vc.id_orden, 
                           vc.fechaCreacion as fecha_eliminacion,
                           CONCAT(u.nombres, " ", u.apellidos) as nombre_usuario');
        $this->db->from('ventas_cabeza vc');
        $this->db->join('usuarios u', 'u.id_usuario = vc.idUsuario');
        $this->db->where('vc.estado', 0);
        $this->db->order_by('vc.fechaCreacion', 'DESC');
        
        return $this->db->get()->result_array();
    }

}
?>
