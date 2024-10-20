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
                    <h1 id="title">Agregar Usuario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Supervisor/index">Home</a></li>
                        <li class="breadcrumb-item active">Agregar Usuario</li>
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
                            <?php echo form_open_multipart("Admin/agregarbd", ['id' => 'formAgregar']); ?>

                            <div class="form-group">
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="nombres" placeholder="Escriba sus Nombres" maxlength="20" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div style="position: relative;">
                                    <span class="input-icon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="apellidos" placeholder="Escriba sus Apellidos" maxlength="20" required>
                                </div>
                            </div>
                            <br>
                            <div style="position: relative;">
                                <span class="input-icon"><i class="fa fa-file-alt"></i></span>
                                <select class="form-control" name="rol" required>
                                    <option value="" disabled selected>Seleccione su rol</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="usuario">Usuario/Cliente</option>
                                </select>
                            </div>
                            <br>
                            <div style="position: relative;">
                                <span class="input-icon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Escriba su Email" required>
                            </div>
                            <br>
                            <div style="position: relative;">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Escriba su Password" required
                                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                <span class="password-toggle" onclick="togglePasswordVisibility('password')">
                                    <i id="password-toggle-icon" class="zmdi zmdi-eye"></i>
                                </span>
                            </div>
                            <small class="form-text text-muted">
                                La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula y un número.
                            </small>
                            <br>
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
