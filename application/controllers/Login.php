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
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $codigo_ingresado = $this->input->post('codigo_verificacion');
    
        // Consultar la base de datos para verificar las credenciales
        $this->load->model('Usuario_model');
        $user = $this->Usuario_model->get_user($email);
    
        if ($user && password_verify($password, $user->password)) {
            if ($user->sesion_verificada == 'no') {
                if ($codigo_ingresado) {
                    if ($codigo_ingresado == $user->codigo_verificacion) {
                        // Código es correcto, actualizar el estado de verificación
                        $this->Usuario_model->update_verification_status($email);
                        $userdata = array(
                            'id_usuario' => $user->id_usuario,
                            'nombres' => $user->nombres,
                            'apellidos' => $user->apellidos,
                            'email' => $user->email,
                            'rol' => $user->rol,
                            'logged_in' => TRUE
                        );
    
                        // Guardar datos del usuario en sesión
                        $this->session->set_userdata($userdata);
                        
                        // Redireccionar según el rol del usuario
                        switch ($user->rol) {
                            case 'administrador':
                                redirect('admin');
                                break;
                            case 'usuario':
                                redirect('menu');
                                break;
                            case 'supervisor':
                                redirect('supervisor');
                                break;
                            default:
                                redirect('menu');
                                break;
                        }
                    } else {
                        $this->session->set_flashdata('error_msg', 'Código de verificación incorrecto.');
                        redirect('login');
                    }
                } else {
                    // Guardar información temporal en la sesión
                    $this->session->set_userdata('temp_login', array(
                        'email' => $email,
                        'password' => $password
                    ));
                    $this->session->set_flashdata('codigo_verificacion', $user->codigo_verificacion);
                    $this->load->view('login_view', ['mostrar_codigo_verificacion' => true]);
                }
            } else {
                $userdata = array(
                    'id_usuario' => $user->id_usuario,
                    'nombres' => $user->nombres,
                    'apellidos' => $user->apellidos,
                    'email' => $user->email,
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
        } else {
            $this->session->set_flashdata('error_msg', 'Email o contraseña incorrectos.');
            redirect('login');
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

        $email = strtolower($email);
        $nombre = strtoupper($nombre);
        $apellido = strtoupper($apellido);

        $this->load->model('Usuario_model');
        if ($this->Usuario_model->email_exists($email)) {
            $this->session->set_flashdata('error_msg', 'El correo electrónico ya está registrado.');
            redirect('login');
            return;
        }

        // Comentado el código de reCAPTCHA ya que no es necesario
        /*
        $recaptchaResponse = $this->input->post('g-recaptcha-response');
        $recaptchaSecret = '6LfifAQqAAAAAI8DZjl9CegRk9qvjFve3AI271S7';

        $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptchaResponseData = array(
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse
        );

        $recaptchaVerification = curl_init($recaptchaUrl);
        curl_setopt($recaptchaVerification, CURLOPT_POST, true);
        curl_setopt($recaptchaVerification, CURLOPT_POSTFIELDS, http_build_query($recaptchaResponseData));
        curl_setopt($recaptchaVerification, CURLOPT_RETURNTRANSFER, true);

        $recaptchaResponseJson = curl_exec($recaptchaVerification);
        curl_close($recaptchaVerification);

        $recaptchaResponseData = json_decode($recaptchaResponseJson);
        */

        // Eliminada la verificación del reCAPTCHA
        // if ($recaptchaResponseData->success) {
        
        // Generar código de verificación
        $codigo_verificacion = rand(1000, 9999);

        $data = array(
            'nombres' => $nombre,
            'apellidos' => $apellido,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'estado' => $estado,
            'rol' => $rol,
            'codigo_verificacion' => $codigo_verificacion,
            'sesion_verificada' => 'no'
        );

        $insert_id = $this->Usuario_model->insert_user($data);

        if ($insert_id) {
            $this->send_verification_email($email, $codigo_verificacion, $nombre);
            $this->session->set_flashdata('success_msg', 'Cuenta creada exitosamente. Revisa tu correo para verificar la cuenta.');
            redirect('login');
        } else {
            $this->session->set_flashdata('error_msg', 'Error al registrar usuario. Por favor, intenta nuevamente.');
            redirect('login');
        }
        /* } else {
            $this->session->set_flashdata('error_msg', 'Por favor, completa el reCAPTCHA correctamente.');
            $this->load->view('login_view');
        } */
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
        $email = $this->input->post('email');
        $this->load->model('Usuario_model');
    
        // Verifica si el correo existe
        if ($this->Usuario_model->email_exists2($email)) {
            // Verifica si la cuenta está activa
            if ($this->Usuario_model->is_account_verified($email)) {
                $token = bin2hex(random_bytes(50)); // Genera un token único
                $this->Usuario_model->store_reset_token($email, $token);
    
                // Enviar correo con el enlace de restablecimiento
                if ($this->send_reset_email($email, $token)) {
                    $this->session->set_flashdata('success_msg', 'Se ha enviado un enlace para restablecer tu contraseña.');
                    redirect('login/index'); // Redirige al login en caso de éxito
                } else {
                    $this->session->set_flashdata('error_msg', 'Error al enviar el correo.');
                    redirect('login/reset_password'); // Mantener en la misma página en caso de error
                }
            } else {
                $this->session->set_flashdata('error_msg', 'La cuenta no está activa. Verifica tu correo electrónico para activarla.');
                redirect('login/reset_password'); // Mantener en la misma página si la cuenta no está activa
            }
        } else {
            $this->session->set_flashdata('error_msg', 'El correo no está registrado.');
            redirect('login/reset_password'); // Mantener en la misma página si el correo no existe
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
