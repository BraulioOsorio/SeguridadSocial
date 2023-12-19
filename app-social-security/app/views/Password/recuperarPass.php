<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('app/views/layouts/head.php'); ?>
</head>
<body class="hold-transition login-page bg-navy">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-info">
      <div class=" text-center">
        <img src="<?= base_url();?>/assets/dist/img/logo-emp.png" alt="" class="img-fluid">
      </div>
      <div class="card-header text-center">
        <a href="#" class="h1 text-navy"><b>Integrando</b> pagos</a>
      </div>
      <div class="card-body">
        <h5 class="login-box-msg text-navy">Ingrese su <b>correo</b> electronico</h5>
        <form action="" method="post">
          <div class="input-group mb-3">
            <?php $data = ['name'=> 'correo','type'=> 'email','placeholder'=> 'Ingrese su Email','class'=> 'form-control']; echo form_input($data); ?>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-6 mx-auto">
              <?php $data = array('type'=>'submit','class'=> 'btn btn-primary btn-block bg-navy mb-3','content'=> 'Enviar'); echo form_button($data); ?>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
<!-- /.login-box -->


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
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>







