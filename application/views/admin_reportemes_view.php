<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRINK | REPORTE</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carga de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga de SweetAlert -->
    <style>
        .btn {
            font-weight: bold;
        }

        .btn-morado {
            background-color: #6f42c1; /* Color morado */
            color: white; /* Color del texto */
        }

        .btn-morado:hover {
            background-color: #563d7c; /* Color morado más oscuro para el hover */
            color: white;
        }

        .btn-info {
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 8px;
            padding-right: 8px;
        }

        .btn-verde {
            background-color: #3AD335; /* Color verde */
            color: black; /* Color del texto */
            margin-left: 7px;
        }

        .btn-verde:hover {
            background-color: #2BA81B; /* Color verde más oscuro para el hover */
            color: white;
        }

        .btn-warning {
            float: right;
            margin-right: 7px;
        }

        .text-center {
            text-align: center; /* Centra el contenido horizontalmente */
        }

        .color-num {
            color: #083CC2;
            font-weight: bold;
        }

        .hr-ta {
            margin-top: -10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        .date-picker {
            margin: 5px; /* Margen entre campos */
        }
    </style>
</head>
<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 id="title">REPORTE MENSUAL</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Reportes</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="card-info">
            <div class="card-body">
                <!-- Campos para seleccionar rango de fechas -->
                <div class="text-center">
                    <label for="fecha-desde">Desde:</label>
                    <input type="date" id="fecha-desde" class="date-picker">
                    <label for="fecha-hasta">Hasta:</label>
                    <input type="date" id="fecha-hasta" class="date-picker">
                    <button class="btn btn-verde" onclick="filtrarFechas()">Filtrar</button>
                </div>
                <br>
                <hr class="hr-ta">
                
                <table id="example1" class="table table-bordered table-striped table-neon">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>N° de Orden</th>
            <th>Nombre Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (is_array($ventas) || is_object($ventas)):
            $current_order = null;
            $rowspan_count = 0;
            $total_venta = 0;
        ?>
            <?php foreach ($ventas as $index => $venta): ?>
                <?php 
                if ($venta['id_orden'] !== $current_order): 
                    $current_order = $venta['id_orden'];
                    $rowspan_count = 0;
                    $total_venta = 0;

                    foreach ($ventas as $v) {
                        if ($v['id_orden'] === $venta['id_orden']) {
                            $rowspan_count++;
                            $total_venta += $v['cantidad'] * $v['precio'];
                        }
                    }
                ?>
                    <tr>
                        <td rowspan="<?php echo $rowspan_count; ?>"><?php echo date('d-m-Y', strtotime($venta['fechaCreacion'])); ?></td>
                        <td rowspan="<?php echo $rowspan_count; ?>"><?php echo $venta['id_orden']; ?></td>
                        <td><?php echo $venta['nombre_producto']; ?></td>
                        <td><?php echo $venta['cantidad']; ?></td>
                        <td><?php echo number_format($venta['precio'], 2); ?></td>
                        <td><?php echo number_format($venta['cantidad'] * $venta['precio'], 2); ?></td>
                        <td rowspan="<?php echo $rowspan_count; ?>"><?php echo number_format($total_venta, 2); ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo $venta['nombre_producto']; ?></td>
                        <td><?php echo $venta['cantidad']; ?></td>
                        <td><?php echo number_format($venta['precio'], 2); ?></td>
                        <td><?php echo number_format($venta['cantidad'] * $venta['precio'], 2); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No hay ventas disponibles.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function filtrarFechas() {
        var desde = $('#fecha-desde').val();
        var hasta = $('#fecha-hasta').val();
        
        // Aquí puedes agregar la lógica para filtrar los datos en tu tabla según las fechas seleccionadas
        console.log("Filtrar desde: " + desde + " hasta: " + hasta);
    }
    function filtrarFechas() {
    var fechaDesde = document.getElementById("fecha-desde").value;
    var fechaHasta = document.getElementById("fecha-hasta").value;

    if (fechaDesde && fechaHasta) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Admin/reporteMes'); ?>",
            data: {
                fecha_desde: fechaDesde,
                fecha_hasta: fechaHasta
            },
            success: function(response) {
                // Aquí puedes mostrar el reporte sin recargar la página
                $('#example1 tbody').html(response);
            },
            error: function() {
                alert("Error al obtener los datos. Por favor, intenta de nuevo.");
            }
        });
    } else {
        alert("Por favor, selecciona ambas fechas.");
    }
}


</script>
