<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Productos_supervisor extends CI_Controller
{
// INICIO CRUD PRODUCTOS
    public function productos()
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
        $data_u['user'] = $user_data;

        $lista = $this->Productos_model->listaproductos();
        $data['productos'] = $lista;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu', $data_u);
        $this->load->view('supervisor_productos_view', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function agregarproductos()
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
        $data_u['user'] = $user_data;


        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu',$data_u);
        $this->load->view('form_agregar_productos_supervisor');
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function modificarproducto()
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
        $data_u['user'] = $user_data;


        $id_producto = $_POST['id_producto'];
        $data['infoproducto'] = $this->Productos_model->recuperarproducto($id_producto);
        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu',$data_u);
        $this->load->view('form_modificar_productos_supervisor', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function eliminadosproductos()
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
        $data_u['user'] = $user_data;


        $lista = $this->Productos_model->listaproductoseliminados();
        $data['productos'] = $lista;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu',$data_u);
        $this->load->view('eliminadosproductos_supervisor', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function eliminarproductodb()
    {
        $id_producto=$_POST['id_producto'];
        $this->Productos_model->eliminarproducto($id_producto);
        redirect('Productos/productos', 'refresh');
    }
    public function deshabilitarproductodb()
    {
        if ($this->input->is_ajax_request()) {
            try {
                $id_producto = $this->input->post('id_producto');
                $data['estado'] = '0';
        
                if ($this->Productos_model->modificarproducto($id_producto, $data)) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Producto deshabilitado correctamente'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Error al deshabilitar el producto'
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error inesperado: ' . $e->getMessage()
                ]);
            }
        } else {
            // Si no es AJAX, manejar como una petición normal
            $id_producto = $this->input->post('id_producto');
            $data['estado'] = '0';
            
            if ($this->Productos_model->modificarproducto($id_producto, $data)) {
                redirect('Productos_supervisor/productos', 'refresh');
            }
        }
    }
    public function agregarproductobd()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    
        try {
            // Obtener los datos del formulario
            $data['nombre'] = strtoupper($this->input->post('nombre'));
            $data['categoria'] = strtoupper($this->input->post('categoria'));
            $data['stock'] = $this->input->post('stock');
            $data['precio'] = $this->input->post('precio');
    
            // Verificar si se subió una imagen
            if (!empty($_FILES['imagen']['name'])) {
                // Configuración para la subida de imagen
                $config['upload_path'] = './assets/imagenes_bebidas/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];
                $config['max_size'] = 2048;
    
                // Cargar la librería de carga de archivos
                $this->load->library('upload', $config);
    
                // Intentar subir la imagen
                if ($this->upload->do_upload('imagen')) {
                    // Obtener los datos de la imagen subida
                    $uploadData = $this->upload->data();
                    $data['imagen'] = $uploadData['file_name'];
                } else {
                    echo json_encode([
                        'status' => 'error', 
                        'message' => $this->upload->display_errors('', '')
                    ]);
                    return;
                }
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'No se ha subido ninguna imagen.'
                ]);
                return;
            }
    
            // Guardar el nuevo producto en la base de datos
            if ($this->Productos_model->insertar_producto($data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Producto agregado correctamente'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al agregar el producto en la base de datos.'
                ]);
            }
    
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ]);
        }
    }

    public function modificarproductodb()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    
        try {
            $id_producto = $this->input->post('id_producto');
            $data['nombre'] = strtoupper($this->input->post('nombre'));
            $data['categoria'] = strtoupper($this->input->post('categoria'));
            $data['stock'] = $this->input->post('stock');
            $data['precio'] = $this->input->post('precio');
            
            // Verificar si se subió una nueva imagen
            if (!empty($_FILES['imagen']['name'])) {
                $config['upload_path'] = './assets/imagenes_bebidas/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];
                $config['max_size'] = 2048;
        
                $this->load->library('upload', $config);
        
                if ($this->upload->do_upload('imagen')) {
                    $uploadData = $this->upload->data();
                    $data['imagen'] = $uploadData['file_name'];
        
                    // Borrar la imagen antigua
                    $imagen_actual = $this->input->post('imagen_actual');
                    if (!empty($imagen_actual) && file_exists('./assets/imagenes_bebidas/' . $imagen_actual)) {
                        unlink('./assets/imagenes_bebidas/' . $imagen_actual);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $this->upload->display_errors('', '')
                    ]);
                    return;
                }
            } else {
                // Mantener la imagen actual
                $data['imagen'] = $this->input->post('imagen_actual');
            }
        
            // Actualizar en la base de datos
            if ($this->Productos_model->modificarproducto($id_producto, $data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Producto modificado correctamente'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al modificar el producto en la base de datos.'
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ]);
        }
    }
    
    
    
    public function habilitarproductobd()
    {
        if ($this->input->is_ajax_request()) {
            try {
                $id_producto = $this->input->post('id_producto');
                $data['estado'] = '1';
    
                if ($this->Productos_model->modificarproducto($id_producto, $data)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Producto habilitado correctamente'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al habilitar el producto'
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error inesperado: ' . $e->getMessage()
                ]);
            }
        } else {
            // Si no es AJAX, manejar como una petición normal
            $id_producto = $this->input->post('id_producto');
            $data['estado'] = '1';
            
            if ($this->Productos_model->modificarproducto($id_producto, $data)) {
                redirect('Productos_supervisor/productos', 'refresh');
            }
        }
    }
}
?>