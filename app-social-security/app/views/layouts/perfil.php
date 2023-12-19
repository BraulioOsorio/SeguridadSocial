<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?= base_url();?>/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="<?= base_url();?>CUsuario/perfil" class="d-block"><?= $this->session->userdata('name'); ?></a>
    </div>
</div>