  
  <style>
    .btn{
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
    .btn-verde {
        background-color: #3AD335; /* Color morado */
        color: black; /* Color del texto */
        margin-left: 7px;
    }
    .btn-verde:hover {
        background-color: #2BA81B; /* Color morado más oscuro para el hover */
        color: white;
    }
    .btn-warning
    {
      float: right;
      margin-right: 7px;
    }
    .text-center {
        text-align: center; /* Centra el contenido horizontalmente */
    }
    .color-num{
      color: #083CC2;
      font-weight: bold;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 id="title">LISTA DE EVENTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Eventos/index">Home</a></li>
              <li class="breadcrumb-item active">Tablas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <br>
<a href="<?php echo base_url(); ?>index.php/Eventos/index">
<button type="button" class="btn btn-warning">Ver lista</button>
<br>
<br>
</a>
<div class="card-info">
              <div class="card-header">
                <h3 class="card-title">LISTA</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-neon">
<hr class="hr-ta">
            <thead>

                <th>#</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>fecha del evento</th>
                <th>Estado</th>
                <th>Acciones</th>

            </thead>
            <tbody>
                <?php
                $contador = 1;
                foreach ($eventos->result() as $row) {
                ?>
                    <tr>
                        <td class="color-num"><?php echo $contador ?></td>
                        <td>
                            <?php
                            $foto=$row->imagen_evento;
                            ?>
                            <img src="<?php echo base_url()?>/assets/imagenes_eventos/<?php echo $foto ?>" width="100"/>
                        </td>
                        <td><?php echo $row-> nombre_evento; ?></td>
                        <td><?php echo $row-> descripcion; ?></td>
                        <td><?php echo $row-> fecha_inicio; ?></td>
                    <td class="orientation_col"><?php echo $row-> estado; ?></td>
                    <td>
    <?php
    echo form_open_multipart("Eventos/habilitareventobd", ['class' => 'habilitar-form']); // Añadir una clase al formulario
    ?>
    <input type="hidden" name="id_evento" value="<?php echo $row->id_evento; ?>">
    <button type="button" class="btn btn-morado habilitar-btn"><i class="fas fa-check-circle"></i></button>
    <?php
    echo form_close();
    ?>
</td>

                </tr>

                <?php
                $contador++;
                }
                ?>
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
  </div>
  <!-- ./wrapper -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Agregar SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    $('.habilitar-btn').on('click', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario
        const form = $(this).closest('form'); // Obtener el formulario más cercano

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Deseas habilitar este evento!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, habilitar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            icon: response.success ? 'success' : 'error',
                            title: response.success ? 'Éxito' : 'Error',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: response.success ? '#1AEB01' : '#d33'
                        }).then(() => {
                            window.location.href = '<?php echo base_url(); ?>index.php/Eventos/index'; 
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });
});

</script>