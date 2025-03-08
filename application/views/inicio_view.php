<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>assets-ini/assets/img/logo_drink.jpg" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets-ini/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url(); ?>assets-ini/assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex flex-column justify-content-center">
    <nav class="nav-menu">
      <ul>
        <li class="active"><a href="#hero"><i class="bx bx-home"></i> <span>INICIO</span></a></li>
        <li><a href="<?php echo site_url('login'); ?>"><i class="bx bx-user"></i> <span>LOG IN</span></a></li>
      </ul>
    </nav>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <h1 id="text">DRINKMASTER</h1>
      <h2>Disfruta cada sorbo con estilo!</h2>
      <br> 
      <p><span class="typed" data-typed-items="¡Haz de cada bebida un evento!, ¡Sabor y diversión en cada copa!, Tu experiencia de bebida mejorada., Brindemos por los buenos tiempos."></span></p>
      <br>
      <div class="social-links">
        <a href="https://www.facebook.com/" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
        <a href="https://www.instagram.com/" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>DRINKMASTER</h3>
      <p>Ofrecemos las mejores bebidas para cada ocasión, asegurando una experiencia única y deliciosa.</p>
      <div class="social-links">
        <a href="https://www.facebook.com/" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="https://www.instagram.com/" class="instagram"><i class="bx bxl-instagram"></i></a>
      </div>
      <div class="copyright">
        &copy; Copyright <strong><span>Daniela Coca</span></strong>. Derechos reservados
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/counterup/counterup.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/typed.js/typed.min.js"></script>
  <script src="<?php echo base_url(); ?>assets-ini/assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url(); ?>assets-ini/assets/js/main.js"></script>

  <script>
    /* EFECTO LETRAS MOVIENDOSE */
    document.addEventListener('scroll', function() {
      const textElement = document.getElementById('text');
      const scrollPosition = window.scrollY;
      textElement.style.marginLeft = scrollPosition * 2 + 'px';
      textElement.style.marginTop = scrollPosition * 1 + 'px';
    });
  </script>

</body>
</html>
