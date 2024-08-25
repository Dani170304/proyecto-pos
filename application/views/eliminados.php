  
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
            <h1>LISTA DE USUARIOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Admin/index">Home</a></li>
              <li class="breadcrumb-item active">Tablas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <br>
<a href="<?php echo base_url(); ?>index.php/Admin/index">
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
                <table id="example1" class="table table-bordered table-striped">
            <thead>
                <th>No.</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Habilitar</th>
            </thead>
            <tbody>
                <?php
                $contador=1;
                foreach($usuarios->result() as $row)
                {
                ?>
                <tr>
                    <td> <?php echo $contador ?></td>
                    <td><?php echo $row-> nombres; ?></td>
                    <td><?php echo $row-> apellidos; ?></td>
                    <td><?php echo $row-> email; ?></td>
                    <td><?php echo $row-> rol; ?></td>
                    <td><?php echo $row-> estado; ?></td>
                    <td>
                    <?php
                    echo form_open_multipart("Admin/habilitarbd");
                    ?>
                    <input type="hidden" name="id_usuario" value="<?php echo $row->id_usuario; ?>">
                    <button type="submit" class="btn btn-morado">Habilitar</button>
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
