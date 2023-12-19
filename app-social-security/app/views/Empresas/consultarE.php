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
                            <h1>Empresas</h1>
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
                                <div class="px-2 py-4">
                                    <table id="example1" class="table table-bordered table-striped text-center">
                                        <?php if ($this->session->userdata('rol') == 'admin') { ?>
                                            <a href="<?= base_url() ?>CEmpresa/crearEmpresa"
                                                class="btn btn-secondary my-2">Registrar<i
                                                    class="fa-solid fa-plus ml-2"></i></a>
                                        <?php } ?>
                                        <thead>
                                            <tr>
                                                <th clas="">Nombre</th>
                                                <th clas="">NIT</th>
                                                <th clas="">Dirección</th>
                                                <th clas="">Teléfono</th>
                                                <th clas="">Correo</th>
                                                <th clas="">Info</th>
                                                <th clas="">Asignar empleado</th>
                                                <th>Plan asignado</th>
                                                <th>Asignar Plan</th>
                                                <?php if ($this->session->userdata('rol') == 'admin') { ?>
                                                    <th clas="">Editar</th>
                                                    <th clas="">Eliminar</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($empresas as $ke => $empresa): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $empresa->nombre_empresa ?> 
                                                </td>
                                                <td>
                                                    <?php echo $empresa->nit ?> 
                                                </td>
                                                <td>
                                                    <?php echo $empresa->direccion_empresa ?> 
                                                </td>
                                                <td>
                                                    <?php echo $empresa->telefono_empresa ?> 
                                                </td>
                                                <td>
                                                    <?php echo $empresa->correo_empresa ?> 
                                                </td>
                                                <td>
                                                <!-- CEmpresa -->
                                                    
                                                    <a href="TrabajadoresEmpresa/<?php echo $empresa->id_empresa ?>" class="btn btn-secondary"><i class="fa-solid fa-circle-info"></i></a>

                                                </td>
                                                <td>
                                                <!-- CEmpresa -->
                                                    <a href="buscarTrabajador/<?php echo $empresa->id_empresa ?>" class="btn btn-warning"><i class="fa-solid fa-people-arrows"></i></a>
                                                </td>
                                                <td>
                                                    <?php echo (empty($empresa->nombre_plan)? "sin asignar": $empresa->nombre_plan) ?>
                                                </td>
                                                <?php if(empty($empresa->nombre_plan)) { ?>
                                                    <td>
                                                        <a href="<?php echo base_url() ?>CPlan/planes/<?php echo $empresa->nit ?>" class="btn btn-secondary">Asignar</a>
                                                    </td>
                                                    <?php } else { ?>
                                                        <td>
                                                            <a href="<?php echo base_url() ?>CPlan/planes/<?php echo $empresa->nit ?>/<?php echo $empresa->id_plan ?>" class="btn btn-secondary">Cambiar</a>
                                                        </td>
                                                    <?php } ?>
                                                <?php if($this->session->userdata('rol') == 'admin'){ ?>
                                                    <td>
                                                        <a href="crearEmpresa/<?php echo $empresa->id_empresa ?>" class="btn bg-gradient-navy"><i class="fa-solid fa-pencil"></i></a>
                                                    </td>
                                                    <td >
                                                        <a href="eliminarEmpresa/<?php echo $empresa->id_empresa ?>" class="btn bg-gradient-danger"><i class="fa-solid fa-trash"></i></a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
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
    <script
        src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script
        src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
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
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'csv',
                text: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'excel',
                text: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdf',
                text: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                text: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            'colvis'
        ]
    });

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