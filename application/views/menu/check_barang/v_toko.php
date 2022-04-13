<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
<section class="content-header">
        <h1>
            List Toko
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="">Cek Barang</li>
            <li class="active">Toko</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">

                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <div class="container-fluid">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Nama</th>
                                            <th style="text-align: center;">Alamat</th>
                                            <th style="text-align: center;">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($toko as $r) :
                                        ?>
                                            <tr>
                                                <th style="text-align: center;" width="50px"><?php echo $no++; ?></th>
                                                <th><?php echo $r->nama_toko; ?></th>
                                                <th><?php echo $r->alamat_toko; ?></th>
                                                <th style="text-align: center;" width="100px">
                                                    <a href="<?php echo base_url('menu/CheckBarang/barang/' . $r->id_toko); ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>&nbsp; Lihat Barang</a>
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

<?php $this->load->view('layout/v_footer'); ?>