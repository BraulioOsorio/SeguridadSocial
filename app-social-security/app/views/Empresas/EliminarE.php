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
                            <h1>Confirmacion de Eliminacion de Empresa</h1>
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
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Datos de la Empresa</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="post" action="../borrar/<?php echo $id_empresa ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nombre</label>
                                            <?php

                                            $data = [
                                                'name' => 'nombre_empresa',
                                                'type' => 'text',
                                                'value'     => $nombre_empresa,
                                                'class' => 'form-control',
                                                'id' => 'exampleInputEmail1',
                                                'required' => true,
                                                'disabled' => 'disabled',
                                            ];
                                            echo form_input($data);
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">NIT</label>
                                            <?php
                                            $data = [
                                                'name' => 'nit',
                                                'type' => 'number',
                                                 'value'     =>  $nit,
                                                'class' => 'form-control',
                                                'id' => 'exampleInputPassword1',
                                                'required' => true,
                                                'disabled' => 'disabled',
                                            ];
                                            echo form_input($data);
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Direccion</label>
                                            <?php
                                            $data = [
                                                'name' => 'direccion',
                                                'type' => 'text',
                                                'value'     =>  $direccion_empresa,
                                                'class' => 'form-control',
                                                'id' => 'exampleInputPassword1',
                                                'required' => true,
                                                'disabled' => 'disabled',
                                            ];
                                            echo form_input($data);
                                            ?>
                                        </div>
                                        <div class="form-group" id="divTel">
                                            <label for="exampleInputPassword1">Telefono</label>
                                            <?php
                                            $data = [
                                                'name' => 'telefono',
                                                'type' => 'number',
                                                'value'     =>  $telefono_empresa,
                                                'class' => 'form-control',
                                                'id' => 'inputTelefono',
                                                'required' => true,
                                                'disabled' => 'disabled',
                                            ];
                                            echo form_input($data);
                                            ?>
                                            <p id="parrafoTel"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Correo</label>
                                            <?php
                                            $data = [
                                                'name' => 'correoEmpresa',
                                                'type' => 'Email',
                                                'value'     =>  $correo_empresa,
                                                'class' => 'form-control',
                                                'id' => 'exampleInputPassword1',
                                                'required' => true,
                                                'disabled' => 'disabled',
                                            ];
                                            echo form_input($data);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <?php
                                        $data = array(
                                            'name' => 'mysubmit',
                                            'id' => 'boton',
                                            'type' => 'submit',
                                            'class' => 'btn bg-gradient-secondary',
                                            'content' => 'Enviar!'
                                        );
                                        echo form_button($data);
                                        ?>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
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

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>/assets/dist/js/main.js"></script>
    <!-- Page specific script -->
    
</body>

</html>