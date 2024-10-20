<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .form-control {
            position: relative;
            padding-left: 40px; /* Deja espacio para el icono */
        }
        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            color: #999;
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2; /* Asegura que el ícono esté encima del input */
        }
        .btn-morado {
            background-color: #6f42c1; /* Color morado */
            color: white; /* Color del texto */
        }
        .btn-morado:hover {
            background-color: #563d7c; /* Color morado más oscuro para el hover */
            color: white;
        }
        .swal2-confirm {
            display: flex;
            justify-content: center;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Modificar Evento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Eventos/index">Home</a></li>
                        <li class="breadcrumb-item active">Modificar Evento</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Main content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php foreach ($infoevento->result() as $row): ?>
                                <?php echo form_open('Eventos/modificareventodb', ['id' => 'formModificarEvento', 'enctype' => 'multipart/form-data']); ?>
    <input type="hidden" name="id_evento" value="<?php echo $row->id_evento; ?>">
    <input type="hidden" name="imagen_actual" value="<?php echo $row->imagen_evento; ?>"> <!-- Imagen actual -->

    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" name="nombre" placeholder="Escriba nombre del evento" maxlength="50" value="<?php echo $row->nombre_evento; ?>" required>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-envelope"></i></span>
            <input type="text" class="form-control" name="descripcion" placeholder="Escriba la descipcion" value="<?php echo $row->descripcion; ?>" required>
        </div>
    </div>

    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-image"></i></span>
            <input type="file" class="form-control" name="imagen" accept="image/*">
            <?php if (isset($row->imagen_evento) && !empty($row->imagen_evento)): ?>
                <p>Imagen actual: <?php echo $row->imagen_evento; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
                                <div style="position: relative;" onclick="this.querySelector('input').focus();">
                                    <span class="input-icon"><i class="fa fa-calendar"></i></span> <!-- Icono para fecha de inicio -->
                                    <input type="date" class="form-control" name="fecha" placeholder="Selecciona una fecha" value="<?php echo $row->fecha_inicio; ?>" required>
                                </div>
                            </div>
    <br>
    <button type="submit" class="btn btn-morado">Modificar Evento</button>
<?php echo form_close(); ?>

                            <?php endforeach; ?>
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
<script>
    $(document).ready(function() {
    $('#formModificarEvento').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío normal del formulario
        const form = $(this);

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Deseas modificar este evento!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, modificar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: new FormData(form[0]), // Usar FormData para permitir la subida de archivos
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            icon: response.success ? 'success' : 'error',
                            title: response.success ? 'Éxito' : 'Error',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: response.success ? '#1AEB01' : '#d33'
                        }).then(() => {
                            if (response.success) {
                                window.location.href = '<?php echo base_url(); ?>index.php/Eventos/index'; 
                            }
                        });
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