<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
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
                    <h1>Modificar Producto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Admin/productos">Home</a></li>
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
                                <?php echo form_open_multipart("Admin/modificarproductodb"); ?>
                                
                                <?php if ($this->session->flashdata('error_msg')): ?>
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: '<?php echo $this->session->flashdata('error_msg'); ?>',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#1AEB01',
                                            customClass: {
                                                confirmButton: 'swal2-confirm'
                                            }
                                        });
                                    </script>
                                <?php endif; ?>

                                <input type="hidden" name="id_producto" value="<?php echo $row->id_producto; ?>" required>

                                <div class="form-group">
                                    <div style="position: relative;">
                                        <span class="input-icon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="nombre" placeholder="Escriba nombre del producto" maxlength="20" value="<?php echo $row->nombre; ?>" required>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-file-alt"></i></span>
                                        <select class="form-control" name="categoria" required>
                                            <option value="" disabled <?php echo ($row->categoria == '') ? 'selected' : ''; ?>>Seleccione la categoria</option>
                                            <option value="botella" <?php echo ($row->categoria == 'botella') ? 'selected' : ''; ?>>Botella</option>
                                            <option value="coctel" <?php echo ($row->categoria == 'coctel') ? 'selected' : ''; ?>>Coctel</option>
                                            <option value="soda" <?php echo ($row->categoria == 'soda') ? 'selected' : ''; ?>>Sosa</option>
                                            <option value="cerveza" <?php echo ($row->categoria == 'cerveza') ? 'selected' : ''; ?>>Cerveza</option>
                                            <option value="piqueo" <?php echo ($row->categoria == 'piqueo') ? 'selected' : ''; ?>>Piqueo</option>

                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="stock" placeholder="Escriba el stock" value="<?php echo $row->stock; ?>" required>
                                </div>
                                <br>
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="precio" placeholder="Escriba el precio" value="<?php echo $row->precio; ?>" required>
                                </div>
                                <br>
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-image"></i></span>
                                    <input type="file" class="form-control" name="imagen" accept="image/*" placeholder="Seleccione la imagen">
                                    <?php if (isset($row->imagen) && !empty($row->imagen)): ?>
                                        <p>Imagen seleccionada: <?php echo $row->imagen; ?></p>
                                    <?php endif; ?>
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

</body>
</html>
