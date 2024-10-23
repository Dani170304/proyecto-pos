<!-- ./wrapper -->

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

$(function () {
    // Configuración para la tabla #example1
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
                    columns: [0, 1, 2, 3, 4] // Columnas a incluir para esta tabla específica
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-secondary-pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Columnas a incluir para esta tabla específica
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-secondary-print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Columnas a incluir para esta tabla específica
                }
            }
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>
<script>
$(function () {
    // Configuración para la tabla #example1
    $("#example3").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
    }).container().appendTo('#example3_wrapper .col-md-6:eq(0)');
});
</script>
<script>
$(function () {
    // Configuración para la tabla #example1
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
                    columns: [0, 2, 3, 4, 5] // Columnas a incluir para esta tabla específica
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-secondary-pdf',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5] // Columnas a incluir para esta tabla específica
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-secondary-print',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5] // Columnas a incluir para esta tabla específica
                }
            }
        ]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
});
</script>

</body>
</html>
