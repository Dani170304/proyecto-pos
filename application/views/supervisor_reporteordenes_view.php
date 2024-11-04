<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <h1 id="title">REPORTE TICKETS ELIMINADAS</h1>
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
                <hr class="hr-ta">
                
                <table id="ordenesELiminadas" class="table table-bordered table-striped table-neon">
                    <thead>
                        <tr>
                            
                            <th class="text-center">#</th>
                            <th class="text-center">N° de Orden</th>
                            <th class="text-center">Fecha eliminación</th>
                            <th class="text-center">Elimino</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($ordenesEliminadas) && !empty($ordenesEliminadas)) {
                            $contador = 1;
                            foreach($ordenesEliminadas as $orden) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $contador++; ?></td>
                                    <td class="text-center"><?php echo $orden['id_orden']; ?></td>
                                    <td class="text-center"><?php echo date('d/m/Y H:i:s', strtotime($orden['fecha_eliminacion'])); ?></td>
                                    <td><?php echo $orden['nombre_usuario']; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay registros disponibles</td>
                            </tr>
                        <?php } ?>
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