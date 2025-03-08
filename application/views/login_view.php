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
            color: #bb0533;
            /* Color del texto */
        }

        input {
            color: #bb0533;
            /* Aplica el color a todo el cuerpo */
        }

        /* Estilos para el contenedor principal con video de fondo */
        .main {
            width: 350px;
            height: 390px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0px 2px 50px #6e6262e0;
            opacity: 0;
            /* Empieza invisible */
            position: relative;
            /* Para posicionar el video */
            z-index: 1;
            /* Para asegurar que el contenido esté por encima del video */
        }

        /* Video de fondo */
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Para que el video cubra todo el contenedor */
            z-index: -1;
            /* Para que esté detrás del contenido */
            border-radius: 10px;
            /* Mismo radio de borde que el contenedor */
        }

        /* Overlay para hacer el contenido más legible */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Fondo negro semitransparente */
            z-index: 0;
            border-radius: 10px;
        }

        /* Asegurar que el contenido esté por encima del video y overlay */
        .login,
        #main-ver {
            position: relative;
            z-index: 2;
        }

        /* Ajustar los colores para mejor legibilidad con el video de fondo */
        label {
            text-shadow: 0 0 8px rgba(0, 0, 0, 0.8);
        }

        #olv {
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
        }
    </style>
</head>

<body>
    <div class="btn-container">
        <a href="<?php echo site_url('inicio'); ?>" class="btn-inicio">
            <i class="bx bx-home"></i> <span>INICIO</span>
        </a>
    </div>

    <div class="main">
        <!-- Video de fondo -->
        <video class="video-background" autoplay loop muted playsinline>
            <source src="<?php echo base_url('assets/img/fondo_login.mp4'); ?>" type="video/mp4">
        </video>

        <!-- Overlay para mejorar legibilidad -->
        <div class="overlay"></div>

        <?php if (isset($mostrar_codigo_verificacion) && $mostrar_codigo_verificacion): ?>
            <!-- Mostrar el campo para el código de verificación -->
            <form id="main-ver" method="post" action="<?php echo base_url('index.php/Login/validate_login'); ?>" onsubmit="showLoadingMessage('loadingMessageMain');">

                <input type="hidden" name="login" value="<?php echo htmlspecialchars($this->session->userdata('temp_login')['login']); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($this->session->userdata('temp_login')['password']); ?>">
                <div class="">
                    <label for="codigo_verificacion">Verificando....</label>
                    <video class="video-lo" src="<?php echo base_url('assets/img/candado.mp4'); ?>" autoplay loop muted style="display: block; margin: 10px auto; width: 100px; height: 100px;"></video>
                    <br>
                    <input type="text" name="codigo_verificacion" id="codigo_verificacion" placeholder="Código de verificación" class="form-control verification-code" required>
                </div>
                <button type="submit" id="SingIn-b"><i class="bx bx-lock"></i> Verificar código</button>
                <div class="loading-message" id="loadingMessageMain">Verificando.......</div>
            </form>
        <?php else: ?>

            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="login">
                <!-- Mostrar el formulario de login normal -->
                <form id="login-form" action="<?php echo site_url('login/validate_login'); ?>" method="POST" onsubmit="showLoadingMessage('loadingMessageLogin');">
                    <label for="chk" aria-hidden="true">LOG IN</label>
                    <input type="text" name="login" id="userLogin" placeholder="Login" required="">
                    <div class="password-container">
                        <input type="password" name="password" id="loginPasswordInput" placeholder="Password" required="">
                        <span class="password-toggle" onclick="togglePasswordVisibility('loginPasswordInput', 'login-password-toggle-icon')">
                            <i id="login-password-toggle-icon" class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                    <div>
                        <button type="submit" id="SingIn-b"><i class="bx bx-user"></i> LOG IN</button>
                    </div>
                    <div class="loading-message" id="loadingMessageLogin">Iniciando.......</div>
                </form>
                <br>
                <a id="olv" href="<?php echo site_url('login/reset_password'); ?>">Olvidaste tu contraseña?</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showLoadingMessage(messageId) {
            // Muestra el mensaje de carga correspondiente
            var loadingMessage = document.getElementById(messageId);
            if (loadingMessage) {
                loadingMessage.style.display = 'block';
            }
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

            // Mostrar mensaje de bienvenida si el campo de verificación está presente
            if (document.querySelector('.verification-code')) {
                Swal.fire({
                    title: '¡Bienvenido a Drinkmaster!',
                    html: '<strong>Verifiquemos tu cuenta</strong><p>Ingresa el código enviado a tu correo.</p>',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            }

            // Asegurar que el video de fondo se reproduzca
            var videoBackground = document.querySelector('.video-background');
            if (videoBackground) {
                videoBackground.play().catch(function(error) {
                    console.log('Error al reproducir el video:', error);
                });
            }
        });

        function togglePasswordVisibility(inputId, iconId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = document.getElementById(iconId);

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
</body>

</html>