<?php


class Eventos extends CI_Controller
{

    // usuarios
    public function dash()
    {
        $data_g['ganancias'] = $this->Admin_model->get_total_ganancias();
        $data_g['Nroventas'] = $this->Admin_model->get_ventas();
        $data_g['clientes'] = $this->Admin_model->get_clientes();
        $data_g['ventas'] = $this->Admin_model->obtener_ultimas_ventas();
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Eventos_model->get_user_by_id($user_id);
    
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
    
    // INICIO CRUD EVENTOS
    public function index()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Eventos_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $data_u['user'] = $user_data;

        $lista = $this->Eventos_model->listaeventos();
        $data['eventos'] = $lista;

        $this->load->view('inc/head');
        $this->load->view('inc/menu', $data_u);
        $this->load->view('admin_eventos_view', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    public function agregareventos()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Eventos_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $dataU['user'] = $user_data;

        $lista = $this->Eventos_model->listaeventos();
        $data['eventos'] = $lista;
        $this->load->view('inc/head');
        $this->load->view('inc/menu',$dataU);
        $this->load->view('form_agregar_eventos',$data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    public function agregareventobd() {
        // Primero verificamos que tengamos una sesión válida
        if (!$this->session->userdata('id_usuario')) {
            echo json_encode(array('status' => 'error', 'message' => 'No hay una sesión activa.'));
            return;
        }
    
        // Obtenemos el ID del usuario de la sesión
        $id_usuario = $this->session->userdata('id_usuario');
    
        $data = array(
            'nombre_evento' => strtoupper($this->input->post('nombre')),
            'descripcion' => strtoupper($this->input->post('descripcion')),
            'ubicacion_evento' => strtoupper($this->input->post('ubicacion')),
            'telefono_evento' => $this->input->post('telefono'),
            'fecha_inicio' => $this->input->post('fecha'),
            'id_usuario' => $id_usuario, // Usamos el ID de la sesión
            'idUsuario' => $id_usuario  // Para auditoría
        );
    
        // Verificar que el usuario existe y está activo
        $usuario_existe = $this->db->where('id_usuario', $id_usuario)
                                  ->where('estado', 1)
                                  ->get('usuarios')
                                  ->num_rows() > 0;
        
        if (!$usuario_existe) {
            echo json_encode(array('status' => 'error', 'message' => 'Usuario no autorizado o inactivo.'));
            return;
        }
    
        // Verificar si se subió una imagen
        if (!empty($_FILES['imagen']['name'])) {
            $config['upload_path'] = './assets/imagenes_eventos/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];
            $config['max_size'] = 2048;
    
            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('imagen')) {
                $uploadData = $this->upload->data();
                $data['imagen_evento'] = $uploadData['file_name'];
            } else {
                echo json_encode(array('status' => 'error', 'message' => $this->upload->display_errors()));
                return;
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se ha subido ninguna imagen.'));
            return;
        }
    
        // Intentar insertar el evento
        if ($this->Eventos_model->insertar_evento($data)) {
            echo json_encode(array(
                'status' => 'success', 
                'message' => 'Evento agregado correctamente.'
            ));
        } else {
            echo json_encode(array(
                'status' => 'error', 
                'message' => 'Error al agregar el evento en la base de datos.'
            ));
        }
    }

    public function modificarevento()
    {
        $user_id = $this->session->userdata('id_usuario'); // Cambia 'user_id' si es necesario
        $user_data = $this->Eventos_model->get_user_by_id($user_id);
    
        if ($user_data) {
            // Process the full name to get only the first and last names
            $nombres = explode(' ', $user_data['nombres']);
            $apellidos = explode(' ', $user_data['apellidos']);
        
            // Combine the first and last names into one string
            $user_data['nombre_completo'] = $nombres[0] . ' ' . $apellidos[0];
        }
        
    
        // Pasar los datos a la vista
        $dataU['user'] = $user_data;


        $id_evento = $_POST['id_evento'];
        $data['infoevento'] = $this->Eventos_model->recuperarevento($id_evento);
        $this->load->view('inc/head');
        $this->load->view('inc/menu',$dataU);
        $this->load->view('form_modificar_eventos', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    public function modificareventodb()
    {
        $id_evento = $this->input->post('id_evento');  // Obtener ID del evento
        $data['nombre_evento'] = strtoupper($this->input->post('nombre'));
        $data['descripcion'] = strtoupper($this->input->post('descripcion'));
        $data['fecha_inicio'] = $this->input->post('fecha');
    
        // Verificar si se subió una nueva imagen
        if (!empty($_FILES['imagen']['name'])) {
            // Configuración para la subida de imagen
            $config['upload_path'] = './assets/imagenes_eventos/';  // Ruta a la carpeta donde se guardarán las imágenes
            $config['allowed_types'] = 'jpg|jpeg|png';  // Tipos de archivos permitidos
            $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];  // Generar un nombre único para la imagen
            $config['max_size'] = 2048;  // Tamaño máximo de la imagen (2MB)
    
            // Cargar la librería de carga de archivos
            $this->load->library('upload', $config);
    
            // Intentar subir la imagen
            if ($this->upload->do_upload('imagen')) {
                // Obtener los datos de la imagen subida
                $uploadData = $this->upload->data();
                $data['imagen_evento'] = $uploadData['file_name'];  // Guardar el nombre de la imagen en el arreglo $data
    
                // Borrar la imagen antigua si existe
                $imagen_actual = $this->input->post('imagen_actual');
                if (!empty($imagen_actual) && file_exists('./assets/imagenes_eventos/' . $imagen_actual)) {
                    unlink('./assets/imagenes_eventos/' . $imagen_actual);  // Eliminar la imagen actual
                }
            } else {
                // Manejar errores en la carga
                $error = $this->upload->display_errors();
                echo json_encode(['success' => false, 'message' => $error]);  // Mostrar el error como respuesta JSON
                return;
            }
        } else {
            // Mantener la imagen actual si no se subió una nueva
            $data['imagen_evento'] = $this->input->post('imagen_actual');
        }
    
        // Actualizar los datos en la base de datos
        if ($this->Eventos_model->modificarevento($id_evento, $data)) {
            echo json_encode(['success' => true, 'message' => 'Evento modificado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al modificar el evento.']);
        }
    }

    public function eliminareventodb()
    {
        $id_evento = $_POST['id_evento'];
        $success = $this->Eventos_model->eliminarevento($id_evento);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Evento eliminado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el evento.']);
        }
    }
    
    public function deshabilitareventodb()
    {
        $id_evento = $_POST['id_evento'];
        $data['estado'] = '0';
    
        $success = $this->Eventos_model->modificarevento($id_evento, $data);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Evento deshabilitado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al deshabilitar el evento.']);
        }
    }
    public function eliminadoseventos()
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


        $lista = $this->Eventos_model->listaeventoseliminados();
        $data['eventos'] = $lista;

        $this->load->view('inc/head');
        $this->load->view('inc/menu',$dataU);
        $this->load->view('eliminadoseventos', $data);
        $this->load->view('inc/footer');
        $this->load->view('inc/pie');
    }
    
    public function habilitareventobd()
    {
        $id_evento = $_POST['id_evento'];
        $data['estado'] = '1';
    
        // Intentar habilitar el producto y manejar el resultado
        if ($this->Eventos_model->modificarevento($id_evento, $data)) {
            // Éxito
            echo json_encode(['success' => true, 'message' => 'Evento habilitado correctamente.']);
        } else {
            // Error
            echo json_encode(['success' => false, 'message' => 'Error al habilitar el evento.']);
        }
    }
}
?>
