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
                            <h1>Buscar <?= ($tipo == 'empresa')?'Empresa':'Persona'?></h1>
                        </div>
                    </div>
                    <?php 
                    $alerta = $this->session->flashdata('alertaa');
                    if (!empty($alerta)) { ?>
                        <div class="alert alert-<?= $alerta["color"]?> alert-dismissible fade show" role="alert">
                            <strong><?= $alerta["mensaje"]?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </section>


            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card">
                                <div class="m-3 text-center">
                                    <div>
                                        <h5>
                                            <?= ($tipo == 'empresa')?'Ingrese el NIT de la empresa':'Ingrese el documento de la persona' ?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="px-2 py-4">
                                    <?= form_open('CPago/estadoPago'); ?>
                                    <div class="row justify-content-center">
                                        <div class="col-auto mt-2">
                                            <label for="cedula" class="form-group">Buscar</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="hidden" name="tipo" value="<?= $tipo?>">
                                            <input type="number" name="<?= ($tipo == 'empresa')?'nit':'documento'?>" class="form-control" placeholder="<?= ($tipo == 'empresa')?'Ingrese el NIT de la empresa':'Ingrese el documento de la persona'?>">
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-sidebar" type="submit">
                                                <i class="fas fa-search fa-fw"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?= form_close(); ?>
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
    
    <script>
        
    </script>
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