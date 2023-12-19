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
                            <h1>Asignar empleado</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>inicio"">Home</a></li>
                                <li class=" breadcrumb-item active">Validation</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card">
                                <div class="m-3">
                                    <div>
                                        <h5>Tenga en cuenta que...</h5>
                                    </div>
                                    <div>
                                        <p>
                                            Deberá de ingresar el número de cédula del trabajador ya
                                            registrado anteriormente en el sistema en el campo buscar.
                                        </p>
                                    </div>
                                </div>
                                <div class="px-2 py-4">
                                    <?= form_open('CEmpresa/buscarTrabajador'); ?>
                                    <div class="row justify-content-center">
                                        <div class="col-auto mt-2">
                                            <label for="cedula" class="form-group">Buscar</label>
                                        </div>
                                        <div class="col-3">
                                            <?php
                                            $data = [
                                                'name' => 'cedulaTrabajador',
                                                'type' => 'number',
                                                'class' => 'form-control',
                                                'placeholder' => 'Documento del trabajador',
                                                'id' => 'cedula',
                                                'required' => true
                                            ];
                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-sidebar" type="submit">
                                                <i class="fas fa-search fa-fw"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                                <div class="ml-4 mb-2 ">
                                    <?php $alerta = $this->session->flashdata('alertaa');
                                    if (!empty($alerta)) {
                                        ?>
                                        <div class="row mb-2 ms-1 justify-content-center">
                                            <div class="col-5">
                                                <div class="alert alert-<?php echo $alerta['color']; ?>" role="alert">
                                                    <?php echo $alerta['mensaje']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="ml-4 mb-2 mx-auto">
                                    <?php if ($status == true): ?>

                                        <p><b>  Nombre del empleado:</b>
                                            <?php echo $nombre_trabajador; ?>
                                        </p>
                                        <p><b>Apellido del empleado:</b>
                                            <?php echo $apellido_trabajador; ?>
                                        </p>
                                        <p><b>Correo electrónico del empleado:</b>
                                            <?php echo $correo_trabajador; ?>
                                        </p>
                                        <a href="asignarTrabajador/<?php echo $this->session->userdata('id_empresa') ?>/<?php echo $id_trabajador; ?>" class="btn bg-gradient-navy">Asignar</a>
                                    <?php endif; ?>
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

    <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>
    <!-- Page specific script -->

    <!-- Page specific script -->
</body>

</html>