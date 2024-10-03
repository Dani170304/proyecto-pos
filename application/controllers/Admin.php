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
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $rol = $this->input->post('rol');
        
        // Convertir el email a minúsculas
        $email = strtolower($email);
        // Convertir el nombre a mayúsculas
        $nombre = strtoupper($nombre);
        $apellido = strtoupper($apellido);
        
        // Verificar si el email ya existe
        if ($this->Admin_model->verificarEmail($email)) {
            // Enviar respuesta JSON si el email ya existe
            echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado.']);
            return;
        }
        
        // Generar un código de verificación de 4 dígitos
        $codigo_verificacion = rand(1000, 9999);

        $id_usuario_auditoria = $this->session->userdata('id_usuario');
        // Preparar los datos para la inserción
        $data = array(
            'nombres' => $nombre,
            'apellidos' => $apellido,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'rol' => $rol,
            'codigo_verificacion' => $codigo_verificacion,
            'idUsuario_auditoria' => $this->session->userdata('id_usuario') // Incluye el ID del usuario que hizo la acción
        );
        
        // Insertar el usuario utilizando el modelo
        $insert = $this->Admin_model->agregarUsuario($data);
        
        if ($insert) {
            // Enviar correo de verificación
            $this->send_verification_email($email, $codigo_verificacion, $nombre);
            
            // Enviar respuesta JSON
            echo json_encode(['status' => 'success', 'message' => 'Cuenta creada exitosamente. Revisa tu correo para verificar la cuenta.']);
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

    public function modificardb()
    {
        $password = $this->input->post('password');
        $id_usuario = $this->input->post('id_usuario');
        $data['nombres'] = strtoupper($this->input->post('nombres'));
        $data['apellidos'] = strtoupper($this->input->post('apellidos'));
        $data['email'] = $this->input->post('email');
        $data['rol'] = $this->input->post('rol');
    
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
    
        // Actualiza el usuario en la base de datos
        $this->Admin_model->modificarusuario($id_usuario, $data);
    
        // Redirige a la página de inicio o cualquier otra página
        redirect('Admin/index', 'refresh');
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
    
        // Obtener las fechas desde el formulario
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
    
        // Obtener las ventas dentro del rango de fechas
        $ventas = $this->Admin_model->obtener_ventas_por_fecha($fecha_desde, $fecha_hasta);
    
        $data_u['user'] = $user_data;
        $data['ventas'] = $ventas;
    
        $lista = $this->Admin_model->listausuarios();
        $data['usuarios'] = $lista;
    
        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_reportemes_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    
    
    
    
    
    public function reporteProductoMasVendido()
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
        $this->load->view('admin_reporteproducto_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    // FIN CRUD USUARIOS
}
?>
