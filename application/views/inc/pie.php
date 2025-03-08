<!-- ./wrapper -->
 <style>
    #example1_filter input,
#example2_filter input,
#example3_filter input {
    padding-left: 10px !important; /* Ajusta el padding izquierdo */
    text-indent: 0 !important; /* Elimina cualquier sangría adicional */
    background-position: 8px center !important; /* Ajusta la posición del icono si existe */
}
 </style>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url(); ?>template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>template/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url(); ?>template/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>template/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url(); ?>template/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>template/dist/js/pages/dashboard2.js"></script>




<!-- DataTables  & Plugins -->
<script src="<?php echo base_url(); ?>template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>template/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    $(document).ready(function() {
    $('.nav-link[data-widget="pushmenu"]').on('click', function() {
        $('body').toggleClass('sidebar-collapse');
        // Puedes agregar más clases aquí si es necesario
    });
});
function getPDFConfig(title, hasFooter = false) {
    return {
        extend: 'pdf',
        text: '<i class="fas fa-file-pdf"></i> PDF',
        className: 'btn btn-secondary-pdf',
        pageOrientation: 'landscape',
        pageSize: 'A4',
        customize: function(doc) {
            // Estilos básicos
            doc.defaultStyle = {
                fontSize: 9,
                color: '#000000'
            };
            
            // Estilos del encabezado de la tabla
            doc.styles.tableHeader = {
                fontSize: 10,
                bold: true,
                fillColor: '#f2f2f2',
                color: '#000000',
                alignment: 'left',
                padding: 8
            };
            
            // Estilos del título
            doc.styles.title = {
                fontSize: 18,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 20]
            };

            // Configuración de la tabla
            doc.content[1].table = {
                ...doc.content[1].table,
                widths: Array(doc.content[1].table.body[0].length).fill('*'),
                headerRows: 1,
                keepWithHeaderRows: 1,
                dontBreakRows: true
            };

            // Agregar bordes negros a la tabla
            doc.content[1].layout = {
                hLineWidth: function(i, node) { return 1; }, // Grosor de líneas horizontales
                vLineWidth: function(i, node) { return 1; }, // Grosor de líneas verticales
                hLineColor: function(i, node) { return '#000000'; }, // Color de líneas horizontales
                vLineColor: function(i, node) { return '#000000'; }, // Color de líneas verticales
                paddingLeft: function(i, node) { return 8; },
                paddingRight: function(i, node) { return 8; },
                paddingTop: function(i, node) { return 8; },
                paddingBottom: function(i, node) { return 8; }
            };

            // Estilos de las celdas
            doc.styles.tableBodyEven = {
                padding: 8
            };
            doc.styles.tableBodyOdd = {
                padding: 8
            };

            // Configuración de los márgenes de la página
            doc.pageMargins = [28.35, 28.35, 28.35, 28.35]; // 1cm en puntos
            
            // Estilo para números (clase color-num)
            doc.styles.colorNum = {
                color: '#083CC2'
            };
        },
        title: title,
        footer: hasFooter ? function(currentPage, pageCount) {
            return {
                text: 'Página ' + currentPage.toString() + ' de ' + pageCount,
                alignment: 'center',
                margin: [0, 10, 0, 0]
            };
        } : null
    };
}

$(function () {
    // Configuración para la tabla #example1
    $("#example3").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
    }).container().appendTo('#example3_wrapper .col-md-6:eq(0)');
});
$(function () {
    // Configuración para la tabla #example1
    $("#example7").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
    }).container().appendTo('#example7_wrapper .col-md-6:eq(0)');
});
// Configuración para example1
$("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-secondary-excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            filename:'lista_usuarios',
            title: 'Lista de Usuarios'
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'btn btn-secondary-pdf',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            filename: 'lista_usuarios',
            title: 'Lista de Usuarios',
            pageOrientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                // Estilos básicos
                doc.defaultStyle = {
                    fontSize: 9,
                    color: '#000000'
                };
                
                // Estilos del encabezado de la tabla
                doc.styles.tableHeader = {
                    fontSize: 10,
                    bold: true,
                    fillColor: '#f2f2f2',
                    color: '#000000',
                    alignment: 'left',
                    padding: 8
                };
                
                // Estilos del título
                doc.styles.title = {
                    fontSize: 18,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                };

                // Configuración de la tabla con anchos específicos
                doc.content[1].table = {
                    ...doc.content[1].table,
                    widths: ['7%', '23%', '23%', '25%', '22%'], // Anchos específicos para cada columna
                    headerRows: 1,
                    keepWithHeaderRows: 1,
                    dontBreakRows: true
                };

                // Agregar bordes negros a la tabla
                doc.content[1].layout = {
                    hLineWidth: function(i, node) { return 1; },
                    vLineWidth: function(i, node) { return 1; },
                    hLineColor: function(i, node) { return '#000000'; },
                    vLineColor: function(i, node) { return '#000000'; },
                    paddingLeft: function(i, node) { return 8; },
                    paddingRight: function(i, node) { return 8; },
                    paddingTop: function(i, node) { return 8; },
                    paddingBottom: function(i, node) { return 8; }
                };

                // Estilos de las celdas
                doc.styles.tableBodyEven = {
                    padding: 8
                };
                doc.styles.tableBodyOdd = {
                    padding: 8
                };

                // Configuración de los márgenes de la página
                doc.pageMargins = [28.35, 28.35, 28.35, 28.35];

                // Estilo para números y alineación central de la primera columna
                doc.content[1].table.body.forEach(function(row, i) {
                    if(i === 0) return;
                    row[0].color = '#000'; // Color azul para números
                    row[0].alignment = 'center'; // Centrar números
                });
            }
        }
    ],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
// Configuración para example1
$("#example9").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-secondary-excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            filename:'lista_productos_mas_vendidos',
            title: 'Lista de Productos Mas Vendidos'
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'btn btn-secondary-pdf',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            filename: 'lista_productos_mas_vendidos',
            title: 'Lista de Productos Mas Vendidos',
            pageOrientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                // Estilos básicos
                doc.defaultStyle = {
                    fontSize: 9,
                    color: '#000000'
                };
                
                // Estilos del encabezado de la tabla
                doc.styles.tableHeader = {
                    fontSize: 10,
                    bold: true,
                    fillColor: '#f2f2f2',
                    color: '#000000',
                    alignment: 'left',
                    padding: 8
                };
                
                // Estilos del título
                doc.styles.title = {
                    fontSize: 18,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                };

                // Configuración de la tabla con anchos específicos
                doc.content[1].table = {
                    ...doc.content[1].table,
                    widths: ['7%', '23%', '23%', '25%', '22%'], // Anchos específicos para cada columna
                    headerRows: 1,
                    keepWithHeaderRows: 1,
                    dontBreakRows: true
                };

                // Agregar bordes negros a la tabla
                doc.content[1].layout = {
                    hLineWidth: function(i, node) { return 1; },
                    vLineWidth: function(i, node) { return 1; },
                    hLineColor: function(i, node) { return '#000000'; },
                    vLineColor: function(i, node) { return '#000000'; },
                    paddingLeft: function(i, node) { return 8; },
                    paddingRight: function(i, node) { return 8; },
                    paddingTop: function(i, node) { return 8; },
                    paddingBottom: function(i, node) { return 8; }
                };

                // Estilos de las celdas
                doc.styles.tableBodyEven = {
                    padding: 8
                };
                doc.styles.tableBodyOdd = {
                    padding: 8
                };

                // Configuración de los márgenes de la página
                doc.pageMargins = [28.35, 28.35, 28.35, 28.35];

                // Estilo para números y alineación central de la primera columna
                doc.content[1].table.body.forEach(function(row, i) {
                    if(i === 0) return;
                    row[0].color = '#000'; // Color azul para números
                    row[0].alignment = 'center'; // Centrar números
                });
            }
        }
    ],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
}).buttons().container().appendTo('#example9_wrapper .col-md-6:eq(0)');
// Configuración para example2
$("#example2").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-secondary-excel',
            exportOptions: {
                columns: [0, 2, 3, 4, 5]
            },
            filename:'lista_productos',
            title: 'Lista de Productos'
        },
        {
            ...getPDFConfig('Lista de Productos'),
            exportOptions: {
                columns: [0, 2, 3, 4, 5]
            },
            filename:'lista_productos'
        }
    ],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
}).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

// Configuración para tablaMeseros
$("#tablaMeseros").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-secondary-excel',
            exportOptions: {
                columns: [0, 1, 2]
            },
            filename:'reporte_mesero',
            title: 'Reporte de Ventas Mesero'
        },
        {
            ...getPDFConfig('Reporte de Meseros', true),
            exportOptions: {
                columns: [0, 1, 2]
            },
            filename:'reporte_mesero'
        }
    ],
    // ... resto de la configuración de tablaMeseros ...
}).buttons().container().appendTo('#tablaMeseros_wrapper .col-md-6:eq(0)');

// Configuración para ordenesELiminadas
$(function () {
    // Configuración para la tabla #example1
    $("#ordenesEliminadas").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
    }).container().appendTo('#example7_wrapper .col-md-6:eq(0)');
}).buttons().container().appendTo('#ordenesELiminadas_wrapper .col-md-6:eq(0)');

// Configuración para tablaProductosVendidos
$("#tablaProductosVendidos").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-secondary-excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            filename:'lista_usuarios',
            title: 'Lista de Usuarios'
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'btn btn-secondary-pdf',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            filename: 'lista_usuarios',
            title: 'Lista de Usuarios',
            pageOrientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                // Estilos básicos
                doc.defaultStyle = {
                    fontSize: 9,
                    color: '#000000'
                };
                
                // Estilos del encabezado de la tabla
                doc.styles.tableHeader = {
                    fontSize: 10,
                    bold: true,
                    fillColor: '#f2f2f2',
                    color: '#000000',
                    alignment: 'left',
                    padding: 8
                };
                
                // Estilos del título
                doc.styles.title = {
                    fontSize: 18,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                };

                // Configuración de la tabla con anchos específicos
                doc.content[1].table = {
                    ...doc.content[1].table,
                    widths: ['7%', '23%', '23%', '25%', '22%'], // Anchos específicos para cada columna
                    headerRows: 1,
                    keepWithHeaderRows: 1,
                    dontBreakRows: true
                };

                // Agregar bordes negros a la tabla
                doc.content[1].layout = {
                    hLineWidth: function(i, node) { return 1; },
                    vLineWidth: function(i, node) { return 1; },
                    hLineColor: function(i, node) { return '#000000'; },
                    vLineColor: function(i, node) { return '#000000'; },
                    paddingLeft: function(i, node) { return 8; },
                    paddingRight: function(i, node) { return 8; },
                    paddingTop: function(i, node) { return 8; },
                    paddingBottom: function(i, node) { return 8; }
                };

                // Estilos de las celdas
                doc.styles.tableBodyEven = {
                    padding: 8
                };
                doc.styles.tableBodyOdd = {
                    padding: 8
                };

                // Configuración de los márgenes de la página
                doc.pageMargins = [28.35, 28.35, 28.35, 28.35];

                // Estilo para números y alineación central de la primera columna
                doc.content[1].table.body.forEach(function(row, i) {
                    if(i === 0) return;
                    row[0].color = '#000'; // Color azul para números
                    row[0].alignment = 'center'; // Centrar números
                });
            }
        }
    ],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
}).buttons().container().appendTo('#tablaProductosVendidos_wrapper .col-md-6:eq(0)');
</script>

</body>
</html>
