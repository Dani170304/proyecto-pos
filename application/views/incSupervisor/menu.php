<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader ">
    <!-- <img class="animation__wobble" src="<?php echo base_url(); ?>template/dist/img/logo_drink.jpg" alt="DricnkLogo" height="60" width="60"> -->
  </div>

  <!-- INICIO Barra de arriba -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url(); ?>index.php/Supervisor/dash" class="nav-link">INICIO</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <a class="close" href="<?php echo site_url('cerrar'); ?>">Cerrar Sesión</a>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.FIN Barra de arriba -->

  <!-- INICIO Navegador derecha -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo site_url('cerrarDrink'); ?>" class="brand-link">
      <img src="<?php echo base_url(); ?>template/dist/img/logo_drink.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DRINKMASTER</span>
    </a>

    <!-- INICIO Navegador derecha -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?php echo base_url(); ?>template/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <?php if (isset($user) && !is_null($user)): ?>
          <p class="info-p"><strong><?php echo $user['nombre_completo']; ?></strong></p>
            <p class="info-p-rol"><?php echo $user['rol']; ?></p>
        <?php else: ?>
            <p class="info-p"><strong>Usuario no disponible</strong></p>
            <p class="info-p-rol">Rol no disponible</p>
        <?php endif; ?>
    </div>
</div>


      <!-- INICIO Navegador derecha -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="<?php echo base_url(); ?>index.php/Supervisor/dash" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <br>
          <li class="nav-item">
            <p class="color-li ">
              <i class="nav-icon fas fa-table"></i>
              TABLAS
              <!-- <i class="fas fa-angle-right right"></i> -->
            </p>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Supervisor/index" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>USUARIOS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Productos_supervisor/productos" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>PRODUCTOS</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <p class="color-li ">
              <i class="fas fa-file-invoice nav-icon"></i>
              PEDIDOS
              <!-- <i class="fas fa-angle-right right"></i> -->
            </p>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Supervisor/recuperarTicket" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>REC. TICKET</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Supervisor/eliminarTicket" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ELIMINAR TICKET</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <p class="color-li ">
              <i class="nav-icon fas fa-file"></i>
              REPORTES
              <!-- <i class="fas fa-angle-right right"></i> -->
            </p>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Supervisor/reporteDia" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>REPORTE DIARIO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Supervisor/reporteMesero" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>REPORTE VENTAS MESERO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/Supervisor/reporteTicketsEliminados" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>REPORTE TICKETS ELIMINADOS</p>
                </a>
              </li>
          </li>

          
        </ul>
      </nav>
      <!-- /.FIN Navegador derecha -->
    </div>
    <!-- /.sidebar -->
  </aside>