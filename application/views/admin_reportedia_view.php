<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carga de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga de SweetAlert -->
    <!-- Para Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<!-- Para PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- SheetJS (XLSX) -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    
    <!-- PDFMake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

    <!-- Font Awesome -->
    <!-- <script src="https://kit.fontawesome.com/tu-codigo-de-kit.js" crossorigin="anonymous"></script> -->
    <style>
        .btn-secondary-excel {
    background-color: #4CAF50;
    color: white;
    margin-right: 5px;
}

.btn-secondary-pdf {
    background-color: #FF0000;
    color: white;
    margin-right: 5px;
}

.btn-secondary-print {
    background-color: #6c757d;
    color: white;
}

.btn-secondary-excel:hover,
.btn-secondary-pdf:hover,
.btn-secondary-print:hover {
    opacity: 0.9;
    color: white;
}
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
                        <h1 id="title">REPORTE DIARIO</h1>
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
            <div class="export-buttons">
    <button class="btn btn-secondary-excel" onclick="exportToExcel()">
        <i class="fas fa-file-excel"></i> Excel
    </button>
    <button class="btn btn-secondary-pdf" onclick="exportToPDF()">
        <i class="fas fa-file-pdf"></i> PDF
    </button>
    <button class="btn btn-secondary-print" onclick="printTable()">
        <i class="fas fa-print"></i> Print
    </button>
</div>
<br>
                <hr class="hr-ta">
                
                <table id="example3" class="table table-bordered table-striped table-neon">
    <thead>
        <th>#</th>
        <th>Fecha</th>
        <th>N° de Orden</th>
        <th>Nombre Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Subtotal</th>
        <th>Total</th>
    </thead>
    <tbody>
        <?php 
        if (is_array($ventas) || is_object($ventas)):
            $current_order = null;
            $rowspan_count = 0; // Inicializamos el contador de rowspan
            $total_venta = 0; // Inicializamos el total de la venta
            $contador = 1; // Inicializa el contador
        ?>
            <?php foreach ($ventas as $index => $venta): ?>
                <?php 
                // Si el id_orden es diferente del anterior, contamos y mostramos el rowspan
                if ($venta['id_orden'] !== $current_order): 
                    // Contamos cuántas veces aparece el mismo id_orden y sumamos el total
                    $current_order = $venta['id_orden'];
                    $rowspan_count = 0;
                    $total_venta = 0; // Reiniciar el total para esta orden

                    foreach ($ventas as $v) {
                        if ($v['id_orden'] === $venta['id_orden']) {
                            $rowspan_count++;
                            $total_venta += $v['cantidad'] * $v['precio']; // Sumar el total de cada producto
                        }
                    }
                ?>
                    <tr>
                        <td class="color-num" rowspan="<?php echo $rowspan_count; ?>"><?php echo $contador++; ?></td> <!-- Muestra el número del producto -->
                        <td rowspan="<?php echo $rowspan_count; ?>"><?php echo date('d-m-Y', strtotime($venta['fechaCreacion'])); ?></td>
                        <td rowspan="<?php echo $rowspan_count; ?>"><?php echo $venta['id_orden']; ?></td>
                        <td><?php echo $venta['nombre_producto']; ?></td>
                        <td><?php echo $venta['cantidad']; ?></td>
                        <td><?php echo number_format($venta['precio'], 2); ?></td>
                        <td><?php echo number_format($venta['cantidad'] * $venta['precio'], 2); ?></td> <!-- Calcular subtotal para el producto -->
                        <td rowspan="<?php echo $rowspan_count; ?>">Bs. <?php echo number_format($total_venta, 2); ?></td> <!-- Mostrar el total de la orden -->
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo $venta['nombre_producto']; ?></td>
                        <td><?php echo $venta['cantidad']; ?></td>
                        <td><?php echo number_format($venta['precio'], 2); ?></td>
                        <td><?php echo number_format($venta['cantidad'] * $venta['precio'], 2); ?></td> <!-- Calcular subtotal para el producto -->
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No hay ventas disponibles.</td>
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
function exportToExcel() {
    let table = document.getElementById('example3');
    let ws = XLSX.utils.table_to_sheet(table, {
        raw: true,
        display: true,
        origin: 'A2' // Deja espacio para el título
    });
    
    // Agregar el título
    XLSX.utils.sheet_add_aoa(ws, [['Reporte de Ventas Diarias']], { origin: 'A1' });
    
    // Combinar celdas para el título (desde A1 hasta H1, asumiendo 8 columnas)
    if(!ws['!merges']) ws['!merges'] = [];
    ws['!merges'].push(
        {s: {r:0, c:0}, e: {r:0, c:7}} // Combina las celdas A1:H1
    );

    // Asegurarse de que el título esté centrado
    if(!ws['!cols']) ws['!cols'] = [];
    ws['A1'] = { 
        v: 'Reporte de Ventas Diarias',
        t: 's',
        s: {
            alignment: {
                horizontal: 'center',
                vertical: 'center'
            },
            font: {
                bold: true,
                sz: 14 // Tamaño de fuente
            }
        }
    };
    
    // Crear libro y añadir la hoja
    let wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Reporte");
    
    // Descargar el archivo
    XLSX.writeFile(wb, "reporte_ventas_dia.xlsx");
}

function exportToPDF() {
    let table = document.getElementById('example3');
    let rows = Array.from(table.rows);
    
    // Configuración del PDF
    let docDefinition = {
        pageOrientation: 'landscape',
        content: [{
            text: 'Reporte de Ventas Diarias',
            style: 'header',
            alignment: 'center',
            margin: [0, 0, 0, 10]
        }],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                margin: [0, 0, 0, 10]
            },
            tableHeader: {
                bold: true,
                fontSize: 10,
                fillColor: '#f2f2f2'
            },
            tableCell: {
                fontSize: 9
            }
        }
    };

    // Preparar datos de la tabla
    let tableBody = [];
    let headerCells = Array.from(rows[0].cells).map(cell => ({
        text: cell.textContent.trim(),
        style: 'tableHeader'
    }));
    tableBody.push(headerCells);

    // Variables para manejar el rowspan
    let currentRowspan = 0;
    let savedValues = null;

    // Procesar filas de datos
    for (let i = 1; i < rows.length; i++) {
        let row = rows[i];
        let cells = Array.from(row.cells);
        let rowData = [];

        if (cells[0].hasAttribute('rowspan')) {
            // Nueva orden - guardar valores con rowspan
            currentRowspan = parseInt(cells[0].getAttribute('rowspan'));
            savedValues = [
                cells[0].textContent.trim(), // número
                cells[1].textContent.trim(), // fecha
                cells[2].textContent.trim(), // orden
                cells[7].textContent.trim()  // total
            ];
            rowData = [
                {text: savedValues[0], rowSpan: currentRowspan, style: 'tableCell'},
                {text: savedValues[1], rowSpan: currentRowspan, style: 'tableCell'},
                {text: savedValues[2], rowSpan: currentRowspan, style: 'tableCell'},
                {text: cells[3].textContent.trim(), style: 'tableCell'},
                {text: cells[4].textContent.trim(), style: 'tableCell'},
                {text: cells[5].textContent.trim(), style: 'tableCell'},
                {text: cells[6].textContent.trim(), style: 'tableCell'},
                {text: savedValues[3], rowSpan: currentRowspan, style: 'tableCell'}
            ];
            currentRowspan--;
        } else {
            // Filas adicionales de la misma orden
            rowData = [
                {text: '', style: 'tableCell'},
                {text: '', style: 'tableCell'},
                {text: '', style: 'tableCell'},
                {text: cells[0].textContent.trim(), style: 'tableCell'},
                {text: cells[1].textContent.trim(), style: 'tableCell'},
                {text: cells[2].textContent.trim(), style: 'tableCell'},
                {text: cells[3].textContent.trim(), style: 'tableCell'},
                {text: '', style: 'tableCell'}
            ];
            currentRowspan--;
        }
        tableBody.push(rowData);
    }

    // Agregar la tabla al documento
    docDefinition.content.push({
        table: {
            headerRows: 1,
            widths: ['auto', 'auto', 'auto', '*', 'auto', 'auto', 'auto', 'auto'],
            body: tableBody
        },
        layout: {
            fillColor: function(rowIndex, node, columnIndex) {
                return (rowIndex === 0) ? '#f2f2f2' : null;
            }
        }
    });

    // Generar y descargar el PDF
    pdfMake.createPdf(docDefinition).download('reporte_ventas_dia.pdf');
}

function printTable() {
    let printContents = document.getElementById('example3').outerHTML;
    let originalContents = document.body.innerHTML;
    
    document.body.innerHTML = `
        <style>
            @media print {
                table { 
                    border-collapse: collapse; 
                    width: 100%; 
                    page-break-inside: auto;
                }
                th { 
                    background-color: #f2f2f2 !important; 
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                }
                th, td { 
                    border: 1px solid black; 
                    padding: 8px; 
                    text-align: left;
                }
                tr { 
                    page-break-inside: avoid; 
                    page-break-after: auto;
                }
                .no-print { 
                    display: none; 
                }
                .color-num {
                    color: #083CC2 !important;
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                }
            }
            @page {
                size: landscape;
                margin: 1cm;
            }
        </style>
        <h1 style="text-align: center; margin-bottom: 20px;">Reporte de Ventas Diarias</h1>
        ${printContents}
    `;
    
    window.print();
    document.body.innerHTML = originalContents;
    
    // Recargar la página después de imprimir para restaurar la funcionalidad
    window.location.reload();
}
</script>