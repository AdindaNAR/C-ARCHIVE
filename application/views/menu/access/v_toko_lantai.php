<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Acces Toko & Lantai
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="">Management Acces</li>
            <li class="active">Acces Toko & Lantai</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php if (($this->session->flashdata('create')) or ($this->session->flashdata('update')) or ($this->session->flashdata('delete'))) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo $this->session->flashdata('create'); ?>
                        <?php echo $this->session->flashdata('update'); ?>
                        <?php echo $this->session->flashdata('delete'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('failed')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-times"></i>
                        <?php echo $this->session->flashdata('failed'); ?>
                    </div>
                <?php endif ?>

                <div class="box box-primary">
                    <div class="box-header">
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <div class="container-fluid">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Nama Toko</th>
                                            <th style="text-align: center;">Nama Lantai</th>
                                            <th style="text-align: center;">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($toko_lantai as $r) :
                                        ?>
                                            <tr>
                                                <th style="text-align: center;" width="50px"><?php echo $no++; ?></th>
                                                <th style="text-align: center;"><?php echo $r->nama_toko; ?></th>
                                                <th style="text-align: center;"><?php echo $r->nama_lantai; ?></th>
                                                <th style="text-align: center;" width="200px">
                                                    <a href="" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#update<?php echo $r->id_access_toko; ?>"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                    <a href="<?php echo base_url('menu/AccessTokoLantai/delete/' . $r->id_access_toko); ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i>&nbsp; Hapus</a>
                                                </th>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('menu/AccessTokoLantai/create'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h3 class="modal-title font-weight-bold">Tambah <?php echo $title ?></h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Toko</label>
                        <select id="id_toko" name="id_toko" class="form-control">
                            <?php foreach ($toko as $_toko) : ?>
                                <option value="<?php echo $_toko->id_toko; ?>"><?php echo $_toko->nama_toko; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Lantai</label>
                        <select id="id_lantai" name="id_lantai" class="form-control">
                            <?php foreach ($lantai as $_lantai) : ?>
                                <option value="<?php echo $_lantai->id_lantai; ?>"><?php echo $_lantai->nama_lantai; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End of Modal Create -->

<!-- Modal Update -->
<?php foreach ($toko_lantai as $r) : ?>
    <div class="modal fade" id="update<?php echo $r->id_access_toko; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form method="post" action="<?php echo base_url('menu/AccessTokoLantai/update'); ?>">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                        <h3 class="modal-title font-weight-bold">Edit <?php echo $title ?></h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_access_toko" value="<?php echo $r->id_access_toko ?>">
                        <div class="form-group">
                            <label class="control-label">Nama Toko</label>
                            <select id="id_toko" name="id_toko" class="form-control">
                                <?php foreach ($toko as $_toko) : ?>
                                    <?php if ($_toko->id_toko == $r->id_toko) : ?>
                                        <option value="<?php echo $_toko->id_toko ?>" selected><?php echo $_toko->nama_toko; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $_toko->id_toko ?>"><?php echo $_toko->nama_toko; ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Lantai</label>
                            <select id="id_lantai" name="id_lantai" class="form-control">
                                <?php foreach ($lantai as $_lantai) : ?>
                                    <?php if ($_lantai->id_lantai == $r->id_lantai) : ?>
                                        <option value="<?php echo $_lantai->id_lantai ?>" selected><?php echo $_lantai->nama_lantai; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $_lantai->id_lantai ?>"><?php echo $_lantai->nama_lantai; ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<?php $this->load->view('layout/v_footer'); ?>