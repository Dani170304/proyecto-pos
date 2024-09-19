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
        // Recoger datos del formulario
        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $rol = 'usuario'; // Cambiado de 'mesero' a 'usuario'
        $estado = 1; // Por defecto el usuario se registra activo

        // Convertir el email a minúsculas
        $email = strtolower($email);
        // Convertir el nombre a mayúsculas
        $nombre = strtoupper($nombre);
        $apellido = strtoupper($apellido);

        // Verificar si el correo electrónico ya existe en la base de datos
        $this->load->model('Usuario_model');
        if ($this->Usuario_model->email_exists($email)) {
            // Mostrar mensaje de error si el correo ya está registrado
            $this->session->set_flashdata('error_msg', 'El correo electrónico ya está registrado.');
            redirect('login');
            return; // Terminar la ejecución del método
        }

        // Verificar reCAPTCHA v2
        $recaptchaResponse = $this->input->post('g-recaptcha-response');
        $recaptchaSecret = '6LfifAQqAAAAAI8DZjl9CegRk9qvjFve3AI271S7'; // Aquí colocar tu clave secreta de reCAPTCHA v2

        // Hacer una solicitud POST para verificar la respuesta del reCAPTCHA
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

        // Verificar si la respuesta del reCAPTCHA es válida
        if ($recaptchaResponseData->success) {
            // Generar un código de verificación de 4 dígitos
            $codigo_verificacion = rand(1000, 9999);

            // Preparar los datos para la inserción
            $data = array(
                'nombres' => $nombre,
                'apellidos' => $apellido,
                'password' => password_hash($password, PASSWORD_DEFAULT), // Utilizamos password_hash
                'email' => $email,
                'estado' => $estado,
                'rol' => $rol,
                'codigo_verificacion' => $codigo_verificacion,
                'sesion_verificada' => 'no'
            );

            // Insertar el usuario utilizando el modelo
            $insert_id = $this->Usuario_model->insert_user($data);

            if ($insert_id) {
                // Actualizar el campo idUsuario_auditoria con el id del usuario recién insertado
                // $this->Usuario_model->update_user_auditoria($insert_id);

                // Enviar correo de verificación
                $this->send_verification_email($email, $codigo_verificacion, $nombre);

                // Mostrar mensaje de éxito
                $this->session->set_flashdata('success_msg', 'Cuenta creada exitosamente. Revisa tu correo para verificar la cuenta.');
                redirect('login'); // Redirigir al formulario de inicio de sesión
            } else {
                // Mostrar mensaje de error si no se pudo insertar
                $this->session->set_flashdata('error_msg', 'Error al registrar usuario. Por favor, intenta nuevamente.');
                redirect('login');
            }
        } else {
            // Mostrar mensaje de error si el reCAPTCHA no fue validado correctamente
            $this->session->set_flashdata('error_msg', 'Por favor, completa el reCAPTCHA correctamente.');
            $this->load->view('login_view'); // Cargar la vista de registro nuevamente
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
}
?>
