<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            $ceknamatoko = $this->db->get_where('tbl_toko', array('id_toko' => $this->uri->segment(4)))->row();
            ?>
            <?php echo $ceknamatoko->nama_toko; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url(''); ?>">Cek Barang</a></li>
            <li><a href="<?php echo base_url('main/Bigmap'); ?>">Toko</a></li>
            <li class="active"><?php echo $ceknamatoko->nama_toko; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box primary">
                    <div class="box-header">
                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#lantai"><span class="fa fa-plus"></span>&nbsp; Pilih Lantai</a>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="table-barang" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ID Barang</th>
                                    <th style="text-align: center;" id="clickable">Nama Barang</th>
                                    <th style="text-align: center;">Nama Brand</th>
                                    <th style="text-align: center;">Lantai</th>
                                    <th style="text-align: center;">Deskripsi</th>
                                    <th style="text-align: center;">Stok</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- get idTOko -->
<!-- end -->

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
                                    <a href="<?php echo base_url('menu/CheckBarang/lantai/' . $r->id_toko . '/' . $r->id_lantai); ?>" class="btn btn-primary btn-sm">Pilih</a>
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

<?php $this->load->view('layout/v_footer'); ?>

<input type="hidden" id="id_toko" value="<?php echo  $this->uri->segment(4); ?>">
<input type="hidden" id="idRole" value="<?php echo $this->session->userdata('id_role'); ?>">

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
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?php echo base_url('index.php/main/Bigmap/dataPenjualan3') ?>", // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                    id_toko: id_toko
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
                }, // Tampilkan 
                {
                    "data": "nama_brand"
                }, // Tampilkan 
                {
                    "data": "nama_lantai"
                }, // Tampilkan 
                {
                    "data": "deskripsi_barang"
                },
                {
                    "data": "stock_sold"
                },
            ],
        });

        $('#table-barang tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            var id_barang = data.id_barang;
            $.ajax({
                success: function() {
                    window.location.href = "" + data.id_toko + "/" + data.id_lantai + "/" + data.id_barang;
                }
            })
        });

        function get_code_barang() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/main/Bigmap/get_code_barang') ?>",
                dataType: "JSON",
                success: function(obj) {
                    $('#kobar').val(obj);
                }

            });
        }
    });
</script>