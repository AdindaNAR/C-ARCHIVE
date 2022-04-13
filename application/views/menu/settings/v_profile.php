<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<?php
$where = array(
    'id_user' => $this->session->userdata('id_user'),
);

$session = $this->db->get_where('tbl_user', $where)->row();
?>

<div class="content-wrapper">
    <section class="content-header">
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php if (($this->session->flashdata('update'))) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo $this->session->flashdata('update'); ?>
                    </div>
                <?php elseif (($this->session->flashdata('error'))) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif ?>

                <div class="box box-primary">
                    <form method="post" action="<?php echo base_url('menu/SettingsProfile') ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-7">
                                    <!-- <div class="form-group">
                                        <label for="id_user" class="col-form-label">Kode Petugas<i style="color: red;">*</i></label>
                                        <input type="text" class="form-control" value="<?php echo $session->id_user; ?>" readonly>
                                    </div> -->
                                    <input type="hidden" value="<?php echo $session->id_user; ?>">
                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama Lengkap<i style="color: red;">*</i></label>
                                        <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $session->nama; ?>">
                                        <?php echo form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email<i style="color: red;">*</i></label>
                                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $session->email; ?>">
                                        <?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-xs-3"></div>
                                        <div class="col-xs-6">
                                            <img src="<?php echo base_url(); ?><?php echo $session->file_gambar; ?>" width="200" height="200" class="img-thumbnail rounded-pill">
                                        </div>
                                        <div class="col-xs-3"></div>
                                    </div>

                                    <p class="text-center"><b>Foto Profil (1x1)<i style="color: red;">*</i></b></p>
                                    <p class="text-center">Format gambar (JPEG, JPG dan PNG) dengan ukuran maksimal 500KB.</p>
                                    <!-- <input type="file" id="image" name="image" class="form-control"> -->
                                    <input type="file" id="image" name="image" class="dropify" data-height="100">
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('layout/v_footer'); ?>