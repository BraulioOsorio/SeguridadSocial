<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Validation Form</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header dark-mode navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <?php include_once('application/views/layouts/menuSuperior.php'); ?>
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>/assets/index3.html" class="brand-link">
      <img src="<?php echo base_url();?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <?php include('application/views/layouts/perfil.php') ?>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php include_once('application/views/layouts/menuLateral.php'); ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usuario</h1>
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
                <h3 class="card-title">Datos del usuario</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form id="quickForm" method="post">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Correo electronico</label>
                        <?php
                        
                        $data = [
                        'name'      => 'correo',
                        'type'      => 'email',
                        'value'     => $correo,
                        'class'     => 'form-control',
                        'id'     => 'exampleInputEmail1',
                        ];
                        echo form_input($data);
                        ?>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <?php
                        $data = [
                        'name'      => 'passw',
                        'type'      => 'password',
                        'value'     =>  $passw,
                        'class'     => 'form-control',
                        'id'     => 'exampleInputPassword1',
                        ];
                        echo form_input($data);
                        ?>
                      </div>
                      <div class="form-group mb-0">
                          <div class="form-group">
                              <div class="custom-control custom-switch ">
                                  <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                  <label class="custom-control-label" for="customSwitch3">Mostrar contraseña</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="">Rol</label>
                        <select name="rol" class="custom-select">
                            <?php if (isset($rol) && $rol !== '') { ?>
                                    <option value="<?= $rol?>"><?= $rol?></option>
                                    <option value="<?= ($rol == 'lector')?'admin':'lector'?><?= $rol?>"><?= ($rol == 'lector')?'Admin':'Lector'?></option>
                                    
                            <?php  }else { ?>
                                    <option value="">Seleccione un rol</option>
                                    <option value="admin">Admin</option>
                                    <option value="lector">Lector</option>
                            <?php   } ?>
                        </select>
                      </div>
                      <div class="form-group">                        
                        <?php //($estado == '0')?'<button class="btn bg-gradient-success">Activar</button>':'' ?>
                      </div>
                    </div>
                
                    <div class="card-footer">
                    <?php
                        $data = array(
                            'name'          => 'mysubmit',
                            'id'            => 'boton',
                            'type'          => 'submit',
                            'class'         => 'btn bg-gradient-secondary',
                            'content'       => 'Enviar!'
                        );
                        echo form_button($data);
                    ?>
                    </div>
                  </form>
                </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="<?php echo base_url();?>/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>/assets/dist/js/main.js"></script>
<!-- Page specific script -->
<script>
// $(function () {
//   $('#quickForm').validate({
//     rules: {
//       email: {
//         required: true,
//         email: true,
//       },
//       password: {
//         required: true,
//         minlength: 5
//       },
//       terms: {
//         required: true
//       },
//     },
//     messages: {
//       email: {
//         required: "Please enter a email address",
//         email: "Por ingrese un email valido"
//       },
//       password: {
//         required: "Please provide a password",
//         minlength: "Your password must be at least 5 characters long"
//       },
//       terms: "Please accept our terms"
//     },
//     errorElement: 'span',
//     errorPlacement: function (error, element) {
//       error.addClass('invalid-feedback');
//       element.closest('.form-group').append(error);
//     },
//     highlight: function (element, errorClass, validClass) {
//       $(element).addClass('is-invalid');
//     },
//     unhighlight: function (element, errorClass, validClass) {
//       $(element).removeClass('is-invalid');
//     }
//   });
// });
</script>
</body>
</html>
