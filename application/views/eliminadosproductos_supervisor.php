  <style>
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

    .btn-verde {
      background-color: #3AD335;
      /* Color morado */
      color: black;
      /* Color del texto */
      margin-left: 7px;
    }

    .btn-verde:hover {
      background-color: #2BA81B;
      /* Color morado más oscuro para el hover */
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
          <div class="col-sm-12">
            <h1 id="title">LISTA DE PRODUCTOS DESHABLITADOS</h1>
          </div>
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Productos_supervisor/productos">Home</a></li>
              <li class="breadcrumb-item active">Tablas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <br>
    <a href="<?php echo base_url(); ?>index.php/Productos_supervisor/productos">
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
            $contador = 1;
            foreach ($productos->result() as $row) {
            ?>
              <tr>
                <td class="color-num"> <?php echo $contador ?></td>
                </td>
                <td>
                  <?php
                  $foto = $row->imagen;
                  ?>
                  <img src="<?php echo base_url() ?>/assets/imagenes_bebidas/<?php echo $foto ?>" width="40" />
                </td>

                <td><?php echo $row->nombre; ?></td>
                <td><?php echo $row->categoria; ?></td>
                <td><?php echo $row->stock; ?></td>
                <td><?php echo $row->precio; ?></td>
                <td class="orientation_col"><?php echo $row->estado; ?></td>
                <td>
                  <?php
                  echo form_open_multipart("Productos_supervisor/habilitarproductobd", ['class' => 'habilitar-form']); // Añadir una clase al formulario
                  ?>
                  <input type="hidden" name="id_producto" value="<?php echo $row->id_producto; ?>">
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
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
          title: '¿Estás seguro?',
          text: "¿Deseas habilitar este producto?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#6f42c1',
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
                if (response.success) {
                  Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                    confirmButtonColor: '#6f42c1'
                  }).then(() => {
                    // Redirigir a la página de productos eliminados
                    window.location.href = '<?php echo base_url(); ?>index.php/Productos_supervisor/productos';
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    confirmButtonColor: '#d33'
                  });
                }
              },
              error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Ocurrió un error al procesar la solicitud: ' + error,
                  confirmButtonColor: '#d33'
                });
              }
            });
          }
        });
      });
    });
  </script>