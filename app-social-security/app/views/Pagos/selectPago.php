<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('app/views/layouts/head.php'); ?>
    <style>
        .pago-section{
            height: 500px;
            
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('app/views/layouts/menuSuperior.php'); ?>
        <!-- /.navbar -->

        <?php include_once('app/views/layouts/menuLateral.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Modulo de pago</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card m-3 pago-section">
                            
                                <div class="row text-center m-3">
                                    <div class="col-6" style="margin-top: 220px;">
                                        <a href="<?= base_url('buscar-pago/persona')?>" class="btn bg-gradient-secondary">PAGO PARA INDEPENDIENTE</a>
                                    </div>
                                    <div class="col-6" style="margin-top: 220px;">
                                        <a href="<?= base_url('buscar-pago/empresa')?>" class="btn bg-gradient-navy">PAGO PARA EMPRESA</a>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('app/views/layouts/footer.php'); ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>
    <!-- Page specific script -->
</body>

</html>
