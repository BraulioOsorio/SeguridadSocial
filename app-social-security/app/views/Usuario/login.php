<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('app/views/layouts/head.php'); ?>
</head>
<body class="hold-transition login-page bg-navy">
  <div class="login-box">
    <div class="card card-outline card-info">
      <div class=" text-center">
        <img src="<?= base_url();?>/assets/dist/img/logo-emp.png" alt="" class="img-fluid">
      </div>
      <div class="card-header text-center">
        <a href="<?= base_url()?>" class="h1 text-navy"><b>Integrando</b> pagos</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg text-navy">Ingrese sus datos para iniciar sesion</p>
        <p class="text-danger" id="msg"></p>
        <form action="" method="post" class="needs-validation" novalidate id="login_form">
          
          <div class="input-group mb-3 col-auto" >
            <?php $data = ['name'=> 'correo','id' => 'form_correo','type'=> 'email','placeholder'=> 'Email','class'=> 'form-control',"required" => true]; echo form_input($data); ?>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <div class="invalid-feedback" id="email">
              
            </div>
          </div>
          <div class="input-group mb-3 col-auto">
            <?php $data = ['name'=> 'contrasenia','id'=>'form_passw','type'=> 'password','placeholder'=> 'Contraseña','class'=> 'form-control',"required" => true]; echo form_input($data); ?>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <button class="btn" type="button" id="btn_eye"><i class="fa-regular fa-eye-slash" id="icon"></i></button>
            <div class="invalid-feedback" id="passw">
              
            </div>
          </div>
          <div class="row">
            <div class="col-6 mx-auto">
              <?php $data = array('type'=>'submit','class'=> 'btn btn-primary btn-block bg-navy mb-3','content'=> 'Iniciar sesion'); echo form_button($data); ?>
            </div>
          </div>
        </form>
        <p class="mb-1">
          <a href="<?= base_url() ?>CUsuario/recuperar">Olvide mi contraseña</a>
        </p>
      </div>
    </div>
  </div>
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
  <script>
    let btn_eye = document.getElementById('btn_eye');
    let icon = document.getElementById('icon');
    let form_passw = document.getElementById('form_passw');

    btn_eye.addEventListener('click', () => {
      const isPassword = form_passw.type === 'password';
      icon.classList.replace(isPassword ? 'fa-eye-slash' : 'fa-eye', isPassword ? 'fa-eye' : 'fa-eye-slash');
      form_passw.type = isPassword ? 'text' : 'password';
    });
  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url('/assets/dist/js/auth/login.js')?>"></script>
<script src="<?= base_url('/assets/plugins/jquery/jquery.min.js');?>"></script>
<script src="<?= base_url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
<script src="<?= base_url('/assets/dist/js/adminlte.min.js');?>"></script>
</body>
</html>
