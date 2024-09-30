  
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
    .btn-info
    {
      padding-top: 3px;
      padding-bottom: 3px;
      padding-left: 8px;
      padding-right: 8px;

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
    .hr-ta
    {
      margin-top: -10px;
      margin-bottom: 30px;
      border: 1px solid #ccc;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 id="title">LISTA DE PRODUCTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tablas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <br>
<a href="<?php echo base_url(); ?>index.php/Productos/agregarproductos">
<button type="button" class="btn btn-verde">Agregar producto</button>
</a>
<a href="<?php echo base_url(); ?>index.php/Productos/eliminadosproductos">
<button type="button" class="btn btn-warning">Ver deshabilitados</button>
<br>
<br>
</a>
<?php if ($this->session->has_userdata('id_usuario')) : ?>
    <div class="bold-text-info">
        <!-- <span>N°</span> -->
        <input type="hidden" value="<?= htmlspecialchars($this->session->userdata('id_usuario')) ?>" readonly>
    </div>
<?php endif; ?>
<div class="card-info">

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped table-neon">
<hr class="hr-ta">
            <thead>

                <th>No.</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>

            </thead>
            <tbody>
                <?php
                $contador=1;
                foreach($productos->result() as $row)
                {
                ?>
                <tr>
                    <td  class="color-num"> <?php echo $contador ?></td>
                    </td>
                    <td>
                        <?php
                        $foto=$row->imagen;
                        ?>
                        <img src="<?php echo base_url()?>/assets/imagenes_bebidas/<?php echo $foto ?>" width="40"/>
                    </td>

                    <td><?php echo $row-> nombre; ?></td>
                    <td><?php echo $row-> categoria; ?></td>
                    <td><?php echo $row-> stock; ?></td>
                    <td><?php echo $row-> precio; ?></td>
                    <td class="orientation_col"><?php echo $row-> estado; ?></td>
                    <td class="text-center">
  <div class="btn-group-ac">
    <?php echo form_open_multipart("Productos/modificarproducto"); ?>
      <input type="hidden" name="id_producto" value="<?php echo $row->id_producto; ?>">
      <button type="submit" class="btn btn-morado"><i class="fas fa-edit"></i></button>
    <?php echo form_close(); ?>
    
    <?php echo form_open_multipart("Productos/eliminarproductodb"); ?>
      <input type="hidden" name="id_producto" value="<?php echo $row->id_producto; ?>">
      <button type="button" class="btn btn-danger eliminar-btn"><i class="fas fa-trash-alt"></i></button>
    <?php echo form_close(); ?>
    
    <?php echo form_open_multipart("Productos/deshabilitarproductodb"); ?>
      <input type="hidden" name="id_producto" value="<?php echo $row->id_producto; ?>">
      <button type="button" class="btn btn-info deshabilitar-btn"><i class="fas fa-ban"></i></button>
    <?php echo form_close(); ?>
  </div>
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
<!-- Carga de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Carga de SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tu script personalizado -->
<script>
$(document).ready(function() {
    // Confirmación de eliminación
    $('.eliminar-btn').on('click', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario
        const form = $(this).closest('form'); // Obtener el formulario más cercano

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Deseas eliminar este producto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: response.success ? 'Éxito' : 'Error',
                            text: response.message,
                            icon: response.success ? 'success' : 'error'
                        }).then(() => {
                            // Recargar la página o realizar alguna acción adicional
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema al procesar la solicitud.', 'error');
                    }
                });
            }
        });
    });

    // Confirmación de deshabilitación
    $('.deshabilitar-btn').on('click', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario
        const form = $(this).closest('form'); // Obtener el formulario más cercano

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Deseas deshabilitar este producto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffbb33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, deshabilitar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: response.success ? 'Éxito' : 'Error',
                            text: response.message,
                            icon: response.success ? 'success' : 'error'
                        }).then(() => {
                            // Recargar la página o realizar alguna acción adicional
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema al procesar la solicitud.', 'error');
                    }
                });
            }
        });
    });
});

</script>

