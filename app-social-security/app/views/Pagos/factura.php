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
                            <h1></h1>
                        </div>
                    </div>
                </div>
            </section>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Transaccion exitosa.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php 
                $alertaCorreo = $this->session->flashdata('alertaCorreo');
                if (!empty($alertaCorreo)) { ?>
                    <div class="alert alert-<?= $alertaCorreo["color"]?> alert-dismissible fade show" role="alert">
                        <strong><?= $alertaCorreo["mensaje"]?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <?php } ?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Factura de pago</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th><?= !empty($empresa)?'Empresa': 'Trabajador'; ?></th>
                                                <th>Plan</th>
                                                <th>Total Pagado</th>
                                                <th>Monto Recibido</th>
                                                <th>Devuelta</th>
                                                <th>Fecha Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($vdata)) extract($vdata); ?>
                                            <tr class="text-center">
                                                <td><?= !empty($empresa) ? "Empresa" : "Trabajador"; ?></td>
                                                <td> <?= $plan; ?> </td>
                                                <td> <?= number_format($monto, 2, '.', ','); ?> </td>
                                                <td> <?= number_format($dineroRecibido, 2, '.', ','); ?> </td>
                                                <td> <?= number_format($devuelta, 2, '.', ','); ?> </td>
                                                <td> <?= $fecha; ?> </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-center">
                                                <th><?= !empty($empresa) ? "Empresa" : "Trabajador"; ?></th>
                                                <th>Plan</th>
                                                <th>Total Pagado</th>
                                                <th>Monto Recibido</th>
                                                <th>Devuelta</th>
                                                <th>Fecha Pago</th>
                                            </tr>
                                        </tfoot>
                                    </table>    
                                    <div class=" text-center">
                                        <a href="<?= !empty($empresa)?base_url('buscar-pago/empresa'):base_url('buscar-pago/persona') ;?>" class="btn bg-gradient-navy">Volver al menu</a>
                                    </div>
                                    
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
   
    
    <script src="<?= base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?= base_url(); ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
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
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5] }
                },
                {
                    extend: 'csv',
                    text: 'csv',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5] }
                },
                {
                    extend: 'excel',
                    text: 'excel',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5] }
                },
                {
                    extend: 'pdf',
                    text: 'pdf',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5] }
                },
                {
                    extend: 'print',
                    text: 'print',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5] }
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