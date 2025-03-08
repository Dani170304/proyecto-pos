<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carga de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga de SweetAlert -->
        <!-- Agregar estas librerías -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script src="<?php echo base_url(); ?>template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

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

        .export-buttons {
            margin-bottom: 15px;
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

    border: 2px solid #C9005A; /* Borde rojo alrededor de todos los botones */
    overflow: hidden; /* Para que los bordes redondeados funcionen correctamente */
}

/* Estilos comunes para todos los botones */
.paginate_button {
    padding: 6px 15px;
    text-align: center;
    cursor: pointer;
    background: black;
    font-weight: bold;
    font-size: 17px;
    color: #2a92ff; /* Azul para el texto de los botones */
    border: none; /* Sin bordes individuales */
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
    border: 2px solid #C9005A; /* Borde rojo como en la imagen */
    background-color: #000;
    color: #fff;
    margin-left: 5px;
}
/* Estilos para el hover de los botones de paginación */
.paginate_button:hover {
    background-color: #C9005A !important; /* Color rojo similar al borde */
    color: white !important; /* Texto blanco al hacer hover */
    transition: background-color 0.3s, color 0.3s; /* Transición suave */
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
                        <h1 id="title">REPORTE MENSUAL</h1>
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
                <!-- Campos para seleccionar rango de fechas -->
                <div class="text-center">
                    <label for="fecha-desde">Desde:</label>
                    <input type="date" id="fecha-desde" class="date-picker">
                    <label for="fecha-hasta">Hasta:</label>
                    <input type="date" id="fecha-hasta" class="date-picker">
                    <button class="btn btn-verde" onclick="filtrarFechas()">Filtrar</button>
                </div>
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
                
                <table id="example7" class="table table-bordered table-striped table-neon">
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
                    <td rowspan="<?php echo $rowspan_count; ?>"><?php echo number_format($total_venta, 2); ?></td> <!-- Mostrar el total de la orden -->
                </tr>
            <?php else: ?>
                <tr>
                    <td><?php echo $venta['nombre_producto']; ?></td>
                    <td><?php echo $venta['cantidad']; ?></td>
                    <td><?php echo number_format($venta['precio'], 2); ?></td ?>
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
    function filtrarFechas() {
    var fechaDesde = document.getElementById('fecha-desde').value;
    var fechaHasta = document.getElementById('fecha-hasta').value;

    if (fechaDesde && fechaHasta) {
        $.ajax({
            url: '<?= base_url("index.php/admin/reporteMesFiltrado") ?>',
            type: 'POST',
            data: {
                fecha_desde: fechaDesde,
                fecha_hasta: fechaHasta
            },
            success: function(response) {
                // Actualizar el contenido de la tabla
                $('#example7 tbody').html(response);
                
                // Reinicializar la paginación después de filtrar
                initPagination();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al obtener los datos.'
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor, selecciona ambas fechas.'
        });
    }
}
function initPagination() {
    // Definir variables de paginación
    const rowsPerPage = 10; // Cantidad de filas por página (10 órdenes)
    let currentPage = 1;
    
    // Obtener todas las filas actualizadas
    const rows = $('#example7 tbody tr');
    
    // Calcular el número total de órdenes (contando solo filas principales)
    let totalOrders = 0;
    rows.each(function() {
        if ($(this).find('td[rowspan]').length > 0) {
            totalOrders++;
        }
    });
    
    // Calcular total de páginas
    const totalPages = Math.ceil(totalOrders / rowsPerPage);
    
    // Eliminar paginación existente
    $('.dataTables_paginate').remove();
    
    // Si no hay órdenes, no crear paginación
    if (totalOrders === 0) {
        return;
    }
    
    // Mostrar las filas correspondientes a la página actual
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
                        if (rowIndex + i < rows.length) {
                            $(rows[rowIndex + i]).show();
                        }
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
        
        // Botón Anterior
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
        
        // Botón Siguiente
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
        $('#example7').after(paginationContainer);
    }

    // Actualizar la información de paginación
    function updatePaginationInfo() {    
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
    
    // Crear la paginación y mostrar la primera página
    createPagination();
    showRows();
    
    // Agregar campo de búsqueda
    addSearchField();
    
    // Función para el campo de búsqueda
    function addSearchField() {
    // Eliminar cualquier campo de búsqueda existente
    $('.dataTables_filter').remove();
    
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
    
    // Función de filtrado para búsqueda
    function filterTable(term) {
    const searchTerm = term.toLowerCase().trim();
    
    if (searchTerm === '') {
        // Si se borra la búsqueda, volver a la paginación normal
        currentPage = 1;
        showRows();
        updatePaginationInfo();
        // Asegurarse de que la paginación sea visible
        $('.dataTables_paginate').css('display', 'block');
        return;
    }
    
    // Ocultar todas las filas inicialmente
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
        // Mostrar mensaje de "No se encontraron resultados"
        const noResultsRow = $('<tr><td colspan="8" class="text-center">No se encontraron resultados para el número de orden: "' + term + '"</td></tr>');
        rows.parent().append(noResultsRow);
        
        // Ocultar paginación si no hay resultados
        $('.dataTables_paginate').css('display', 'none');
        return;
    }
    
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
    
    // Recalcular la paginación basada en resultados filtrados
    
    // Recalcular total de órdenes filtradas
    let filteredOrders = matchingOrders.size;
    let newTotalPages = Math.ceil(filteredOrders / rowsPerPage);
    
    if (newTotalPages > 0) {
        // Asegurarse de que currentPage no exceda el nuevo total
        if (currentPage > newTotalPages) {
            currentPage = 1;
        }
        
        // Recrear paginación con el nuevo total
        $('.dataTables_paginate').remove();
        
        // Crear paginación adaptada al filtro
        createFilteredPagination(newTotalPages, Array.from(matchingOrders));
    } else {
        // Si no hay páginas, ocultar paginación
        $('.dataTables_paginate').css('display', 'none');
    }
}
// Función para crear paginación específica para resultados filtrados
function createFilteredPagination(totalFilteredPages, matchingOrderIds) {
    // Crear el contenedor principal
    const paginationContainer = $('<div></div>')
        .addClass('dataTables_paginate paging_simple_numbers');
    
    // Crear contenedor de botones
    const buttonContainer = $('<div></div>')
        .addClass('paginate_button_container');
    
    // Botón Anterior
    const prevButton = $('<button></button>')
        .text('Anterior')
        .addClass('paginate_button previous')
        .on('click', function() {
            if (currentPage > 1) {
                currentPage--;
                showFilteredRows(matchingOrderIds);
                updateFilteredPaginationInfo(totalFilteredPages);
            }
        });
    
    // Determinar qué botones numerados mostrar
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalFilteredPages, startPage + 4);
    
    // Si estamos cerca del final, ajustar el rango
    if (endPage - startPage < 4 && totalFilteredPages > 5) {
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
                    showFilteredRows(matchingOrderIds);
                    updateFilteredPaginationInfo(totalFilteredPages);
                }
            });
        
        // Marcar el botón actual como activo
        if (i === currentPage) {
            pageButton.addClass('current');
        }
        
        buttonContainer.append(pageButton);
    }
    
    // Botón Siguiente
    const nextButton = $('<button></button>')
        .text('Siguiente')
        .addClass('paginate_button next')
        .on('click', function() {
            if (currentPage < totalFilteredPages) {
                currentPage++;
                showFilteredRows(matchingOrderIds);
                updateFilteredPaginationInfo(totalFilteredPages);
            }
        });
    
    // Agregar botón Siguiente
    buttonContainer.append(nextButton);
    
    // Agregar elementos al contenedor principal
    paginationContainer.append(buttonContainer);
    
    // Añadir el contenedor de paginación después de la tabla
    $('#example7').after(paginationContainer);
    
    // Mostrar la primera página de resultados filtrados
    showFilteredRows(matchingOrderIds);
}

// Actualizar la información de paginación para resultados filtrados
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

// Mostrar las filas correspondientes a la página actual para resultados filtrados
function showFilteredRows(matchingOrderIds) {
    // Ocultar todas las filas
    rows.hide();
    
    // Eliminar cualquier mensaje de "no se encontraron resultados"
    $('#example7 tbody tr:has(td[colspan])').remove();
    
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
}
 </script>
<script>
// Reemplaza todo el script del $(document).ready con este código más limpio
$(document).ready(function() {
    // Desactivar la inicialización de DataTable existente
    if ($.fn.dataTable.isDataTable('#example7')) {
        $('#example7').DataTable().destroy();
    }
    
    // Inicializar la paginación personalizada
    initPagination();
});

// Modificar la función exportToExcel para que use la referencia global 
// a las filas en lugar de una referencia local
window.exportToExcel = function() {
    let table = document.getElementById('example7');
    
    // Mostrar temporalmente todas las filas para exportar
    $('#example7 tbody tr').show();
    
    let ws = XLSX.utils.table_to_sheet(table, {
        raw: true,
        display: true,
        origin: 'A2' // Deja espacio para el título
    });
    
    // Obtener las fechas
    let fechaDesde = document.getElementById('fecha-desde').value;
    let fechaHasta = document.getElementById('fecha-hasta').value;
    
    // Crear el título incluyendo el rango de fechas si están disponibles
    let titulo = 'Reporte de Ventas Mensual';
    if(fechaDesde && fechaHasta) {
        titulo += ` (${fechaDesde} a ${fechaHasta})`;
    }
    
    // Agregar el título
    XLSX.utils.sheet_add_aoa(ws, [[titulo]], { origin: 'A1' });
    
    // Combinar celdas para el título
    if(!ws['!merges']) ws['!merges'] = [];
    ws['!merges'].push(
        {s: {r:0, c:0}, e: {r:0, c:7}} // Ajustar según el número de columnas
    );
    
    let wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Reporte");
    
    // Nombre del archivo con fechas
    let fileName = "reporte_ventas_mes";
    if(fechaDesde && fechaHasta) {
        fileName += `_${fechaDesde}_a_${fechaHasta}`;
    }
    
    XLSX.writeFile(wb, `${fileName}.xlsx`);
    
    // Volver a aplicar la paginación reimplementándola
    initPagination();
};

// Modificar también exportToPDF y printTable de manera similar
window.exportToPDF = function() {
    // Mostrar temporalmente todas las filas para la exportación
    $('#example7 tbody tr').show();
    
    let table = document.getElementById('example7');
    let tableRows = Array.from(table.getElementsByTagName('tr'));
    
    let docDefinition = {
        pageOrientation: 'landscape',
        content: [{
            text: 'Reporte de Ventas Mensual',
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

    // Agregar fechas al título si están seleccionadas
    let fechaDesde = document.getElementById('fecha-desde').value;
    let fechaHasta = document.getElementById('fecha-hasta').value;
    if(fechaDesde && fechaHasta) {
        docDefinition.content.push({
            text: `Período: ${fechaDesde} a ${fechaHasta}`,
            alignment: 'center',
            margin: [0, 0, 0, 10]
        });
    }

    let tableBody = [];
    let headerCells = Array.from(tableRows[0].cells).map(cell => ({
        text: cell.textContent.trim(),
        style: 'tableHeader'
    }));
    tableBody.push(headerCells);

    let currentRowspan = 0;
    let savedValues = null;

    for (let i = 1; i < tableRows.length; i++) {
        let cells = Array.from(tableRows[i].cells);
        let rowData = [];

        if (cells[0].hasAttribute('rowspan')) {
            currentRowspan = parseInt(cells[0].getAttribute('rowspan'));
            savedValues = [
                cells[0].textContent.trim(),
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[7].textContent.trim()
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

    docDefinition.content.push({
        table: {
            headerRows: 1,
            widths: ['auto', 'auto', 'auto', '*', 'auto', 'auto', 'auto', 'auto'],
            body: tableBody
        }
    });

    let fileName = "reporte_ventas_mes";
    if(fechaDesde && fechaHasta) {
        fileName += `_${fechaDesde}_a_${fechaHasta}`;
    }
    pdfMake.createPdf(docDefinition).download(`${fileName}.pdf`);
    
    // Reinicializar la paginación
    initPagination();
};

</script>
