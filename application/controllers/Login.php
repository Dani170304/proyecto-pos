<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Login extends CI_Controller {

    public function index()
    {
        $this->load->view('login_view');
    }

    public function validate_login()
    {
        $login = $this->input->post('login'); // Ahora usamos login en lugar de email
        $password = $this->input->post('password');
        $codigo_ingresado = $this->input->post('codigo_verificacion');
    
        // Consultar la base de datos para verificar las credenciales
        $this->load->model('Usuario_model');
        $user = $this->Usuario_model->get_user_by_login($login); // Cambio en el método
    
        if ($user && password_verify($password, $user->password)) {
            // Verificar si el usuario necesita verificación (solo administradores y supervisores)
            if ($user->rol != 'usuario' && $user->sesion_verificada == 'no') {
                if ($codigo_ingresado) {
                    if ($codigo_ingresado == $user->codigo_verificacion) {
                        // Código es correcto, actualizar el estado de verificación
                        $this->Usuario_model->update_verification_status($user->id_usuario);
                        $this->create_session_and_redirect($user);
                    } else {
                        $this->session->set_flashdata('error_msg', 'Código de verificación incorrecto.');
                        redirect('login');
                    }
                } else {
                    // Guardar información temporal en la sesión
                    $this->session->set_userdata('temp_login', array(
                        'login' => $login,
                        'password' => $password
                    ));
                    $this->session->set_flashdata('codigo_verificacion', $user->codigo_verificacion);
                    $this->load->view('login_view', ['mostrar_codigo_verificacion' => true]);
                }
            } else {
                // Usuario tipo cliente o ya verificado, iniciar sesión directamente
                $this->create_session_and_redirect($user);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Login o contraseña incorrectos.');
            redirect('login');
        }
    }
    
    private function create_session_and_redirect($user)
    {
        $userdata = array(
            'id_usuario' => $user->id_usuario,
            'nombres' => $user->nombres,
            'apellidos' => $user->apellidos,
            'email' => $user->email,
            'login' => $user->login,
            'rol' => $user->rol,
            'logged_in' => TRUE
        );

        $this->session->set_userdata($userdata);
        
        switch ($user->rol) {
            case 'administrador':
                redirect('admin');
                break;
            case 'usuario':
                redirect('menu');
                break;
            case 'supervisor':
                redirect('supervisor/dash');
                break;
            default:
                redirect('menu');
                break;
        }
    }
    
    public function validate_signup()
    {
        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $rol = 'usuario';
        $estado = 1;

        $nombre = strtoupper($nombre);
        $apellido = strtoupper($apellido);

        // Generar login automáticamente (nombre + primera inicial del apellido)
        $login = strtolower(preg_replace('/\s+/', '', $nombre) . substr($apellido, 0, 1));
        
        $this->load->model('Usuario_model');
        
        // Verificar si el login ya existe y añadir un número si es necesario
        $login_base = $login;
        $counter = 1;
        while ($this->Usuario_model->login_exists($login)) {
            $login = $login_base . $counter;
            $counter++;
        }

        // Para usuarios normales, el email es opcional
        if (!empty($email)) {
            $email = strtolower($email);
            
            // Verificar si el email ya existe
            if ($this->Usuario_model->email_exists($email)) {
                $this->session->set_flashdata('error_msg', 'El correo electrónico ya está registrado.');
                redirect('login');
                return;
            }
        } else {
            $email = null; // Email opcional para usuarios normales
        }

        // Los usuarios tipo 'usuario' no necesitan verificación
        $sesion_verificada = 'si';
        $codigo_verificacion = null;

        $data = array(
            'nombres' => $nombre,
            'apellidos' => $apellido,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'estado' => $estado,
            'rol' => $rol,
            'login' => $login,
            'codigo_verificacion' => $codigo_verificacion,
            'sesion_verificada' => $sesion_verificada
        );

        $insert_id = $this->Usuario_model->insert_user($data);

        if ($insert_id) {
            $message = 'Cuenta creada exitosamente. Tu login es: ' . $login;
            $this->session->set_flashdata('success_msg', $message);
            redirect('login');
        } else {
            $this->session->set_flashdata('error_msg', 'Error al registrar usuario. Por favor, intenta nuevamente.');
            redirect('login');
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
            echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
        }
    }

    public function reset_password()
    {
        $this->load->view('reset_password_view');
    }

    public function send_reset_link()
    {
        $login_or_email = $this->input->post('login_or_email');
        $this->load->model('Usuario_model');
    
        // Buscar al usuario por login o email
        $user = $this->Usuario_model->get_user_by_login_or_email($login_or_email);
        
        if ($user) {
            // Si es un usuario cliente, debe tener email para poder resetear
            if ($user->rol == 'usuario' && empty($user->email)) {
                $this->session->set_flashdata('error_msg', 'Este tipo de cuenta no permite restablecer la contraseña. Contacta al administrador.');
                redirect('login/reset_password');
                return;
            }
            
            // Solo se puede resetear si la cuenta está activa
            if ($user->estado == 1) {
                $token = bin2hex(random_bytes(50)); // Genera un token único
                $this->Usuario_model->store_reset_token($user->id_usuario, $token);
    
                // Enviar correo con el enlace de restablecimiento
                if ($this->send_reset_email($user->email, $token)) {
                    $this->session->set_flashdata('success_msg', 'Se ha enviado un enlace para restablecer tu contraseña.');
                    redirect('login/index');
                } else {
                    $this->session->set_flashdata('error_msg', 'Error al enviar el correo.');
                    redirect('login/reset_password');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'La cuenta no está activa.');
                redirect('login/reset_password');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'No se encontró ninguna cuenta con ese login o correo.');
            redirect('login/reset_password');
        }
    }
    
    private function send_reset_email($email, $token)
    {
        $resetLink = base_url("index.php/login/reset_password_form/$token");

        $mail = new PHPMailer(true);
        try {
            // Configura el servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'drink.master.2004@gmail.com';
            $mail->Password = 'lhwkmuzraevheiem';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configura los destinatarios
            $mail->setFrom('drink.master.2004@gmail.com', 'DRINKMASTER');
            $mail->addAddress($email); // Receptor del correo

            // Configura el contenido del correo
            $mail->Subject = 'Restablecer contraseña';
            $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='$resetLink'>Restablecer contraseña</a>";
            $mail->isHTML(true);

            // Envía el correo
            return $mail->send();
        } catch (Exception $e) {
            log_message('error', 'No se pudo enviar el correo: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function reset_password_form($token)
    {
        $this->load->model('Usuario_model');
        // Verificar el token aquí
        if ($this->Usuario_model->is_token_valid($token)) {
            $data['token'] = $token;
            $this->load->view('new_password_view', $data);
        } else {
            $this->session->set_flashdata('error_msg', 'El enlace de restablecimiento es inválido o ha expirado.');
            redirect('login/reset_password');
        }
    }

    public function update_password()
    {
        $this->load->model('Usuario_model');
        $token = $this->input->post('token');
        $new_password = $this->input->post('new_password');
    
        // Verifica y actualiza la contraseña
        if ($this->Usuario_model->update_password($token, password_hash($new_password, PASSWORD_DEFAULT))) {
            $this->session->set_flashdata('success_msg', 'Contraseña actualizada con éxito.');
            redirect('login/index');
        } else {
            $this->session->set_flashdata('error_msg', 'Error al actualizar la contraseña.');
            redirect("login/reset_password_form/$token");
        }
    }
}
?>