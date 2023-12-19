<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('app/views/layouts/head.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('app/views/layouts/menuSuperior.php'); ?>
        <!-- /.navbar -->

        <?php include_once('app/views/layouts/menuLateral.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Listado personas independientes</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Validation</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <?php if ($this->session->userdata('rol') == 'admin' || $this->session->userdata('rol') == 'empleado') { ?>
                                            <a href="<?php echo base_url('registrar-independiente') ?>" 
                                                class="btn btn-secondary my-2">Registrar<i
                                                    class="fa-solid fa-plus ml-2"></i></a>
                                        <?php } ?>
                                        <thead>
                                            <tr>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Documento</th>
                                                <th>Fecha nacimiento</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Correo</th>
                                                <th>Salario</th>
                                                <th>Plan asignado</th>
                                                <th>Asignar Plan</th>
                                                <?php if ($this->session->userdata('rol') == 'admin') { ?>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php foreach ($independientes as $key => $independiente) : ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $independiente->nombre_trabajador ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $independiente->apellido_trabajador ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $independiente->documento ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $independiente->fecha_nacimiento ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $independiente->direccion_trabajador ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $independiente->telefono_trabajador ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $independiente->correo_trabajador ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $numero_formateado = number_format($independiente->salario , 2, '.', ',');
                                                            echo $numero_formateado 
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo (empty($independiente->nombre_plan)? "sin asignar": $independiente->nombre_plan) ?>
                                                    </td>
                                                    <?php if(empty($independiente->nombre_plan)) { ?>
                                                        <td>
                                                            <a href="<?php echo base_url() ?>CPlan/planes/<?php echo $independiente->id_trabajador ?>" class="btn btn-secondary">Asignar</a>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td>
                                                            <a href="<?php echo base_url() ?>CPlan/planes/<?php echo $independiente->id_trabajador ?>/<?php echo $independiente->id_plan ?>" class="btn btn-secondary">Cambiar</a>
                                                        </td>
                                                    <?php } ?>

                                                    <?php if ($this->session->userdata('rol') == 'admin') { ?>
                                                        <td>
                                                            <a href="<?php echo base_url("registrar-independiente") ?>/<?php echo $independiente->id_trabajador ?>" class="btn bg-gradient-navy"><i class="fa-solid fa-pencil"></i></a>
                                                        </td>
                                                        <td>
                                                            <button class="btn bg-gradient-danger" data-toggle="modal" data-target="#modalEliminar<?=$independiente->id_trabajador ?>"><i class="fa-solid fa-trash"></i></button>
                                                        </td>
                                                    <?php } ?>
                                                </tr>

                                                <div class="modal fade" id="modalEliminar<?= $independiente->id_trabajador ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Eliminar trabajador</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="accion" value="eliminar">
                                                                <input type="hidden" name="id_trabajador" value="<?= $independiente->id_trabajador ?>">
                                                                <div class="modal-body">
                                                                    <div class="container-fluid ">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <h3>¿Estas seguro de eliminar <b><?= $independiente->nombre_trabajador ?></b>?</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <a href="<?=base_url()?>CIndependiente/eliminarIndependiente/<?php echo $independiente->id_trabajador ?>" class="btn bg-gradient-danger">Confirmar</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include('app/views/layouts/footer.php'); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php $alerta = $this->session->flashdata('alerta');
        if (!empty($alerta)) {
        $alertType = $alerta['status'] ? 'success' : 'error';
        $alertMessage = $alerta['message'];
        $alertTitle = $alerta['title'];
        ?>
        <script>
            swal('<?= $alertTitle ?>', '<?= $alertMessage ?>', '<?= $alertType ?>');
        </script>
    <?php } ?>
    <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>
    <!-- Page specific script -->
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
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: 'csv',
                    text: 'csv',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: 'excel',
                    text: 'excel',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: 'pdf',
                    text: 'pdf',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: 'print',
                    text: 'print',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7] }
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

    </script>
    <!-- Page specific script -->
</body>

</html>