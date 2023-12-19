<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('app/views/layouts/head.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include_once('app/views/layouts/menuSuperior.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include_once('app/views/layouts/menuLateral.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Planes de seguros</h1>
            </div>

            <?php
                $nitEmpresa = $this->session->flashdata('nit');  
                $PlanAsignado = $this->session->flashdata('pla');  
                $idTrabajadorr = $this->session->flashdata('id');
                $id_trabajador_filtro = $this->session->flashdata('id_trabajador_filtro');  
                $id_plan_filtro = $this->session->flashdata('id_plan_filtro');  
                $id_nit_filtro = $this->session->flashdata('id_nit_filtro');  
                
                if((!empty($nitEmpresa) || !empty($id_nit_filtro)) and (!empty($PlanAsignado) || !empty($id_plan_filtro))){ 
                  $idDesvincular = null;
                  if($id_nit_filtro == null){
                    $idDesvincular = $nitEmpresa;
                  }else{
                    $idDesvincular = $id_nit_filtro;;
                  }
                  ?>
                
                  <div class="col-sm-6"> 
                    <div class="text-center  float-right">
                      <a href="<?= base_url()?>CEmpresa/DesvincularEmpresa/<?= $idDesvincular?>" class="btn bg-navy">Desvincular Plan</a>
                    </div>  
                  </div>
              <?php
              }elseif((!empty($idTrabajadorr) || !empty($id_trabajador_filtro)) and (!empty($id_plan_filtro) || !empty($PlanAsignado) )){ 
                $idDesvincular = null;
                if($id_trabajador_filtro == null){
                  $idDesvincular = $idTrabajadorr;
                }else{
                  $idDesvincular = $id_trabajador_filtro;
                }
                ?>
                <div class="col-sm-6"> 
                  <div class="text-center  float-right">
                  <a href="<?php echo base_url("") ?>CEmpresa/Desvincular/<?php echo $idDesvincular ?>" class="btn bg-navy">Desvincular Plan</a>
                  </div>  
                </div>
            <?php
              
            }elseif ($this->session->userdata('rol') == 'admin' && empty($idTrabajadorr) and $id_nit_filtro == null and $id_trabajador_filtro == null ){ ?>
              <div class="col-sm-6 ">
                <button type="button" class="btn bg-gradient-navy float-right " data-toggle="modal" data-target="#modalCrear">
                  <b>CREAR PLAN</b> <i class="fa fa-plus"></i>
                </button>
              </div>
          <?php } ?>
            
              
            
            
          </div>
        </div>
        <div class="row mt-2 mb-2">
          <div class="col-sm-4"></div>
          <div class="col-sm-4">
            <?= form_open(); ?>
              <div class="input-group">
                <input class="form-control form-control-sidebar" name="nombre" type="search" placeholder="Buscar plan">
                <input type="hidden" name="accion" value="buscar">
                <input type="hidden" name="id_trabajador" value="<?= isset($idTrabajadorr) ? $idTrabajadorr : $id_trabajador_filtro ?>">
                <input type="hidden" name="id_plan_asignado" value="<?= isset($PlanAsignado) ? $PlanAsignado : $id_plan_filtro ?>">
                <input type="hidden" name="id_nit_empresa" value="<?= isset($nitEmpresa) ? $nitEmpresa : $id_nit_filtro ?>">

                <div class="input-group-append">
                  <button class="btn btn-sidebar" type="submit" >
                    <i class="fas fa-search fa-fw"></i>
                  </button>
                </div>
              </div>
            <?= form_close(); ?>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- /.card-body -->
            <?php $planess = $this->session->flashdata('Planes');
            $idTrabajadorr = $this->session->flashdata('id');
            $nitEmpresa = $this->session->flashdata('nit');  
            $PlanAsignado = $this->session->flashdata('pla');  
            $id_trabajador_filtro = $this->session->flashdata('id_trabajador_filtro');  
            
            if (!empty($planess)) { ?>
              <?php foreach ($planess["planFilter"] as $plan) { ?>
                <div class="col-md-3">
                  <div class="card card-navy card-outline card-style">
                    <div class="row">
                      <?php if ($this->session->userdata('rol') == 'admin' && empty($id_trabajador_filtro)) { ?>
                        <div class="m-2 col-1">
                          <button class="btn bg-gradient-secondary btn-sm" data-toggle="modal" data-target="#modalEditar<?= $plan->id_plan?>">
                            <i class="fas fa-gear giracion"></i>
                          </button>
                        </div>
                        
                        <div class="m-2 col-1">
                          <button class="btn bg-gradient-danger btn-sm" data-toggle="modal" data-target="#modalEliminar<?= $plan->id_plan?>">
                            <i class="fas fa-trash sacudelo"></i>
                          </button>
                        </div>
                      <?php } ?>
                    </div>
                    
                    <div class="card-body box-profile">
                      <h3 class="profile-username text-center">
                        <?= $plan->nombre_plan ?>
                      </h3>
                      <p class="text-muted text-center">
                        <?= $plan->tipo ?>
                      </p>

                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>
                            Porcentaje Salud
                          </b> <a class="float-right"><?= $plan->porcentaje_salud ?>%</a>
                        </li>
                        <li class="list-group-item">
                          <b>
                            Porcentaje Pensión
                          </b> <a class="float-right"><?= $plan->porcentaje_pension ?>%</a>
                        </li>
                        <li class="list-group-item">
                          <b>
                            Porcentaje ARL
                          </b> <a class="float-right"><?= $plan->porcentaje_arl ?> %</a>
                        </li>
                      </ul>
                      

                      <?php if(!empty($nitEmpresa) ){ ?>
                        <div class="text-center">
                          <a href="<?= base_url()?>CPlan/asignarPlanEmpresa/<?php echo $plan->id_plan?>/<?= $nitEmpresa?>" class="btn bg-navy">Asignar Plan</a>
                        </div>
                      <?php }elseif (!empty($id_trabajador_filtro)) {?>
                        <div class="text-center">
                          <a href="<?= base_url()?>CPlan/asignarPlan/<?php echo $plan->id_plan?>/<?= $id_trabajador_filtro?>" class="btn bg-navy">Asignar Plan</a>
                        </div>
                      <?php }?>
                      
                    
                    </div>
                  </div>
                </div>




                <!-- Modal Editar-->
                <div class="modal fade" id="modalEditar<?= $plan->id_plan?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
                  aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id_plan" value="<?= $plan->id_plan?>">
                        <div class="modal-body">
                          <div class="container-fluid ">
                            <div class="row">
                              <div class="col-12">
                                <h3>Estas editando <b><?= $plan->nombre_plan?></b> </h3>
                                <div class="card card-navy card-outline">
                                  <div class="card-body box-profile">
                                    <ul class="list-group list-group-unbordered mb-3">
                                      <li class="list-group-item">
                                        <label for="">Nombre</label>
                                        <?php $data = ['name' => 'nombre', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->nombre_plan ]; echo form_input($data);?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">Tipo</label>
                                        <?php $data = ['name' => 'tipo', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->tipo ]; echo form_input($data);?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">Salud %</label>
                                        <?php $data = ['name' => 'salud', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->porcentaje_salud ]; echo form_input($data); ?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">Pension %</label>
                                        <?php $data = ['name' => 'pension', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->porcentaje_pension ]; echo form_input($data); ?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">ARL %</label>
                                        <?php $data = ['name' => 'arl', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->porcentaje_arl ]; echo form_input($data); ?>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn bg-navy">Actualizar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                  
                <!-- Modal Eliminar-->
                <div class="modal fade" id="modalEliminar<?= $plan->id_plan?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
                  aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Eliminar plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_plan" value="<?= $plan->id_plan?>">
                        <div class="modal-body">
                          <div class="container-fluid ">
                            <div class="row">
                              <div class="col-12">
                                <h3>¿Estas seguro de eliminar <b><?= $plan->nombre_plan ?></b>?</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-danger">Confirmar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



              <?php } ?>
            <?php }elseif ( isset($planes) && empty($planess) ) { ?>
              <?php foreach ($planes as $plan) { ?>
                <div class="col-md-3">
                  <div class="card card-navy card-outline card-style">
                    <div class="row">
                    <?php
                    if($this->session->userdata('rol') == 'admin' && empty($idTrabajador)){ ?>

                        <div class="m-2 col-1">
                        <button class="btn bg-gradient-secondary btn-sm" data-toggle="modal" data-target="#modalEditar<?= $plan->id_plan?>">
                          <i class="fas fa-gear giracion"></i>
                        </button>
                        </div>

                        <div class="m-2 col-1">
                        <button class="btn bg-gradient-danger btn-sm" data-toggle="modal" data-target="#modalEliminar<?= $plan->id_plan?>">
                          <i class="fas fa-trash sacudelo"></i>
                        </button>
                        </div>
                    <?php }
                     ?>
                    </div>
                    <div class="card-body box-profile">
                      <h3 class="profile-username text-center">
                        <?= $plan->nombre_plan ?>
                      </h3>
                      <p class="text-muted text-center">
                        <?= $plan->tipo ?>
                      </p>

                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>
                            Porcentaje Salud
                          </b> <a class="float-right"><?= $plan->porcentaje_salud ?>%</a>
                        </li>
                        <li class="list-group-item">
                          <b>
                            Porcentaje Pensión
                          </b> <a class="float-right"><?= $plan->porcentaje_pension ?>%</a>
                        </li>
                        <li class="list-group-item">
                          <b>
                            Porcentaje ARL
                          </b> <a class="float-right"><?= $plan->porcentaje_arl ?> %</a>
                        </li>
                      </ul>
                      <?php if(!empty($nitEmpresa) ){ ?>
                        <div class="text-center">
                          <a href="<?= base_url()?>CPlan/asignarPlanEmpresa/<?php echo $plan->id_plan?>/<?= $nitEmpresa?>" class="btn bg-navy">Asignar Plan </a>
                        </div>
                      <?php } elseif (empty(!$idTrabajador)) { ?>
                          
                        <div class="text-center">
                          <a href="<?= base_url()?>Cplan/asignarPlan/<?php echo $plan->id_plan?>/<?= $idTrabajador?>" class="btn bg-navy">Asignar Plan</a>
                        </div>
                      <?php }?>
                    </div>
                  </div>
                </div>




                <!-- Modal Editar-->
                <div class="modal fade" id="modalEditar<?= $plan->id_plan?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
                  aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id_plan" value="<?= $plan->id_plan?>">
                        <div class="modal-body">
                          <div class="container-fluid ">
                            <div class="row">
                              <div class="col-12">
                                <h3>Estas editando <b><?= $plan->nombre_plan?></b> </h3>
                                <div class="card card-navy card-outline">
                                  <div class="card-body box-profile">
                                    <ul class="list-group list-group-unbordered mb-3">
                                      <li class="list-group-item">
                                        <label for="">Nombre</label>
                                        <?php $data = ['name' => 'nombre', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->nombre_plan ]; echo form_input($data);?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">Tipo</label>
                                        <?php $data = ['name' => 'tipo', 'type' => 'text', 'class' => 'form-control', 'value' => $plan->tipo ]; echo form_input($data);?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">Salud %</label>
                                        <?php $data = ['name' => 'salud', 'type' => 'number', 'class' => 'form-control', 'value' => $plan->porcentaje_salud ]; echo form_input($data); ?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">Pension %</label>
                                        <?php $data = ['name' => 'pension', 'type' => 'number', 'class' => 'form-control', 'value' => $plan->porcentaje_pension ]; echo form_input($data); ?>
                                      </li>
                                      <li class="list-group-item">
                                        <label for="">ARL %</label>
                                        <?php $data = ['name' => 'arl', 'type' => 'number', 'class' => 'form-control', 'value' => $plan->porcentaje_arl ]; echo form_input($data); ?>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn bg-navy">Actualizar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                  
                <!-- Modal Eliminar-->
                <div class="modal fade" id="modalEliminar<?=$plan->id_plan?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
                  aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Eliminar plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_plan" value="<?= $plan->id_plan?>">
                        <div class="modal-body">
                          <div class="container-fluid ">
                            <div class="row">
                              <div class="col-12">
                                <h3>¿Estas seguro de eliminar <b><?= $plan->nombre_plan ?></b>?</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-danger">Confirmar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



              <?php } ?>
            <?php } ?>
            <!-- /.card-body -->
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
  <!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="modalCrear" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Crear plan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <input type="hidden" name="accion" value="crear">
          <div class="modal-body">
            <div class="container-fluid ">
              <div class="row">
                <div class="col-12">
                  <div class="card card-navy card-outline">
                    <div class="card-body box-profile">
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <label for="">Nombre</label>
                          <?php $data = ['name' => 'nombre', 'type' => 'text', 'class' => 'form-control', 'required' => true,];
                          echo form_input($data); ?>
                        </li>
                        <li class="list-group-item">
                          <label for="">Tipo</label>
                          <?php $data = ['name' => 'tipo', 'type' => 'text', 'class' => 'form-control', 'required' => true,];
                          echo form_input($data); ?>
                        </li>
                        <li class="list-group-item">
                          <label for="">Salud %</label>
                          <?php $data = ['id' => 'campoSalud', 'name' => 'salud', 'type' => 'text', 'class' => 'form-control'];
                          echo form_input($data); ?>
                        </li>
                        <li class="list-group-item">
                          <label for="">Pension %</label>
                          <?php $data = ['id' => 'campoPension', 'name' => 'pension', 'type' => 'text', 'class' => 'form-control'];
                          echo form_input($data); ?>
                        </li>
                        <li class="list-group-item">
                          <label for="">ARL %</label>
                          <?php $data = ['id' => 'campoArl', 'name' => 'arl', 'type' => 'text', 'class' => 'form-control'];
                          echo form_input($data); ?>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn bg-gradient-navy">Crear</button>
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
      swal('<?= $alertTitle ?>', '<?= $alertMessage ?>', '<?= $alertType ?>');
    </script>
  <?php } ?>
  <script>
    let campoSalud = document.getElementById('campoSalud');
    let campoPension = document.getElementById('campoPension');
    let campoArl = document.getElementById('campoArl');

    campoSalud.addEventListener('input', function () {
      let salud = campoSalud.value;

      let validInput =  salud.match(/^[\d.]+$/);


      if (!validInput) {
        campoSalud.value = salud.replace(/[^\d.]/g, '');
      }
    });

    campoPension.addEventListener('input', function () {
      let pension = campoPension.value;

      let validInput =  pension.match(/^[\d.]+$/);


      if (!validInput) {
        campoPension.value = pension.replace(/[^\d.]/g, '');
      }
    });

    campoArl.addEventListener('input', function () {
      let arl = campoArl.value;

      let validInput =  arl.match(/^[\d.]+$/);


      if (!validInput) {
        campoArl.value = arl.replace(/[^\d.]/g, '');
      }
    });


    function handleKeyPress(event) {
      // Verificar si se presionó una letra
      if (/^[a-zA-Z]$/.test(event.key)) {
        console.log('Se presionó una letra: ' + event.key);
      }
      
      // Verificar si se presionó un número
      if (/^\d$/.test(event.key)) {
        console.log('Se presionó un número: ' + event.key);
      }
    }
  </script>
  <!-- jQuery -->
  <script src=" <?= base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src=" <?= base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url(); ?>/assets/dist/js/demo.js"></script>
  <script src="<?= base_url(); ?>/assets/dist/js/main.js"></script>

</body>

</html>