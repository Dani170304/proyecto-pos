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
        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu');
        $this->load->view('form_agregar_productos');
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function modificarproducto()
    {
        $id_producto = $_POST['id_producto'];
        $data['infoproducto'] = $this->Productos_model->recuperarproducto($id_producto);
        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu');
        $this->load->view('form_modificar_productos', $data);
        $this->load->view('incSupervisor/footer');
        $this->load->view('incSupervisor/pie');
    }
    public function eliminadosproductos()
    {
        $lista = $this->Productos_model->listaproductoseliminados();
        $data['productos'] = $lista;

        $this->load->view('incSupervisor/head');
        $this->load->view('incSupervisor/menu');
        $this->load->view('eliminadosproductos', $data);
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
        $id_producto = $_POST['id_producto'];
        $data['estado'] = '0';

        $this->Productos_model->modificarproducto($id_producto, $data);
        redirect('Productos/productos', 'refresh');
    }
    
    public function modificarproductodb()
    {
        $id_producto = $this->input->post('id_producto');  // Obtener ID del producto
        $data['nombre'] = strtoupper($this->input->post('nombre'));
        $data['categoria'] = strtoupper($this->input->post('categoria'));
        $data['stock'] = $this->input->post('stock');
        $data['precio'] = $this->input->post('precio');
        
        // Verificar si se subió una nueva imagen
        if (!empty($_FILES['imagen']['name'])) {
            // Configuración para la subida de imagen
            $config['upload_path'] = './assets/imagenes_bebidas/';  // Ruta a la carpeta donde se guardarán las imágenes
            $config['allowed_types'] = 'jpg|jpeg|png';  // Tipos de archivos permitidos
            $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];  // Generar un nombre único para la imagen
            $config['max_size'] = 2048;  // Tamaño máximo de la imagen (2MB)
    
            // Cargar la librería de carga de archivos
            $this->load->library('upload', $config);
    
            // Intentar subir la imagen
            if ($this->upload->do_upload('imagen')) {
                // Obtener los datos de la imagen subida
                $uploadData = $this->upload->data();
                $data['imagen'] = $uploadData['file_name'];  // Guardar el nombre de la imagen en el arreglo $data
    
                // Borrar la imagen antigua si existe
                $imagen_actual = $this->input->post('imagen_actual');
                if (!empty($imagen_actual) && file_exists('./assets/imagenes_bebidas/' . $imagen_actual)) {
                    unlink('./assets/imagenes_bebidas/' . $imagen_actual);  // Eliminar la imagen actual
                }
            } else {
                // Manejar errores en la carga
                $error = $this->upload->display_errors();
                echo $error;  // Mostrar el error
                return;
            }
        } else {
            // Mantener la imagen actual si no se subió una nueva
            $data['imagen'] = $this->input->post('imagen_actual');
        }
    
        // Actualizar los datos en la base de datos
        $this->Productos_model->modificarproducto($id_producto, $data);
    
        // Redirigir a la página de productos
        redirect('Productos/productos', 'refresh');
    }
    
    
    public function habilitarproductobd()
    {
        $id_producto = $_POST['id_producto'];
        $data['estado'] = '1';

        $this->Productos_model->modificarproducto($id_producto, $data);
        redirect('Productos/eliminadosproductos', 'refresh');
    }
}
?>