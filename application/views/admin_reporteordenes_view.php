<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carga de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga de SweetAlert -->
    <!-- Agregar estas librerías para exportar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
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
        .btn-secondary-pdf:hover{
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
    margin-bottom: 30px;
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
                        <h1 id="title">REPORTE TICKETS ELIMINADOS</h1>
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
                <hr class="hr-ta">
                
                <table id="ordenesEliminadas" class="table table-bordered table-striped table-neon">
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

<script>
// Inicialización con paginación personalizada
$(document).ready(function() {
    // Eliminar la inicialización de DataTable si existe
    if ($.fn.dataTable.isDataTable('#ordenesEliminadas')) {
        $('#ordenesEliminadas').DataTable().destroy();
    }
    
    // Inicializar la paginación personalizada
    initPagination();
});

// Función para inicializar la paginación personalizada
function initPagination() {
    // Definir variables de paginación
    const rowsPerPage = 10; // Cantidad de filas por página
    let currentPage = 1;
    
    // Obtener todas las filas de datos (excluyendo encabezados)
    const rows = $('#ordenesEliminadas tbody tr');
    
    // Calcular el número total de filas
    const totalRows = rows.length;
    
    // Calcular total de páginas
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    
    // Eliminar paginación existente
    $('.dataTables_paginate').remove();
    
    // Si no hay filas, no crear paginación
    if (totalRows === 0) {
        return;
    }
    
    // Función para mostrar las filas correspondientes a la página actual
    function showRows() {
        // Ocultar todas las filas
        rows.hide();
        
        // Calcular índices para la página actual
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, totalRows);
        
        // Mostrar las filas para esta página
        for (let i = startIndex; i < endIndex; i++) {
            $(rows[i]).show();
        }
    }
    
    // Función para crear la estructura de paginación personalizada
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
        $('#ordenesEliminadas').after(paginationContainer);
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
    
    // Agregar campo de búsqueda personalizado
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
    
    // Función para filtrar la tabla
    function filterTable(term) {
        const searchTerm = term.toLowerCase().trim();
        
        // Si el término de búsqueda está vacío, mostrar todas las filas
        if (searchTerm === '') {
            currentPage = 1;
            $('.dataTables_paginate').css('display', 'block');
            showRows();
            updatePaginationInfo();
            return;
        }
        
        // Ocultar todas las filas
        rows.hide();
        
        // Almacenar las filas que coinciden con el término de búsqueda
        const matchingRows = [];
        
        // Buscar en la columna de número de orden (índice 1)
        rows.each(function() {
            const orderNumber = $(this).find('td:eq(1)').text().trim().toLowerCase();
            if (orderNumber.includes(searchTerm)) {
                matchingRows.push($(this));
            }
        });
        
        // Si no hay resultados, mostrar mensaje
        if (matchingRows.length === 0) {
            // Eliminar cualquier mensaje anterior
            $('#ordenesEliminadas tbody tr.no-results').remove();
            
            // Mostrar mensaje de "No se encontraron resultados"
            const noResultsRow = $('<tr class="no-results"><td colspan="4" class="text-center">No se encontraron resultados para el número de orden: "' + term + '"</td></tr>');
            $('#ordenesEliminadas tbody').append(noResultsRow);
            
            // Ocultar paginación si no hay resultados
            $('.dataTables_paginate').css('display', 'none');
            return;
        }
        
        // Eliminar cualquier mensaje de no resultados
        $('#ordenesEliminadas tbody tr.no-results').remove();
        
        // Mostrar las filas que coinciden
        for (let i = 0; i < matchingRows.length; i++) {
            matchingRows[i].show();
        }
        
        // Si hay suficientes resultados para paginar, mostrar paginación filtrada
        if (matchingRows.length > rowsPerPage) {
            let newTotalPages = Math.ceil(matchingRows.length / rowsPerPage);
            $('.dataTables_paginate').remove();
            createFilteredPagination(newTotalPages, matchingRows);
        } else {
            // Si hay pocos resultados, no necesitamos paginación
            $('.dataTables_paginate').css('display', 'none');
        }
    }
    
    // Función para crear paginación de resultados filtrados
    function createFilteredPagination(totalFilteredPages, matchingRows) {
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
                    showFilteredRows(matchingRows);
                    updateFilteredPaginationInfo(totalFilteredPages, matchingRows);
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
                        showFilteredRows(matchingRows);
                        updateFilteredPaginationInfo(totalFilteredPages, matchingRows);
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
                    showFilteredRows(matchingRows);
                    updateFilteredPaginationInfo(totalFilteredPages, matchingRows);
                }
            });
        
        // Agregar botón Siguiente
        buttonContainer.append(nextButton);
        
        // Agregar elementos al contenedor principal
        paginationContainer.append(buttonContainer);
        
        // Añadir el contenedor de paginación después de la tabla
        $('#ordenesEliminadas').after(paginationContainer);
        
        // Mostrar la primera página de resultados filtrados
        showFilteredRows(matchingRows);
    }
    
    // Función para mostrar filas filtradas por página
    function showFilteredRows(matchingRows) {
        // Ocultar todas las filas
        rows.hide();
        
        // Eliminar cualquier mensaje de "no se encontraron resultados"
        $('#ordenesEliminadas tbody tr.no-results').remove();
        
        // Calcular índices para la página actual
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, matchingRows.length);
        
        // Mostrar las filas para esta página
        for (let i = startIndex; i < endIndex; i++) {
            matchingRows[i].show();
        }
    }
    
    // Función para actualizar paginación filtrada
    function updateFilteredPaginationInfo(totalFilteredPages, matchingRows) {
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
            createFilteredPagination(totalFilteredPages, matchingRows);
        }
    }
    
    // Inicializar paginación, mostrar filas y agregar campo de búsqueda
    createPagination();
    showRows();
    addSearchField();
    
    // Agregar estilos CSS para la paginación y el campo de búsqueda si no existen
    if ($('#pagination-styles').length === 0) {
        const paginationStyles = `
        <style id="pagination-styles">
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
            overflow: hidden;
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
            border: none;
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
            background-color: #000;
            color: #fff;
            margin-left: 5px;
        }

        /* Estilos para el hover de los botones de paginación */
        .paginate_button:hover {
            background-color: #C9005A !important;
            color: white !important;
            transition: background-color 0.3s, color 0.3s;
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
        `;
        $('head').append(paginationStyles);
    }
}

// Modificación de la función filtrarFechas para usar paginación personalizada
function filtrarFechas() {
    var fechaDesde = document.getElementById('fecha-desde').value;
    var fechaHasta = document.getElementById('fecha-hasta').value;

    if (fechaDesde && fechaHasta) {
        $.ajax({
            url: '<?= base_url("index.php/admin/reporteTicketsEliminadosFiltrado") ?>',
            type: 'POST',
            data: {
                fecha_desde: fechaDesde,
                fecha_hasta: fechaHasta
            },
            success: function(response) {
                // Actualizar el contenido de la tabla
                $('#ordenesEliminadas tbody').html(response);
                
                // Reinicializar la paginación personalizada
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

// Funciones de exportación
function exportToExcel() {
    let table = document.getElementById('ordenesEliminadas');
    
    // Mostrar temporalmente todas las filas para exportar
    $('#ordenesEliminadas tbody tr').show();
    
    let ws = XLSX.utils.table_to_sheet(table, {
        raw: true,
        display: true,
        origin: 'A2' // Deja espacio para el título
    });
    
    // Obtener las fechas
    let fechaDesde = document.getElementById('fecha-desde').value;
    let fechaHasta = document.getElementById('fecha-hasta').value;
    
    // Crear el título incluyendo el rango de fechas si están disponibles
    let titulo = 'Reporte de Tickets Eliminados';
    if(fechaDesde && fechaHasta) {
        titulo += ` (${fechaDesde} a ${fechaHasta})`;
    }
    
    // Agregar el título
    XLSX.utils.sheet_add_aoa(ws, [[titulo]], { origin: 'A1' });
    
    // Combinar celdas para el título (ajusta el número de columnas según tu tabla)
    if(!ws['!merges']) ws['!merges'] = [];
    ws['!merges'].push(
        {s: {r:0, c:0}, e: {r:0, c:3}} // 4 columnas en total
    );
    
    let wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Tickets Eliminados");
    
    // Nombre del archivo con fechas
    let fileName = "reporte_tickets_eliminados";
    if(fechaDesde && fechaHasta) {
        fileName += `_${fechaDesde}_a_${fechaHasta}`;
    }
    
    XLSX.writeFile(wb, `${fileName}.xlsx`);
    
    // Reinicializar la paginación personalizada
    initPagination();
}

function exportToPDF() {
    // Mostrar temporalmente todas las filas para la exportación
    $('#ordenesEliminadas tbody tr').show();
    
    let table = document.getElementById('ordenesEliminadas');
    let rows = Array.from(table.getElementsByTagName('tr'));
    
    let docDefinition = {
        pageOrientation: 'portrait',
        content: [{
            text: 'Reporte de Tickets Eliminados',
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
    let headerCells = Array.from(rows[0].cells).map(cell => ({
        text: cell.textContent.trim(),
        style: 'tableHeader'
    }));
    tableBody.push(headerCells);

    for (let i = 1; i < rows.length; i++) {
        if (!rows[i].classList.contains('d-none') && !rows[i].classList.contains('no-results')) {
            let cells = Array.from(rows[i].cells);
            let rowData = cells.map(cell => ({
                text: cell.textContent.trim(),
                style: 'tableCell'
            }));
            tableBody.push(rowData);
        }
    }

    docDefinition.content.push({
        table: {
            headerRows: 1,
            widths: ['auto', 'auto', '*', 'auto'],
            body: tableBody
        }
    });

    let fileName = "reporte_tickets_eliminados";
    if(fechaDesde && fechaHasta) {
        fileName += `_${fechaDesde}_a_${fechaHasta}`;
    }
    pdfMake.createPdf(docDefinition).download(`${fileName}.pdf`);
    
    // Reinicializar la paginación
    initPagination();
}

</script>