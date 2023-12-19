<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('app/views/layouts/head.php'); ?>
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="hold-transition login-page bg-navy">
  <form action="" method="post" id="formApi" hidden><input name="destinatario" type="email" value="<?= $this->session->userdata('correo'); ?>"></form>
  <div class="login-box">
    <div class="card card-outline card-info">
      <div class=" text-center">
        <img src="<?= base_url();?>/assets/dist/img/logo-emp.png" alt="" class="img-fluid">
      </div>
      <div class="card-header text-center">
        <a href="#" class="h1 text-navy"><b>Integrando</b> pagos</a>
      </div>
      <div class="card-body">
        <h5 class="login-box-msg text-navy">Ingrese el <b>token</b> que fue enviado a su correo</h5>
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="number" name="num1" placeholder="*" min="0" max="9" class="form-control text-center" oninput="moveToNextInput(this, 'num2')" onkeydown="moveToPreviousInput(this, 'num1')">
            <input type="number" name="num2" placeholder="*" min="0" max="9" class="form-control text-center" oninput="moveToNextInput(this, 'num3')" onkeydown="moveToPreviousInput(this, 'num1')">
            <input type="number" name="num3" placeholder="*" min="0" max="9" class="form-control text-center" oninput="moveToNextInput(this, 'num4')" onkeydown="moveToPreviousInput(this, 'num2')">
            <input type="number" name="num4" placeholder="*" min="0" max="9" class="form-control text-center" onkeydown="moveToPreviousInput(this, 'num3')">
          </div>
          <div class="row">
            <div class="col-6 mx-auto">
              <?php $data = array('type'=>'submit','class'=> 'btn btn-primary btn-block bg-navy mb-3','content'=> 'Enviar'); echo form_button($data); ?>
            </div>
          </div>
        </form>
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
      const postCorreo = async () => {
        let formApi = document.getElementById('formApi');
        let datos = new FormData(formApi);
        try {
          const peticion = await fetch('http://127.0.0.1:8000/recuperarPassw',{method:"POST",body:datos });
          const response = await peticion.json();
          console.log(response);
        } catch (error) {
          console.error(error);
        }
      }
      postCorreo();
      swal('<?= $alertTitle ?>', '<?= $alertMessage ?>', '<?= $alertType ?>');
    </script>
<?php } ?>
<script>
    function moveToNextInput(currentInput, nextInputId) {
      if (currentInput.value.length === 1) {
        document.getElementsByName(nextInputId)[0].focus();
      }
    }

    function moveToPreviousInput(currentInput, previousInputName) {
      if (event.key === "Backspace" && currentInput.value === "") {
        document.getElementsByName(previousInputName)[0].focus();
      }
    }
  </script>
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>







