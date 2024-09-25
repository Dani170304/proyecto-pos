<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="tu-estilo.css"> <!-- Asegúrate de tener el archivo CSS correcto -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carga de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga de SweetAlert -->
    <style>
        .btn {
            font-weight: bold;
        }
        .btn-morado {
            background-color: #6f42c1; /* Color morado */
            color: white; /* Color del texto */
        }
        .btn-morado:hover {
            background-color: #563d7c; /* Color morado más oscuro para el hover */
            color: white;
        }
        .btn-warning {
            float: right;
            margin-right: 7px;
        }
        .text-center {
            text-align: center; /* Centra el contenido horizontalmente */
        }
        .color-num {
            color: #083CC2;
            font-weight: bold;
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
                    <div class="col-sm-6">
                        <h1 id="title">LISTA DE USUARIOS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Admin/index">Home</a></li>
                            <li class="breadcrumb-item active">Tablas</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <br>
        <a href="<?php echo base_url(); ?>index.php/Admin/index">
            <button type="button" class="btn btn-warning">Ver lista</button>
            <br><br>
        </a>
        <div class="card-info">
            <div class="card-header">
                <h3 class="card-title">LISTA</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Habilitar</th>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1;
                        foreach ($usuarios->result() as $row) {
                        ?>
                            <tr>
                                <td> <?php echo $contador ?></td>
                                <td><?php echo $row->nombres; ?></td>
                                <td><?php echo $row->apellidos; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->rol; ?></td>
                                <td><?php echo $row->estado; ?></td>
                                <td>
                                    <?php echo form_open_multipart("Admin/habilitarbd", ['class' => 'formHabilitar']); ?>
                                    <input type="hidden" name="id_usuario" value="<?php echo $row->id_usuario; ?>">
                                    <button type="button" class="btn btn-morado habilitar-btn"><i class="fas fa-check-circle"></i></button>
                                    <?php echo form_close(); ?>
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
    <!-- /.content-wrapper -->

    <script>
$(document).ready(function() {
    // Confirmación de habilitación
    $('.habilitar-btn').on('click', function(e) {
        e.preventDefault(); // Prevenir el comportamiento predeterminado del botón
        const form = $(this).closest('form'); // Obtener el formulario más cercano

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Deseas habilitar este usuario!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, habilitar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: res.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#1AEB01'
                            }).then(() => {
                                window.location.href = '<?php echo base_url(); ?>index.php/Admin/index'; 
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
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });
});

    </script>
</body>
</html>
