<!DOCTYPE html>
<html>
<head>
    <title>DRINK | LOGIN</title>
    <link href="<?php echo base_url(); ?>assets-ini/assets/img/logo_drink.jpg" rel="icon">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets-ini/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/venobox/venobox.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<style>
    .swal2-confirm {
        display: flex;
        justify-content: center;
        width: 60px;
    }
</style>
<body>
    <div class="btn-container">
        <a href="<?php echo site_url('inicio'); ?>" class="btn-inicio">
            <i class="bx bx-home"></i> <span>INICIO</span>
        </a>
    </div>
    <div class="main">   

    <?php if (isset($mostrar_codigo_verificacion) && $mostrar_codigo_verificacion): ?>
    <!-- Mostrar el campo para el código de verificación -->
    <form id="main-ver" method="post" action="<?php echo base_url('index.php/Login/validate_login'); ?>">
        
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($this->session->userdata('temp_login')['email']); ?>">
        <input type="hidden" name="password" value="<?php echo htmlspecialchars($this->session->userdata('temp_login')['password']); ?>">
        <div class="">
            <label for="codigo_verificacion">Verificando....</label>
            <video class="video-lo" src="<?php echo base_url('assets/img/candado.mp4'); ?>" autoplay loop muted style="display: block; margin: 10px auto; width: 100px; height: 100px;"></video>
            <br>
            <input type="text" name="codigo_verificacion" id="codigo_verificacion" placeholder="Código de verificación" class="form-control verification-code" required>
        </div>
        <button type="submit" id="SingIn-b"><i class="bx bx-lock"></i> Verificar codigo</button>
    </form>
<?php endif; ?>
        <input type="checkbox" id="chk" aria-hidden="true">
        
        <div class="login">

            <?php if (!isset($mostrar_codigo_verificacion) || !$mostrar_codigo_verificacion): ?>
                <!-- Mostrar el formulario de login normal -->
                <form id="login-form" action="<?php echo site_url('login/validate_login'); ?>" method="POST">
                    <label for="chk" aria-hidden="true">LOG IN</label>
                    <input type="email" name="email" id="userEmail" placeholder="Email" required="">
                    <div class="password-container">
                        <input type="password" name="password" id="loginPasswordInput" placeholder="Password" required="">
                        <span class="password-toggle" onclick="togglePasswordVisibility('loginPasswordInput')">
                            <i id="login-password-toggle-icon" class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                    <div>
                        <button type="submit" id="SingIn-b"><i class="bx bx-user"></i> LOG IN</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <div class="signup">
            <form action="<?php echo site_url('login/validate_signup'); ?>" method="POST" id="signupForm">
                <label id="label-si" for="chk" aria-hidden="true">SIGN UP</label>
                <input type="text" name="nombre" id="signupNombre" placeholder="Nombre" required="">
                <input type="text" name="apellido" id="signupApellido" placeholder="Apellido" required="">
                <input type="email" name="email" id="signupEmail" placeholder="Email" required="">
                <div class="password-container">
                    <input type="password" name="password" id="signupPasswordInput" placeholder="Password" required="">
                    <span class="password-toggle" onclick="togglePasswordVisibility('signupPasswordInput')">
                        <i id="signup-password-toggle-icon" class="zmdi zmdi-eye"></i>
                    </span>
                </div>
                <div class="g-recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="6LfifAQqAAAAACWV8ZpG_1ZcgLMsyd-gPeAc1oKF"></div>
                </div>
                <button type="submit" id="SingUp-b"><i class="bx bx-file"></i> SIGN UP</button>
            </form>
        </div>

        <script>
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

                // Mostrar mensaje de bienvenida si el campo de verificación está presente
                if (document.querySelector('.verification-code')) {
                    Swal.fire({
                        title: '¡Bienvenido a Drinkmaster!',
                        html: '<strong>Verifiquemos tu cuenta</strong><p>Inicia sesión nuevamente e ingresa el código enviado a tu correo.</p>',
                        icon: 'info',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                }
            });

            // Validar la contraseña en el formulario de registro
            document.getElementById('signupForm').addEventListener('submit', function(event) {
                var password = document.getElementById('signupPasswordInput').value;
                var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

                if (!passwordPattern.test(password)) {
                    event.preventDefault(); // Evita el envío del formulario
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'La contraseña no cumple con los requisitos de seguridad debe contener, <strong>simbolos</strong> o <strong>numeros</strong>.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#1AEB01',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                }
            });

            function togglePasswordVisibility(inputId) {
                var passwordInput = document.getElementById(inputId);
                var toggleIcon = document.getElementById('signup-password-toggle-icon');

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
