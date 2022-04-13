<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Status Barang
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="">Management Access</li>
            <li class="active">Status Barang</li>
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
                <?php elseif ($this->session->flashdata('msguniq')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-times"></i>
                        <?php echo $this->session->flashdata('msguniq');?>
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
                                            <th style="text-align: center;">Nama</th>
                                            <th style="text-align: center;">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($status_barang as $r) :
                                        ?>
                                            <tr>
                                                <th style="text-align: center;" width="50px"><?php echo $no++; ?></th>
                                                <th style="text-align: center;"><?php echo $r->nama_sb; ?></th>
                                                <th style="text-align: center;" width="200px">
                                                    <a href="" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#update<?php echo $r->id_sb; ?>"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                    <a href="<?php echo base_url('menu/StatusBarang/delete/' . $r->id_sb); ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i>&nbsp; Hapus</a>
                                                </th>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
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
    <form method="post" action="<?php echo base_url('menu/StatusBarang/create'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h3 class="modal-title font-weight-bold">Tambah <?php echo $title ?></h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_sb" class="col-form-label">Nama</label>
                        <input type="text" id="nama_sb" name="nama_sb" class="form-control" placeholder="Example : Display" required>
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
<?php foreach ($status_barang as $r) : ?>
    <div class="modal fade" id="update<?php echo $r->id_sb; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form method="post" action="<?php echo base_url('menu/StatusBarang/update'); ?>">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>                        
                        <h3 class="modal-title font-weight-bold">Edit <?php echo $title ?></h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_sb" name="id_sb" value="<?php echo $r->id_sb ?>">
                        <div class="form-group">
                            <label for="nama_sb" class="col-form-label">Nama</label>
                            <input type="text" id="nama_sp" name="nama_sb" class="form-control" placeholder="Example : Display" value="<?php echo $r->nama_sb ?>" required>
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