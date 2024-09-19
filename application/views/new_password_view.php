<!DOCTYPE html>
<html>
<head>
    <title>DRINK | RESET</title>
    <link href="<?php echo base_url(); ?>assets-ini/assets/img/logo_drink.jpg" rel="icon">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets-ini/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/venobox/venobox.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .swal2-confirm {
            display: flex;
            justify-content: center;
            width: 60px;
        }
        .loading-message {
            display: none;
            text-align: center;
            font-size: 18px;
            color: #bb0533; /* Color del texto */
        }
        /* Color del texto en otras partes */
        body {
            color: #bb0533; /* Aplica el color a todo el cuerpo */
        }
        label, input {
            color: #bb0533; /* Aplica el color a etiquetas, inputs y botones */
        }
    </style>
</head>
<body>

    <div class="main">   
        <input type="checkbox" id="chk" aria-hidden="true">
        
        <div class="login">
            <form id="login-form" action="<?php echo site_url('login/update_password'); ?>" method="POST" onsubmit="showLoadingMessage();">
                <label for="chk" aria-hidden="true">NUEVO PASSWORD</label>
                <video class="video-lo" src="<?php echo base_url('assets/img/candado.mp4'); ?>" autoplay loop muted style="display: block; margin: 10px auto; width: 100px; height: 100px;"></video>
                <br>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"> <!-- Agregado el campo token -->
                <div class="password-container">
                    <input type="password" name="new_password" id="loginPasswordInput" placeholder="Password" required="">
                    <span class="password-toggle" onclick="togglePasswordVisibility('loginPasswordInput')">
                        <i id="login-password-toggle-icon" class="zmdi zmdi-eye"></i>
                    </span>
                </div>
                <div>
                    <button type="submit" id="SingIn-b"><i class="bx bx-mail-send"></i> Restablecer</button>
                </div>
            </form>

            <div class="loading-message" id="loadingMessage">Restableciendo password, por favor espera...</div>
            <br>
        </div>

        <script>
            function showLoadingMessage() {
                // Muestra el mensaje de carga
                document.getElementById('loadingMessage').style.display = 'block';
            }

            document.addEventListener('DOMContentLoaded', function() {
                <?php if ($this->session->flashdata('error_msg')): ?>
                    Swal.fire({
                        title: 'Error',
                        text: '<?php echo addslashes($this->session->flashdata('error_msg')); ?>',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                <?php elseif ($this->session->flashdata('success_msg')): ?>
                    Swal.fire({
                        title: 'Éxito',
                        text: '<?php echo addslashes($this->session->flashdata('success_msg')); ?>',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                <?php endif; ?>

                // Validación de contraseña en el formulario de restablecimiento
                document.getElementById('login-form').addEventListener('submit', function(event) {
                    var newPassword = document.getElementById('loginPasswordInput').value;
                    var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;

                    if (!passwordPattern.test(newPassword)) {
                        event.preventDefault(); // Evita el envío del formulario
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'La contraseña debe contener al menos 8 caracteres, un número, una letra mayúscula y un símbolo.',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    }
                });
            });

            function togglePasswordVisibility(inputId) {
                var passwordInput = document.getElementById(inputId);
                var toggleIcon = document.getElementById('login-password-toggle-icon'); // Corregido

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

            window.addEventListener('load', function() {
                var preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }

                // Agrega la clase para activar la animación
                var mainElement = document.querySelector('.main');
                if (mainElement) {
                    mainElement.classList.add('window-effect');
                }
            });
        </script>

        <div id="preloader"></div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
        <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/venobox/venobox.min.js"></script>
    </div>
</body>
</html>
