<!-- GET DATA FROM SESSION LOGIN -->
<?php
    $id_role = $this->session->userdata('id_role');
    $id_toko = $this->session->userdata('id_toko');
?>

<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <?php if ($id_role == 1) : ?>
                <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <?php elseif ($id_role == 2) : ?>
                <li><a href="<?php echo base_url('main/AdminOffice'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <?php else : ?>
                <li><a href="<?php echo base_url('main/AdminToko'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <?php endif; ?>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="alert"></div>

                <div class="box">
                    <?php if (($this->session->flashdata('berhasil_tambah')) or ($this->session->flashdata('berhasil_update')) or ($this->session->flashdata('berhasil_hapus'))) : ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>
                            <?php echo $this->session->flashdata('berhasil_tambah'); ?>
                            <?php echo $this->session->flashdata('berhasil_update'); ?>
                            <?php echo $this->session->flashdata('berhasil_hapus'); ?>
                        </div>
                    <?php elseif (($this->session->flashdata('gagal_tambah')) or ($this->session->flashdata('gagal_update'))) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-exclamation"></i>
                            <?php echo $this->session->flashdata('gagal_tambah'); ?>
                            <?php echo $this->session->flashdata('gagal_update'); ?>
                        </div>
                    <?php endif ?>

                    <div class="box-header">

                        <?php if ($id_role != 3) : ?>
                            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#PopUpCreateDataBarang" data-backdrop="static" data-keyboard="false"><span class="fa fa-plus"></span>&nbsp; Tambah Barang</a>
                            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pilih_toko" data-backdrop="static" data-keyboard="false"><span class="fa fa-building"></span>&nbsp; Pilih Toko</a>
                            <a href="<?php echo base_url('assets/import/FORM_INPUT_BARANG.xls') ?>" onclick="window.open('<?php echo base_url('assets/import/PANDUAN_FORM_INPUT_BARANG.xls') ?>');" class="btn btn-primary btn-sm"><span class="fa fa-download"></span>&nbsp; Download Format</a>
                            <a href="<?php echo base_url('export/PDFBrand'); ?>" target="_blank" class="btn btn-primary btn-sm"><span class="fa fa-download"></span>&nbsp;Format Kode</a>
                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importexcel" data-backdrop="static" data-keyboard="false"><span class="fa fa-upload"></span>&nbsp; Import Data</a>
                        <?php else : ?>
                            <a href="<?php echo base_url('main/Bigmap/get_toko/' . $id_toko); ?>" class="btn btn-sm btn-primary"><span class="fa fa-eye"></span>&nbsp; Lihat Toko</a>
                        <?php endif; ?>
                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#export" data-backdrop="static" data-keyboard="false"><span class="fa fa-file-excel-o"></span>&nbsp; Export Data</a>
                    </div>


                    <div class="box-body table-responsive">
                        <table id="table-barang" class="table table-bordered table-striped display">
                            <thead>
                                <tr>

                                    <th style="min-width: 250px">Opsi</th>
                                    <th class="text-center">Kode Barang</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Nama Brand</th>
                                    <!-- <th class="text-center">Nama Toko</th> -->
                                    <!-- <th class="text-center">Lantai</th> -->
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Harga(Rp.)</th>
                                    <th class="text-center">Diskon(%)</th>
                                    <th class="text-center">Cashback(Rp.)</th>
                                    <th class="text-center">Harga Netto(Rp.)</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>



<!-- POP UP MODAL CREATE DATA BARANG -->
<div class="modal fade" id="PopUpCreateDataBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" id="barang_form">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h3 class="modal-title font-weight-bold">Tambah Barang</h3>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="kobar" class="col-form-label">Kode Barang</label>
                        <input type="text" id="kobar" name="kobar" class="form-control" placeholder="Example : BRG00001" required="true">
                    </div>
                    <p id="notif"></p>

                    <div class="form-group">
                        <label class="control-label">Nama Brand</label>
                        <select id="id_brand" name="id_brand" class="form-control">
                            <option value="">-Pilih-</option>
                            <?php foreach ($data_brand as $data) : ?>
                                <option value="<?php echo $data->id_brand; ?>"><?php echo $data->nama_brand; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang" class="col-form-label">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Example : Baju Koko" required>
                    </div>

                    <div class="form-group">
                        <label for="desc" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="desc" name="desc" rows="5" placeholder="Keterangan ..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="harga_barang" class="col-form-label">Harga Barang</label>
                        <input type="number" id="harga_barang" name="harga_barang" class="form-control" onkeyup="sum();" onkeypress="return hanyaAngka(event)" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Barang dilihatt</label>


                        <select class="bootstrap-select toko_id" data-width="100%" data-live-search="true" multiple required>
                            <?php foreach ($toko as $data) : ?>
                                <option value="<?php echo $data->id_toko; ?>"><?php echo $data->nama_toko; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" class="Listtoko_id" name="toko_id" id="toko_id">

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
<!-- END POP UP MODAL CREATE DATA BARANG -->

<!-- POP UP MODAL EDIT DATA BARANG -->
<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Detail</h3>
            </div>

            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kobar_edit" class="col-form-label">Kode Barang</label>
                        <input type="text" id="kobar_edit" name="kobar_edit" class="form-control" placeholder="Kode Barang" required="true" readonly>
                    </div>


                    <div class="form-group">
                        <label class="control-label">Nama Brand</label>
                        <select class="form-control select2" name="id_brand_edit" id="id_brand_edit">
                            <option value="">-Pilih-</option>
                            <?php foreach ($data_brand as $data) : ?>
                                <option value="<?php echo $data->id_brand; ?>"><?php echo $data->nama_brand; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Nama Brand</label>
                        <div class="col-xs-8">
                            <select class="form-control select2" name="id_brand_edit" id="id_brand_edit">
                                <option value="">-Pilih-</option>
                                <?php foreach ($data_brand as $data) : ?>
                                    <option value="<?php echo $data->id_brand; ?>"><?php echo $data->nama_brand; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label for="nama_barang_edit" class="col-form-label">Nama Barang</label>
                        <input type="text" id="nama_barang_edit" name="nama_barang_edit" class="form-control" placeholder="Example : Baju Koko" required>
                    </div>

                    <div class="form-group">
                        <label for="harga_barang_edit" class="col-form-label">Harga Barang</label>
                        <input type="text" id="harga_barang_edit" name="harga_barang_edit" class="form-control" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required>
                    </div>

                    <div class="form-group">
                        <label for="desc" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="desc_edit" name="desc_edit" rows="5" placeholder="Keterangan ..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Nama Toko</label>
                        <div class="col-sm-10">
                            <select class="bootstrap-select strings" id="listTokoedit" name="id_toko_edit[]" data-width="100%" data-live-search="true" multiple required>
                                <?php foreach ($toko as $row) : ?>
                                    <option value="<?php echo $row->id_toko; ?>"><?php echo $row->nama_toko; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="edit_id" required>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Kembali</button>
                    <button class="btn btn-success" id="btn_update">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--POP UP MODAL EDIT DATA BARANG-->

<!-- POP UP MODAL PILIH TOKO -->
<div class="modal fade" id="pilih_toko" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                <h4 class="modal-title font-weight-bold">Pilih Toko</h4>
            </div>
            <div class="modal-body">
                <table id="example1" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Nama Toko</th>
                            <th style="text-align: center;">Alamat</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($toko as $r) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $no++; ?></td>
                                <td style="text-align: center;"><?php echo $r->nama_toko; ?></td>
                                <td style="text-align: center;"><?php echo $r->alamat_toko; ?></td>
                                <td style="text-align: center;">
                                    <a href="<?php echo base_url('main/Bigmap/get_toko/' . $r->id_toko); ?>" class="btn btn-primary btn-sm">Pilih</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
<!-- END POP UP MODAL PILIH TOKO -->

<!-- POP UP MODAL EXPORT DATA BERDASARKAN FILTER -->
<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('export/ExcelBarang'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title font-weight-bold">Pilih Data Export</h4>
                </div>
                <div class="modal-body">
                    <!-- cari tau dari mana dan untuk apa-->
                    <!-- <div class="form-group">
                        <label class="control-label">Lantai</label>
                        <select class="form-control" name="id_lantai" id="id_lantai">
                            <option value="">-Pilih-</option>
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
<!-- END POP UP MODAL EXPORT DATA BERDASARKAN FILTER -->

<!-- POP UP MODAL IMPORT EXCEL MULTI TOKO -->
<div class="modal fade" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('import/Importexcel_barang/saveimport_multitoko'); ?>" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title font-weight-bold">Import Data</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_brand" class="col-form-label">Lampirkan File (.xls)</label>
                        <input type="file" id="file" name="file" class="dropify" accept=".xls, .xlsx" data-height="100">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" value="Import" name="import">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- END POP UP MODAL IMPORT EXCEL MULTI TOKO -->

<input type="hidden" id="idRole" value="<?php echo $this->session->userdata('id_role'); ?>">
<input type="hidden" id="idToko" value="<?php echo $this->session->userdata('id_toko'); ?>">

<!-- POP UP MODAL HAPUS DATA BARANG -->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin menghapus barang ini?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END POP UP MODAL HAPUS DATA BARANG -->

<!-- POP UP MODAL HAPUS DATA BARANG -->
<!-- <?php foreach ($tbl_barang as $a) : ?>
    <div class="modal fade" id="hapus_barang<?php echo $a->id_barang; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form method="post" action="<?php echo base_url('main/Bigmap/hapus_data_barang'); ?>">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                        <h3 class="modal-title font-weight-bold">Hapus Barang</h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $a->id_barang ?>">
                        <div class="alert alert-warning">
                            <p>Apakah Anda yakin menghapus barang ini?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?> -->
<!-- END POP UP MODAL HAPUS DATA BARANG -->

<!-- POP UP MODAL DISKON -->
<div class="modal fade" id="ModalDiskon" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Diskon</h3>
            </div>

            <form>
                <div class="modal-body">

                    <div class="form-group">
                        <!-- <label for="kobar_edit" class="col-form-label">Kode Barang</label> -->
                        <input type="hidden" id="kobar_edit" name="kobar_edit" class="form-control" placeholder="Kode Barang" required="true" readonly>
                    </div>

                    <div class="form-group">
                        <!-- <label for="harga_barang_edit" class="col-form-label">Harga Barang</label> -->
                        <input type="hidden" id="harga_barang_edit" name="harga_barang_edit" class="form-control harga_barang_edit" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required readonly>
                    </div>

                    <div id="mainDiv">
                        <div class="one">
                            <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="" class="for">Diskon</label>
                                        <input type="text" name="persentase_edit[]" class="form-control diskon" onkeypress="return hanyaAngka(event)" required="true">
                                    </div>
                                    
                                    <div class="input-field col s1" >
                                        <a href="#" class="btn btn-primary add-diskon" style="font-size: .8em; margin-top: 10px;"><i class="fa fa-plus"></i> </a>
                                    </div>

                                    <div class="input-field col s1">
                                        <a href="#" class="btn btn-danger delete-diskon" style="font-size: .8em; margin-top: 5px;"><i class="fa fa-trash"></i> </a>
                                    </div>
                                </div>
                                <div class="input-field col s1">
                                    <input type="hidden" class="subtotal" name="Subtotal[]" value=" " readonly>
                                    <!-- <label for="Subtotal" >Subtotal</label> -->
                                </div>
                           
                            </div>
                        </div>

                        <div class="input-field col s2">
                            <!-- <label for="Grand_total" >Grand Total</label> -->
                            <input type="hidden" name="Grand_total_diskon" id="grand_total" class="form-control grand_total" value=" " readonly>
                        </div>
                    </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Kembali</button>
                    <button class="btn btn-success" id="btn_diskon">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END POP UP MODAL DISKON -->

<!-- MODAL CASHBACK -->
<div class="modal fade" id="ModalCashback" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Cashback</h3>
            </div>

            <form>
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3" >Kode barang</label>
                        <div class="col-xs-9">
                            <input name="kobar_edit" id="kobar_edit" class="form-control" type="text" readonly="true" placeholder="Kode Barang" style="width:335px;" required="true">
                        </div>
                    </div> -->

                    <div class="form-group">
                        <!-- <label for="kobar_edit" class="col-form-label">Kode Barang</label> -->
                        <input type="hidden" id="kobar_edit" name="kobar_edit" class="form-control" placeholder="Kode Barang" required="true" readonly>
                    </div>

                    <div class="form-group">
                        <!-- <label for="harga_barang_edit" class="col-form-label">Harga Barang</label> -->
                        <input type="hidden" id="harga_barang_edit" name="harga_barang_edit" class="form-control harga_barang_edit" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required readonly>
                    </div>

                    <div id="mainDiv_cb">
                        <div class="two">
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label for="" class="for">Cashback</label>
                                    <input type="text" name="cashback[]" class="form-control cashback" onkeypress="return hanyaAngka(event)" required>
                                </div>
                                <div class="input-field col s1">
                                    <input type="hidden" class="subtotal_cb" name="Subtotal_cb[]" value=" " readonly required>
                                    <!-- <label for="Subtotal_cb" >Subtotal</label> -->
                                </div>

                                <div class="input-field col s1">
                                    <a href="#" class="btn btn-primary add_cb" style="font-size: .8em; margin-top: 10px;"><i class="fa fa-plus"></i></a>
                                </div>
                                <div class="input-field col s1">
                                    <a href="#" class="btn btn-danger delete_cb" style="font-size: .8em; margin-top: 5px;"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-field col s2">
                        <!-- <label for="Grand_total" >Grand Total</label> -->
                        <input type="hidden" name="Grand_total" id="grand_total_cb" class="form-control grand_total_cb" value=" " readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Kembali</button>
                    <button class="btn btn-success" id="btn_cashback">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL CASHBACK -->



<?php $this->load->view('layout/v_footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var alert = $('#alert').html('');
        var idRole = $('#idRole').val();
        var idToko = $('#idToko').val();
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const noPo = urlParams.get('noPo');
        const nabar = urlParams.get('nabar');
        const nabrand = urlParams.get('nabrand');

        var table_new = $('#example1').DataTable();

        var table = null;
        table = $('#table-barang').DataTable({
            "processing": true,
            "serverSide": true,
            "bInfo": false,
            "bAutoWidth": false,
            autoWidth: false,
            "pageLength": 50,
            "ordering": true, // Set true agar bisa di sorting // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/data_stok_master_data') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    id_toko: idToko,
                    // noPo: noPo,
                    nabar: nabar,
                    nabrand: nabrand
                },
            },
            "deferRender": true,
            "aLengthMenu": [
                [50, 100, 500],
                [50, 100, 500]
            ], // Combobox Limit

            "columns": [

                {
                    "render": function(data, type, row) { // Tampilkan kolom aksi
                        var html = '';
                        if (idRole != 3) {
                            html = '<a href="javascript:;" class="btn btn-warning btn-sm item_edit  update-record" data-package_id="' + row.id_barang + '" data="' + row.id_barang + '">Edit</a> '
                            html += '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus" data="' + row.id_barang + '">Hapus</a> '
                            html += '<a href="javascript:;" class="btn btn-success btn-sm item_diskon" data="' + row.id_barang + '"><i class="fa fa-plus"> Diskon</i></a> '
                            html += '<a href="javascript:;" class="btn btn-success btn-sm item_cashback" data="' + row.id_barang + '"><i class="fa fa-plus"> Cashback</i></a> '
                        }
                        return html
                    }
                },
                {
                    "data": "id_barang"
                },
                {
                    "data": "nama_barang"
                },
                {
                    "data": "nama_brand"
                },
                {
                    "data": "total_stock"
                },
                {
                    "data": "harga_baru"
                },
                {
                    "data": "diskon"
                },

                // HANYA ADMIN 
                {
                    "data": "cashback"
                }, // Tampilkan 
                {
                    "data": "harga_netto"
                }, // Tampilkan 
                {
                    "data": "deskripsi_barang"
                }, // Tampilkan 

            ],
        });

        //HIDE COLUMN ADMIN ONLY
        if (idRole == 3) {
            table.column(0).visible(false);
            table.column(5).visible(false);
            table.column(6).visible(false);
            table.column(7).visible(false);
            table.column(8).visible(false);
            table.column(9).visible(false);
            table.column(10).visible(false);
            table.column(11).visible(false);
        }

        $('#table-barang tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            var id_barang = data.id_barang;
            $.ajax({
                success: function() {
                    window.location.href = "<?php echo base_url('index.php/main/Bigmap/get_barang_detail/'); ?>" + data.id_barang;
                }
            })
        });

        $('#example1 tbody').on('click', 'tr', function() {
            var data = table_new.row(this).data();
            // alert( 'You clicked on '+data[0]+'\'s row' );
            alert('You clicked ons row');
        });


        //multiselect
        $(".toko_id").change(function() {
            f2();
        });

        var f2 = function() {
            var values = Array.from($(".toko_id").find(':selected')).map(function(item) {
                return $(item).val();
            });
            $('.Listtoko_id').val(values);
        }
        f2();


        $('#btn_simpan').on('click', function() {
            var kobar = $('#kobar').val();
            var id_brand = $('#id_brand').val();
            var nama_barang = $('#nama_barang').val();
            var desc = $('#desc').val();
            var harga_barang = $('#harga_barang').val();
            var id_toko = $('.Listtoko_id').val();
            // var id_lantai = $('#id_lantai').val();
            // var nama_barang = $('#nama_barang').val();

            if (kobar == '' || nama_barang == '') {

            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/simpan_barang') ?>",
                    dataType: "JSON",
                    data: {
                        kobar: kobar,
                        id_brand: id_brand,
                        nama_barang: nama_barang,
                        desc: desc,
                        harga_barang: harga_barang,
                        id_toko: id_toko
                        // id_lantai: id_lantai,
                    },

                    success: function(data) {
                        if (data != 'notfound') {
                            $('[name="kobar"]').val("");
                            $('[name="id_brand"]').val("");
                            $('[name="nama_barang"]').val("");
                            $('[name="desc"]').val("");
                            $('[name="harga_barang"]').val("");
                            $('[name="id_toko"]').val("");
                            // $('[name="id_lantai"]').val("");
                            $('#PopUpCreateDataBarang').modal('hide');
                            $('.Listtoko_id').val("");
                            $('#alert').html('');
                            $('#alert').append(`    <div class="alert alert-success alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <i class="icon fa fa-check"></i>
                                                        <?php echo 'Data Barang Berhasil Tersimpan' ?>
                                                    </div>`);
                            $('#notif').html('');
                            location.reload();

                            // table_po.ajax.reload();
                            get_code_barang();

                        } else {
                            $('#notif').html('');
                            $('#notif').append('<p class="text-danger">Kode Barang Sudah ada</p>');
                        }

                    }
                });
                return false;
            }
        });



        $('.bootstrap-select').selectpicker();
        $('#show_data').on('click', '.update-record', function(e) {
            var id = $(this).attr('data');
            $('[name="edit_id"]').val(id);
            $(".strings").val('');
            $.ajax({
                url: "<?php echo site_url('index.php/main/Bigmap/get_toko_by_barang'); ?>",
                method: "GET",
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {

                    console.log(data);
                    var item = data;
                    var val1 = item.replace("[", "");
                    var val2 = val1.replace("]", "");
                    var val3 = val2.replace(/"/g, ''); //mengganti semua yang memiliki tanda kutip
                    var values = val3;
                    $.each(values.split(","), function(i, e) {


                        $(".strings option[value='" + e + "']").prop("selected", true).trigger('change');
                        $(".strings").selectpicker('refresh');

                    });
                }

            });
            return false;
        });


        $('#show_data').on('click', '.item_edit', function(e) {
            var id = $(this).attr('data');


            e.stopPropagation();

            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_barang') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id_barang, id_brand, nama_barang, deskripsi_barang, harga_barang) {
                        $('#ModalaEdit').modal('show');
                        $('[name="kobar_edit"]').val(data.id_barang);
                        $('[name="id_brand_edit"]').val(data.id_brand);
                        // $('[name="id_lantai_edit"]').val(data.id_lantai);
                        $('[name="nama_barang_edit"]').val(data.nama_barang);
                        $('[name="desc_edit"]').val(data.deskripsi_barang);
                        $('[name="harga_barang_edit"]').val(data.harga_barang);
                        // $('[name="harga_akhir_edit"]').val(data.harga_akhir);
                        // $('[id="diskon1_edit"]').val(data.diskon1);
                        // $('[id="diskon2_edit"]').val(data.diskon2);
                        // $('[id="diskon3_edit"]').val(data.diskon3);
                        // $('[id="cashback_edit"]').val(data.cashback);
                    });
                }
            });
            return false;
        });


        $('#btn_update').on('click', function() {
            var idBrarang = $('#kobar_edit').val()
            var nabrand = $('#id_brand_edit').val();
            var nabar = $('#nama_barang_edit').val();
            var desc = $('#desc_edit').val();
            var listToko = $('#listTokoedit').val();
            var harga_barang_edit = $('#harga_barang_edit').val();
            // var id_diskon_edit = $("input[name^='id_diskon_edit']").map(function (idx, ele) {
            // return $(ele).val();
            // }).get();

            // var persentase_edit = $("input[name^='persentase_edit']").map(function(idx, ele) {
            //   return $(ele).val();
            // }).get();

            // var cashback_edit = $('#cashback_edit').val();
            // var harga_akhir_edit = $('#harga_akhir_edit').val();

            if (idBrarang == '' || nabrand == '' || nabar == '') {

            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/main/Bigmap/updateBarang') ?>",
                    dataType: "JSON",
                    data: {
                        idBrarang: idBrarang,
                        nabrand: nabrand,
                        nabar: nabar,
                        desc: desc,
                        listToko: listToko,
                        harga_barang_edit: harga_barang_edit
                    },
                    success: function(data) {
                        $('[name="kobar_edit"]').val("");
                        $('[name="nama_barang_edit"]').val("");
                        $('[name="desc_edit"]').val("");
                        $('#ModalaEdit').modal('hide');
                        $('#alert').html('');
                        $('#alert').append(`    <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <i class="icon fa fa-check"></i>
                                                    <?php echo 'Data Berhasil Diubah!' ?>
                                                </div>`);
                        table.ajax.reload();
                        get_code_barang();
                    }
                });
                return false;
            }
        });


        $('#show_data').on('click', '.item_hapus', function(e) {
            var id = $(this).attr('data');
            e.stopPropagation();

            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });

        //Hapus Barang
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/nonAktif') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    $('#alert').append(` <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo 'Data Berhasil Dihapus!' ?>
                        </div>`);
                    table.ajax.reload();
                }
            });
            return false;
        });


        // $('#tambah').on('click', function(){
        //     tampil_data_toko();
        // }); 

        // UNTUK DISKON
        $('#show_data').on('click', '.item_diskon', function(e) {
            var id = $(this).attr('data');
            e.stopPropagation();
            $('#ModalDiskon').modal('show');
            $('[name="kode"]').val(id);
        });

        $('#show_data').on('click', '.item_diskon', function(e) {
            var id = $(this).attr('data');
            e.stopPropagation();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_barang') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id_barang, id_brand, nama_barang, nama_brand, deskripsi_barang, harga_barang, harga_akhir, diskon1, diskon2, diskon2, cashback) {
                        $('#ModalDiskon').modal('show');
                        $('[name="kobar_edit"]').val(data.id_barang);
                        $('[name="id_brand_edit"]').val(data.id_brand);
                        $('[name="id_lantai_edit"]').val(data.id_lantai);
                        $('[name="nama_barang_edit"]').val(data.nama_barang);
                        $('[name="nama_brand_edit"]').val(data.nama_brand);
                        $('[name="desc_edit"]').val(data.deskripsi_barang);
                        $('[name="harga_barang_edit"]').val(data.harga_barang);
                        $('[name="harga_akhir_edit"]').val(data.harga_akhir);
                        $('[id="diskon1_edit"]').val(data.diskon1);
                        $('[id="diskon2_edit"]').val(data.diskon2);
                        $('[id="diskon3_edit"]').val(data.diskon3);
                        $('[id="cashback_edit"]').val(data.cashback);
                    });
                }
            });
            return false;
        });
        // END UNTUK DISKON

        //GET Cashback
        $('#show_data').on('click', '.item_cashback', function(e) {
            var id = $(this).attr('data');
            e.stopPropagation();
            $('#ModalCashback').modal('show');
            $('[name="kode"]').val(id);
        });

        //GET CASHBACK
        $('#show_data').on('click', '.item_cashback', function(e) {
            var id = $(this).attr('data');
            e.stopPropagation();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_barang') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id_barang, id_brand, id_toko, id_lantai, nama_barang, deskripsi_barang, harga_barang, harga_akhir, diskon1, diskon2, diskon2, cashback) {
                        $('#ModalCashback').modal('show');
                        $('[name="kobar_edit"]').val(data.id_barang);
                        $('[name="harga_barang_edit"]').val(data.harga_barang);
                        $('[name="harga_akhir_edit"]').val(data.harga_akhir);


                    });
                }
            });
            return false;
        });

        // BUTTON POP UP MODAL UNTUK DISKON
        $('#btn_diskon').on('click', function() {
            var idBrarang = $('#kobar_edit').val()
            var persentase_edit = $("input[name^='persentase_edit']").map(function(idx, ele) {
                return $(ele).val();
            }).get();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/updateDiskon') ?>",
                dataType: "JSON",
                data: {
                    idBrarang: idBrarang,
                    persentase_edit: persentase_edit,
                },

                success: function(data) {
                    location.reload(true);
                    $('[name="kobar_edit"]').val("");
                    $('[name="persentase_edit[]"]').val("");
                    $('#ModalDiskon').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(`<div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <i class="icon fa fa-check"></i>
                                            <?php echo 'Data Diskon Berhasil Diubah!' ?>
                                        </div>`);
                    table.ajax.reload();
                    get_code_barang();
                }
            });
            return false;
        });
        // END BUTTON POP UP MODAL UNTUK DISKON


        $('#btn_cashback').on('click', function() {
            var idBrarang = $('#kobar_edit').val()
            // var hargaBarang = $('#harga_barang_edit').val()
            // var hargaAkhir = $('#grand_total_cb').val()
            // var nabrand = $('#id_brand_edit').val();
            // var nalantai = $('#id_lantai_edit').val();
            // var nabar = $('#nama_barang_edit').val();
            // var desc = $('#desc_edit').val();
            // var harga_barang_edit = $('#harga_barang_edit').val();
            // var id_diskon_edit = $("input[name^='id_diskon_edit']").map(function (idx, ele) {
            // return $(ele).val();
            // }).get();

            var cashback = $("input[name^='cashback']").map(function(idx, ele) {
                return $(ele).val();
            }).get();

            // var cashback_edit = $('#cashback_edit').val();
            // var harga_akhir_edit = $('#harga_akhir_edit').val();


            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/updateCahback') ?>",
                dataType: "JSON",
                data: {
                    idBrarang: idBrarang,
                    // hargaBarang: hargaBarang,
                    // hargaAkhir: hargaAkhir,

                    cashback: cashback,

                },
                success: function(data) {
                    location.reload(true);
                    $('[name="kobar_edit"]').val("");
                    $('[name="cashback[]"]').val("");
                    $('#ModalCashback').modal('hide');
                    $('#alert').html('');
                    $('#alert').append(`<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <i class="icon fa fa-check"></i>
                  <?php echo 'Data Berhasil Diubah!' ?>
                  </div>`);
                    table.ajax.reload();
                    get_code_barang();
                }
            });
            return false;

        });

        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function(e) {
            var id = $(this).attr('data');
            e.stopPropagation();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/main/Bigmap/get_barang') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(id_barang, id_brand, id_toko, nama_barang, nama_brand, deskripsi_barang, diskon1, diskon2, diskon2, cashback) {
                        $('#ModalaEdit').modal('show');
                        $('[name="kobar_edit"]').val(data.id_barang);
                        $('[name="id_brand_edit"]').val(data.id_brand);
                        $('[name="nama_barang_edit"]').val(data.nama_barang);
                        $('[name="harga_barang_edit"]').val(data.harga_barang);
                        $('[name="harga_netto_edit"]').val(data.harga_netto);
                        $('[name="nama_brand_edit"]').val(data.nama_brand);
                        $('[name="desc_edit"]').val(data.deskripsi_barang);
                        $('[id="diskon1_edit"]').val(data.diskon1);
                        $('[id="diskon2_edit"]').val(data.diskon2);
                        $('[id="diskon3_edit"]').val(data.diskon3);
                        $('[id="cashback_edit"]').val(data.cashback);
                    });
                }
            });
            return false;
        });
    });
</script>