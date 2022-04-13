<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>



<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Detail Barang
        </h1>
        <?php

        $iid_barang = $this->uri->segment(4);
        $idrole =  $this->session->userdata('id_role');

        $ceknamabarang = $this->db->get_where('tbl_barang', array('id_barang' => $iid_barang))->row();
        ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('main/Bigmap'); ?>">Master Data</a></li>

            <li class="active"><?php echo $ceknamabarang->nama_barang; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box" id="detail_barang">
                    <div class="box-body">
                        <?php foreach ($tbl_barang as $a) : ?>
                            <table class="table table-condensed">
                                <tr>
                                    <th style="width: 150px">Kode Barang</th>
                                    <th style="width: 25px">:</th>
                                    <th><?php echo $a->id_barang; ?></th>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>:</th>
                                    <th><?php echo $a->nama_barang; ?></th>
                                </tr>
                                <tr>
                                    <th>Nama Brand</th>
                                    <th>:</th>
                                    <td><?php echo $a->nama_brand; ?></td>
                                </tr>

                                <tr>
                                    <th>Deskripsi</th>
                                    <th>:</th>
                                    <td><?php echo $a->deskripsi_barang; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Stok</th>
                                    <th>:</th>
                                    <?php foreach ($total_stock as $b) : ?>
                                        <td id="stock_quantity">
                                            <?php

                                            if (empty($b->total_stock)) {
                                                echo "0";
                                            } else {
                                                echo $b->total_stock;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="btn btn-warning btn-sm" title="Ubah Detail" data-toggle="modal" data-target="#ModalaEditBarang<?php echo $a->id_barang; ?>" data-backdrop="static"><span class="fa fa-pencil"></span>&nbsp; Edit</a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12" id="allStok">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">All Stok</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12" id="penjualan">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Penjualan</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">

                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <div class="container-fluid">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">Kode Toko</th>
                                            <th style="text-align: center;">Nama Toko</th>
                                            <th style="text-align: center;">Stok</th>
                                            <th style="text-align: center;">Terjual</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        <?php $no = 1; ?>
                                        <?php foreach ($data_list_stock as $st) : ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $no++; ?></td>
                                                <td><?php echo $st->id_toko ?></td>
                                                <td><?php echo $st->nama_toko ?></td>
                                                <td style="text-align: center;"><?php echo $st->total_stock ?></td>
                                                <td style="text-align: center;"><?php echo $st->terjual ?></td>
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



        <div id="alert">
        </div>

        <div class="row">
            <div class="col-xs-12" id="boxDetail">
                <div class="box">
                    <div class="box-header">
                        <p>Detail Barang</p>
                    </div>


                    <div class="box-body table-responsive">
                        <table id="table-barang" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>Nomor PO</th>
                                    <th>Ukuran</th>
                                    <th>Banyak</th>
                                    <th>Tanggal Po Toko</th>
                                    <th>Tanggal Masuk Ke Toko</th>
                                    <th>Keterangan</th>
                                    <!-- <th>Aksi</th> -->

                                </tr>
                            </thead>
                            <tbody id="show_data"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" id="boxPenjualan">
                <div class="box">
                    <div class="box-header">
                        <p>Table Penjualan </p>
                    </div>
                    <div class="box-header">

                    </div>
                    <div class="box-body table-responsive">
                        <table id="table-penjualan" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>Nomor PO</th>
                                    <th>Ukuran</th>
                                    <th>Banyak</th>
                                    <th>Tanggal Keluar</th>
                                    <th>No Faktur</th>
                                    <th>Keterangan</th>
                                    <!-- <th>Aksi</th> -->

                                </tr>
                            </thead>
                            <tbody id="show_data_penjualan">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<input type="hidden" id="id_barang" value="<?php echo  $this->uri->segment(4); ?>">
<input type="hidden" id="idRole" value="<?php echo $this->session->userdata('id_role'); ?>">
<input type="hidden" id="idToko" value="<?php echo $this->session->userdata('id_toko'); ?>">

<!-- Pop Up Update Barang -->
<?php foreach ($tbl_barang as $a) { ?>
    <div id="ModalaEditBarang<?php echo $a->id_barang; ?>" class="modal fade" role="dialog">
        <form class="form-horizontal" action="<?php echo base_url('main/Bigmap/edit_barang') ?>" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Barang</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_barang" value="<?php echo $a->id_barang ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_barang" value="<?php echo $a->nama_barang ?>" placeholder="Masukan Nama Barang" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Brand</label>
                            <div class="col-sm-9">
                                <select class="form-control col-sm-9" name="id_brand" required>
                                    <?php foreach ($tbl_brand as $c) : ?>
                                        <?php if ($c->id_brand == $a->id_brand) : ?>
                                            <option value="<?php echo $c->id_brand; ?>" selected><?php echo $c->nama_brand; ?></option>
                                        <?php else : ?>
                                            <option value="<?php echo $c->id_brand; ?>"><?php echo $c->nama_brand; ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi Barang</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi_barang" rows="3" placeholder="Masukan Deskripsi Barang" required><?php echo $a->deskripsi_barang ?></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php } ?>
<!-- End Pop Up Update Barang -->

<!-- Pop Up Create Detail Barang -->
<div class="modal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Tambah Detail Barang</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_barang2" value="<?php echo  $this->uri->segment(6); ?>">
                    <div class="form-group">
                        <label for="no_po" class="col-form-label">No PO</label>
                        <input type="text" name="no_po" id="no_po" class="form-control" placeholder="NO PO" required="true">
                    </div>
                    <div class="form-group">
                        <label for="banyak" class="col-form-label">Banyak Barang</label>
                        <input type="number" name="banyak" id="banyak" class="form-control" placeholder="Banyak" required="true">
                    </div>
                    <div class="form-group">
                        <label for="ukuran" class="col-form-label">Ukuran</label>
                        <input type="text" name="ukuran" id="ukuran" class="form-control" placeholder="Ukuran" required="true">
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Warna</label>
                        <input type="text" name="warna" id="warna" class="form-control" placeholder="Warna" required="true">
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Tanggal Masuk</label>
                        <input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control" placeholder="21-08-2021" required="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-success" id="btn_simpan">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Pop Up Create Detail Barang -->

<!-- Pop Up Update Detail Barang -->
<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Detail Barang</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idDetail" name="idDetail">
                    <div class="form-group">
                        <label for="no_po" class="col-form-label">No PO</label>
                        <input type="text" name="nopo_edit" id="nopo2" class="form-control" placeholder="Kode Barang" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="banyak" class="col-form-label">Banyak Barang</label>
                        <input type="text" name="banyak_edit" id="banyak2" class="form-control" placeholder="Kode Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="ukuran" class="col-form-label">Ukuran</label>
                        <input type="text" name="ukuran_edit" id="ukuran2" class="form-control" placeholder="Ukuran" required>
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Warna</label>
                        <input type="text" name="warna_edit" id="warna2" class="form-control" placeholder="Harga" required>
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Tanggal Masuk</label>
                        <input type="text" name="tanggal_masuk_edit" id="tanggal_masuk2" class="form-control" placeholder="Harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-success" id="btn_update">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Pop Up Delete -->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin mau memhapus barang ini?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Pop Up Delete -->

<!-- Pop Up Finish PO -->
<div class="modal fade" id="ModalOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Selesaikan PO</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kode" id="textkode2" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin mau Menyelesaikan PO ini?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                    <button class="btn_hapus btn btn-success" id="btn_ok">OK</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Pop Up Finish PO -->

<!-- Pop Up Create Penjualan -->
<div class="modal fade" id="ModalaAddPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Tambah Penjualan</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="stock_quantity2">
                    <input type="hidden" name="idDetailBarang" id="idDetailBarang">
                    <input type="hidden" name="idRiwayat" id="idRiwayat">

                    <div class="form-group">
                        <a class="btn btn-success btn-sm form-control" id="tambah" data-toggle="modal" data-target="#ModalListPo"><span class="fa fa-plus"></span>&nbsp; Pilih Nomor PO</a>
                    </div>

                    <div class="form-group">
                        <label for="no_po" class="col-form-label">No PO</label>
                        <input type="text" name="noPo" id="noPo" class="form-control" readonly="true" placeholder="NO PO" required="true">
                    </div>
                    <div class="form-group">
                        <label for="banyak" class="col-form-label">Banyak Barang</label>
                        <input type="number" name="banyak_keluar" id="banyak_keluar" class="form-control" maxlength='100' pattern='^[0-9]$' placeholder="Banyak" required="true">
                        <p id="notif"></p>
                    </div>
                    <div class="form-group">
                        <label for="no_faktur" class="col-form-label">No Faktur</label>
                        <input type="text" name="no_faktur" id="no_faktur" class="form-control" placeholder="No Faktur" required="true">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_keluar" class="col-form-label">Tanggal Keluar</label>
                        <input type="text" name="tanggal_keluar" id="tanggal_keluar" class="form-control" placeholder="21-08-2021" required="true">
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-success" id="btn_simpan_penjualan">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapusPenjualan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
            </div>
            <form class="form-horizontal">

                <div class="modal-body">
                    <input type="hidden" name="kode_penjualan" id="textkodePenjualan" value="">
                    <input type="hidden" name="data2" id="data2" value="">
                    <input type="hidden" name="data3" id="data3" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin mau memhapus barang ini?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus_penjualan">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->


<!-- MODAL EDIT -->
<div class="modal fade" id="ModalaEditPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Penjualan</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idRiwayat2" id="idRiwayat2">
                    <input type="hidden" name="idDetailBarang2" id="idDetailBarang2">

                    <div class="form-group">
                        <label for="no_po" class="col-form-label">No PO</label>
                        <input type="text" name="noPo2" id="noPo2" class="form-control" readonly="true" placeholder="NO PO" required="true">
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="banyak" class="col-form-label">Banyak Barang</label>
                        <input name="banyak_keluar2" id="banyak_keluar2" class="form-control" type="hidden" placeholder="2" required>
                    </div>
                    <div class="form-group">
                        <label for="no_faktur" class="col-form-label">No Faktur</label>
                        <input type="text" name="no_faktur2" id="no_faktur2" class="form-control" placeholder="No Faktur" required="true">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_keluar" class="col-form-label">Tanggal Keluar</label>
                        <input type="text" name="tanggal_keluar2" id="tanggal_keluar2" class="form-control" placeholder="21-08-2021" required="true">
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan2" name="keterangan2" rows="3" placeholder="Keterangan ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-success" id="btn_update_penjualan">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal Export -->
<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('export/ExcelDetailBarang'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Pilih Bulan & Tahun</h5>
                </div>
                <div class="modal-body" id="selectall">
                    <input type="hidden" name="id_barang" id="id_barang" value="<?php echo $a->id_barang; ?>">
                    <div class="form-group">
                        <label class="control-label">Bulan</label>
                        <select class="form-control" name="bulan" id="bulan">
                            <option value="">-Pilih-</option>
                            <?php foreach ($bulan as $data) : ?>
                                <option value="<?php echo $data->bulan; ?>"><?php echo bulan($data->bulan) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tahun</label>
                        <select class="form-control" name="tahun" id="tahun">
                            <option value="">-Pilih-</option>
                            <?php foreach ($tahun as $data) : ?>
                                <option value="<?php echo $data->tahun; ?>"><?php echo $data->tahun; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success">Export</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Modal Export -->

<!-- List No PO -->
<!--Modal List PO-->
<div class="modal fade" id="ModalListPo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                <h4 class="modal-title" id="myModalLabel">List No Po</h4>
            </div>
            <div class="box-body">
                <table id="table-list-po" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Ukuran</th>
                            <th>Sisa Stok PO</th>
                            <th>Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layout/v_footer'); ?>


<script type="text/javascript">
    $(document).ready(function() {
        var alert = $('#alert').html('');
        get_code_po();
        get_code_riwayat();

        // var id_toko = $('#id_toko').val();
        // var id_lantai = $('#id_lantai').val();
        var id_barang = $('#id_barang').val();
        var idRole = $('#idRole').val();

        var tablepo = null;
        tablepo = $('#table-list-po').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "bAutoWidth": false,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/data_detail_barang') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    // id_toko: id_toko,
                    // id_lantai: id_lantai,
                    id_barang: id_barang
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [5, 10, 50],
                [5, 10, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "tanggal_masuk"
                }, {
                    "data": "no_po"
                }, // Tampilkan 
                {
                    "data": "ukuran"
                }, // Tampilkan 
                {
                    "data": "sisa"
                }, // Tampilkan 

                // Tampilkan 
            ],
        });


        //row clik table list po
        $('#table-list-po tbody').on('click', 'tr', function() {
            let data = tablepo.row(this).data();
            var id = data.id_detail_barang;
            var noPo = data.no_po;

            $.ajax({
                success: function() {

                    $('#ModalListPo').modal('hide');
                }
            })
        });

        var table = null;
        table = $('#table-barang').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/dataPenjualan') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    // id_toko: id_toko,
                    // id_lantai: id_lantai,
                    id_barang: id_barang
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [5, 10, 50],
                [5, 10, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "no_po"
                }, // Tampilkan 
                {
                    "data": "ukuran"
                }, // Tampilkan 
                {
                    "data": "banyak"
                }, // Tampilkan 
                {
                    "data": "tanggal_masuk"
                },
                {
                    "data": "tanggal_terima"
                },

                {
                    "data": "keterangan"
                },
                // {
                //     "render": function(data, type, row) {
                //         // Tampilkan kolom aksi
                //         var html = '';
                //         if (idRole != 3) {
                //             html = '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus_penjualan" data="' + row.id_riwayat + '" data2="' + row.banyak + '" data3="' + row.id_detail_barang + '">Hapus</a>  '

                //         }
                //         return html
                //     }
                // },
            ],
        });

        var tabledet = null;
        tabledet = $('#detail-barang').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url() ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    // id_toko: id_toko,
                    // id_lantai: id_lantai,
                    // id_barang: id_barang
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [5, 10, 50],
                [5, 10, 50]
            ], // Combobox Limit

        });

        //tombol  all stock and penjualan
        $('#allStok').on('click', function() {
            $('#boxDetail').show();
            $('boxPenjualan').hide();
        });

        $('#penjualan').on('click', function() {
            $('boxPenjualan').show();
            $('#boxDetail').hide();
        });

        //Simpan Barang
        $('#btn_simpan').on('click', function() {
            var noPo = $('#no_po').val();
            var banyak = $('#banyak').val();
            var ukuran = $('#ukuran').val();
            var warna = $('#warna').val();
            var tanggalMasuk = $('#tanggal_masuk').val();
            var id_barang2 = $('#id_barang2').val();
            if (banyak == '' || noPo == '' || ukuran == '' || warna == '' || tanggalMasuk == '') {} else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/simpan_detail') ?>",
                    dataType: "JSON",
                    data: {
                        id_barang: id_barang2,
                        noPo: noPo,
                        banyak: banyak,
                        ukuran: ukuran,
                        warna: warna,
                        tanggalMasuk: tanggalMasuk
                    },
                    success: function(data) {
                        $("#detail_barang").load(" #detail_barang > *");
                        $('[name="no_po"]').val("");
                        $('[name="banyak"]').val("");
                        $('[name="ukuran"]').val("");
                        $('[name="warna"]').val("");
                        $('[name="tanggal_masuk"]').val("");
                        $('#ModalaAdd').modal('hide');
                        $('#alert').html('');
                        $('#alert').append(` <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>
                            <?php echo 'Data Berhasil Disimpan!' ?>
                            </div>`);
                        table.ajax.reload();
                        tablepo.ajax.reload();
                        get_code_po();
                    }
                });
                return false;
            }
        });

        //Update 
        $('#btn_update').on('click', function() {
            var idDet = $('#idDetail').val();
            var nopo = $('#nopo2').val();
            var banyak = $('#banyak2').val();
            var ukuran = $('#ukuran2').val();
            var warna = $('#warna2').val();
            var tanggalMasuk = $('#tanggal_masuk2').val();
            if (idDet == '' || nopo == '' || banyak == '' || ukuran == '' || warna == '' || tanggalMasuk == '') {

            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/updateDetBarang') ?>",
                    dataType: "JSON",
                    data: {
                        idDetail: idDet,
                        nopo: nopo,
                        banyak: banyak,
                        ukuran: ukuran,
                        warna: warna,
                        tanggalMasuk: tanggalMasuk
                    },
                    success: function(data) {
                        $("#detail_barang").load(" #detail_barang > *");
                        $('[name="no_po"]').val("");
                        $('[name="banyak"]').val("");
                        $('[name="ukuran"]').val("");
                        $('[name="warna"]').val("");
                        $('[name="tanggal_masuk"]').val("");
                        $('#ModalaEdit').modal('hide');
                        $('#alert').html('');
                        $('#alert').append(` <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>
                            <?php echo 'Data Berhasil Diubah!' ?>
                            </div>`);
                        table.ajax.reload();
                        tablepo.ajax.reload();
                    }
                });
                return false;
            }
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });

        //Hapus Barang
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/nonAktifDet') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $("#detail_barang").load(" #detail_barang > *");
                    $('#ModalHapus').modal('hide');
                    $('#alert').html('');

                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo 'Data Berhasil Dihapus!' ?>
                        </div>`);
                    table.ajax.reload();
                    tablepo.ajax.reload();
                    get_code_po();
                }
            });
            return false;
        });

        //get ok
        $('#show_data').on('click', '.item_ok', function() {
            var id = $(this).attr('data');
            $('#ModalOk').modal('show');
            $('[name="kode"]').val(id);
        });

        $('#btn_ok').on('click', function() {
            var kode = $('#textkode2').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/pesananOK') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $("#detail_barang").load(" #detail_barang > *");
                    $('#ModalOk').modal('hide');
                    table.ajax.reload();
                }
            });
            return false;
        });

        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');

            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_detail') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id_detail_barang, no_po, stock_quantity, ukuran, warna, tanggal_masuk) {
                        $('#ModalaEdit').modal('show');
                        $('[name="idDetail"]').val(data.id_detail_barang);
                        $('[name="nopo_edit"]').val(data.no_po);
                        $('[name="banyak_edit"]').val(data.stock_quantity);
                        $('[name="ukuran_edit"]').val(data.ukuran);
                        $('[name="warna_edit"]').val(data.warna);
                        $('[name="tanggal_masuk_edit"]').val(data.tanggal_masuk);
                    });
                }
            });
            return false;
        });

        function get_code_po() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/get_code_po') ?>",
                dataType: "JSON",
                success: function(obj) {

                }
            });
        }

        function get_code_riwayat() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/get_code_riwayat') ?>",
                dataType: "JSON",
                success: function(obj) {
                    $('#idRiwayat').val(obj);
                }
            });
        }



        let elTangalmasuk = $('#tanggal_masuk');
        elTangalmasuk.datepicker({
            format: 'dd-mm-yyyy',
            clearBtn: false,
            autoclose: true,
            todayHighlight: true,
            readonly: false
        });

        let elTangalmasuk2 = $('#tanggal_masuk2');
        elTangalmasuk2.datepicker({
            format: 'dd-mm-yyyy',
            clearBtn: false,
            autoclose: true,
            todayHighlight: true,
            readonly: false
        });

        let elTangalkeluar = $('#tanggal_keluar');
        elTangalkeluar.datepicker({
            format: 'dd-mm-yyyy',
            clearBtn: false,
            autoclose: true,
            todayHighlight: true,
            readonly: false
        });

        let elTangalkeluar2 = $('#tanggal_keluar2');
        elTangalkeluar2.datepicker({
            format: 'dd-mm-yyyy',
            clearBtn: false,
            autoclose: true,
            todayHighlight: true,
            readonly: false
        });

        var tablePenjualan = null;
        tablePenjualan = $('#table-penjualan').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/list_data_penjualan_toko2') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    // id_toko: id_toko,
                    // id_lantai: id_lantai,
                    id_barang: id_barang
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [5, 10, 50],
                [5, 10, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "no_po"
                }, // Tampilkan 
                {
                    "data": "ukuran"
                }, // Tampilkan 
                {
                    "data": "qty"
                }, // Tampilkan 
                {
                    "data": "tanggal_terima"
                },
                {
                    "data": "no_po"
                },
                {
                    "data": "keterangan"
                },
                // {
                //     "render": function(data, type, row) {
                //         // Tampilkan kolom aksi
                //         var html = '';
                //         if (idRole != 3) {
                //             html = '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus_penjualan" data="' + row.id_riwayat + '" data2="' + row.banyak + '" data3="' + row.id_detail_barang + '">Hapus</a>  '

                //         }
                //         return html
                //     }
                // },
            ],
        });
        if (idRole == 3) {

            tablePenjualan.column(7).visible(false);

        }


        //readonly form add penjualan
        $('#banyak_keluar').prop("readonly", true);
        $('#tanggal_keluar').prop("readonly", true);
        $('#keterangan').prop("readonly", true);
        $('#no_faktur').prop("readonly", true);
        $('#btn_simpan_penjualan').hide();



        //Simpan penjualan
        $('#btn_simpan_penjualan').on('click', function() {
            var idRiwayat = $('#idRiwayat').val();
            var idDetailBarang = $('#idDetailBarang').val();
            var noPo = $('#noPo').val();
            var banyak_keluar = $('#banyak_keluar').val();
            var noFaktur = $('#no_faktur').val();
            var tanggal_keluar = $('#tanggal_keluar').val();
            var keterangan = $('#keterangan').val();
            if (noPo == '' || banyak_keluar == '' || noFaktur == '' || tanggal_keluar == '') {

            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/simpan_penjualan') ?>",
                    dataType: "JSON",
                    data: {
                        noPo: noPo,
                        idRiwayat: idRiwayat,
                        idDetailBarang: idDetailBarang,
                        banyak_keluar: banyak_keluar,
                        tanggal_keluar: tanggal_keluar,
                        noFaktur: noFaktur,
                        keterangan: keterangan
                    },
                    success: function(data) {
                        $("#detail_barang").load(" #detail_barang > *");
                        $('[name="idRiwayat"]').val("");
                        $('[name="idDetailBarang"]').val("");
                        $('[name="noPo"]').val("");
                        $('[name="banyak_keluar"]').val("");
                        $('[name="tanggal_keluar"]').val("");
                        $('[name="no_faktur"]').val("");
                        $('[name="keterangan"]').val("");
                        tablePenjualan.ajax.reload();
                        table.ajax.reload();
                        tablepo.ajax.reload();
                        $('#ModalaAddPenjualan').modal('hide');
                        $('#alert').html('');
                        $('#alert').append(` <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>
                            <?php echo 'Data Berhasil Disimpan!' ?>
                            </div>`);
                        get_code_riwayat();

                    }
                });
                return false;
            }
        });


        //GET HAPUS Penjualan
        $('#show_data_penjualan').on('click', '.item_hapus_penjualan', function() {
            var id = $(this).attr('data');
            var data2 = $(this).attr('data2');
            var data3 = $(this).attr('data3');
            $('#ModalHapusPenjualan').modal('show');
            $('[name="kode_penjualan"]').val(id);
            $('[name="data2"]').val(data2);
            $('[name="data3"]').val(data3);
        });

        //Hapus Barang
        $('#btn_hapus_penjualan').on('click', function() {
            var kode = $('#textkodePenjualan').val();
            var data2 = $('#data2').val();
            var data3 = $('#data3').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/nonAktifPenjualan') ?>",
                dataType: "JSON",
                data: {
                    kode: kode,
                    data2: data2,
                    data3: data3
                },
                success: function(data) {
                    $("#detail_barang").load(" #detail_barang > *");
                    tablePenjualan.ajax.reload();
                    table.ajax.reload();
                    tablepo.ajax.reload();
                    $('#ModalHapusPenjualan').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo 'Data Berhasil Dihapus!' ?>
                        </div>`);
                }
            });
            return false;
        });

        //GET UPDATE
        $('#show_data_penjualan').on('click', '.item_edit_penjualan', function() {
            var id = $(this).attr('data');
            console.log(id)
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_penjualan') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id_riwayat, id_detail_barang, no_po, banyak, tanggal_keluar, no_faktur, keterangan) {
                        $('#ModalaEditPenjualan').modal('show');
                        $('[name="idRiwayat2"]').val(data.id_riwayat);
                        $('[name="idDetailBarang2"]').val(data.id_detail_barang);
                        $('[name="noPo2"]').val(data.no_po);
                        $('[name="banyak_keluar2"]').val(data.banyak);
                        $('[name="tanggal_keluar2"]').val(data.tanggal_keluar);
                        $('[name="no_faktur2"]').val(data.no_faktur);
                        $('[name="keterangan2"]').val(data.keterangan);
                    });
                }
            });
            return false;
        });

        //update penjualan
        $('#btn_update_penjualan').on('click', function() {
            var idRiwayat = $('#idRiwayat2').val();
            var idDetailBarang = $('#idDetailBarang2').val();
            var banyak = $('#banyak_keluar2').val();
            var tanggalKeluar = $('#tanggal_keluar2').val();
            var no_faktur = $('#no_faktur2').val();
            var keterangan = $('#keterangan2').val();
            if (idRiwayat == '' || idDetailBarang == '' || banyak == '' || tanggalKeluar == '' || no_faktur == '') {

            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/updatePenjualan') ?>",
                    dataType: "JSON",
                    data: {
                        idRiwayat: idRiwayat,
                        idDetailBarang: idDetailBarang,
                        banyak: banyak,
                        tanggalKeluar: tanggalKeluar,
                        no_faktur: no_faktur,
                        keterangan: keterangan
                    },
                    success: function(data) {
                        $("#detail_barang").load(" #detail_barang > *");
                        $('[name="noPo"]').val("");
                        $('[name="noPo2"]').val("");
                        $('[name ="idDetailBarang2"]').val("");
                        $('[name ="id_riwayat2"]').val("");
                        $('[name="banyak_keluar2"]').val("");
                        $('[name="tanggal_keluar2"]').val("");
                        $('[name="no_faktur2"]').val("");
                        $('[name="keterangan2"]').val("");
                        $('#ModalaEditPenjualan').modal('hide');
                        $('#alert').html('');
                        $('#alert').append(` <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>
                            <?php echo 'Data Berhasil Diubah!' ?>
                            </div>`);
                        tablePenjualan.ajax.reload();
                    }
                });
                return false;
            }
        });

        //cek stock po
        $('#banyak_keluar').on('keyup', function() {
            var byk_keluar = parseInt($('#banyak_keluar').val());
            var banyak_keluar = $('#banyak_keluar').val();
            var no_po = $('#noPo2').val();
            var noFaktur = $('#no_faktur').val();
            var tanggal_keluar = $('#tanggal_keluar').val();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_detail') ?>",
                dataType: "JSON",
                data: {
                    id: no_po
                },
                success: function(data) {
                    $('#stock_quantity2').val(data.sisa);
                    $('#notif').html('');
                    if (byk_keluar > data.sisa || byk_keluar > 100) {
                        $('#notif').append('<p class="text-danger">Jumlah yang anda masukan melebihi jumlah stok yang di PO kan!.</p>');
                        ('#btn_simpan_penjualan').hide();
                    } else {
                        $('#notif').html('');
                        $('#tanggal_keluar').on('change', function() {
                            var banyak_keluar = $('#banyak_keluar').val();
                            var no_po = $('#noPo2').val();
                            var noFaktur = $('#no_faktur').val();
                            var tanggal_keluar = $('#tanggal_keluar').val();
                            if (banyak_keluar != '' && tanggal_keluar != '' && noFaktur != '') {
                                $('#btn_simpan_penjualan').show();
                            }
                        });
                        if (banyak_keluar == '' || tanggal_keluar == '') {
                            $('#btn_simpan_penjualan').hide();
                        } else {
                            $('#btn_simpan_penjualan').show();
                        }
                    }
                }
            });
            return false;
        });

    });
</script>

</body>

</html>