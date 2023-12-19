<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('app/views/layouts/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include_once('app/views/layouts/menuSuperior.php'); ?>
  <?php include_once('app/views/layouts/menuLateral.php'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil de usuario</h1>
          </div>
        </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <div class="card card-navy card-outline">
              <div class="card-body box-profile text-center">
                <img class="profile-user-img img-fluid img-circle" src="<?php if(!empty($this->session->userdata('foto'))){?><?=base_url();?><?=$this->session->userdata('foto')?><?php }else{ ?><?= base_url();?>assets/dist/img/user2-160x160.jpg<?php } ?>" alt="foto de perfil">
                <h3 class="profile-username"><?= $nombre." ".$apellido?></h3>
                <p class="text-muted mt-3"><?= ($rol == 'admin')?'ADMINISTRADOR':'EMPLEADO'?></p>
                <h5 class="profile-username mb-3"><?= $correo?></h5>
                
                <form action="<?= base_url()?>CUsuario/cambiarFoto" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="userfile" class="form-label">Cambiar foto de perfil:</label>
                  <input type="file" class="form-control" name="userfile" size="20" accept="image/*">
                </div>
                <button type="submit" class="btn bg-gradient-navy btn-block">Cambiar foto</button>
              </form>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <h4 class="text-center">Configuracion</h4>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane">
                    <form class="form-horizontal" method="post">
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="inputEmail" class="col-form-label">Nombre</label>
                          <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?= $nombre;?>">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputEmail" class="col-form-label">Apellido</label>
                          <input type="text" class="form-control" name="apellido" placeholder="Apellido" value="<?= $apellido;?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="inputEmail" class="col-form-label">Correo</label>
                          <input type="email" class="form-control" name="correo" placeholder="Email" value="<?= $correo;?>">
                        </div>
                        <div class="col-sm-4">
                          <label for="inputExperience" class="col-form-label">Contraseña</label>
                          <input type="password" class="form-control" id="form_passw" name="passw" placeholder="contraseña" value="<?= $passw;?>">
                        </div>
                        <div class="col-sm-2">
                          <label for="" class="col-form-label">ver contraseña</label>
                          <button class="btn" type="button" id="btn_eye"><i class="fa-regular fa-eye-slash" id="icon"></i></button>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12 text-center">
                          <button type="submit" class="btn bg-gradient-navy">Editar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </section>
  </div>
  <?php include('app/views/layouts/footer.php'); ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
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
<script src=" <?= base_url();?>/assets/plugins/jquery/jquery.min.js"></script>
<script src=" <?= base_url();?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url();?>/assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url();?>/assets/dist/js/demo.js"></script>
</body>
</html>
