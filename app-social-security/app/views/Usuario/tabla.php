<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('app/views/layouts/head.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" id="bodyChange">
    <div class="wrapper">
            <?php include_once('app/views/layouts/menuSuperior.php'); ?>
            <?php include_once('app/views/layouts/menuLateral.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Empleados</h1>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn bg-gradient-navy float-right" data-toggle="modal" data-target="#modalCrear">Registrar empleado</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Lista de empleados</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Correo</th>
                                                <th>Estado</th>
                                                <th>Editar</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($usuarios as $key => $user) : ?>
                                                <tr class="text-center">
                                                    <td><?= $user->nombre_usuario ?></td>
                                                    <td><?= $user->apellido_usuario ?></td>
                                                    <td><?= $user->correo ?></td>
                                                    <td>
                                                        <?= ($user->estado_usuario != 1)? '<i class=" fa-solid fa-circle" style="color: #af0d0d;"></i>': '<i class=" fa-solid fa-circle" style="color: #0abd16;"></i>' ?>
                                                    </td>
                                                    <td>
                                                        <button class='btn bg-gradient-navy' data-toggle="modal" data-target="#modalEditar<?= $user->id_usuario?>"><i class="fa-solid fa-pencil"></i></button>
                                                    </td>
                                                    <td>
                                                        <?= ($user->estado_usuario != 1)? "<button class='btn bg-gradient-success' data-toggle='modal' data-target='#modalActivar$user->id_usuario'>Activar</button>": "<button class='btn bg-gradient-danger' data-toggle='modal' data-target='#modalEliminar$user->id_usuario'><i class='fa-solid fa-trash'></i> Eliminar</button>" ?>
                                                    </td>
                                                </tr>




                                                <!-- Modal Editar-->
                                                <div class="modal fade" id="modalEditar<?=$user->id_usuario?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Estas editando a <b><?php echo $user->nombre_usuario ." ". $user->apellido_usuario ?></b></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="accion" value="editar">
                                                                <input type="hidden" name="id_usuario" value="<?=$user->id_usuario?>">
                                                                <div class="modal-body">
                                                                    <div class="container-fluid ">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label for="">Nombre del empleado</label>
                                                                                <?php $data = ['name' => 'nombreEdit', 'type' => 'text', 'class' => 'form-control', 'value' => $user->nombre_usuario,];
                                                                                echo form_input($data); ?>

                                                                                <label for="">Apellido</label>
                                                                                <?php $data = ['name' => 'apellidoEdit', 'type' => 'text', 'class' => 'form-control', 'value' => $user->apellido_usuario,];
                                                                                echo form_input($data); ?>

                                                                                <label for="">Correo</label>
                                                                                <?php $data = ['name' => 'correoEdit', 'type' => 'email', 'class' => 'form-control', 'value' => $user->correo,];
                                                                                echo form_input($data); ?>

                                                                                <label for="">Contraseña</label>
                                                                                <?php $data = ['name' => 'contraseniaEdit', 'type' => 'password', 'class' => 'form-control', 'value' => $user->contrasenia,];
                                                                                echo form_input($data); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" class="btn bg-gradient-navy">Editar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Eliminar-->
                                                <div class="modal fade" id="modalEliminar<?=$user->id_usuario?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Eliminar Empleado</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="accion" value="eliminar">
                                                                <input type="hidden" name="id_usuario" value="<?= $user->id_usuario?>">
                                                                <div class="modal-body">
                                                                    <div class="container-fluid ">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <h3>¿Estas seguro de eliminar a <b><?php echo $user->nombre_usuario ." ". $user->apellido_usuario ?></b> ?</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <a href="delete/<?= $user->id_usuario?>" class="btn bg-gradient-danger">Confirmar</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Modal Activar-->
                                                <div class="modal fade" id="modalActivar<?= $user->id_usuario?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Activar Empleado</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="accion" value="activar">
                                                                <div class="modal-body">
                                                                    <div class="container-fluid ">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <?php $data = ['name' => 'id_usuario', 'type' => 'hidden', 'class' => 'form-control', 'value' => $user->id_usuario,];
                                                                                echo form_input($data); ?>
                                                                                <h4><b><?= $user->nombre_usuario ?></b> .Ha sido eliminado, Deseas darle acceso al sistema nuevamente?</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <a href="activate/<?= $user->id_usuario?>" class="btn bg-gradient-success">Confirmar</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-center">
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Correo</th>
                                                <th>Estado</th>
                                                <th>Editar</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('app/views/layouts/footer.php'); ?>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCrear" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Registrar empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="accion" value="crear">
                    <div class="modal-body">
                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Nombre del empleado</label>
                                    <?php $data = ['name' => 'nombre', 'type' => 'text', 'class' => 'form-control', 'required' => true,];
                                    echo form_input($data); ?>

                                    <label for="">Apellido</label>
                                    <?php $data = ['name' => 'apellido', 'type' => 'text', 'class' => 'form-control', 'required' => true,];
                                    echo form_input($data); ?>

                                    <label for="">Correo</label>
                                    <?php $data = ['name' => 'correo', 'type' => 'email', 'class' => 'form-control', 'required' => true,];
                                    echo form_input($data); ?>

                                    <label for="">Contraseña</label>
                                    <?php $data = ['name' => 'contrasenia', 'type' => 'password', 'class' => 'form-control', 'required' => true,];
                                    echo form_input($data); ?>

                                    <label for="" class="form-label">Cargo</label>
                                    <select name="rol" class="form-control" required >
                                        <option value="">Seleccione un rol</option>
                                        <option value="admin">Administrador</option>
                                        <option value="empleado">Empleado</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-navy">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $alerta = $this->session->flashdata('alerta');
        if (!empty($alerta)) {
        $alertType = $alerta['status'] ? 'success' : 'error';
        $alertMessage = $alerta['message'];
        $alertTitle = $alerta['title'];
        ?>
        <script>
            console.log("llego la alerta");
        swal('<?= $alertTitle ?>', '<?= $alertMessage ?>', '<?= $alertType ?>');
        </script>
    <?php } ?>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>/assets/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url(); ?>/assets/dist/js/demo.js"></script>
    <script>
        $(function() {
            var table = $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'copy',
                    text: 'copy',
                    exportOptions: {columns: [0, 1, 2] }
                },
                {
                    extend: 'csv',
                    text: 'csv',
                    exportOptions: {columns: [0, 1, 2] }
                },
                {
                    extend: 'excel',
                    text: 'excel',
                    exportOptions: {columns: [0, 1, 2] }
                },
                {
                    extend: 'pdf',
                    text: 'pdf',
                    exportOptions: {columns: [0, 1, 2] }
                },
                {
                    extend: 'print',
                    text: 'print',
                    exportOptions: {columns: [0, 1, 2] }
                },'colvis']});

            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
        console.log('¡Hola desarrollador! 🕵️‍♂️ ¿Listo para buscar el error?');

    </script>

    
    
</body>

</html>