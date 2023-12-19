<aside class="main-sidebar elevation-4 sidebar-light-navy ">
  <!-- Brand Logo -->
  <a href="<?= base_url(); ?>inicio" class="brand-link bg-navy">
    <img src="<?= base_url(); ?>/assets/dist/img/logo-emp.png" alt="Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Integrando pagos</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img class="img-circle elevation-2" src="<?php if(!empty($this->session->userdata('foto'))){?><?=base_url();?><?=$this->session->userdata('foto')?><?php }else{ ?><?= base_url();?>assets/dist/img/user2-160x160.jpg<?php } ?>" alt="foto de perfil">
      </div>
      <div class="info">
        <a href="<?= base_url(); ?>CUsuario/perfil" class="d-block">
          <?= $this->session->userdata('name'); ?>
        </a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- /.sidebar-menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item ">
          <a href="<?= base_url() ?>inicio" class="nav-link">
            <i class="nav-icon fa-solid fa-house"></i>
            <p>
              Inicio
            </p>
          </a>
        </li>
        <li class="nav-header">FUNCIONES</li>
        <?php if ($this->session->userdata('rol') == 'empleado') { ?>
          <li class="nav-item">
            <a href="<?= base_url('CEmpresa/consultarEmpresas')?>" class="nav-link">
              <i class="nav-icon fa-solid fa-list"></i>
              <p>
                Lista de empresas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('lista-independientes') ?>" class="nav-link">
              <i class="nav-icon fa-solid fa-list"></i>
              <p>
                Lista de independientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('CPlan/planes')?>" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Planes de seguros
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('registrar-independiente') ?>" class="nav-link">
              <i class="nav-icon fa-solid fa-user-plus "></i>
              <p>
                Persona independiente
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('CEmpresa/crearEmpresa')?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Registrar empresa
              </p>
            </a>
          </li>

        <?php } else { ?>
          <li class="nav-item">
            <a href="<?= base_url() ?>CUsuario/usuarios" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Lista de empleados
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('CEmpresa/consultarEmpresas')?>" class="nav-link">
              <i class="nav-icon fa-solid fa-list"></i>
              <p>
                Lista de empresas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('lista-independientes') ?>" class="nav-link">
              <i class="nav-icon fa-solid fa-list"></i>
              <p>
                Lista de independientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('CPlan/planes')?>" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Planes de seguros
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('CEmpresa/crearEmpresa')?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Registrar empresa
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('registrar-independiente') ?>" class="nav-link">
              <i class="nav-icon fa-solid fa-user-plus "></i>
              <p>
                Persona independiente
              </p>
            </a>
          </li>
        <?php } ?>
        <li class="nav-item">
            <a href="<?= base_url('pago') ?>" class="nav-link">
              <i class="nav-icon fa-solid fa-money-check-dollar "></i>
              <p>
                MODULO DE PAGO
              </p>
            </a>
          </li>


        <li class="nav-item">
          <a href="<?= base_url('CUsuario/cerrar_sesion')?>" class="nav-link">
            <i class="nav-icon fa-solid fa-right-from-bracket"></i>
            <p>
              Cerrar sesion
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
  <!-- /.sidebar -->
</aside>