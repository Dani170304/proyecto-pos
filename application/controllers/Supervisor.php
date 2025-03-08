<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Supervisor extends CI_Controller
{

    // usuarios
    public function dash()
    {
        $data_g['ganancias'] = $this->Supervisor_model->get_total_ganancias();
        $data_g['Nroventas'] = $this->Supervisor_model->get_ventas();
        $data_g['clientes'] = $this->Supervisor_model->get_clientes();
        $data_g['ventas'] = $this->Supervisor_model->obtener_ultimas_ventas();
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);

            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }


        // Pasar los datos a la vista
        $data['user'] = $user_data;
        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data);
        $this->load->view('incSupervisor/dash', $data_g); // Suponiendo que esta es la vista
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    // INICIO CRUD USUARIOS
    public function index()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);

            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }


        // Pasar los datos a la vista
        $data_u['user'] = $user_data;

        $lista = $this->Supervisor_model->listausuarios();
        $data['usuarios'] = $lista;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_panel_view', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    public function eliminados()
    {
        $lista = $this->Supervisor_model->listausuarioseliminados();
        $data['usuarios'] = $lista;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu');
        $this->load->view('eliminadosproductos_supervisor', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    public function agregar()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Productos_model->get_user_by_id($user_id);

        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);

            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }


        // Pasar los datos a la vista
        $dataU['user'] = $user_data;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $dataU);
        $this->load->view('form_agregar_supervisor');
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    public function eliminardb()
    {
        $id_usuario = $_POST['id_usuario'];
        $this->Supervisor_model->eliminarusuario($id_usuario);
        redirect('Supervisor/index', 'refresh');
    }
    public function agregarbd()
    {




        // Cargar el modelo de Usuario
        $this->load->model('Supervisor_model');

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
        if ($this->Supervisor_model->verificarEmail($email)) {
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
        $insert = $this->Supervisor_model->agregarUsuario($data);

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
        $id_usuario = $_POST['id_usuario'];
        $data['estado'] = '0';

        $this->Supervisor_model->modificarusuario($id_usuario, $data);
        redirect('Supervisor/index', 'refresh');
    }

    public function habilitarbd()
    {
        $id_usuario = $_POST['id_usuario'];
        $data['estado'] = '1';

        $this->Supervisor_model->modificarusuario($id_usuario, $data);
        redirect('Supervisor/eliminados', 'refresh');
    }

    public function modificar()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

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
        $data['infousuario'] = $this->Supervisor_model->recuperarusuario($id_usuario);
        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $dataU);
        $this->load->view('form_modificar_supervisor', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    public function modificardb()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id_usuario = $this->input->post('id_usuario');
        $data['nombres'] = strtoupper($this->input->post('nombres'));
        $data['apellidos'] = strtoupper($this->input->post('apellidos'));
        $data['email'] = $this->input->post('email');
        $data['rol'] = $this->input->post('rol');

        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            $this->Supervisor_model->modificarusuario($id_usuario, $data);
            // La respuesta será manejada por el success del AJAX
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            // En caso de error, enviamos una respuesta de error
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    // FIN CRUD USUARIOS

    //tickets
    public function recuperarTicket()
    {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }

        $data_u['user'] = $user_data;

        // Solo buscar ticket si es una petición POST
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post('orden_id')) {
            $ticket_data = $this->Supervisor_model->get_ticket_by_order($this->input->post('orden_id'));
            if ($ticket_data) {
                $data_u['ticket'] = $ticket_data;
            } else {
                $data_u['error'] = 'Orden no encontrada';
            }
        }

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_recuperar_view', $data_u);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    //eliminacion ticket
    public function eliminarTicket()
    {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }

        $data_u['user'] = $user_data;

        // Solo buscar ticket si es una petición POST
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post('orden_id')) {
            $ticket_data = $this->Supervisor_model->get_ticket_by_order($this->input->post('orden_id'));
            if ($ticket_data) {
                $data_u['ticket'] = $ticket_data;
            } else {
                $data_u['error'] = 'Orden no encontrada';
            }
        }

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_eliminar_view', $data_u);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }


    public function procesarEliminacionTicket()
    {
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
            $result = $this->Supervisor_model->eliminarOrdenYRestaurarStock($orden_id);

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

    //reportes
    public function reporteDia()
    {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }

        $data_u['user'] = $user_data;

        // Obtener la lista de usuarios
        $lista = $this->Supervisor_model->listausuarios();
        $data['usuarios'] = $lista;

        // Obtener las ventas del día
        $ventasDelDia = $this->Supervisor_model->obtenerVentasDelDia();
        $data['ventas'] = $ventasDelDia; // Pasar los datos de ventas a la vista

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_reportedia_view', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }

    public function reporteMesero()
    {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }

        $data_u['user'] = $user_data;

        // Obtener el reporte de meseros
        $reporteMeseros = $this->Supervisor_model->obtenerReporteMeseros();

        // Calcular el total general
        $total_general = 0;
        foreach ($reporteMeseros as $mesero) {
            $total_general += $mesero['total_venta'];
        }

        $data['reporteMeseros'] = $reporteMeseros;
        $data['total_general'] = $total_general;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_reportemesero_view', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function reporteTicketsEliminados()
    {
        $user_id = $this->session->userdata('id_usuario');
        $user_data = $this->Supervisor_model->get_user_by_id($user_id);

        if ($user_data) {
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }

        $data_u['user'] = $user_data;

        // Obtener las órdenes eliminadas
        $data['ordenesEliminadas'] = $this->Supervisor_model->obtenerOrdenesEliminadas();

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_reporteordenes_view', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
}
