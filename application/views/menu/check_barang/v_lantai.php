<?php
    $id_toko = $this->uri->segment(4);
    $id_lantai = $this->uri->segment(5);
    $toko = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai JOIN tbl_toko c ON a.id_toko=c.id_toko  where a.id_toko = '$id_toko' AND a.id_lantai = '$id_lantai' AND a.data_status = '1' ")->result();
foreach($toko as $toko): ?>
<?php endforeach;?>

<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $toko->nama_toko;?>
            <small><?php echo $toko->nama_lantai;?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('main/Bigmap'); ?>">Big Map</a></li>
            <li><a href="<?php echo base_url('main/Bigmap/get_toko/').$id_toko; ?>"><?php echo $toko->nama_toko;?></a></li>
            <li class="active"><?php echo $toko->nama_lantai;?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">

                    </div>

                    <div class="box-body table-responsive">
                        <table id="table-barang" class="table table-bordered table-striped display">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Nama Brand</th>
                                    <th style="text-align: center;">Deskripsi</th> 
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

<?php $this->load->view('layout/v_footer'); ?>


<input type="hidden" id="id_toko" value="<?php echo  $this->uri->segment(4);?>">
<input type="hidden" id="id_lantai" value="<?php echo  $this->uri->segment(5);?>">

 <script type="text/javascript">
    $(document).ready(function(){
        var id_toko = $('#id_toko').val();
        var id_lantai = $('#id_lantai').val();
        var table = null;
            table = $('#table-barang').DataTable({
                "processing": true,
                "bInfo" : false,
                "serverSide": true,
                "ordering": true, // Set true agar bisa di sorting
                "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                "ajax":
                    {
                        "url": "<?php echo base_url('index.php/main/Bigmap/data_perlantai') ?>", // URL file untuk proses select datanya
                        "type": "POST",
                        "data" : {
                            id_toko : id_toko,
                            id_lantai : id_lantai
                        },
                    },
                "deferRender": true,
                "aLengthMenu": [[5, 10, 50],[ 5, 10, 50]], // Combobox Limit
                "columns": [
                    { "data": "nama_barang" }, // Tampilkan 
                    { "data": "nama_brand" },  // Tampilkan 
                    { "data": "deskripsi_barang" }, // Tampilkan 
                ],
            });
    });
</script>
