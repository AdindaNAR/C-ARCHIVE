<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>



<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php $ceknamatoko = $this->db->get_where('tbl_toko', array('id_toko' => $this->uri->segment(4)))->row(); ?>
            <?php echo $ceknamatoko->nama_toko; ?>
        </h1>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('main/Bigmap'); ?>">Big Map</a></li>
            <!-- <li><a href="<?php echo base_url('#'); ?>">Toko</a></li> -->
            <li class="active"><?php echo $ceknamatoko->nama_toko; ?></li>
            <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <span id="alert"></span>
                <?php $listPo = $this->uri->segment(5); ?>
                <?php $idrole =  $this->session->userdata('id_role'); ?>
                
                <?php if ($listPo != 'listPo') : ?>
                    <div class="box" id="box-barang">
                        <div class="box-header">
                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lantai"><span class="fa fa-plus"></span>&nbsp; Pilih Lantai</a>
                            <?php if ($idrole != 3) : ?>
                                <a href="<?php echo $actual_link . '/' . '1'; ?>" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span>&nbsp; PO Baru</a>

                            <?php else : ?>

                            <?php endif; ?>
                        </div>

                        <div class="box-body table-responsive">
                            <table id="table-barang" class="table table-bordered table-striped display">
                                <thead>
                                    <tr>
                                        <th>ID Barang</th>
                                        <th id="clickable">Nama Barang</th>
                                        <th>Nama Brand</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody id="show_data"></tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($listPo != 'listPo') : ?>
                    <div class="box" id="box-po">
                        <div class="box-header">
                           
                            <?php if ($idrole != 3) : ?>
                                <a class="btn btn-success btn-sm" id="btn-add-po" data-toggle="modal" data-target="#ModalaAddPO"><span class="fa fa-plus"></span>&nbsp; Buat PO</a>
                            <?php else : ?>
                            <?php endif; ?>
                        </div>

                        <div class="box-body table-responsive">
                            <form action="<?php echo base_url() . 'main/bigmap/simpan_po' ?>" method="post">
                                <center>
                                    <!-- error uniq -->
                                    <span><?php echo $this->session->flashdata('msguniq'); ?></span>
                                    <!-- success -->
                                    <span><?php echo $this->session->flashdata('msgsuccess'); ?></span>
                                </center>
                                <br>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2">
                                            NOPO
                                            <input type="text" name="nopo" id="nopo" class="form-control input-sm" required style="width:130px">
                                            <!-- Get ID TOKO  -->
                                            <input type="hidden" name="id_toko" value="<?php echo $this->uri->segment(4); ?>" class="form-control input-sm" style="width:130px">
                                        </div>

                                        <div class="col-md-4">
                                            Status Pengiriman
                                            <select id="sp" name="sp" class="select2 form-control" data-live-search="true" title="Pilih Status" data-width="100%" required>
                                                <option value="">-Pilih-</option>
                                                <option value="manual">Manual</option>
                                                <?php foreach ($data_sp as $data) : ?>
                                                    <option value="<?php echo $data->nama_sp; ?>"><?php echo $data->nama_sp; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <input type="text" name="manual_sp" id="manual_sp" style="margin-top: 2px;" value="" hidden />
                                        </div>

                                        <div class="col-md-4">
                                            Status Barang
                                            <select id="sb" name="sb" class="select2 form-control" data-live-search="true" title="Pilih Status" data-width="100%" required>
                                                <option value="">-Pilih-</option>
                                                <option value="manual">Manual</option>
                                                <?php foreach ($data_sb as $data) : ?>
                                                    <option value="<?php echo $data->nama_sb; ?>"><?php echo $data->nama_sb; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="text" name="manual_sb" id="manual_sb" style="margin-top: 2px;" value="" hidden />
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Nama Brand</th>
                                            <th>Harga</th>
                                            <th>QTY</th>
                                            <th>Item Description</th>
                                            <th>Subtotal</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($this->cart->contents() as $items) : ?>
                                            <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>

                                            <tr>
                                                <td><?php echo $items['id']; ?></td>
                                                <td><?php echo $items['name']; ?></td>
                                                <td><?php echo $items['nama_brand']; ?></td>
                                                <td><?php echo $items['price']; ?></td>
                                                <td><?php echo $items['qty']; ?></td>
                                                <td>
                                                    <?php if ($this->cart->has_options($items['rowid']) == TRUE) : ?>
                                                        <p>
                                                            <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) : ?>
                                                                <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />
                                                            <?php endforeach; ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo number_format($items['subtotal']); ?></td>
                                                <td style="text-align:center;">
                                                    <a href="<?php echo base_url() . 'main/bigmap/remove/' . $items['rowid']; ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a>
                                                </td>
                                            </tr>

                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <table>
                                    <tr>
                                        <td style="width:670px;" rowspan="2"></td>
                                        <th style="width:140px;">Total(Rp)</th>
                                        <th style="text-align:right;width:140px;">
                                            <input type="text" name="total2" value="<?php echo number_format($this->cart->total()); ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly>
                                        </th>
                                    </tr>
                                </table>

                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                <a href="<?php echo base_url() . 'main/bigmap/destroy' ?>" class="btn btn-danger btn-sm">Hapus Cart</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="box">
                    <div class="box-header">
                        <h3><b>Daftar List Po</b></h3>
                        <!-- <a class="btn btn-primary btn-sm" id="tambah" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span>&nbsp; Tambah Barang</a> -->
                        <!-- <a  href="<?php echo $actual_link . '/' . '1'; ?>"class="btn btn-warning btn-sm"><span class="fa fa-plus"></span>&nbsp; PO Baru</a> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="table_list_po" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th>No PO</th>
                                    <th>Status Pengiriman </th>
                                    <th>Status Barang </th>
                                    <th>Tanggal Po</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data_po"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('layout/v_footer'); ?>

<input type="hidden" id="id_toko" value="<?php echo  $this->uri->segment(4); ?>">
<input type="hidden" id="id_add" value="<?php echo  $this->uri->segment(5); ?>">
<input type="hidden" id="idRole" value="<?php echo $this->session->userdata('id_role'); ?>">


<!-- <div class="control-sidebar-bg"></div>
</div> -->

<!-- Pop Up Pilih Lantai -->
<div class="modal fade" id="lantai" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                <h3 class="modal-title font-weight-bold">Pilih Lantai</h3>
            </div>
            
            <div class="modal-body">
                <table id="example1" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Nama Lantai</th>
                            <th style="text-align: center;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lantai as $r) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $r->nama_lantai; ?></td>
                                <td style="text-align: center;">
                                    <a href="<?php echo base_url('main/Bigmap/get_lantai/' . $r->id_toko . '/' . $r->id_lantai); ?>" class="btn btn-primary btn-sm">Pilih</a>
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
<!-- End Pop Up Pilih Lantai -->

<!-- Pop Up Import Excel -->
<div class="modal fade" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('import/Importexcel_barang/saveimport'); ?>" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Import Excel</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_toko" name="id_toko" value="<?php echo $this->uri->segment('4') ?>">
                    <div class="form-group">
                        <label for="nama_brand" class="col-form-label">Lampirkan File (.xls)</label>
                        <!-- <input type="file" name="file" class="form-control" id="file" required accept=".xls, .xlsx" /> -->
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
<!-- End Pop Up Import Excel -->

<!-- MODAL ADD -->
<div class="modal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h3 class="modal-title font-weight-bold">Tambah Barang</h3>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="kobar" class="col-form-label">Kode Barang</label>
                        <input type="text" id="kobar" name="kobar" class="form-control" placeholder="Kode Barang" required="true">
                    </div>

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
                        <label class="control-label">Lantai</label>
                        <select id="id_lantai" name="id_lantai" class="form-control">
                            <option value="">-Pilih-</option>
                            <?php foreach ($lantai as $data) : ?>
                                <option value="<?php echo $data->id_lantai; ?>"><?php echo $data->nama_lantai; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="desc" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="desc" name="desc" rows="5" placeholder="Keterangan ..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="harga_barang" class="col-form-label">Harga Barang</label>
                        <input type="number" id="harga_barang" name="harga_barang" class="form-control" placeholder="" onkeyup="sum();" required>
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
<!-- MODAL ADD -->

<!--MODAL HAPUS-->
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
            <p>Apakah Anda yakin mau menghapus barang ini?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
          <button class="btn_hapus btn btn-success" id="btn_hapus">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--END MODAL HAPUS-->

<!-- MODAL EDIT -->
<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title" id="myModalLabel">Edit Detail</h3>
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
                        <label class="control-label col-xs-3" >Nama Brand</label>
                        <div class="col-xs-8">
                            <select  class="form-control select2"  name="id_brand_edit" id="id_brand_edit" >
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

          <!-- <div class="form-group">
                        <label class="control-label col-xs-3" >Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="nama_barang_edit" id="nama_barang_edit" class="form-control" type="text" placeholder="nama" style="width:335px;" required>
                        </div>
                    </div> -->

          <div class="form-group">
            <label class="control-label">Lantai</label>
            <select class="form-control" name="id_lantai_edit" id="id_lantai_edit">
              <option value="">-Pilih-</option>
              <?php foreach ($data_lantai_akses as $data) : ?>
                <option value="<?php echo $data->id_lantai; ?>"><?php echo $data->nama_lantai; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="harga_barang_edit" class="col-form-label">Harga Barang</label>
            <input type="text" id="harga_barang_edit" name="harga_barang_edit" class="form-control" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required>
          </div>

          <!-- <input type="hidden" id="id_diskon1_edit" name="id_diskon_edit[]" require> -->
          <!-- <div class="form-group">
                        <label for="diskon1_edit" class="col-form-label">Diskon 1</label>
                        <input type="text" id="diskon1_edit" name="persentase_edit[]" class="form-control" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required>
                    </div> -->

          <!-- <input type="hidden" id="id_diskon2_edit" name="id_diskon_edit[]" require> -->
          <!-- <div class="form-group">
                        <label for="diskon2_edit" class="col-form-label">Diskon 2</label>
                        <input type="text" id="diskon2_edit" name="persentase_edit[]" class="form-control" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required>
                    </div> -->

          <!-- <input type="hidden" id="id_diskon3_edit" name="id_diskon_edit[]" require> -->
          <!-- <div class="form-group">
                        <label for="diskon3_edit" class="col-form-label">Diskon 3</label>
                        <input type="text" id="diskon3_edit" name="persentase_edit[]" class="form-control" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required>
                    </div> -->

          <!-- <input type="hidden" id="id_cashback" name="id_cashback" require>
                    <div class="form-group">
                        <label for="cashback" class="col-form-label">Cashback</label>
                        <input type="text" id="cashback_edit" name="cashback_edit" class="form-control" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required>
                    </div>

                    <div class="form-group">
                        <label for="harga_akhir_edit" class="col-form-label">Harga Akhir</label>
                        <input type="text" id="harga_akhir_edit" name="harga_akhir_edit" class="form-control" placeholder="Example : Baju Koko" required>
                    </div> -->

          <!-- <div class="form-group">
                        <label class="control-label col-xs-3" >Lantai

                        </label>
                        <div class="col-xs-8">
                            <select  class="form-control" name="id_lantai_edit" id="id_lantai_edit" >
                                <option value="">-Pilih-</option>
                                <?php foreach ($data_lantai_akses as $data) : ?>
                                    <option value="<?php echo $data->id_lantai; ?>"><?php echo $data->nama_lantai; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> -->

          <div class="form-group">
            <label for="desc" class="col-form-label">Deskripsi</label>
            <textarea class="form-control" id="desc_edit" name="desc_edit" rows="5" placeholder="Keterangan ..."></textarea>
          </div>

          <!-- <div class="form-group">
                        <label class="control-label col-xs-3" >Deskripsi</label>
                        <div class="col-xs-9">
                            <textarea class="form-control" id="desc_edit" name="desc_edit" rows="5" placeholder="Keterangan ..."></textarea>
                        </div>
                    </div> -->

        </div>

        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Kembali</button>
          <button class="btn btn-success" id="btn_update">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--END MODAL EDIT-->

<!-- MODAL DISKON -->
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
                <label for="" class="for">Diskon</label>
                <input type="text" name="persentase_edit[]" class="form-control diskon" onkeypress="return hanyaAngka(event)" required>
              </div>
              <div class="input-field col s1">
                <input type="hidden" class="subtotal" name="Subtotal[]" value=" " readonly>
                <!-- <label for="Subtotal" >Subtotal</label> -->
              </div>
              <!-- <div class="row"> -->
              <div class="input-field col s1 add">
                <a href="#" class="btn btn-primary" style="font-size: .8em;">Tambah Diskon</a>
              </div>
              <div class="input-field col s1 delete">
                <a href="#" class="btn btn-danger" style="font-size: .8em; margin-top: 5px;">Hapus Diskon</a>
              </div>
              <!-- </div> -->
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
<!-- END MODAL DISKON -->

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
            <label for="kobar_edit" class="col-form-label">Kode Barang</label>
            <input type="text" id="kobar_edit" name="kobar_edit" class="form-control" placeholder="Kode Barang" required="true" readonly>
          </div>

          <div class="form-group">
            <!-- <label for="harga_barang_edit" class="col-form-label">Harga Barang</label> -->
            <input type="hidden" id="harga_barang_edit" name="harga_barang_edit" class="form-control harga_barang_edit" placeholder="Example : Baju Koko" onkeyup="sum_edit();" required readonly>
          </div>

          <div id="mainDiv_cb">
            <div class="two">
              <div class="form-group">
                <label for="" class="for">Cashback</label>
                <input type="text" name="cashback[]" class="form-control cashback" onkeypress="return hanyaAngka(event)" required>
              </div>
              <div class="input-field col s1">
                <input type="hidden" class="subtotal_cb" name="Subtotal_cb[]" value=" " readonly required>
                <!-- <label for="Subtotal_cb" >Subtotal</label> -->
              </div>

              <div class="input-field col s1 add_cb">
                <a href="#" class="btn btn-primary" style="font-size: .8em;">Tambah Cashback</a>
              </div>
              <div class="input-field col s1 delete_cb">
                <a href="#" class="btn btn-danger" style="font-size: .8em; margin-top: 3px;"> Hapus Cashback</a>
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


<!-- Pop Up Create PO -->
<div class="modal fade" id="ModalaAddPO" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
        <h3 class="modal-title font-weight-bold">Tambah </h5>
      </div>

      <form action="<?php echo base_url() . 'main/Bigmap/add_to_cart' ?>" method="post">

      
        
        <div class="modal-body">
          <div class="form-group">
            <a class="btn btn-success btn-sm form-control" id="pilihbarang" data-toggle="modal" data-target="#ModalListBarang"><span class="fa fa-plus"></span>&nbsp; Pilih Barang</a>
          </div>

          <div class="form-group">
            <label for="no_po" class="col-form-label">Kode Barang</label>
            <input type="text" name="kode_brg" id="kode_brg" class="form-control" readonly="true" placeholder="Kode Barang" required="true">
          </div>

          <div class="form-group">
            <label for="Brand" class="col-form-label">Nama Brand</label>
            <input type="text" name="nama_brandpo" id="nama_brandpo" class="form-control" readonly="true" placeholder="Nama Brand" required="true">
          </div>

          <div class="form-group">
            <label for="Barang" class="col-form-label">Nama Barang</label>
            <input type="text" name="nama_barangpo" id="nama_barangpo" class="form-control" readonly="true" placeholder="Nama Barang" required="true">
          </div>

          <div class="form-group">
            <label for="Barang" class="col-form-label">Harga</label>
            <input type="number" id="hargapo" class="form-control" readonly="true" placeholder="Nama Barang" required="true">
          </div>

          <div class="form-group">
            <label for="banyak" class="col-form-label">Banyak Barang</label>
            <input type="number" name="qyt" id="qyt" class="form-control" maxlength='100' pattern='^[0-9]$' placeholder="Banyak" required="true" onkeypress="return hanyaAngka(event)">
            <p id="notif"></p>
          </div>

          <div class="form-group">
            <label for="ukuran" class="col-form-label">Ukuran</label>
            <input type="text" name="ukuranpo" id="ukuranpo" class="form-control" placeholder="Ukuran" required="true">
          </div>

          <div class="form-group">
            <label for="no_faktur" class="col-form-label">Warna</label>
            <input type="text" name="warnapo" id="warnapo" class="form-control" placeholder="Warna" required="true">
          </div>

          <div class="form-group">
            <label for="tanggal_keluar" class="col-form-label">Tanggal PO</label>
            <input type="text" name="tanggalpo" id="tanggalpo" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="21-08-2021" required="true" readonly>
          </div>

          <div class="form-group">
            <label for="Keterangan" class="col-form-label">Keterangan</label>
            <textarea class="form-control" id="keteranganpo" name="keteranganpo" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Pop Up Create PO -->

<!--Modal List PO-->
<div class="modal fade" id="ModalListBarang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
        <h4 class="modal-title" id="myModalLabel">List No Po</h4>
      </div>

      <div class="box-body">
        <table id="table-barang-po" class="table table-bordered table-striped display">
          <thead>
            <tr>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Nama Brand</th>
              <th>Deskripsi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!--EndModal List PO-->

<!-- Pop Up Delete PO -->
<div class="modal fade" id="ModalHapusPo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        <h4 class="modal-title" id="myModalLabel">Hapus PO</h4>
      </div>
      <form class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="kodepo" id="textkodepo" value="">
          <div class="alert alert-warning">
            <p>Apakah Anda yakin mau memhapus Po ini?</p>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button class="btn_hapus btn btn-danger" id="btn_hapus_po">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Pop Up Delete -->



<!-- MODAL ADD -->
<div class="modal fade" id="ModalaAddPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <form>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
          <h3 class="modal-title font-weight-bold">Tambah Penjualan</h3>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="kobar" class="col-form-label">Kode Barang</label>
            <input type="text" id="kobar" name="kobar" class="form-control" placeholder="Kode Barang" required="true">
          </div>

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
            <label class="control-label">Lantai</label>
            <select id="id_lantai" name="id_lantai" class="form-control">
              <option value="">-Pilih-</option>
              <?php foreach ($lantai as $data) : ?>
                <option value="<?php echo $data->id_lantai; ?>"><?php echo $data->nama_lantai; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="desc" class="col-form-label">Deskripsi</label>
            <textarea class="form-control" id="desc" name="desc" rows="5" placeholder="Keterangan ..."></textarea>
          </div>

          <div class="form-group">
            <label for="harga_barang" class="col-form-label">Harga Barang</label>
            <input type="number" id="harga_barang" name="harga_barang" class="form-control" placeholder="" onkeyup="sum();" required>
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
<!-- MODAL ADD -->


<script type="text/javascript">
  $(document).ready(function() {
    get_code_barang();
    var alert = $('#alert').html('');

    var id_toko = $('#id_toko').val();
    var idRole = $('#idRole').val();
    var table = null;
    table = $('#table-barang').DataTable({
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
        "url": "<?php echo base_url('index.php/main/Bigmap/data_toko') ?>", // URL file untuk proses select datanya
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
          "data": "id_barang"
        },
        {
          "data": "nama_barang"
        }, // Tampilkan 
        {
          "data": "nama_brand"
        }, // Tampilkan 

        {
          "data": "deskripsi_barang"
        },
        // Tampilkan 
      ],
    });

    var table_po = null;
    table_po = $('#table-barang-po').DataTable({
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
        "url": "<?php echo base_url('index.php/main/Bigmap/data_toko') ?>", // URL file untuk proses select datanya
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
          "data": "id_barang"
        },
        {
          "data": "nama_barang"
        }, // Tampilkan 
        {
          "data": "harga_baru"
        }, // Tampilkan 
        {
          "data": "nama_brand"
        }, // Tampilkan 
        {
          "data": "deskripsi_barang"
        },
        // Tampilkan 
      ],
    });

    var table_list_po = null;
    table_list_po = $('#table_list_po').DataTable({
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
        "url": "<?php echo base_url('index.php/main/Bigmap/list_data_po_toko') ?>", // URL file untuk proses select datanya
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
          "data": "no_po"
        },
        {
          "data": "nama_sp"
        },
        {
          "data": "nama_sb"
        }, // Tampilkan 
        {
          "data": "tanggal_masuk"
        }, // Tampilkan 
        {
          "render": function(data, type, row) { // Tampilkan kolom aksi
            var html = '';
            if (idRole != 3) {
              html = '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus_po" data="' + row.no_po + '">Hapus</a>  '
            }
            return html
          }
        },

      ],
    });

    $('#table-barang tbody').on('click', 'tr', function() {
      var data = table.row(this).data();
      var id_barang = data.id_barang;
      $.ajax({
        success: function() {
          window.location.href = "<?php echo base_url('index.php/main/Bigmap/get_barang_detail/'); ?>" + data.id_barang;
        }
      });
    });

    $('#table_list_po tbody').on('click', 'tr', function() {
      var data = table_list_po.row(this).data();
      $.ajax({
        success: function() {
          window.location.href = "<?php echo base_url('index.php/main/Bigmap/get_po_detail/'); ?>" + data.no_po + '/' + id_toko;
        }
      });
    });

    $('#table-barang-po tbody').on('click', 'tr', function() {
      var data = table_po.row(this).data();
      var id_barang = data.id_barang;
      var nama_brand = data.nama_brand;
      var nama_barang = data.nama_barang;
      var hargapo = data.harga_baru;
      $.ajax({
        success: function() {
          $('#kode_brg').val(id_barang);
          $('#nama_brandpo').val(nama_brand);
          $('#hargapo').val(hargapo);
          $('#nama_barangpo').val(nama_barang);
          $('#ModalListBarang').hide();
        }
      });
    });

    var table_penjualan = null;
    table_penjualan = $('#table_penjualan').DataTable({
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
          "data": "no_po"
        },
        {
          "data": "ukuran"
        },
        {
          "data": "banyak"
        }, // Tampilkan 
        {
          "data": "tanggal_penjualan"
        }, // Tampilkan
        {
          "data": "tanggal_penjualan"
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
              html = '<a href="javascript:;" class="btn btn-danger btn-sm item_hapus_po" data="' + row.no_po + '">Hapus</a>  '
            }
            return html
          }
        },

      ],
    });


    //Simpan Barang
    $('#btn_simpan').on('click', function() {
      var kobar = $('#kobar').val();
      var id_brand = $('#id_brand').val();
      var nama_barang = $('#nama_barang').val();
      var id_lantai = $('#id_lantai').val();
      var id_toko = $('#id_toko').val();
      var desc = $('#desc').val();
      var harga_barang = $('#harga_barang').val();
      var nama_barang = $('#nama_barang').val();

      if (kobar == '' || nama_barang == '' || id_lantai == '' || id_toko == '') {

      } else {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('index.php/main/Bigmap/simpan_barang') ?>",
          dataType: "JSON",
          data: {
            kobar: kobar,
            id_brand: id_brand,
            nama_barang: nama_barang,
            id_lantai: id_lantai,
            id_toko: id_toko,
            desc: desc,
            harga_barang: harga_barang
          },

          success: function(data) {
            $('[name="kobar"]').val("");
            $('[name="nama_barang"]').val("");
            $('[name="id_lantai"]').val("");
            $('[name="id_toko"]').val("");
            $('[name="desc"]').val("");
            $('#ModalaAdd').modal('hide');
            $('#alert').html('');
            $('#alert').append(` <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <i class="icon fa fa-check"></i>
                  <?php echo 'Data Berhasil Tersimpan' ?>
                  </div>`);
            table.ajax.reload();
            table_po.ajax.reload();
            get_code_barang();
          }
        });
        return false;
      }
    });

    //GET HAPUS
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
          $('#alert').html('');
          $('#alert').append(` <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i>
                <?php echo 'Data Berhasil Di Hapus' ?>
                </div>`);
          table.ajax.reload();
        }
      });
      return false;
    });

    //GET DISKON
    $('#show_data').on('click', '.item_diskon', function(e) {
      var id = $(this).attr('data');
      e.stopPropagation();
      $('#ModalDiskon').modal('show');
      $('[name="kode"]').val(id);
    });

    //GET DISKON
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
          $.each(data, function(id_barang, id_brand, id_toko, id_lantai, nama_barang, deskripsi_barang, harga_barang, harga_akhir, diskon1, diskon2, diskon2, cashback) {
            $('#ModalDiskon').modal('show');
            $('[name="kobar_edit"]').val(data.id_barang);
            $('[name="id_brand_edit"]').val(data.id_brand);
            $('[name="id_lantai_edit"]').val(data.id_lantai);
            $('[name="nama_barang_edit"]').val(data.nama_barang);
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
          $.each(data, function(id_barang, id_brand, id_toko, id_lantai, nama_barang, deskripsi_barang, harga_barang, harga_akhir, diskon1, diskon2, diskon2, cashback) {
            $('#ModalaEdit').modal('show');
            $('[name="kobar_edit"]').val(data.id_barang);
            $('[name="id_brand_edit"]').val(data.id_brand);
            $('[name="id_lantai_edit"]').val(data.id_lantai);
            $('[name="nama_barang_edit"]').val(data.nama_barang);
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

    //Update 
    $('#btn_update').on('click', function() {
      var idBrarang = $('#kobar_edit').val()
      var nabrand = $('#id_brand_edit').val();
      var nalantai = $('#id_lantai_edit').val();
      var nabar = $('#nama_barang_edit').val();
      var desc = $('#desc_edit').val();
      var harga_barang_edit = $('#harga_barang_edit').val();
      // var id_diskon_edit = $("input[name^='id_diskon_edit']").map(function (idx, ele) {
      // return $(ele).val();
      // }).get();

      // var persentase_edit = $("input[name^='persentase_edit']").map(function(idx, ele) {
      //   return $(ele).val();
      // }).get();

      // var cashback_edit = $('#cashback_edit').val();
      // var harga_akhir_edit = $('#harga_akhir_edit').val();

      if (idBrarang == '' || nabrand == '' || nalantai == '' || nabar == '') {

      } else {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('index.php/main/Bigmap/updateBarang') ?>",
          dataType: "JSON",
          data: {
            idBrarang: idBrarang,
            nabrand: nabrand,
            nalantai: nalantai,
            nabar: nabar,
            desc: desc,
            harga_barang_edit: harga_barang_edit
            // id_diskon_edit:id_diskon_edit,
            // persentase_edit: persentase_edit,
            // cashback_edit: cashback_edit,
            // harga_akhir_edit: harga_akhir_edit
          },
          success: function(data) {
            $('[name="kobar_edit"]').val("");
            $('[name="nama_barang_edit"]').val("");
            $('[name="id_lantai_edit"]').val("");
            $('[name="id_toko_edit"]').val("");
            $('[name="desc_edit"]').val("");
            $('#ModalaEdit').modal('hide');
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
      }
    });

    $('#btn_diskon').on('click', function() {
      var idBrarang = $('#kobar_edit').val()
      // var hargaBarang = $('#harga_barang_edit').val()
      // var hargaAkhir = $('#grand_total').val()
      // var nabrand = $('#id_brand_edit').val();
      // var nalantai = $('#id_lantai_edit').val();
      // var nabar = $('#nama_barang_edit').val();
      // var desc = $('#desc_edit').val();
      // var harga_barang_edit = $('#harga_barang_edit').val();
      // var id_diskon_edit = $("input[name^='id_diskon_edit']").map(function (idx, ele) {
      // return $(ele).val();
      // }).get();

      var persentase_edit = $("input[name^='persentase_edit']").map(function(idx, ele) {
        return $(ele).val();
      }).get();

      // var cashback_edit = $('#cashback_edit').val();
      // var harga_akhir_edit = $('#harga_akhir_edit').val();


      $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/main/Bigmap/updateDiskon') ?>",
        dataType: "JSON",
        data: {
          idBrarang: idBrarang,
          // hargaBarang: hargaBarang,
          // hargaAkhir: hargaAkhir,

          persentase_edit: persentase_edit,

        },
        success: function(data) {
          $('[name="kobar_edit"]').val("");

          $('#ModalDiskon').modal('hide');
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
          $('[name="kobar_edit"]').val("");

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

    //GET HAPUS PO
    $('#show_data_po').on('click', '.item_hapus_po', function(e) {
      var id = $(this).attr('data');
      e.stopPropagation();
      $('#ModalHapusPo').modal('show');
      $('[name="kodepo"]').val(id);
    });

    //Hapus Barang
    $('#btn_hapus_po').on('click', function() {
      var kode = $('#textkodepo').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/main/Bigmap/nonAktifPo') ?>",
        dataType: "JSON",
        data: {
          kode: kode
        },
        success: function(data) {
          $("#detail_barang").load(" #detail_barang > *");
          $('#ModalHapusPo').modal('hide');
          $('#alert').html('');

          $('#alert').append(` <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i>
                <?php echo 'Data Berhasil Dihapus!' ?>
                </div>`);
          table.ajax.reload();
          table_po.ajax.reload();
          table_list_po.ajax.reload();
        }
      });
      return false;
    });

    function get_code_barang() {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/main/Bigmap/get_code_barang') ?>",
        dataType: "JSON",
        success: function(data) {

          console.log(data)
        }
      });
    }

    //Hide and Show BOX
    $('#box-po').hide();
    $('#btn-box-po').on('click', function() {
      $('#box-po').show();
      $('#box-barang').hide();
    });
    var idaad = $('#id_add').val();
    console.log(idaad);
    if (idaad === '1') {
      $('#box-po').show();
      $('#box-barang').hide();
    }

    $("#sp").change(function() {
      console.log($("#sp option:selected").val());
      if ($("#sp option:selected").val() == 'manual') {
        $('#manual_sp').prop('hidden', false);
      } else {
        $('#manual_sp').prop('hidden', 'true');
      }
    });

    $("#sb").change(function() {
      console.log($("#sb option:selected").val());
      if ($("#sb option:selected").val() == 'manual') {
        $('#manual_sb').prop('hidden', false);
      } else {
        $('#manual_sb').prop('hidden', 'true');
      }
    });
    $('#btnPenjualan').click(function() {

    });

  });
</script>

<!-- <script type="text/javascript">
  function ShowHideDiv(btnDisc) {
    var show = document.getElementById("show");
    show.style.display = btnDisc.value == "Tambah" ? "block" : "none";
  }

  $("#csbk").change(function() {
    console.log($("#sp option:selected").val());
    if ($("#csbk option:selected").val() == 'show') {
      $('#cashback').prop('hidden', false);
    } else {
      $('#cashback').prop('hidden', 'true');
    }
  });
</script>

<script>
  document.getElementById("persentase1").onclick = function() {
    var form = document.getElementById("show");
    var input = document.createElement("input");
    input.type = "text";
    var br = document.createElement("br");
    form.appendChild(input);
    form.appendChild(br);
  }
</script> -->

<script>
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>