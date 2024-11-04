
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>assets-ini/assets/img/logo_drink.jpg" rel="icon">
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

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
  <link href="<?php echo base_url(); ?>assets-ini/assets/css/cambios.css" rel="stylesheet">
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
        <li><a href="#services"><i class="bx bx-server"></i> <span>EVENTOS</span></a></li>
        <li><a href="#resume"><i class="bx bx-file"></i> <span>NOSOTROS</span></a></li>
        <li><a href="#contact"><i class="bx bx-envelope"></i> <span>CONTACTO</span></a></li>
        <li><a href="<?php echo site_url('login'); ?>"><i class="bx bx-user"></i> <span>LOG IN</span></a></li>
      </ul>
    </nav><!-- .nav-menu -->
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <h1 id="text">DRINKMASTER</h1>
      <h2>Disfruta cada sorbo con estilo!</h2>
      <br> 
      <p><span class="typed" data-typed-items="¡Haz de cada bebida un evento!, ¡Sabor y diversión en cada copa!, Tu experiencia de bebida mejorada.,Brindemos por los buenos tiempos."></span></p>
      <br>
      <br>
      <div class="social-links">
        <a href="https://www.facebook.com/" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
        <a href="https://www.instagram.com/" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">
        <!-- ======= Events Section ======= -->
<!-- views/eventsView.php -->
<section id="services" class="services">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>EVENTOS</h2>
      <p>Escoge tu evento y sigue deleitándote con tus bebidas favoritas.</p>
    </div>

    <div class="row">
      <?php if (empty($eventos)): ?>
      <?php else: ?>
        <?php foreach ($eventos as $evento): ?>
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <a href="<?php echo site_url('login'); ?>">
            <div class="icon-box iconbox-blue">
              <div class="icon">
                <?php
                $foto = $evento['imagen_evento'];
                ?>
                <img class="imagen_evento" src="<?php echo base_url()?>/assets/imagenes_eventos/<?php echo $foto ?>" alt="<?php echo $evento['nombre_evento']; ?>" />

              </div>
              
              <h4><a><?php echo $evento['nombre_evento']; ?></a></h4>
              <?php
              // Arreglo de meses en español
              $meses = [
                  1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 
                  5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 
                  9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
              ];

              $fechaInicio = new DateTime($evento['fecha_inicio']);
              $mes = $meses[(int)$fechaInicio->format('m')]; // Obtener el nombre del mes en español
              ?>
              <p class="fecha"><strong>FECHA INICIO:</strong> <?php echo $fechaInicio->format("d") . " de " . $mes . " " . "de ". $fechaInicio->format("Y"); ?></p>

              <p class="descripcion"><?php echo $evento['descripcion']; ?></p>
            </div>
          </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section><!-- End Events Section -->
    <!-- ======= Resume Section ======= -->
    <section id="resume" class="resume">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>NOSOTROS</h2>
          <p>En DrinkMaster, nos especializamos en crear momentos memorables a través de una selección exclusiva de bebidas. Nuestro compromiso es ofrecer experiencias únicas mediante un portafolio diverso y refinado que se ajusta a cada ocasión. Con un equipo apasionado y un enfoque en la excelencia, nos esforzamos por elevar cada evento al más alto nivel de sofisticación y disfrute.</p>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <h3 class="resume-title">INTRODUCCION</h3>
            <div class="resume-item pb-0">
              <h4>Sobre Nosotros</h4>
              <p><em>Fundado en 2024, DrinkMaster se ha establecido rápidamente como un líder en la industria de bebidas. Nuestro enfoque en la calidad y la innovación nos distingue en el mercado, ofreciendo productos que no solo satisfacen sino que superan las expectativas de nuestros clientes.</em></p>
              <ul>
                <li>Visión: Ser el proveedor preferido de bebidas para eventos y celebraciones.</li>
                <li>Misión: Ofrecer productos de alta calidad y un servicio excepcional.</li>
                <li>Valores: Calidad, Innovación, Servicio al Cliente, Integridad.</li>
              </ul>
            </div>

            <h3 class="resume-title">SERVICIOS</h3>
            <div class="resume-item">
              <h4>Catálogo de Bebidas &amp; Servicios de Catering</h4>
              <h5>Para Eventos Especiales</h5>
              <p><em>Ofrecemos una extensa gama de bebidas adaptadas a cualquier tipo de evento, desde bodas hasta eventos corporativos.</em></p>
              <p>En DrinkMaster, entendemos que cada evento es único. Por eso, nuestro catálogo incluye una variedad de opciones, desde cócteles exclusivos hasta bebidas tradicionales, para satisfacer las necesidades y preferencias de nuestros clientes.</p>
            </div>
            <div class="resume-item">
              <h4>Asesoría en Eventos &amp; Personalización</h4>
              <h5>Consultoría Especializada</h5>
              <p><em>Nuestros expertos están disponibles para ayudarte a planificar el aspecto de bebidas de tu evento, asegurando que cada detalle sea perfecto.</em></p>
              <p>Además de nuestro catálogo, ofrecemos servicios de asesoría para personalizar la selección de bebidas de acuerdo a la temática y los requisitos específicos de tu evento, asegurando una experiencia memorable.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <h3 class="resume-title">EQUIPO</h3>
            <div class="resume-item">
              <h4>BENJAMIN FRONTANILLA</h4>
              <h5>Gerente &amp; Director General</h5>
              <p><em>Con experiencia en la industria de realización de eventos, Benjamin lidera nuestro equipo con pasión y dedicación.</em></p>
              <ul>
                <li>Experiencia en gestión de eventos y servicios de catering.</li>
                <li>Especialista en desarrollo de nuevos productos y tendencias del mercado.</li>
              </ul>
            </div>
            <div class="resume-item">
              <h4>DANIELA COCA</h4>
              <h5>DEVELOPER</h5>
              <p><em>Daniela es la mente maestra detrás de nuestras soluciones tecnológicas, garantizando que nuestras herramientas y sistemas funcionen a la perfección.</em></p>
              <ul>
                <li>Experta en desarrollo de software y programación.</li>
                <li>Responsable de la integración de nuevas tecnologías y la optimización del sistema DRINKMASTER.</li>
              </ul>
          </div>
          </div>
        </div>

      </div>
    </section><!-- End Resume Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>CONTACTANOS</h2>
        </div>

        <div class="row mt-1">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <a href="https://maps.app.goo.gl/7RqGNekPW2HCSCdUA" target="_blank" style="text-decoration: none; color: inherit;">
                  <i class="icofont-google-map"></i>
                  <h4>Ubicación:</h4>
                  <p>Cochabamba</p>
                </a>
              </div>

              <div class="email">
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=drink.master.2004@gmail.com" target="_blank" style="text-decoration: none; color: inherit;">
                  <i class="icofont-envelope"></i>
                  <h4>Email:</h4>
                  <p>drink.master.2004@gmail.com</p>
                </a>
              </div>

              <div class="phone">
                <a href="tel:+59162658939" style="text-decoration: none; color: inherit;">
                  <i class="icofont-phone"></i>
                  <h4>Celular:</h4>
                  <p>62658939</p>
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>DRINKMASTER</h3>
      <p>En DrinkMaster, nos apasiona ofrecer las mejores bebidas para cada ocasión. Nos especializamos en proporcionar una experiencia única y deliciosa a nuestros clientes a través de una amplia gama de opciones de bebidas. Con un enfoque en calidad y servicio, estamos comprometidos a superar tus expectativas y hacer de cada evento un momento inolvidable.</p>
      <div class="social-links">
        <a href="https://www.facebook.com/" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="https://www.instagram.com/" class="instagram-2"><i class="bx bxl-instagram"></i></a>
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

/*--------------------------------------------------------------
# EFECTO LETRAS MOVIENDOSE
--------------------------------------------------------------*/
  document.addEventListener('scroll', function() {
    const textElement = document.getElementById('text');
    const scrollPosition = window.scrollY;
    // textElement.style.transform = `translateX(${scrollPosition}px)`;
    textElement.style.marginLeft = scrollPosition * 2 + 'px';
    textElement.style.marginTop = scrollPosition * 1 + 'px';
  });


</script>


</body>

</html>