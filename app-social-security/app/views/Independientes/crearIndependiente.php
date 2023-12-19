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
                            <h1>Personas Independientes</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Validation</li>
                            </ol>
                        </div>
                    </div>
                    <?php $alerta = $this->session->flashdata('alertaa');
                    if (!empty($alerta)) {
                        ?>
                        <div class="row mb-2 ms-1">
                            <div class="col-5">
                                <div class="alert alert-<?php echo $alerta['color']; ?>" role="alert">
                                    <?php echo $alerta['mensaje']; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row mb-2">

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
                                    <h3 class="card-title">Datos de la Persona Independiente</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="post">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="nombre_i">Nombres:</label>
                                                <?php $data = [ 'name' => 'nombre_trabajador', 'type' => 'text', 'value' =>$nombre_trabajador, 'class' => 'form-control mb-3', 'id' => 'nombre_i', 'required' => true]; echo form_input($data); ?>
                                                
                                                <label for="documento_i">N. Documento:</label>
                                                <?php $data = ['name' => 'documento','type' => 'number','value' => $documento,'class' => 'form-control mb-3','id' => 'documento_i','required' => true,]; echo form_input($data);?>
                                                

                                                <label for="direccion_i">Dirección:</label>
                                                <?php $data = ['name' => 'direccion_trabajador','type' => 'text','value' => $direccion_trabajador,'class' => 'form-control mb-3','id' => 'exampleInputPassword1','required' => true,]; echo form_input($data);?>
                                                

                                                <label for="fecha_nacimiento_i">Fecha nacimiento:</label>
                                                <?php $data = ['name' => 'fecha_nacimiento','type' => 'date','value' => $fecha_nacimiento,'class' => 'form-control ','id' => 'fecha_nacimiento_i','required' => true,]; echo form_input($data);?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="apellido_i">Apellidos:</label>
                                                <?php $data = ['name' => 'apellido_trabajador','type' => 'text','value' =>$apellido_trabajador,'class' => 'form-control mb-3','id' => 'apellido_i','required' => true,]; echo form_input($data);?>

                                                
    
                                                <div id="divTel">
                                                    <label for="telefono_i">Teléfono:</label>
                                                    <?php $data = ['name' => 'telefono_trabajador','type' => 'number','value' => $telefono_trabajador,'class' => 'form-control mb-3','id' => 'inputTelefono','required' => true,]; echo form_input($data);?>
                                                </div>
    
                                                <label for="correo_i">Correo:</label>
                                                <?php $data = ['name' => 'correo_trabajador','type' => 'email','value' => $correo_trabajador,'class' => 'form-control mb-3','id' => 'correo_i','required' => true,]; echo form_input($data);?>
    
                                                <label for="salario_i">Salario:</label>
                                                <?php $data = ['name' => 'salario','type' => 'number','value' => $salario,'class' => 'form-control ','id' => 'salario_i','required' => true,]; echo form_input($data);?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
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
    <script>
        let inputTelefono = document.getElementById('inputTelefono');
        let divTel = document.getElementById('divTel');
        let nuevoParrafo = document.createElement('span');

        //Evento blur es para cuando el usuario apunte en otro input o parte de la pagina
        inputTelefono.addEventListener('input', function () {
            let telefono = inputTelefono.value;
            console.log(telefono);
            telefono = telefono.replace(/\D/g, '');


            if (telefono.length > 10) {
                nuevoParrafo.textContent = 'El telefono debe tener un tamaño maximo de 10 dígitos';
                nuevoParrafo.classList.add('text-danger');
                divTel.append(nuevoParrafo);
                telefono = telefono.slice(0, 10);
            } else {
                nuevoParrafo.textContent = '';
            }

            inputTelefono.value = telefono;
        });

        let quickForm = document.getElementById("quickForm");
        quickForm.addEventListener('submit', (e)=>{
            e.preventDefault();
            quickForm.submit();
            quickForm.reset();
        });

    </script>
    
</body>

</html>