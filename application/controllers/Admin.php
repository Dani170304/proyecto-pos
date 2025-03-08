<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Admin extends CI_Controller
{

    // usuarios
    public function dash()
    {
        $data_g['ganancias'] = $this->Admin_model->get_total_ganancias();
        $data_g['Nroventas'] = $this->Admin_model->get_ventas();
        $data_g['clientes'] = $this->Admin_model->get_clientes();
        $data_g['ventas'] = $this->Admin_model->obtener_ultimas_ventas();
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $data['user'] = $user_data;
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data);
        $this->load->view('inc/dash',$data_g); // Suponiendo que esta es la vista
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    
    // INICIO CRUD USUARIOS
    public function index()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $data_u['user'] = $user_data;

        $lista = $this->Admin_model->listausuarios();
        $data['usuarios'] = $lista;

        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_panel_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    public function eliminados()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $dataU['user'] = $user_data;

        $lista = $this->Admin_model->listausuarioseliminados();
        $data['usuarios'] = $lista;
        

        $this->load->view('inc/head');
        $this->load->view('inc/menu',$dataU);
        $this->load->view('eliminados', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    public function agregar()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $data['user'] = $user_data;
        $this->load->view('inc/head');
        $this->load->view('inc/menu',$data);
        $this->load->view('form_agregar');
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    public function eliminardb()
    {
        $id_usuario = $this->input->post('id_usuario'); // Usar $this->input->post para seguridad
        $success = $this->Admin_model->eliminarusuario($id_usuario); // Captura el resultado
    
        // Devolver una respuesta JSON
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario.']);
        }
    }
    
    
    public function agregarbd()
{
    // Cargar el modelo de Usuario
    $this->load->model('Admin_model');
    
    // Recoger datos del formulario
    $nombre = $this->input->post('nombres');
    $apellido = $this->input->post('apellidos');
    $password = $this->input->post('password');
    $rol = $this->input->post('rol');
    
    // Convertir el nombre a mayúsculas
    $nombre = strtoupper($nombre);
    $apellido = strtoupper($apellido);
    
    // Generar el login: SOLO con el PRIMER nombre (en minúsculas)
    // Obtener solo el primer nombre
    $nombres_array = explode(' ', $nombre);
    $primer_nombre = $nombres_array[0];
    
    // Generar el login solo con el primer nombre
    $login = strtolower($primer_nombre);
    
    // Verificar si existe el mismo login y añadir un número si es necesario
    $login_base = $login;
    $counter = 1;
    while ($this->Admin_model->verificarLogin($login)) {
        $login = $login_base . $counter;
        $counter++;
    }
    
    // Resto del código permanece igual
    // Procesar el email según el rol
    $email = null;
    if ($rol != 'usuario') {
        $email = $this->input->post('email');
        if (empty($email)) {
            echo json_encode(['status' => 'error', 'message' => 'El correo electrónico es obligatorio para administradores y supervisores.']);
            return;
        }
        
        // Convertir el email a minúsculas
        $email = strtolower($email);
        
        // Verificar si el email ya existe
        if ($this->Admin_model->verificarEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado.']);
            return;
        }
    }
    
    // Generar un código de verificación de 4 dígitos (solo para usuarios con email)
    $codigo_verificacion = ($email) ? rand(1000, 9999) : null;

    $id_usuario_auditoria = $this->session->userdata('id_usuario');
    
    // Preparar los datos para la inserción
    $data = array(
        'nombres' => $nombre,
        'apellidos' => $apellido,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'rol' => $rol,
        'codigo_verificacion' => $codigo_verificacion,
        'idUsuario_auditoria' => $this->session->userdata('id_usuario'),
        'login' => $login
    );
    
    // Insertar el usuario utilizando el modelo
    $insert = $this->Admin_model->agregarUsuario($data);
    
    if ($insert) {
        // Enviar correo de verificación si tiene email
        if ($email) {
            $this->send_verification_email($email, $codigo_verificacion, $nombre);
            $message = 'Cuenta creada exitosamente. Se ha enviado un correo de verificación.';
        } else {
            $message = 'Cuenta creada exitosamente. Login generado: ' . $login;
        }
        
        // Enviar respuesta JSON
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
        // Obtener el mensaje de error
        $error = $this->db->error(); // Obtiene detalles del error
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar usuario. Detalles: ' . $error['message']]);
    }
}

    
    
    
    private function send_verification_email($email, $codigo_verificacion, $nombre_usuario)
    {
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'drink.master.2004@gmail.com';
            $mail->Password = 'lhwkmuzraevheiem';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            $mail->setFrom('drink.master.2004@gmail.com', 'DRINKMASTER');
            $mail->addAddress($email); // Receptor del correo
    
            $mail->isHTML(true);
            $mail->Subject = mb_encode_mimeheader('Verificación de tu cuenta', 'UTF-8', 'B');
    
            // Modifica el cuerpo del correo para incluir el nombre del usuario
            $mail->Body = "Hola, $nombre_usuario gracias por unirte a nuestro equipo, y ahora brindemos por los buenos tiempos,<br/><br/>Tu código de verificación es: <b>$codigo_verificacion</b><br/><br/>Saludos y un abrazo del equipo de DRINKMASTER,<br/>";
    
            $mail->send();
        } catch (Exception $e) {
            // Manejo de errores si ocurre
            echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function deshabilitardb()
    {
        $id_usuario = $this->input->post('id_usuario'); // Usar $this->input->post para seguridad
        $data['estado'] = '0';
    
        $success = $this->Admin_model->modificarusuario($id_usuario, $data); // Cambiar para capturar el resultado
    
        // Devolver una respuesta JSON
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Usuario deshabilitado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al deshabilitar el usuario.']);
        }
    }
    
    

    public function habilitarbd()
    {
        $id_usuario = $this->input->post('id_usuario'); // Usar el método de entrada de CodeIgniter
        $data['estado'] = '1';
    
        // Modificar el usuario y almacenar el resultado
        $success = $this->Admin_model->modificarusuario($id_usuario, $data);
    
        // Devolver una respuesta JSON
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Usuario habilitado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al habilitar el usuario.']);
        }
    }
    

    public function modificar()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $dataU['user'] = $user_data;



        $id_usuario = $_POST['id_usuario'];
        $data['infousuario'] = $this->Admin_model->recuperarusuario($id_usuario);
        $this->load->view('inc/head');
        $this->load->view('inc/menu',$dataU);
        $this->load->view('form_modificar', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    // Corrección para el método modificardb() en Admin.php
    public function modificardb()
    {
        $password = $this->input->post('password');
        $id_usuario = $this->input->post('id_usuario');
        $nombres = strtoupper($this->input->post('nombres'));
        $apellidos = strtoupper($this->input->post('apellidos'));
        $rol = $this->input->post('rol');
        
        // Obtener los datos actuales del usuario
        $usuario_actual = $this->Admin_model->recuperarusuario($id_usuario)->row();
        
        // Preparar los datos para la actualización
        $data = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'rol' => $rol
        );
        
        // Actualizar el email solo si el rol es administrador o supervisor
        if ($rol != 'usuario') {
            $email = $this->input->post('email');
            if (empty($email)) {
                echo json_encode(['status' => 'error', 'message' => 'El correo electrónico es obligatorio para administradores y supervisores.']);
                return;
            }
            $data['email'] = strtolower($email);
        } else {
            // Si el rol es usuario, establecer email como NULL
            $data['email'] = null;
        }
        
        // Actualizar el password si se proporciona uno nuevo
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Verificar si han cambiado los nombres o apellidos y actualizar el login si es necesario
        if ($nombres != $usuario_actual->nombres || $apellidos != $usuario_actual->apellidos) {
            // Generar un nuevo login solo con el PRIMER nombre
            $nombres_array = explode(' ', $nombres);
            $primer_nombre = $nombres_array[0];
            
            $login = strtolower($primer_nombre);
            
            // Verificar si ya existe (excepto el propio usuario)
            $login_base = $login;
            $counter = 1;
            while ($this->Admin_model->verificarLoginExceptoUsuario($login, $id_usuario)) {
                $login = $login_base . $counter;
                $counter++;
            }
            
            $data['login'] = $login;
        }
        
        // Actualizar el usuario en la base de datos
        $resultado = $this->Admin_model->modificarusuario($id_usuario, $data);
        
        if ($resultado) {
            $mensaje = 'Usuario modificado correctamente.';
            if (isset($data['login']) && $data['login'] != $usuario_actual->login) {
                $mensaje .= ' Nuevo login: ' . $data['login'];
            }
            echo json_encode(['status' => 'success', 'message' => $mensaje]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al modificar el usuario.']);
        }
    }
    public function reporteDia()
    {
        $user_id = $this->session->userdata('id_usuario'); 
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        $data_u['user'] = $user_data;
        
        // Obtener la lista de usuarios
        $lista = $this->Admin_model->listausuarios();
        $data['usuarios'] = $lista;
        
        // Obtener las ventas del día
        $ventasDelDia = $this->Admin_model->obtenerVentasDelDia();
        $data['ventas'] = $ventasDelDia; // Pasar los datos de ventas a la vista
    
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_reportedia_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    
    public function reporteMes()
    {
        $user_id = $this->session->userdata('id_usuario'); 
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        $data_u['user'] = $user_data;
        
        // Obtener la lista de usuarios
        $lista = $this->Admin_model->listausuarios();
        $data['usuarios'] = $lista;
        
        // Obtener las ventas del día
        $ventasDelDia = $this->Admin_model->obtenerVentasDelMes();
        $data['ventas'] = $ventasDelDia; // Pasar los datos de ventas a la vista
    
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_reportemes_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    
    public function reporteMesFiltrado() {
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
    
        if ($fecha_desde && $fecha_hasta) {
            $ventas = $this->Admin_model->obtenerVentasPorFecha($fecha_desde, $fecha_hasta);
    
            if (!empty($ventas)) {
                $current_order = null;
                $rowspan_count = 0;
                $total_venta = 0;
                $contador = 1; // Inicializa el contador fuera del bucle
    
                foreach ($ventas as $index => $venta) {
                    // Si el id_orden es diferente, reiniciar el conteo y calcular el total de la orden
                    if ($venta['id_orden'] !== $current_order) {
                        $current_order = $venta['id_orden'];
                        $rowspan_count = 0;
                        $total_venta = 0;
    
                        // Contar cuántas veces aparece el mismo id_orden y calcular el total
                        foreach ($ventas as $v) {
                            if ($v['id_orden'] === $venta['id_orden']) {
                                $rowspan_count++;
                                $total_venta += $v['cantidad'] * $v['precio'];
                            }
                        }
    
                        // Mostrar primera fila con rowspan
                        echo '<tr>';
                        echo '<td   class="color-num" rowspan="' . $rowspan_count . '">' . $contador . '</td>'; // Mostrar contador actual
    
                        echo '<td rowspan="' . $rowspan_count . '">' . date('d-m-Y', strtotime($venta['fechaCreacion'])) . '</td>';
                        echo '<td rowspan="' . $rowspan_count . '">' . $venta['id_orden'] . '</td>';
                        echo '<td>' . $venta['nombre_producto'] . '</td>';
                        echo '<td>' . $venta['cantidad'] . '</td>';
                        echo '<td>' . number_format($venta['precio'], 2) . '</td>';
                        echo '<td>' . number_format($venta['cantidad'] * $venta['precio'], 2) . '</td>';
                        echo '<td rowspan="' . $rowspan_count . '">Bs. ' . number_format($total_venta, 2) . '</td>';
                        echo '</tr>';
    
                        $contador++; // Incrementar el contador solo cuando se muestra una nueva orden
                    } else {
                        // Mostrar las filas restantes sin rowspan
                        echo '<tr>';
                        echo '<td>' . $venta['nombre_producto'] . '</td>';
                        echo '<td>' . $venta['cantidad'] . '</td>';
                        echo '<td>' . number_format($venta['precio'], 2) . '</td>';
                        echo '<td>' . number_format($venta['cantidad'] * $venta['precio'], 2) . '</td>';
                        echo '</tr>';
                    }
                }
            } else {
                echo '<tr><td colspan="7" style="text-align: center; font-weight: bold; font-size: 18px;">No hay ventas en el rango de fechas seleccionado.</td></tr>';
            }
    
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<table id="example3" class="table table-bordered table-striped table-neon">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>N° de Orden</th>
                        <th>Nombre Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="8">Fechas inválidas.</td></tr>
                </tbody>
            </table>';
        }
    }
    
    public function reporteProductoMasVendido() {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        // Pasar los datos de usuario
        $data_u['user'] = $user_data;
    
        // Por defecto, mostrar datos de los últimos 30 días
        $fecha_hasta = date('Y-m-d'); // Hoy
        $fecha_desde = date('Y-m-d', strtotime('-30 days')); // 30 días atrás
        
        // Obtener el producto más vendido con filtro de fecha por defecto
        $producto_mas_vendido = $this->Admin_model->obtenerProductosMasVendidosPorFecha($fecha_desde, $fecha_hasta);
        $data['producto_mas_vendido'] = $producto_mas_vendido;
        
        // También pasar las fechas para que se muestren en los campos de filtro
        $data['fecha_desde'] = $fecha_desde;
        $data['fecha_hasta'] = $fecha_hasta;
    
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_reporteproducto_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
        
    public function reporteMesero() {
        $user_id = $this->session->userdata('id_usuario'); 
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        $data_u['user'] = $user_data;
        
        // Obtener el reporte de meseros
        $reporteMeseros = $this->Admin_model->obtenerReporteMeseros();
        
        // Calcular el total general
        $total_general = 0;
        foreach($reporteMeseros as $mesero) {
            $total_general += $mesero['total_venta'];
        }
        
        $data['reporteMeseros'] = $reporteMeseros;
        $data['total_general'] = $total_general;
        
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_reportemesero_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    public function reporteTicketsEliminadosFiltrado() {
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
    
        if ($fecha_desde && $fecha_hasta) {
            $ordenes_eliminadas = $this->Admin_model->obtenerOrdenesEliminadasPorFecha($fecha_desde, $fecha_hasta);
    
            if (!empty($ordenes_eliminadas)) {
                $contador = 1;
                foreach ($ordenes_eliminadas as $orden) {
                    echo '<tr>';
                    echo '<td class="text-center">' . $contador++ . '</td>';
                    echo '<td class="text-center">' . $orden['id_orden'] . '</td>';
                    echo '<td class="text-center">' . date('d/m/Y H:i:s', strtotime($orden['fecha_eliminacion'])) . '</td>';
                    echo '<td>' . $orden['nombre_usuario'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4" class="text-center">No hay registros disponibles en el rango de fechas seleccionado.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="4" class="text-center">Por favor, selecciona ambas fechas para filtrar.</td></tr>';
        }
    }
    public function reporteProductoMasVendidoFiltrado() {
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
    
        if ($fecha_desde && $fecha_hasta) {
            $productos = $this->Admin_model->obtenerProductosMasVendidosPorFecha($fecha_desde, $fecha_hasta);
    
            if (!empty($productos)) {
                $contador = 1;
                foreach ($productos as $producto) {
                    echo '<tr>';
                    echo '<td class="color-num">' . $contador++ . '</td>';
                    echo '<td>' . $producto['nombre'] . '</td>';
                    echo '<td>' . $producto['categoria'] . '</td>';
                    echo '<td>' . $producto['total_vendido'] . '</td>';
                    echo '<td>' . number_format($producto['total_recaudado'], 2) . ' Bs</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5" class="text-center">No hay ventas registradas en el rango de fechas seleccionado.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="5" class="text-center">Por favor, selecciona ambas fechas para filtrar.</td></tr>';
        }
    }
    
    public function reporteTicketsEliminados()
    {
        $user_id = $this->session->userdata('id_usuario'); 
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        $data_u['user'] = $user_data;
        
        // Obtener las órdenes eliminadas de ayer y hoy por defecto
        $fecha_desde = date('Y-m-d', strtotime('-1 day')); // ayer
        $fecha_hasta = date('Y-m-d'); // hoy
        
        // Usar el modelo para obtener solo las órdenes eliminadas en ese rango de fechas
        $data['ordenesEliminadas'] = $this->Admin_model->obtenerOrdenesEliminadasPorFecha($fecha_desde, $fecha_hasta);
        
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_reporteordenes_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    //RECUPERAR
    public function recuperarTicket() {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        $data_u['user'] = $user_data;
        
        // Solo buscar ticket si es una petición POST
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post('orden_id')) {
            $ticket_data = $this->Admin_model->get_ticket_by_order($this->input->post('orden_id'));
            if ($ticket_data) {
                $data_u['ticket'] = $ticket_data;
            } else {
                $data_u['error'] = 'Orden no encontrada';
            }
        }
    
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_recuperar_view', $data_u);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    

    //fin

    //FIN
    public function eliminarTicket() {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Admin_model->get_user_by_id($user_id);
    
        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
    
        $data_u['user'] = $user_data;
        
        // Solo buscar ticket si es una petición POST
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post('orden_id')) {
            $ticket_data = $this->Admin_model->get_ticket_by_order($this->input->post('orden_id'));
            if ($ticket_data) {
                $data_u['ticket'] = $ticket_data;
            } else {
                $data_u['error'] = 'Orden no encontrada';
            }
        }
    
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_eliminar_view', $data_u);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    
    public function procesarEliminacionTicket() {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Acceso no permitido']);
            return;
        }
    
        $orden_id = $this->input->post('orden_id');
        
        if (!$orden_id) {
            echo json_encode(['status' => 'error', 'message' => 'ID de orden no proporcionado']);
            return;
        }
    
        // Iniciar transacción
        $this->db->trans_start();
    
        try {
            // Intentar eliminar la orden y restaurar el stock
            $result = $this->Admin_model->eliminarOrdenYRestaurarStock($orden_id);
    
            if ($result['success']) {
                $this->db->trans_complete();
                echo json_encode(['status' => 'success', 'message' => 'Orden eliminada correctamente']);
            } else {
                $this->db->trans_rollback();
                echo json_encode(['status' => 'error', 'message' => $result['message']]);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => 'Error al procesar la eliminación: ' . $e->getMessage()]);
        }
    }
    // 
    // FIN CRUD USUARIOS

}
?>
