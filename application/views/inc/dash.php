<!-- INICIO Titulo -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Admin/dash">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.FIN Titulo -->

    <!-- INICIO contenido -->
    <section class="content">
        <div class="container-fluid">
            <!-- ganacias -->
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ganancias</span>
                            <span class="info-box-number">
                                <?php echo number_format($ganancias, 2); ?>
                                <small>Bs.</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.ganancias -->

                <!-- /.ventas -->
                <div class="col-12 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-blue elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ventas</span>
                            <span class="info-box-number"><?php echo $ventas; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.ventas -->

                <!-- /.clientes -->
                <div class="col-12 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-red elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Clientes</span>
                            <span class="info-box-number"><?php echo $clientes; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.clientes -->
            </div>
            <!-- /.row -->
<br>
<br>
  <!-- TABLE: Ultimas ventas -->
<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">Ultimas Ventas</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>N° de Orden</th>
                        <th>Producto</th>
                        <th>Total</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($ventas) || is_object($ventas)): ?>
                        <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?php echo $venta->id_orden; ?></td>
                                <td><?php echo $venta->producto; ?></td>
                                <td><?php echo number_format($venta->total, 2); ?> Bs.</td>
                                <td><?php echo $venta->usuario; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No hay ventas disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-right">View All Orders</a> -->
    </div>
    <!-- /.card-footer -->
</div>
<!-- /.Ultimas ventas -->
