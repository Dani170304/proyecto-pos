<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Productos extends CI_Controller
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
        $dataU['user'] = $user_data;

        $lista = $this->Productos_model->listaproductos();
        $data['productos'] = $lista;

        $this->load->view('inc/head');
        $this->load->view('inc/menu', $dataU);
        $this->load->view('admin_productos_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    // Ya no necesitas estos métodos porque ahora usas modales
    // public function agregarproductos() { ... }
    // public function modificarproducto() { ... }

    public function eliminadosproductos()
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

        $lista = $this->Productos_model->listaproductoseliminados();
        $data['productos'] = $lista;

        $this->load->view('inc/head');
        $this->load->view('inc/menu', $dataU);
        $this->load->view('eliminadosproductos', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }

    public function eliminarproductodb()
    {
        $id_producto = $_POST['id_producto'];
        $success = $this->Productos_model->eliminarproducto($id_producto);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto.']);
        }
    }

    public function deshabilitarproductodb()
    {
        $id_producto = $_POST['id_producto'];
        $data['estado'] = '0';

        $success = $this->Productos_model->modificarproducto($id_producto, $data);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Producto deshabilitado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al deshabilitar el producto.']);
        }
    }

    public function agregarproductobd()
    {
        $data['nombre'] = strtoupper($this->input->post('nombre'));
        $data['categoria'] = strtoupper($this->input->post('categoria'));
        $data['stock'] = $this->input->post('stock');
        $data['precio'] = $this->input->post('precio');

        // Incluir el ID del usuario que hizo la acción
        $data['idUsuario'] = $this->session->userdata('id_usuario');

        // Verificar si el producto ya existe en la misma categoría
        if ($this->Productos_model->verificar_producto_existente($data['nombre'], $data['categoria'])) {
            echo json_encode(array('status' => 'error', 'message' => 'El producto ya existe en la misma categoría.'));
            return;
        }

        // Verificar si se subió una imagen
        if (!empty($_FILES['imagen']['name'])) {
            $config['upload_path'] = './assets/imagenes_bebidas/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('imagen')) {
                $uploadData = $this->upload->data();
                $data['imagen'] = $uploadData['file_name'];
            } else {
                echo json_encode(array('status' => 'error', 'message' => $this->upload->display_errors()));
                return;
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se ha subido ninguna imagen.'));
            return;
        }

        if ($this->Productos_model->insertar_producto($data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Producto agregado correctamente.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error al agregar el producto en la base de datos.'));
        }
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
                echo json_encode(['success' => false, 'message' => $error]);  // Mostrar el error como respuesta JSON
                return;
            }
        } else {
            // Mantener la imagen actual si no se subió una nueva
            $data['imagen'] = $this->input->post('imagen_actual');
        }

        // Actualizar los datos en la base de datos
        if ($this->Productos_model->modificarproducto($id_producto, $data)) {
            echo json_encode(['success' => true, 'message' => 'Producto modificado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al modificar el producto.']);
        }
    }

    public function habilitarproductobd()
    {
        $id_producto = $_POST['id_producto'];
        $data['estado'] = '1';

        // Intentar habilitar el producto y manejar el resultado
        if ($this->Productos_model->modificarproducto($id_producto, $data)) {
            // Éxito
            echo json_encode(['success' => true, 'message' => 'Producto habilitado correctamente.']);
        } else {
            // Error
            echo json_encode(['success' => false, 'message' => 'Error al habilitar el producto.']);
        }
    }
}
