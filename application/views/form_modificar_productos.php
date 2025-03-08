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
                <div class="col-sm-12">
                    <h1 id="title">Modificar Producto</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Productos/productos">Home</a></li>
                        <li class="breadcrumb-item active">Modificar Producto</li>
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
                            <?php foreach ($infoproducto->result() as $row): ?>
                                <?php echo form_open('Productos/modificarproductodb', ['id' => 'formModificarProducto', 'enctype' => 'multipart/form-data']); ?>
    <input type="hidden" name="id_producto" value="<?php echo $row->id_producto; ?>">
    <input type="hidden" name="imagen_actual" value="<?php echo $row->imagen; ?>"> <!-- Imagen actual -->

    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" name="nombre" placeholder="Escriba nombre del producto" maxlength="50" value="<?php echo $row->nombre; ?>" required>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-file-alt"></i></span>
            <select class="form-control" name="categoria" required>
                <option value="" disabled <?php echo ($row->categoria == '') ? 'selected' : ''; ?>>Seleccione la categoria</option>
                <option value="botella" <?php echo ($row->categoria == 'BOTELLA') ? 'selected' : ''; ?>>Botella</option>
                <option value="coctel" <?php echo ($row->categoria == 'COCTEL') ? 'selected' : ''; ?>>Coctel</option>
                <option value="soda" <?php echo ($row->categoria == 'SODA') ? 'selected' : ''; ?>>Soda</option>
                <option value="cerveza" <?php echo ($row->categoria == 'CERVEZA') ? 'selected' : ''; ?>>Cerveza</option>
                <option value="piqueo" <?php echo ($row->categoria == 'PIQUEO') ? 'selected' : ''; ?>>Piqueo</option>
                <option value="combo" <?php echo ($row->categoria == 'COMBO') ? 'selected' : ''; ?>>Soda-Combo</option>
            </select>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-envelope"></i></span>
            <input type="number" class="form-control" name="stock" placeholder="Escriba el stock" value="<?php echo $row->stock; ?>" required>
        </div>
    </div>
    <br>
    <div class="form-group">
    <div style="position: relative;">
        <span class="input-icon"><i class="fa fa-dollar-sign"></i></span>
        <input type="text" 
               class="form-control" 
               name="precio" 
               placeholder="Escriba el precio" 
               value="<?php echo htmlspecialchars($row->precio); ?>" 
               required 
               pattern="^\d+([,.]\d{1,2})?$" 
               title="Ingrese un número válido con hasta dos decimales (use . o , como separador)" 
               inputmode="decimal" 
               oninput="this.value = this.value.replace(/[^0-9.,]/g, '');">
    </div>
</div>

    <br>
    <div class="form-group">
        <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-image"></i></span>
            <input type="file" class="form-control" name="imagen" accept="image/*">
            <?php if (isset($row->imagen) && !empty($row->imagen)): ?>
                <p>Imagen actual: <?php echo $row->imagen; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-morado">Modificar Producto</button>
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
    $('#formModificarProducto').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío normal del formulario
        const form = $(this);

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Deseas modificar este producto!",
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
                                window.location.href = '<?php echo base_url(); ?>index.php/Productos/productos'; 
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