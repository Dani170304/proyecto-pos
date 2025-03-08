<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn {
            font-weight: bold;
        }

        .btn-morado {
            background-color: #6f42c1;
            /* Color morado */
            color: white;
            /* Color del texto */
        }

        .btn-morado:hover {
            background-color: #563d7c;
            /* Color morado más oscuro para el hover */
            color: white;
        }

        .btn-info {
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 8px;
            padding-right: 8px;
        }

        .btn-verde {
            background-color: #3AD335;
            /* Color verde */
            color: black;
            /* Color del texto */
            margin-left: 7px;
        }

        .btn-verde:hover {
            background-color: #2BA81B;
            /* Color verde más oscuro para el hover */
            color: white;
        }

        .btn-warning {
            float: right;
            margin-right: 7px;
        }

        .text-center {
            text-align: center;
            /* Centra el contenido horizontalmente */
        }

        .color-num {
            color: #083CC2;
            font-weight: bold;
        }

        .hr-ta {
            margin-top: -10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        /* Estilos para los modales */
        .form-control {
            position: relative;
            padding-left: 40px;
            /* Deja espacio para el icono */
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            color: #fff;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }

        .modal-header {
            background-color: #6f42c1;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 id="title">LISTA DE USUARIOS</h1>
                        <div class="col-sm-12">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Tablas</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
        </section>
        <br>
        <button type="button" class="btn btn-verde" data-toggle="modal" data-target="#modalAgregarUsuario">
            Agregar usuario
        </button>
        <a href="<?php echo base_url(); ?>index.php/Admin/eliminados">
            <button type="button" class="btn btn-warning">Ver deshabilitados</button>
            <br>
            <br>
        </a>
        <?php if ($this->session->has_userdata('id_usuario')) : ?>
            <div class="bold-text-info">
                <input type="hidden" value="<?= htmlspecialchars($this->session->userdata('id_usuario')) ?>" readonly>
            </div>
        <?php endif; ?>
        <div class="card-info">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-neon">
                    <hr class="hr-ta">
                    <thead>
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1;
                        foreach ($usuarios->result() as $row) {
                        ?>
                            <tr>
                                <td class="color-num"><?php echo $contador ?></td>
                                <td><?php echo $row->nombres; ?></td>
                                <td><?php echo $row->apellidos; ?></td>
                                <td><?php echo $row->login; ?></td>
                                <td><?php echo !empty($row->email) ? $row->email : 'SIN EMAIL'; ?></td>
                                <td><?php echo $row->rol; ?></td>
                                <td class="orientation_col"><?php echo $row->estado; ?></td>
                                <td class="text-center">
                                    <div class="btn-group-ac">
                                        <button type="button" class="btn btn-morado modificar-btn"
                                            data-id="<?php echo $row->id_usuario; ?>"
                                            data-nombres="<?php echo $row->nombres; ?>"
                                            data-apellidos="<?php echo $row->apellidos; ?>"
                                            data-email="<?php echo $row->email; ?>"
                                            data-rol="<?php echo $row->rol; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <?php echo form_open_multipart("Admin/eliminardb", ['class' => 'formEliminar']); ?>
                                        <input type="hidden" name="id_usuario" value="<?php echo $row->id_usuario; ?>">
                                        <button type="submit" class="btn btn-danger eliminar-btn"><i class="fas fa-trash-alt"></i></button>
                                        <?php echo form_close(); ?>

                                        <?php echo form_open_multipart("Admin/deshabilitardb", ['class' => 'formDeshabilitar']); ?>
                                        <input type="hidden" name="id_usuario" value="<?php echo $row->id_usuario; ?>">
                                        <button type="submit" class="btn btn-info deshabilitar-btn"><i class="fas fa-ban"></i></button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $contador++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal Agregar Usuario -->
    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarUsuarioLabel">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart("Admin/agregarbd", ['id' => 'formAgregar']); ?>

                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="nombres" placeholder="Escriba sus Nombres" autocomplete="off" maxlength="20" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-user"></i></span>
                            <input id="input-color" type="text" class="form-control" name="apellidos" placeholder="Escriba sus Apellidos" maxlength="20" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-file-alt"></i></span>
                            <select class="form-control" name="rol" id="rol_agregar" required>
                                <option value="" disabled selected>Seleccione su rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="usuario">Mesero</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="email_grupo_agregar">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="email_agregar" placeholder="Escriba su Email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Escriba su Password" required>
                            <span class="password-toggle" onclick="togglePasswordVisibility('password')">
                                <i id="password-toggle-icon" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-morado">Agregar Usuario</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Modificar Usuario -->
    <div class="modal fade" id="modalModificarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalModificarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalModificarUsuarioLabel">Modificar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart("Admin/modificardb", ['id' => 'formModificar']); ?>
                    <input type="hidden" name="id_usuario" id="mod_id_usuario" value="">

                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="nombres" id="mod_nombres" placeholder="Escriba sus Nombres" maxlength="20" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="apellidos" id="mod_apellidos" placeholder="Escriba sus Apellidos" maxlength="20" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-file-alt"></i></span>
                            <select class="form-control" name="rol" id="mod_rol" required>
                                <option value="" disabled>Seleccione su rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="usuario">Mesero</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="email_grupo_modificar">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="mod_email" placeholder="Escriba su Email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="position: relative;">
                            <span class="input-icon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="mod_password" name="password" placeholder="Escriba su Password" required>
                            <span class="password-toggle" onclick="togglePasswordVisibility('mod_password')">
                                <i id="mod_password-toggle-icon" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-morado">Modificar Usuario</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar enlaces a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Función para mostrar/ocultar contraseña
        function togglePasswordVisibility(id) {
            var passwordInput = document.getElementById(id);
            var toggleIcon = document.getElementById(id + '-toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Manejar clic en botón de modificar
        $(document).on('click', '.modificar-btn', function() {
            var id = $(this).data('id');
            var nombres = $(this).data('nombres');
            var apellidos = $(this).data('apellidos');
            var email = $(this).data('email');
            var rol = $(this).data('rol');

            // Llenar el formulario del modal
            $('#mod_id_usuario').val(id);
            $('#mod_nombres').val(nombres);
            $('#mod_apellidos').val(apellidos);
            $('#mod_email').val(email);
            $('#mod_rol').val(rol);

            // Verificar si se debe mostrar campo de email
            if (rol === 'usuario') {
                $('#email_grupo_modificar').hide();
                $('#mod_email').prop('required', false);
            } else {
                $('#email_grupo_modificar').show();
                $('#mod_email').prop('required', true);
            }

            // Mostrar el modal
            $('#modalModificarUsuario').modal('show');
        });

        // Controlar visibilidad del campo email según el rol seleccionado
        $('#rol_agregar').on('change', function() {
            if ($(this).val() === 'usuario') {
                $('#email_grupo_agregar').hide();
                $('#email_agregar').prop('required', false);
            } else {
                $('#email_grupo_agregar').show();
                $('#email_agregar').prop('required', true);
            }
        });

        // Hacer lo mismo para el formulario de modificar
        $('#mod_rol').on('change', function() {
            if ($(this).val() === 'usuario') {
                $('#email_grupo_modificar').hide();
                $('#mod_email').prop('required', false);
            } else {
                $('#email_grupo_modificar').show();
                $('#mod_email').prop('required', true);
            }
        });

        // Inicializar campos al cargar la página
        $(document).ready(function() {
            // Verificar rol inicial al abrir modal de agregar
            $('#modalAgregarUsuario').on('shown.bs.modal', function() {
                if ($('#rol_agregar').val() === 'usuario') {
                    $('#email_grupo_agregar').hide();
                    $('#email_agregar').prop('required', false);
                } else {
                    $('#email_grupo_agregar').show();
                    $('#email_agregar').prop('required', true);
                }
            });
        });

        // Formulario Agregar - Envío AJAX
        $('#formAgregar').on('submit', function(e) {
            e.preventDefault();

            // Mostrar mensaje de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Deseas agregar este usuario!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1AEB01',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, agregar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1AEB01'
                                }).then(() => {
                                    // Cerrar el modal
                                    $('#modalAgregarUsuario').modal('hide');
                                    // Recargar la página
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1AEB01'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al procesar la solicitud: ' + error,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#1AEB01'
                            });
                        }
                    });
                }
            });
        });

        // Formulario Modificar - Envío AJAX
        $('#formModificar').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Deseas modificar este usuario!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1AEB01',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, modificar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                icon: response.status === 'success' ? 'success' : 'error',
                                title: response.status === 'success' ? 'Éxito' : 'Error',
                                text: response.message || 'Usuario modificado correctamente',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#1AEB01'
                            }).then(() => {
                                if (response.status === 'success') {
                                    // Cerrar el modal
                                    $('#modalModificarUsuario').modal('hide');
                                    // Recargar la página
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Intentar analizar la respuesta como JSON
                            try {
                                var errorResponse = JSON.parse(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorResponse.message || 'Ocurrió un error al modificar el usuario.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1AEB01'
                                });
                            } catch (e) {
                                // Si no es JSON, mostrar mensaje genérico
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al modificar el usuario.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1AEB01'
                                });
                            }
                        }
                    });
                }
            });
        });

        // Confirmación de eliminación
        $('.eliminar-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Deseas eliminar este usuario!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: form.attr('action'),
                        data: form.serialize(),
                        success: function(response) {
                            try {
                                const res = JSON.parse(response);
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: res.message,
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#1AEB01'
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message,
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#d33'
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Usuario eliminado correctamente',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1AEB01'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });

        // Confirmación de deshabilitación
        $('.deshabilitar-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Deseas deshabilitar este usuario!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffbb33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, deshabilitar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: form.attr('action'),
                        data: form.serialize(),
                        success: function(response) {
                            try {
                                const res = JSON.parse(response);
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: res.message,
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#1AEB01'
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message,
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#d33'
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Usuario deshabilitado correctamente',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#1AEB01'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>