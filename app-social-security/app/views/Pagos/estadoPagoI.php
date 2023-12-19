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
                            <h1>Estado de cuenta de la persona</h1>
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
                                    <h3 class="card-title">Lista de pago</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Nombre</th>
                                                <th>Plan</th>
                                                <th>Monto</th>
                                                <th>Fecha Pago</th>
                                                <th>Estado Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($estadoPago as $key => $iPago) : ?>
                                                <tr class="text-center">
                                                    <td><?= $iPago->nombre_trabajador ?></td>
                                                    <td><?= $iPago->nombre_plan ?></td>
                                                    <td>
                                                        <?= number_format($iPago->monto_total , 2, '.', ',');?>
                                                    </td>
                                                    <td><?= $iPago->fecha_pago ?></td>
                                                    <td>
                                                        <?= ($iPago->estado_pago != 1)? "<button id='btn_tabla' class='btn bg-gradient-success' data-toggle='modal' data-target='#modalPago$iPago->id_pago_in'>Pagar</button>": "<h4 class='text-success' id='textoPagado'>PAGADO</h4>" ?>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modalPago<?= $iPago->id_pago_in?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Realizar pago</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= base_url()?>CPago/indePago" method="post">
                                                                <input type="hidden" name="id_pago_in" value="<?= $iPago->id_pago_in ?>">
                                                                <input type="hidden" name="monto" value="<?= $iPago->monto_total?>">
                                                                <div class="modal-body">
                                                                    <div class="container-fluid ">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label for="dinero">Ingrese con cuanto desea pagar</label>
                                                                                <div class="input-group mb-3 col-auto">
                                                                                <input type="text" name="dineroRecibido" id="dinero" class="form-control" required onkeydown="handleKeyPress(event)">
                                                                                    <div class="input-group-append">
                                                                                        <div class="input-group-text">
                                                                                            <span class="fas fa-dollar"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <p id="msg" style="color:red"></p>
                                                                                <input type="hidden" name="correo" value="<?= $iPago->correo_trabajador?>">
                                                                                <input type="hidden" id="monto" name="monto" value="<?= $iPago->monto_total?>">
                                                                                <input type="hidden" name="trabajador" value="<?= $iPago->nombre_trabajador?>">
                                                                                <input type="hidden" name="plan" value="<?= $iPago->nombre_plan?>">
                                                                                <input type="hidden" name="fecha" value="<?= $iPago->fecha_pago?>">
                                                                            </div>
                                                                            
                                                                            <div class="col-12 mt-2">
                                                                                <p class=""><b>NOMBRE TRABAJADOR</b>: <?= $iPago->nombre_trabajador ?></p> 
                                                                                <p class=""><b>CORREO TRABAJADOR</b>: <?= $iPago->correo_trabajador ?></p>                                                                    
                                                                                <p class=""><b>NOMBRE PLAN</b>: <?= $iPago->nombre_plan ?></p>                                                                    
                                                                                <p class=""><b>MONTO A PAGAR</b>: <?= number_format($iPago->monto_total , 0, '.', ',');?></p>     
                                                                                <p class=""><b>FECHA LIMITE</b>: <?= $iPago->fecha_pago ?></p>                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" id="btn_pago" class="btn bg-gradient-navy" disabled>Pagar</button>
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
                                                <th>Plan</th>
                                                <th>Monto</th>
                                                <th>Fecha Pago</th>
                                                <th>Estado Pago</th>
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
    <script>
        let monto = document.getElementById('monto');
        let msg = document.getElementById('msg');
        let dinero = document.getElementById('dinero');
        let btn_pago = document.getElementById('btn_pago');

        dinero.addEventListener('input', function(event) {
            let dinero = event.target.value.replace(/[^0-9]/g, '');

            if (dinero.length > 0) {
                dinero = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(parseFloat(dinero));
                event.target.value = dinero;
            }

            compararMontos();
        });

        function compararMontos() {
            let montoNumerico = parseFloat(monto.value.replace(/[^0-9]/g, '')) / 100;
            let dineroSinSimbolo = dinero.value.replace(/[^\d]/g, ''); // Eliminar caracteres no numéricos
            let dineroNumerico = parseInt(dineroSinSimbolo);
            let resultado = montoNumerico > dineroNumerico ? 'dinero insuficiente' : montoNumerico < dineroNumerico ? '' : '';
            if (resultado == '') {
                dinero.classList.add('border-success');
                btn_pago.disabled = false;
            } else {
                dinero.classList.remove('border-success');
                btn_pago.disabled = true;
            }
            msg.textContent = resultado;
        }

        function handleKeyPress(event) {
            const isLetter = /^[a-zA-Z]$/.test(event.key);
            const isSymbol = event.key.length === 1 && !/^[a-zA-Z\d]$/.test(event.key);
            if ( isLetter || isSymbol ) {
                event.preventDefault();
            }
        }

    </script>
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
                    exportOptions: {columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: 'csv',
                    text: 'csv',
                    exportOptions: {columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: 'excel',
                    text: 'excel',
                    exportOptions: {columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: 'pdf',
                    text: 'pdf',
                    exportOptions: {columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: 'print',
                    text: 'print',
                    exportOptions: {columns: [0, 1, 2, 3, 4] }
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