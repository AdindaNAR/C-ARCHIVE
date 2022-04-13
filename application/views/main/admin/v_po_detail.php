<?php
$id_toko = $this->uri->segment(4);
$id_lantai = $this->uri->segment(5);
$toko = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai JOIN tbl_toko c ON a.id_toko=c.id_toko  where a.id_toko = '$id_toko' AND a.id_lantai = '$id_lantai' AND a.data_status = '1' ")->result();
foreach ($toko as $toko) : ?>
<?php endforeach; ?>
<!-- Left side column. contains the logo and sidebar -->
<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <p><b>Daftar Detail Po</b></p>
                <div class="box">
                    <div class="box-header">
                        <a class="btn btn-sm btn-primary" id="tambah" data-toggle="modal" data-target="#export_detail_stock"><span class="fa fa-file-excel-o"></span>&nbsp; Export</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="table-barang" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Barang</th>
                                    <th>QYT</th>
                                    <th>Sisa QYT</th>
                                    <th>Ukuran</th>
                                    <th>Warna</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status Barang</th>
                                    <th>Status Pengiriman</th>
                                    <th>Selesaikan PO</th>
                                    <th>Status </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" id="boxPenjualan">
                <p><b>Table Riwayat</b></p>
                <div class="box">
                    <div class="box-header">
                        <a class="btn btn-sm btn-primary" id="tambah" data-toggle="modal" data-target="#export_riwayat_stock"><span class="fa fa-file-excel-o"></span>&nbsp; Export</a>
                    </div>
                    <!-- <div class="box-header">
                        <p></p>
                    </div>
                    <div class="box-header"> -->
                    <!-- <a class="btn btn-primary btn-sm" id="tambahPenjualan" data-toggle="modal" data-target="#ModalaAddPenjualan"><span class="fa fa-plus"></span>&nbsp; Tambah</a> -->
                    <!-- </div> -->
                    <div class="box-body table-responsive">
                        <table id="table-penjualan" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>Nomor PO</th>
                                    <th>IDDetail</th>
                                    <th>Nama Barang</th>
                                    <th>Lantai</th>
                                    <th>Ukuran</th>
                                    <th>Banyak</th>
                                    <th>Tanggal masuk</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data_penjualan">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3><b>Penjualan</b></h3>
                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalaAddPenjualanCustomer"><span class="fa fa-plus"></span>&nbsp; Tambah Penjualan</a>
                        <!-- <a  href="<?php echo $actual_link . '/' . '1'; ?>"class="btn btn-warning btn-sm"><span class="fa fa-plus"></span>&nbsp; PO Baru</a> -->
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <table id="table_penjualan_customer" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>UniqID</th>
                                    <th>ID</th>
                                    <th>No PO</th>
                                    <th>Ukuran </th>
                                    <th>Banyak </th>
                                    <th>Tanggal Masuk</th>
                                    <th>Harga Jual </th>
                                    <th>Harga Netto </th>
                                     <th>Margin </th>
                                    <th>No Faktur</th>
                                    <th>Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="penjualanCustomer"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php $this->load->view('layout/v_footer'); ?>
<input type="hidden" id="idRole" value="<?php echo $this->session->userdata('id_role'); ?>">

<div class="modal fade" id="export_detail_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('export/ExcelDetailStock'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Pilih Bulan & Tahun</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="no_po" name="no_po" value="<?php echo  $this->uri->segment(4); ?>">
                    <!-- <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata('id_toko'); ?>">
                    <div class="form-group">
                        <label class="control-label">Lantai</label>
                        <select  class="form-control" name="id_lantai" id="id_lantai" >
                            <option value="">-Pilih-</option>
                            <?php foreach ($lantai as $l) : ?>
                                <option value="<?php echo $l->id_lantai; ?>"><?php echo $l->nama_lantai; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label">Bulan</label>
                        <select class="form-control" name="bulan" id="bulan">
                            <option value="">-Pilih-</option>
                            <?php foreach ($bulan as $b) : ?>
                                <option value="<?php echo $b->bulan; ?>"><?php echo bulan($b->bulan); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tahun</label>
                        <select class="form-control" name="tahun" id="tahun">
                            <option value="">-Pilih-</option>
                            <?php foreach ($tahun as $t) : ?>
                                <option value="<?php echo $t->tahun; ?>"><?php echo $t->tahun; ?></option>
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

<div class="modal fade" id="export_riwayat_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('export/ExcelRiwayatStock'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Pilih Bulan & Tahun</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="no_po" name="no_po" value="<?php echo  $this->uri->segment(4); ?>">
                    <!-- <input type="hidden" name="id_toko" value="<?php echo $this->session->userdata('id_toko'); ?>">
                    <div class="form-group">
                        <label class="control-label">Lantai</label>
                        <select  class="form-control" name="id_lantai" id="id_lantai" >
                            <option value="">-Pilih-</option>
                            <?php foreach ($lantai as $l) : ?>
                                <option value="<?php echo $l->id_lantai; ?>"><?php echo $l->nama_lantai; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label">Bulan</label>
                        <select class="form-control" name="bulan" id="bulan">
                            <option value="">-Pilih-</option>
                            <?php foreach ($bulan as $b) : ?>
                                <option value="<?php echo $b->bulan; ?>"><?php echo bulan($b->bulan); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tahun</label>
                        <select class="form-control" name="tahun" id="tahun">
                            <option value="">-Pilih-</option>
                            <?php foreach ($tahun as $t) : ?>
                                <option value="<?php echo $t->tahun; ?>"><?php echo $t->tahun; ?></option>
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

<!-- Pop Up Create Penjualan -->
<div class="modal fade" id="ModalaAddPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"></h5>
                </div>
                <div class="modal-body">
                    <!-- <input type="text"id="stock_quantity2"> -->
                    <input type="hidden" name="idDetailBarang" id="idDetailBarang">
                    <input type="hidden" name="idRiwayat" id="idRiwayat">
                    <div class="form-group">
                        <label for="surat jalan" class="col-form-label">Surat Jalan</label>
                        <input type="text" name="surat_jalan" id="surat_jalan" class="form-control" placeholder="Surat Jalan" required="true">
                    </div>
                    <div class="form-group">
                        <label for="banyak" class="col-form-label">Banyak Barang</label>
                        <input type="number" name="banyak_keluar" id="banyak_keluar" class="form-control" maxlength='100' pattern='^[0-9]$' placeholder="Banyak" required="true">
                        <p id="notif"></p>
                    </div>
                    <div class="form-group">
                        <label for="noPo" class="col-form-label">No PO</label>
                        <input type="text" name="noPo" readonly id="noPo" class="form-control" placeholder="No Faktur" required="true">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Lantai</label>
                        <select id="id_lantai" name="id_lantai" class="form-control">
                            <?php foreach ($lantai as $lantai) : ?>
                                <option value="<?php echo $lantai->id_lantai ?>"><?php echo $lantai->nama_lantai; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_keluar" class="col-form-label">Tanggal Masuk</label>
                        <input type="text" value="<?php echo date('d-m-Y'); ?>" name="tanggal_keluar" id="tanggal_keluar" class="form-control" placeholder="21-08-2021" readonly required="true">
                    </div>
                    <div class="form-group">
                        <label for="warna" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" id="btn_simpan_penjualan">Simpan</button>
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


<!-- Pop Up Delete PenjualanCustomer-->
<div class="modal fade" id="ModalHapusPCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Penjualan</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="kode" id="textkode" value="">
                    <input type="hidden" name="jumlah" id="jumlah" value="">
                    <input type="hidden" name="idRiwayat" id="idRiwayat" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin mau menghapus Penjualan ini?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus_penjualan_customer">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Pop Up Delete -->

<!-- Pop Up Update Detail Barang -->
<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Detail Barang</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="idDetail" name="idDetail">
                    <input type="hidden" id="sisa" name="sisa">
                    <div class="form-group">
                        <label for="no_po" class="col-form-label">No PO</label>
                        <input type="text" name="nopo_edit" id="nopo2" class="form-control" placeholder="Kode Barang" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="banyak" class="col-form-label">Banyak Barang</label>
                        <input type="text" name="banyak_edit" id="banyak2" class="form-control" placeholder="Kode Barang" required>
                        <p id="notif"></p>
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
                        <input type="text" name="tanggal_masuk_edit" id="tanggal_masuk2" class="form-control" placeholder="Tanggal Masuk" readonly required>
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
<div class="modal fade" id="ModalHapusPenjualan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="kode" id="textkode">
                    <input type="hidden" name="qty" id="qtyjual">
                    <input type="hidden" name="idDetail" id="idDetail">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin mau menghapus data ini?</p>
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

<!-- MODAL ADD Penjualan Customer -->
<div class="modal fade" id="ModalaAddPenjualanCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h3 class="modal-title font-weight-bold">Tambah Penjualan</h3>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <a class="btn btn-success btn-sm form-control" id="pilihbarang" data-toggle="modal" data-target="#ModalListBarang"><span class="fa fa-plus"></span>&nbsp; Pilih Barang</a>
                    </div>


                    <input type="hidden" id="id_Riwayat" name="id_Riwayat" class="form-control">

                    <div class="form-group">
                        <label for="nama_barang" class="col-form-label">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="col-form-label">Warna</label>
                        <input type="text" id="warna" name="warna" class="form-control" placeholder="" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tanggal" class="col-form-label">Tanggal Penjualan</label>
                        <input type="text" id="tanggalPenjualan" name="tanggalPenjualan" class="form-control" placeholder="" value="<?php echo date('d-m-Y'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="banyak" class="col-form-label">Banyak</label>
                        <input type="text" id="banyakPenjualan" name="banyakPenjualan" class="form-control" placeholder="">
                        <p id="notifbanyakPenjualan"></p>
                    </div>



                    <div class="form-group">
                        <label for="desc" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="desc" name="desc" rows="5" placeholder="Keterangan ..."></textarea>
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-success" id="btn_simpan_customer">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal List Barang -->
<div class="modal fade" id="ModalListBarang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                <h4 class="modal-title" id="myModalLabel">Daftar Barang toko</h4>
            </div>

            <div class="box-body">
                <table id="table-barang-toko" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Warna</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--EndModal List PO-->
<!-- MODAL ADD -->
<!-- End Pop Up Finish PO -->
<input type="hidden" id="no_po" value="<?php echo  $this->uri->segment(4); ?>">
<input type="hidden" id="id_toko" value="<?php echo  $this->uri->segment(5); ?>">

</div>

<script type="text/javascript">
    $(document).ready(function() {
        get_code_riwayat();

        var no_po = $('#no_po').val();
        var idRole = $('#idRole').val();
        var id_toko = $('#id_toko').val();

        var table = null;
        table = $('#table-barang').DataTable({
            "processing": true,
            "bInfo": false,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/data_detail_po') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    no_po: no_po
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [5, 10, 50],
                [5, 10, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "id_barang"
                },
                {
                    "data": "nama_barang"
                },
                {
                    "data": "harga_baru"
                }, // Tampilkan 
                {
                    "data": "stock_quantity"
                }, // Tampilkan 
                {
                    "data": "sisa"
                },
                {
                    "data": "ukuran"
                }, // Tampilkan 
                {
                    "data": "warna"
                }, // Tampilkan 
                {
                    "data": "tanggal_masuk"
                }, // Tampilkan 
                {
                    "data": "nama_sb"
                }, // Tampilkan 
                {
                    "data": "nama_sp"
                }, // Tampilkan 
                {
                    "render": function(data, type, row) {
                        // Tampilkan kolom aksi
                        var html = '';
                        if (row.stock_sold === row.stock_quantity) {
                            var html = '<a href="javascript:;" class="btn btn-primary btn-sm item_ok" data="' + row.id + '"><i class="fa fa-check" aria-hidden="true"></i></a>'
                        } else {
                            var html = '<a href="javascript:;" class="btn btn-primary btn-sm item_ok disabled" data="' + row.id + '"><i class="fa fa-check" aria-hidden="true"></i></a>'
                        }
                        return html
                    }
                },
                {
                    "render": function(data, type, row) {
                        // Tampilkan kolom aksi
                        var html = '';
                        if (row.sisa > 0) {
                            var html = '<a href="javascript:;" class="btn btn-primary btn-sm item_barang_ok" data="' + row.id + '"><i class="fa fa-check" aria-hidden="true"></i></a>'
                        } else {
                            var html = '<a href="javascript:;" class="btn btn-primary btn-sm item_barang_ok disabled" data="' + row.id + '"><i class="fa fa-check" aria-hidden="true"></i></a>'
                        }
                        return html
                    }
                },
                {
                    "render": function(data, type, row) { // Tampilkan kolom aksi
                        var html = '';
                        if (idRole != 3) {
                            html = '<a href="javascript:;" class="btn btn-info btn-sm item_detail_barang_edit" data="' + row.id + '">Edit</a> '
                            html += '<a href="javascript:;" class="btn btn-danger btn-sm item_detail_barang_hapus" data="' + row.id + '">Hapus</a> '
                        }
                        return html

                    }
                },
            ],
        });

        if (idRole == 3) {

            table.column(10).visible(false);
            table.column(12).visible(false);

        }


        var table_barang_toko = null;
        table_barang_toko = $('#table-barang-toko').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "bAutoWidth": false,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/dataToko') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    no_po: no_po
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
                    "data": "nama_barang"
                }, // Tampilkan 
                {
                    "data": "warna"
                }, // Tampilkan 
                {
                    "data": "banyak"
                }, // Tampilkan 
            ],
        });

        //row clik table barang
        $('#table-barang-toko tbody').on('click', 'tr', function() {
            let data = table_barang_toko.row(this).data();
            console.log(data);

            $.ajax({
                success: function() {

                    $('#nama_barang').val(data.nama_barang);
                    $('#warna').val(data.warna);
                    $('#id_detail_barang').val(data.id_detail);
                    $('#id_Riwayat').val(data.id_riwayat);
                    $('#ModalListBarang').hide();

                }
            })
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
                "url": "<?php echo base_url('index.php/main/Bigmap/dataPenjualan2') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    no_po: no_po
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [5, 10, 50],
                [5, 10, 50]
            ], // Combobox Limit
            "columns": [{
                    "data": "no_po"
                },
                {
                    "data": "idDetail"
                },
                {
                    "data": "nama_barang"
                }, // Tampilkan // Tampilkan 
                {
                    "data": "nama_lantai"
                }, // Tampilkan // Tampilkan 
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
                    "data": "keterangan"
                },

                {
                    "render": function(data, type, row) { // Tampilkan kolom aksi

                        console.log(row);
                        var html = '';
                        html = '<a href="javascript:;" class="btn btn-danger btn-sm item_penjualan_hapus" data="' + row.id + '" qty= "' + row.banyak + '" idDetail= "' + row.idDetail + '">Hapus</a> '
                        return html

                    }
                },

                // { "render": function ( data, type, row ) { 
                //         // Tampilkan kolom aksi
                //         var html = '';
                //         if(idRole != 3){
                //             html  = '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus_penjualan" data="'+row.id_riwayat+'" data2="'+row.banyak+'" data3="'+row.id_detail_barang+'">Hapus</a> | '
                //             html +=  '<a href="javascript:;" class="btn btn-info btn-sm item_edit_penjualan" data="'+row.id_riwayat+'">Edit</a>'
                //         }
                //         return html
                //     }
                // },
            ],
        });
        tablePenjualan.column(1).visible(false);
        //hide column admin only
        if (idRole == 3) {

            tablePenjualan.column(2).visible(false);
            tablePenjualan.column(3).visible(false);
            tablePenjualan.column(4).visible(false);

        }
        var table_penjualan_customer = null;
        table_penjualan_customer = $('#table_penjualan_customer').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 50,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/list_data_penjualan_toko') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    id_toko: id_toko
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [50, 100, 500],
                [50, 100, 500]
            ], // Combobox Limit
            "columns": [{
                    "data": "idRiwayat"
                },
                {
                    "data": "id_penjualan"
                },
                {
                    "data": "no_po"
                },
                {
                    "data": "ukuran"
                },
                {
                    "data": "qty"
                }, // Tampilkan 
                {
                    "data": "tanggal_penjualan"
                }, // Tampilkan
                {
                    "data": "harga_baru"
                }, // Tampilkan
                {
                    "data": "harga_akhir"
                }, // Tampilkan
                {
                    "data": "margin"
                }, // Tampilkan
                {
                    "data": "no_po"
                }, // Tampilkan 
                {
                    "data": "keterangan"
                }, // Tampilkan  
                {
                    "render": function(data, type, row) { // Tampilkan kolom aksi
                        var html = '';
                        if (idRole != 3) {
                            html = '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus_penjualan_customer" data="' + row.id_penjualan + '" jumlah="' + row.qty + '" " idRiwayat="' + row.idRiwayat + '">Hapus</a>  '
                        }
                        return html
                    }
                },

            ],
        });
        table_penjualan_customer.column(0).visible(false);
        table_penjualan_customer.column(1).visible(false);



        //Simpan penjualan
        $('#btn_simpan_penjualan').on('click', function() {
            var idRiwayat = $('#idRiwayat').val();
            var idDetailBarang = $('#idDetailBarang').val();
            var idLantai = $('#id_lantai').val();
            var suratJalan = $('#surat_jalan').val();
            var noPo = $('#noPo').val();
            console.log(noPo);
            var banyak_keluar = $('#banyak_keluar').val();

            var tanggal_keluar = $('#tanggal_keluar').val();
            var keterangan = $('#keterangan').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/simpan_penjualan') ?>",
                dataType: "JSON",
                data: {
                    noPo: noPo,
                    idLantai: idLantai,
                    suratJalan: suratJalan,
                    idRiwayat: idRiwayat,
                    idDetailBarang: idDetailBarang,
                    banyak_keluar: banyak_keluar,
                    tanggal_keluar: tanggal_keluar,
                    keterangan: keterangan
                },
                success: function(data) {
                    $('[name="idRiwayat"]').val("");
                    $('[name="idDetailBarang"]').val("");
                    $('[name="surat_jalan"]').val("");
                    $('[name="banyak_keluar"]').val("");
                    $('[name="noPo"]').val("");
                    $('[name="keterangan"]').val("");
                    $('#ModalaAddPenjualan').modal('hide');
                    tablePenjualan.ajax.reload();
                    table.ajax.reload();
                    table_barang_toko.ajax.reload();
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
        });

        //GET ADD Penjualan
        $('#show_data').on('click', '.item_barang_ok', function() {
            var id = $(this).attr('data');
            $('#ModalaAddPenjualan').modal('show');
            $('#idDetailBarang').val(id);
            $('#btn_simpan_penjualan').hide();

            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_detail2') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id, no_po) {

                        $('[name="noPo"]').val(data.no_po);



                    });
                }
            });
            return false;
        });

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

        // Selesaikan PO
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


        $('#banyak_keluar').on('keyup', function() {
            var id = $('#idDetailBarang').val();
            var surat_jalan = $('#surat_jalan').val();
            var banyak_keluar = $('#banyak_keluar').val();


            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_detail2') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {

                    if (banyak_keluar > data.sisa) {
                        $('#notif').html('');
                        $('#notif').append('<p class="text-danger">Jumlah yang anda masukan melebihi jumlah stok yang di PO kan!.</p>');
                        $('#btn_simpan_penjualan').hide();
                    } else {
                        $('#notif').html('');

                        if (banyak_keluar == '') {
                            $('#btn_simpan_penjualan').hide();
                        } else {
                            $('#btn_simpan_penjualan').show();
                        }
                    }
                }
            });
            return false;
        });

        // Hapus Detail Barang
        $('#show_data').on('click', '.item_detail_barang_hapus', function() {
            var id = $(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });

        // Hapus Detail Barang
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/nonAktifDetBarang') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo 'Data Berhasil Dihapus!' ?>
                        </div>`);
                    table.ajax.reload();
                    tablePenjualan.reload();
                }
            });
            return false;
        });

        // Get Update Detail Barang
        $('#show_data').on('click', '.item_detail_barang_edit', function() {
            var id = $(this).attr('data');

            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_detail2') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id, id_detail_barang, no_po, stock_quantity, ukuran, warna, tanggal_masuk, sisa) {
                        $('#ModalaEdit').modal('show');
                        $('[name="id"]').val(data.id);
                        $('[name="idDetail"]').val(data.id_detail_barang);
                        $('[name="nopo_edit"]').val(data.no_po);
                        $('[name="banyak_edit"]').val(data.stock_quantity);
                        $('[name="ukuran_edit"]').val(data.ukuran);
                        $('[name="warna_edit"]').val(data.warna);
                        $('[name="tanggal_masuk_edit"]').val(data.tanggal_masuk);
                        $('[name="sisa"]').val(data.sisa);
                    });
                }
            });
            return false;
        });

        // Update Detail Barang 
        $('#btn_update').on('click', function() {

            var id = $('#id').val();
            var idDet = $('#idDetail').val();
            var nopo = $('#nopo2').val();
            var banyak = $('#banyak2').val();
            var sisa = $('#sisa').val();
            var ukuran = $('#ukuran2').val();
            var warna = $('#warna2').val();
            var tanggalMasuk = $('#tanggal_masuk2').val();

            if (idDet == '' || nopo == '' || banyak == '' || ukuran == '' || warna == '' || tanggalMasuk == '') {

            } else if (banyak < sisa) {
                alert('Banyak Barang yang anda masukan tidak boleh kurang dari sisa')
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/update_detail_barang') ?>",
                    dataType: "JSON",
                    data: {
                        id: id,
                        idDetail: idDet,
                        nopo: nopo,
                        banyak: banyak,
                        ukuran: ukuran,
                        warna: warna,
                        tanggalMasuk: tanggalMasuk
                    },
                    success: function(data) {
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
                    }
                });
                return false;
            }
        });

        // Hapus Detail Penjualan
        $('#show_data_penjualan').on('click', '.item_penjualan_hapus', function() {
            var id = $(this).attr('data');
            var qty = $(this).attr('qty');
            var idDetail = $(this).attr('idDetail');
            $('#ModalHapusPenjualan').modal('show');
            $('[name="kode"]').val(id);
            $('[name="qty"]').val(qty);
            $('[name="idDetail"]').val(idDetail);
        });

        // Hapus Detail Penjualan
        $('#btn_hapus_penjualan').on('click', function() {
            var kode = $('#textkode').val();
            var qty = $('#qtyjual').val();
            console.log(qty);
            var idDetail = $('#idDetail').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/nonAktifPenjualan2') ?>",
                dataType: "JSON",
                data: {
                    kode: kode,
                    qty: qty,
                    idDetail: idDetail
                },
                success: function(data) {
                    $('#ModalHapusPenjualan').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo 'Data Berhasil Dihapus!' ?>
                        </div>`);
                    table.ajax.reload();
                    tablePenjualan.ajax.reload();
                }
            });
            return false;
        });
        //Cek Update banyak PO
        // $('#btn-tambah-penjualan').click(function(){
        //     $('#ModalaAddPenjualanCustomer').modal('show');
        //     $('#btn_simpan_customer').hide();
        // });
        $('#btn_simpan_customer').hide();
        $('#banyakPenjualan').on('keyup', function() {

            var id = $('#id_Riwayat').val();
            var banyak_keluar = $('#banyakPenjualan').val();
            // var banyak_keluar = parseInt(banyak_keluar);


            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_penjualan') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    var stockToko = data.banyak;
                    console.log(stockToko)


                    if (banyak_keluar > stockToko) {
                        $('#notifbanyakPenjualan').html('');
                        $('#notifbanyakPenjualan').append('<p class="text-danger">Jumlah yang anda masukan melebihi jumlah stok yang di PO kan!.</p>');
                        $('#btn_simpan_customer').hide();
                    } else {
                        $('#notifbanyakPenjualan').html('');

                        if (banyak_keluar == '' || banyak_keluar == '0') {
                            $('#btn_simpan_customer').hide();
                        } else if (banyak_keluar == null) {
                            $('#btn_simpan_customer').hide();
                        } else {
                            $('#btn_simpan_customer').show();
                        }
                    }
                }
            });
            return false;
        });
        //Simpan penjualan To Customer
        $('#btn_simpan_customer').on('click', function() {
            var idRiwayat = $('#id_Riwayat').val();
            console.log(idRiwayat);


            var banyak_keluar = $('#banyakPenjualan').val();

            var keterangan = $('#desc').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/simpan_penjualan_customer') ?>",
                dataType: "JSON",
                data: {
                    idRiwayat: idRiwayat,
                    banyak_keluar: banyak_keluar,
                    keterangan: keterangan
                },
                success: function(data) {
                    $('[name="id_Riwayat"]').val("");
                    $('[name="banyakPenjualan"]').val("");
                    $('[name="desc"]').val("");
                    $('[name="nama_barang"]').val("");
                    $('[name="warna"]').val("");
                    $('[name="tanggalPenjualan"]').val("");
                    location.reload();
                    tablePenjualan.ajax.reload();
                    table.ajax.reload();
                    table_barang_toko.ajax.reload();
                    $('#ModalaAddPenjualanCustomer').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo 'Data Berhasil Disimpan!' ?>
                        </div>`);

                }
            });
            return false;
        });

        // Hapus Penjualan Customer
        $('#penjualanCustomer').on('click', '.item_hapus_penjualan_customer', function() {
            var id = $(this).attr('data');
            var jumlah = $(this).attr('jumlah');

            var idRiwayat = $(this).attr('idRiwayat');
            $('#ModalHapusPCustomer').modal('show');
            $('[name="kode"]').val(id);
            $('[name="jumlah"]').val(jumlah);
            $('[name="idRiwayat"]').val(idRiwayat);

        });
        // Hapus Detail Penjualan
        $('#btn_hapus_penjualan_customer').on('click', function() {
            var kode = $('#textkode').val();
            var jumlah = $('#jumlah').val();
            var idRiwayat = $('#idRiwayat').val();


            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/nonAktifPenjualanCustomer') ?>",
                dataType: "JSON",
                data: {
                    jumlah: jumlah,
                    kode: kode,
                    idRiwayat: idRiwayat
                },
                success: function(data) {
                    $('#ModalHapusPCustomer').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>
                            <?php echo 'Data Berhasil Dihapus!' ?>
                            </div>`);
                    table_penjualan_customer.ajax.reload();
                    tablePenjualan.ajax.reload();
                }
            });
            return false;
        });

    });
</script>

</body>

</html>