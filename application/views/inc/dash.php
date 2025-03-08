<!-- INICIO Titulo -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 id="title" class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
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
                            <span class="info-box-number"><?php echo $Nroventas; ?></span>
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
                            <span class="info-box-text">Usuarios</span>
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
                <thead class="color-dark">
                    <tr>
                        <th>N° de Orden</th>
                        <th>Usuario</th>
                        <th>Producto(s)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="color-dark1">
                    <?php 
                    if (is_array($ventas) || is_object($ventas)):
                        $current_order = null;
                        $rowspan_count = 0; // Inicializamos el contador de rowspan
                        $total_venta = 0; // Inicializamos el total de la venta
                    ?>
                        <?php foreach ($ventas as $index => $venta): ?>
                            <?php 
                            // Si el id_orden es diferente del anterior, contamos y mostramos el rowspan
                            if ($venta->id_orden !== $current_order): 
                                // Contamos cuántas veces aparece el mismo id_orden y sumamos el total
                                $current_order = $venta->id_orden;
                                $rowspan_count = 0;
                                $total_venta = 0; // Reiniciar el total para esta orden
                                
                                foreach ($ventas as $v) {
                                    if ($v->id_orden === $venta->id_orden) {
                                        $rowspan_count++;
                                        $total_venta += $v->total; // Sumar el total de cada producto
                                    }
                                }
                            ?>
                            <tr>
                                <td class="orden-bg" rowspan="<?php echo $rowspan_count; ?>"><?php echo $venta->id_orden; ?></td>
                                <td rowspan="<?php echo $rowspan_count; ?>"><?php echo $venta->usuario; ?></td>
                                <td><?php echo $venta->producto; ?></td>
                                <td class="total-align" rowspan="<?php echo $rowspan_count; ?>"><?php echo number_format($total_venta, 2); ?> Bs.</td> <!-- Mostrar el total de la venta -->
                            </tr>

                            <?php else: ?>
                                <tr>
                                    <td><?php echo $venta->producto; ?></td>
                                </tr>
                            <?php endif; ?>
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
