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


        .btn-secondary-excel:hover,
        .btn-secondary-pdf:hover {
            opacity: 0.9;
            color: white;
        }

        .btn {
            font-weight: bold;
        }

        .btn-morado {
            background-color: #6f42c1;
            /* Color morado */
            color: white;
            /* Color del texto */
        }

        .btn-morado:hover {
            background-color: #563d7c;
            /* Color morado más oscuro para el hover */
            color: white;
        }

        .btn-info {
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 8px;
            padding-right: 8px;
        }

        .btn-verde {
            background-color: #3AD335;
            /* Color verde */
            color: black;
            /* Color del texto */
            margin-left: 7px;
        }

        .btn-verde:hover {
            background-color: #2BA81B;
            /* Color verde más oscuro para el hover */
            color: white;
        }

        .btn-warning {
            float: right;
            margin-right: 7px;
        }

        .text-center {
            text-align: center;
            /* Centra el contenido horizontalmente */
        }

        .color-num {
            color: #2a92ff;
            font-weight: bold;
        }

        .hr-ta {
            margin-top: -10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        /* paginacion */

        /* Estilos para el contenedor de paginación */
        .dataTables_paginate {
            text-align: right;
            margin-top: 15px;
            width: 100%;
        }

        /* Estilos para el contenedor de botones */
        .paginate_button_container {
            display: inline-flex;
            border-radius: 3px;

            border: 2px solid #C9005A;
            /* Borde rojo alrededor de todos los botones */
            overflow: hidden;
            /* Para que los bordes redondeados funcionen correctamente */
        }

        /* Estilos comunes para todos los botones */
        .paginate_button {
            padding: 6px 15px;
            text-align: center;
            cursor: pointer;
            background: black;
            font-weight: bold;
            font-size: 17px;
            color: #2a92ff;
            /* Azul para el texto de los botones */
            border: none;
            /* Sin bordes individuales */
        }

        /* Botón de página actual */
        .paginate_button.current {
            background-color: black;
            color: white;
        }

        /* Estados deshabilitados */
        .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Estilos para el campo de búsqueda */
        .dataTables_filter {
            margin-top: -40px;
            text-align: right;
            background-color: #000;
            color: #fff;
            padding: 6px 10px;
        }

        .dataTables_filter input {
            padding: 5px;
            border-radius: 3px;
            border: 2px solid #C9005A;
            /* Borde rojo como en la imagen */
            background-color: #000;
            color: #fff;
            margin-left: 5px;
        }

        /* Estilos para el hover de los botones de paginación */
        .paginate_button:hover {
            background-color: #C9005A !important;
            /* Color rojo similar al borde */
            color: white !important;
            /* Texto blanco al hacer hover */
            transition: background-color 0.3s, color 0.3s;
            /* Transición suave */
        }

        /* Aplicar hover también a los botones numéricos */
        .paginate_button:not(.previous):not(.next):hover {
            background-color: #C9005A !important;
            color: white !important;
        }

        /* Asegurarse de que el botón actual no cambie su estilo al hacer hover */
        .paginate_button.current:hover {
            background-color: black !important;
            color: white !important;
        }

        /* Eliminar efecto de opacidad para botones deshabilitados */
        .paginate_button.disabled {
            opacity: 1 !important;
            cursor: pointer !important;
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
                    <div class="col-sm-12">
                        <h1 id="title">REPORTE DIARIO</h1>
                    </div>
                    <div class="col-sm-12">
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
        $(document).ready(function() {
            // Definir variables de paginación
            const rowsPerPage = 10; // Cantidad de filas por página
            let currentPage = 1;

            // Obtener todas las filas de datos (excluyendo encabezados)
            const rows = $('#example3 tbody tr');

            // Calcular el número total de órdenes (contando solo filas principales)
            let totalOrders = 0;
            rows.each(function() {
                if ($(this).find('td[rowspan]').length > 0) {
                    totalOrders++;
                }
            });

            // Calcular total de páginas
            const totalPages = Math.ceil(totalOrders / rowsPerPage);

            // Función para mostrar las filas correspondientes a la página actual
            function showRows() {
                // Ocultar todas las filas
                rows.hide();

                // Calcular índices de órdenes para la página actual
                const startOrder = (currentPage - 1) * rowsPerPage;
                const endOrder = startOrder + rowsPerPage;

                // Contador para órdenes
                let orderCount = 0;

                // Mostrar órdenes para la página actual
                rows.each(function() {
                    // Si es una fila principal (con primera celda con rowspan)
                    if ($(this).find('td:first-child').attr('rowspan')) {
                        // Si esta orden está en el rango de la página actual
                        if (orderCount >= startOrder && orderCount < endOrder) {
                            const rowspan = parseInt($(this).find('td:first-child').attr('rowspan'));
                            const rowIndex = rows.index(this);

                            // Mostrar la fila principal
                            $(this).show();

                            // Mostrar todas las filas relacionadas (según rowspan)
                            for (let i = 1; i < rowspan; i++) {
                                $(rows[rowIndex + i]).show();
                            }
                        }
                        orderCount++;
                    }
                });
            }

            // Crear la estructura de paginación en el estilo deseado
            function createPagination() {
                // Crear el contenedor principal
                const paginationContainer = $('<div></div>')
                    .addClass('dataTables_paginate paging_simple_numbers');

                // Crear contenedor de botones
                const buttonContainer = $('<div></div>')
                    .addClass('paginate_button_container');

                // Botón Anterior - solo mostrar si hay más de una página y no estamos en la primera página
                const prevButton = $('<button></button>')
                    .text('Anterior')
                    .addClass('paginate_button previous')
                    .on('click', function() {
                        if (currentPage > 1) {
                            currentPage--;
                            showRows();
                            updatePaginationInfo();
                        }
                    });

                // Determinar qué botones numerados mostrar
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);

                // Si estamos cerca del final, ajustar el rango
                if (endPage - startPage < 4 && totalPages > 5) {
                    startPage = Math.max(1, endPage - 4);
                }

                // Agregar botón Anterior
                buttonContainer.append(prevButton);

                // Agregar botones numerados
                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = $('<button></button>')
                        .text(i)
                        .addClass('paginate_button')
                        .on('click', function() {
                            if (currentPage !== i) {
                                currentPage = i;
                                showRows();
                                updatePaginationInfo();
                            }
                        });

                    // Marcar el botón actual como activo
                    if (i === currentPage) {
                        pageButton.addClass('current');
                    }

                    buttonContainer.append(pageButton);
                }

                // Actualizar información de paginación
                const nextButton = $('<button></button>')
                    .text('Siguiente')
                    .addClass('paginate_button next')
                    .on('click', function() {
                        if (currentPage < totalPages) {
                            currentPage++;
                            showRows();
                            updatePaginationInfo();
                        }
                    });

                // Agregar botón Siguiente
                buttonContainer.append(nextButton);

                // Agregar elementos al contenedor principal
                paginationContainer.append(buttonContainer);

                // Añadir el contenedor de paginación después de la tabla
                $('#example3').after(paginationContainer);
            }

            // Actualizar la función updatePaginationInfo para trabajar con botones numerados
            function updatePaginationInfo() {
                // No modificar la apariencia visual de los botones para indicar que están deshabilitados
                // Simplemente no harán nada cuando se haga clic en ellos si no hay páginas para navegar

                // Actualizar botones numerados
                $('.paginate_button').removeClass('current');
                $('.paginate_button').each(function() {
                    if ($(this).text() == currentPage) {
                        $(this).addClass('current');
                    }
                });

                // Si la página actual no está en los botones visibles, recrear la paginación
                if ($('.paginate_button.current').length === 0) {
                    $('.dataTables_paginate').remove();
                    createPagination();
                }
            }

            // Agregar campo de búsqueda
            function addSearchField() {
                const searchContainer = $('<div></div>')
                    .addClass('dataTables_filter');

                const searchLabel = $('<label></label>')
                    .text('Buscar por N° de Orden: ');

                const searchInput = $('<input>')
                    .attr('type', 'text')
                    .attr('placeholder', 'Ingrese número de orden')
                    .on('input', function() {
                        filterTable($(this).val());
                    });

                searchLabel.append(searchInput);
                searchContainer.append(searchLabel);

                // Agregar justo después de los botones de exportación
                $('.export-buttons').after(searchContainer);
            }

            // Función de filtrado
            // Reemplazar la función filterTable actual con esta versión
            function filterTable(term) {
                const searchTerm = term.toLowerCase().trim();

                if (searchTerm === '') {
                    // Si se borra la búsqueda, volver a la primera página
                    currentPage = 1;
                    showRows();
                    updatePaginationInfo();
                    // Asegurarse de que la paginación sea visible
                    $('.dataTables_paginate').css('display', 'block');
                    return;
                }

                // Ocultar todas las filas
                rows.hide();

                // Conjunto para rastrear las órdenes que coinciden
                const matchingOrders = new Set();

                // Buscar solo en filas principales y solo por número de orden (tercera columna)
                rows.each(function() {
                    const firstCell = $(this).find('td:first-child');

                    // Solo procesar filas principales (las que tienen rowspan)
                    if (firstCell.attr('rowspan')) {
                        // Obtener el número de orden (tercera columna, índice 2)
                        const orderNumber = $(this).find('td:eq(2)').text().trim().toLowerCase();

                        // Verificar si el número de orden contiene el término de búsqueda
                        if (orderNumber.includes(searchTerm)) {
                            const orderId = $(this).find('td:eq(2)').text().trim();
                            matchingOrders.add(orderId);
                        }
                    }
                });

                // Si no hay resultados, mostrar mensaje
                if (matchingOrders.size === 0) {
                    // Eliminar cualquier mensaje anterior
                    $('#example3 tbody tr.no-results').remove();

                    // Mostrar mensaje de "No se encontraron resultados"
                    const noResultsRow = $('<tr class="no-results"><td colspan="8" class="text-center">No se encontraron resultados para el número de orden: "' + term + '"</td></tr>');
                    $('#example3 tbody').append(noResultsRow);

                    // Ocultar paginación si no hay resultados
                    $('.dataTables_paginate').css('display', 'none');
                    return;
                }

                // Eliminar cualquier mensaje de no resultados si hay coincidencias
                $('#example3 tbody tr.no-results').remove();

                // Mostrar todas las filas de órdenes que coincidan
                rows.each(function() {
                    const firstCell = $(this).find('td:first-child');

                    if (firstCell.attr('rowspan')) {
                        const orderId = $(this).find('td:eq(2)').text().trim();

                        if (matchingOrders.has(orderId)) {
                            // Mostrar la fila principal
                            $(this).show();

                            // Mostrar filas relacionadas
                            const rowspan = parseInt(firstCell.attr('rowspan'));
                            const rowIndex = rows.index(this);

                            for (let i = 1; i < rowspan; i++) {
                                if (rowIndex + i < rows.length) {
                                    $(rows[rowIndex + i]).show();
                                }
                            }
                        }
                    }
                });

                // Generar una nueva paginación para los resultados del filtro
                // Recalcular total de órdenes filtradas
                let filteredOrders = matchingOrders.size;

                if (filteredOrders > rowsPerPage) {
                    // Si hay suficientes resultados para paginar
                    let newTotalPages = Math.ceil(filteredOrders / rowsPerPage);

                    // Recrear paginación con nueva información
                    $('.dataTables_paginate').remove();

                    // Mantener currentPage dentro del rango válido
                    if (currentPage > newTotalPages) {
                        currentPage = 1;
                    }

                    // Crear la nueva paginación
                    createFilteredPagination(newTotalPages, Array.from(matchingOrders));
                } else {
                    // Si hay pocos resultados, no necesitamos paginación
                    $('.dataTables_paginate').css('display', 'none');
                }
            }

            // Inicializar todo
            createPagination();
            addSearchField();
            showRows();
            updatePaginationInfo();
        });
        // Función para mostrar filas filtradas por página
        function showFilteredRows(matchingOrderIds) {
            // Ocultar todas las filas
            rows.hide();

            // Eliminar cualquier mensaje de "no se encontraron resultados"
            $('#example3 tbody tr.no-results').remove();

            // Calcular índices para la página actual
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            // Obtener solo las órdenes visibles para esta página
            const visibleOrders = matchingOrderIds.slice(startIndex, endIndex);

            // Mostrar las órdenes para esta página
            rows.each(function() {
                const firstCell = $(this).find('td:first-child');

                if (firstCell.attr('rowspan')) {
                    const orderId = $(this).find('td:eq(2)').text().trim();

                    if (visibleOrders.includes(orderId)) {
                        // Mostrar la fila principal
                        $(this).show();

                        // Mostrar filas relacionadas
                        const rowspan = parseInt(firstCell.attr('rowspan'));
                        const rowIndex = rows.index(this);

                        for (let i = 1; i < rowspan; i++) {
                            if (rowIndex + i < rows.length) {
                                $(rows[rowIndex + i]).show();
                            }
                        }
                    }
                }
            });
        }

        // Función para actualizar información de paginación para resultados filtrados
        function updateFilteredPaginationInfo(totalFilteredPages) {
            // Actualizar botones numerados
            $('.paginate_button').removeClass('current');
            $('.paginate_button').each(function() {
                if ($(this).text() == currentPage) {
                    $(this).addClass('current');
                }
            });

            // Si la página actual no está en los botones visibles, recrear la paginación
            if ($('.paginate_button.current').length === 0) {
                $('.dataTables_paginate').remove();
                createFilteredPagination(totalFilteredPages);
            }
        }

        function exportToExcel() {
            let table = document.getElementById('example3');
            let ws = XLSX.utils.table_to_sheet(table, {
                raw: true,
                display: true,
                origin: 'A2' // Deja espacio para el título
            });

            // Agregar el título
            XLSX.utils.sheet_add_aoa(ws, [
                ['Reporte de Ventas Diarias']
            ], {
                origin: 'A1'
            });

            // Combinar celdas para el título (desde A1 hasta H1, asumiendo 8 columnas)
            if (!ws['!merges']) ws['!merges'] = [];
            ws['!merges'].push({
                    s: {
                        r: 0,
                        c: 0
                    },
                    e: {
                        r: 0,
                        c: 7
                    }
                } // Combina las celdas A1:H1
            );

            // Asegurarse de que el título esté centrado
            if (!ws['!cols']) ws['!cols'] = [];
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
                        cells[7].textContent.trim() // total
                    ];
                    rowData = [{
                            text: savedValues[0],
                            rowSpan: currentRowspan,
                            style: 'tableCell'
                        },
                        {
                            text: savedValues[1],
                            rowSpan: currentRowspan,
                            style: 'tableCell'
                        },
                        {
                            text: savedValues[2],
                            rowSpan: currentRowspan,
                            style: 'tableCell'
                        },
                        {
                            text: cells[3].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: cells[4].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: cells[5].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: cells[6].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: savedValues[3],
                            rowSpan: currentRowspan,
                            style: 'tableCell'
                        }
                    ];
                    currentRowspan--;
                } else {
                    // Filas adicionales de la misma orden
                    rowData = [{
                            text: '',
                            style: 'tableCell'
                        },
                        {
                            text: '',
                            style: 'tableCell'
                        },
                        {
                            text: '',
                            style: 'tableCell'
                        },
                        {
                            text: cells[0].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: cells[1].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: cells[2].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: cells[3].textContent.trim(),
                            style: 'tableCell'
                        },
                        {
                            text: '',
                            style: 'tableCell'
                        }
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
    </script>