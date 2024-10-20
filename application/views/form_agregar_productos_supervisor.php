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
            z-index: 2; 
        }
        .btn-morado {
            background-color: #6f42c1; /* Color morado */
            color: white; /* Color del texto */
        }
        .btn-morado:hover {
            background-color: #563d7c; /* Color morado más oscuro para el hover */
            color: white;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Agregar Producto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Productos_supervisor/productos">Home</a></li>
                        <li class="breadcrumb-item active">Agregar Producto</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php echo form_open_multipart("Productos_supervisor/agregarproductobd", ['id' => 'formAgregar']); ?>

                            <div class="form-group">
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="nombre" placeholder="Escriba nombre del producto" maxlength="20" required>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-file-alt"></i></span>
                                        <select class="form-control" name="categoria" required>
                                            <option value="" disabled>Seleccione la categoria</option>
                                            <option value="botella" >Botella</option>
                                            <option value="coctel" >Coctel</option>
                                            <option value="soda">Soda</option>
                                            <option value="cerveza" >Cerveza</option>
                                            <option value="piqueo" >Piqueo</option>

                                        </select>
                                    </div>
                                </div>
                            <div class="form-group">
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="stock" placeholder="Escriba el stock"  required>
                                </div>
                            </div>
                            <div style="position: relative;">
                                <span class="input-icon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="precio" placeholder="Escriba el precio" required>
                            </div>
                            <br>
                            <div style="position: relative;">
                                <span class="input-icon"><i class="fa fa-image"></i></span>
                                <input type="file" class="form-control" name="imagen" accept="image/*" placeholder="Seleccione la imagen" required>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-morado">Agregar Usuario</button>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function togglePasswordVisibility(id) {
        var passwordInput = document.getElementById(id);
        var toggleIcon = document.getElementById('password-toggle-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('zmdi-eye');
            toggleIcon.classList.add('zmdi-eye-off');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('zmdi-eye-off');
            toggleIcon.classList.add('zmdi-eye');
        }
    }

    $(document).ready(function() {
        $('#formAgregar').on('submit', function(e) {
            e.preventDefault(); 
            
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
                            confirmButtonColor: '#1AEB01',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        }).then(() => {
                            window.location.href = 'index'; 
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#1AEB01',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    }
                }
            });
        });
    });
</script>

</body>
</html>
