<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
  .color-num{
    color: #083CC2;
    font-weight: bold;
  }
  .hr-ta {
    margin-top: -10px;
    margin-bottom: 30px;
    border: 1px solid #ccc;
  }
  /* Estilos para los modales */
  .modal-header {
    background-color: #6f42c1;
    color: white;
  }
  .form-control {
    position: relative;
    padding-left: 40px; /* Deja espacio para el icono */
  }
  .input-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    color: #999;
  }
  .close {
    color: white;
  }
  
  /* Estilos para la previsualización de imágenes */
  .img-preview-container {
    margin-top: 15px;
    text-align: center;
  }
  .img-preview {
    max-width: 200px;
    max-height: 200px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    margin-top: 10px;
  }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 id="title">LISTA DE PRODUCTOS</h1>
        </div>
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tablas</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <br>
  
  <!-- Botón Agregar producto (ahora abre modal) -->
  <button type="button" class="btn btn-verde" data-toggle="modal" data-target="#modalAgregarProducto">
    Agregar producto
  </button>
  
  <a href="<?php echo base_url(); ?>index.php/Productos/eliminadosproductos">
    <button type="button" class="btn btn-warning">Ver deshabilitados</button>
  </a>
  <br>
  <br>
  
  <?php if ($this->session->has_userdata('id_usuario')) : ?>
    <div class="bold-text-info">
      <input type="hidden" value="<?= htmlspecialchars($this->session->userdata('id_usuario')) ?>" readonly>
    </div>
  <?php endif; ?>
  
  <div class="card-info">
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-striped table-neon">
        <hr class="hr-ta">
        <thead>
          <th>#</th>
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
            <td class="color-num"> <?php echo $contador ?></td>
            <td>
              <?php
              $foto=$row->imagen;
              ?>
              <img src="<?php echo base_url()?>/assets/imagenes_bebidas/<?php echo $foto ?>" width="40"/>
            </td>
            <td><?php echo $row->nombre; ?></td>
            <td><?php echo $row->categoria; ?></td>
            <td><?php echo $row->stock; ?></td>
            <td><?php echo $row->precio; ?></td>
            <td class="orientation_col"><?php echo $row->estado; ?></td>
            <td class="text-center">
              <div class="btn-group-ac">
                <!-- Botón Modificar (ahora abre modal) -->
                <button type="button" class="btn btn-morado modificar-btn" 
                  data-id="<?php echo $row->id_producto; ?>"
                  data-nombre="<?php echo $row->nombre; ?>"
                  data-categoria="<?php echo $row->categoria; ?>"
                  data-stock="<?php echo $row->stock; ?>"
                  data-precio="<?php echo $row->precio; ?>"
                  data-imagen="<?php echo $row->imagen; ?>">
                  <i class="fas fa-edit"></i>
                </button>

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
<!-- /.content-wrapper -->

<!-- Modal Agregar Producto -->
<div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart("Productos/agregarproductobd", ['id' => 'formAgregar']); ?>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" name="nombre" placeholder="Escriba nombre del producto" maxlength="50" autocomplete="off" required>
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-file-alt"></i></span>
            <select class="form-control" name="categoria" required>
              <option value="" disabled selected>Seleccione la categoría</option>
              <option value="botella">Botella</option>
              <option value="coctel">Coctel</option>
              <option value="soda">Soda</option>
              <option value="cerveza">Cerveza</option>
              <option value="piqueo">Piqueo</option>
              <option value="combo">Soda-Combo</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input type="number" class="form-control" name="stock" placeholder="Escriba el stock" autocomplete="off" required>
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-dollar-sign"></i></span>
            <input type="text" 
                 class="form-control" 
                 name="precio" 
                 placeholder="Escriba el precio" 
                 required 
                 pattern="^\d+([,.]\d{1,2})?$" 
                 title="Ingrese un número válido con hasta dos decimales (use . o , como separador)" 
                 inputmode="decimal" 
                 autocomplete="off"
                 oninput="this.value = this.value.replace(/[^0-9.,]/g, '');">
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-image"></i></span>
            <input type="file" class="form-control" id="imagen_agregar" name="imagen" accept="image/png, image/jpeg, image/jpg" placeholder="Seleccione la imagen" required>
          </div>
          <!-- Contenedor de previsualización para agregar -->
          <div class="img-preview-container">
            <p class="preview-title">Previsualización:</p>
            <img id="preview_agregar" class="img-preview" src="<?php echo base_url(); ?>" alt="Vista previa" style="display: none;">
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-morado">Agregar Producto</button>
        </div>
        
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Producto -->
<div class="modal fade" id="modalModificarProducto" tabindex="-1" role="dialog" aria-labelledby="modalModificarProductoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalModificarProductoLabel">Modificar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart("Productos/modificarproductodb", ['id' => 'formModificarProducto']); ?>
        
        <input type="hidden" id="mod_id_producto" name="id_producto" value="">
        <input type="hidden" id="mod_imagen_actual" name="imagen_actual" value="">
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" id="mod_nombre" name="nombre" placeholder="Escriba nombre del producto" maxlength="50" autocomplete="off" required>
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-file-alt"></i></span>
            <select class="form-control" id="mod_categoria" name="categoria" required>
              <option value="" disabled>Seleccione la categoria</option>
              <option value="botella">Botella</option>
              <option value="coctel">Coctel</option>
              <option value="soda">Soda</option>
              <option value="cerveza">Cerveza</option>
              <option value="piqueo">Piqueo</option>
              <option value="combo">Soda-Combo</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input type="number" class="form-control" id="mod_stock" name="stock" placeholder="Escriba el stock" autocomplete="off" required>
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-dollar-sign"></i></span>
            <input type="text" 
                 class="form-control" 
                 id="mod_precio"
                 name="precio" 
                 placeholder="Escriba el precio" 
                 required 
                 pattern="^\d+([,.]\d{1,2})?$" 
                 title="Ingrese un número válido con hasta dos decimales (use . o , como separador)" 
                 inputmode="decimal" 
                 autocomplete="off"
                 oninput="this.value = this.value.replace(/[^0-9.,]/g, '');">
          </div>
        </div>
        
        <div class="form-group">
          <div style="position: relative;">
            <span class="input-icon"><i class="fa fa-image"></i></span>
            <input type="file" class="form-control" id="imagen_modificar" name="imagen" accept="image/*">
          </div>
          <!-- Contenedor de previsualización para modificar -->
          <div class="img-preview-container">
            <div class="row">
              <div class="col-md-6">
                <p class="preview-title">Imagen actual:</p>
                <img id="imagen_actual_preview" class="img-preview" src="" alt="Imagen actual">
              </div>
              <div class="col-md-6">
                <p class="preview-title">Nueva imagen:</p>
                <img id="preview_modificar" class="img-preview" src="<?php echo base_url(); ?>" alt="Nueva imagen" style="display: none;">
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-morado">Modificar Producto</button>
        </div>
        
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Scripts necesarios para los modales (asegúrate de que ya estén incluidos en tu footer) -->
<script>
$(document).ready(function() {
  // Previsualización de la imagen al agregar
  $("#imagen_agregar").change(function() {
    previewImage(this, "#preview_agregar");
  });
  
  // Previsualización de la imagen al modificar
  $("#imagen_modificar").change(function() {
    previewImage(this, "#preview_modificar");
  });
  
  // Función para previsualizar imágenes
  function previewImage(input, previewElement) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $(previewElement).attr('src', e.target.result);
        $(previewElement).show();
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  // Manejar clic en botón de modificar
  $(document).on('click', '.modificar-btn', function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    var categoria = $(this).data('categoria');
    var stock = $(this).data('stock');
    var precio = $(this).data('precio');
    var imagen = $(this).data('imagen');
    
    // Llenar el formulario del modal
    $('#mod_id_producto').val(id);
    $('#mod_nombre').val(nombre);
    $('#mod_categoria').val(categoria.toLowerCase());
    $('#mod_stock').val(stock);
    $('#mod_precio').val(precio);
    $('#mod_imagen_actual').val(imagen);
    
    // Mostrar la imagen actual en la previsualización
    var img_path = '<?php echo base_url(); ?>assets/imagenes_bebidas/' + imagen;
    $('#imagen_actual_preview').attr('src', img_path);
    
    // Ocultar la previsualización de la nueva imagen hasta que se seleccione una
    $('#preview_modificar').hide();
    
    // Mostrar el modal
    $('#modalModificarProducto').modal('show');
  });

  // Formulario Agregar Producto - Envío AJAX
  $('#formAgregar').on('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Deseas agregar este producto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#1AEB01',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, agregar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: new FormData(this),
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#1AEB01'
              }).then(() => {
                // Cerrar el modal
                $('#modalAgregarProducto').modal('hide');
                // Recargar la página
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#1AEB01'
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrió un error al procesar la solicitud.',
              confirmButtonText: 'OK',
              confirmButtonColor: '#1AEB01'
            });
          }
        });
      }
    });
  });

  // Formulario Modificar Producto - Envío AJAX
  $('#formModificarProducto').on('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Deseas modificar este producto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, modificar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: new FormData(this),
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(response) {
            Swal.fire({
              icon: response.success ? 'success' : 'error',
              title: response.success ? 'Éxito' : 'Error',
              text: response.message,
              confirmButtonText: 'OK',
              confirmButtonColor: response.success ? '#1AEB01' : '#d33'
            }).then(() => {
              if (response.success) {
                // Cerrar el modal
                $('#modalModificarProducto').modal('hide');
                // Recargar la página
                location.reload();
              }
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

  // Confirmación de eliminación
  $('.eliminar-btn').on('click', function(e) {
    e.preventDefault();
    const form = $(this).closest('form');

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
    e.preventDefault();
    const form = $(this).closest('form');

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
  
  // Resetear el formulario y la previsualización al cerrar el modal de agregar
  $('#modalAgregarProducto').on('hidden.bs.modal', function() {
    $('#formAgregar')[0].reset();
    $('#preview_agregar').attr('src', '<?php echo base_url(); ?>');
    $('#preview_agregar').hide();
  });
  
  // Resetear el formulario y la previsualización al cerrar el modal de modificar
  $('#modalModificarProducto').on('hidden.bs.modal', function() {
    $('#formModificarProducto')[0].reset();
    $('#preview_modificar').attr('src', '<?php echo base_url(); ?>');
    $('#preview_modificar').hide();
  });
});
</script>
</body>
</html>