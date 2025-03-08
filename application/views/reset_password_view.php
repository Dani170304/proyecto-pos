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
            color: #bb0533;
            /* Color del texto */
        }

        /* Color del texto en otras partes */
        body,
        input {
            color: #bb0533;
            /* Aplica el color a todo el cuerpo */
        }
    </style>
</head>

<body>
    <div class="btn-container">
        <a href="<?php echo site_url('login/index'); ?>" class="btn-inicio">
            <i class="bx bx-home"></i> <span>ATRAS</span>
        </a>
    </div>
    <div class="main">

        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="login">

            <form id="login-form" action="<?php echo site_url('login/send_reset_link'); ?>" method="POST" onsubmit="showLoadingMessage();">
                <label for="chk" aria-hidden="true">RESTABLECER PASSWORD</label>
                <video class="video-lo" src="<?php echo base_url('assets/img/candado.mp4'); ?>" autoplay loop muted style="display: block; margin: 10px auto; width: 100px; height: 100px;"></video>
                <br>
                <input type="email" name="email" id="userEmail" placeholder="Email" required="">
                <div>
                    <button type="submit" id="SingIn-b"><i class="bx bx-mail-send"></i> Enviar correo</button>
                </div>
            </form>

            <div class="loading-message" id="loadingMessage">Enviando correo, por favor espera...</div>
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
            });

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