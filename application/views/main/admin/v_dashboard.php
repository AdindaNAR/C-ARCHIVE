<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <?php 
                        foreach($toko->result_array() as $row):
                        $totaltoko = $row['total_toko'];
                    ?>
                        <div class="inner">
                            <h3><?php echo htmlentities($totaltoko , ENT_QUOTES, 'UTF-8');?><sup style="font-size: 20px"></sup></h3>
                            <p>Toko</p>
                        </div>
                    <?php endforeach;?>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <?php 
                            foreach($brand->result_array() as $row):
                            $totalbrand = $row['total_brand'];
                        ?>
                            <h3><?php echo htmlentities($totalbrand , ENT_QUOTES, 'UTF-8');?></h3>
                            <p>Brand</p>
                        <?php endforeach;?>
                    </div>
                    <div class="icon">
                        <i class="ion-pricetag"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                         <?php 
                            foreach($lantai->result_array() as $row):
                            $totallantai = $row['total_lantai'];
                        ?>
                            <h3><?php echo htmlentities($totallantai , ENT_QUOTES, 'UTF-8');?></h3>
                            <p>Lantai</p>
                        <?php endforeach;?>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building-o"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <?php 
                        foreach($user->result_array() as $row):
                        $totaluser = $row['total_user'];
                    ?>
                        <div class="inner">
                            <h3><?php echo htmlentities($totaluser , ENT_QUOTES, 'UTF-8');?></h3>
                            <p>Pengguna</p>
                        </div>
                    <?php endforeach;?>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-cube"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Barang di Gudang</span>
                        <?php 
                            foreach($barang->result_array() as $row):
                            $totalbarang = $row['total_barang'];
                        ?>
                            <span class="info-box-number"><?php echo htmlentities($totalbarang , ENT_QUOTES, 'UTF-8');?> jenis</span>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        
            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-send"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Barang sedang PO</span>
                        <?php 
                            $totalbarang = 0;
                            foreach($detail_barang_by_jenis->result_array() as $row):
                            $totalbarang = ++$totalbarang;
                        ?>
                        <?php endforeach;?>
                        <span class="info-box-number"><?php echo htmlentities($totalbarang , ENT_QUOTES, 'UTF-8');?> jenis</span>
                        
                        <?php 
                            foreach($detail_barang_by_item->result_array() as $row):
                            $totaldetailbarang = $row['total_detail_barang'];
                        ?>
                            <span class="info-box-number"><?php echo htmlentities($totaldetailbarang , ENT_QUOTES, 'UTF-8');?> item</span>
                        <?php endforeach;?>

                        <?php 
                            foreach($detail_barang_by_jml->result_array() as $row):
                            $total_jmlbarangPO = $row['jml_barang_PO'];
                        ?>
                            <span class="info-box-number"><?php echo htmlentities($total_jmlbarangPO , ENT_QUOTES, 'UTF-8');?> unit</span>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>


            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-cubes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Barang di Toko</span>
                        <?php 
                            $totalbarangtoko = 0;
                            foreach($terima_toko_by_jenis->result_array() as $row):
                            $totalbarangtoko = ++$totalbarangtoko;
                        ?>
                        <?php endforeach;?>
                        <span class="info-box-number"><?php echo htmlentities($totalbarangtoko , ENT_QUOTES, 'UTF-8');?> jenis</span><span></span>

                        <?php 
                            $totaldetailbarangtoko = 0;
                            foreach($terima_toko_by_item->result_array() as $row):
                            $totaldetailbarangtoko = ++$totaldetailbarangtoko;
                        ?>
                        <?php endforeach;?>
                        <span class="info-box-number"><?php echo htmlentities($totaldetailbarangtoko , ENT_QUOTES, 'UTF-8');?> item</span>

                        <?php 
                            foreach($terima_toko_by_jml->result_array() as $row):
                            $totalstocktoko = $row['total_stock_toko'];
                        ?>
                            <span class="info-box-number"><?php echo htmlentities($totalstocktoko , ENT_QUOTES, 'UTF-8');?> unit</span>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Penjualan</span>
                        <?php 
                            $totalbarangpenjualan = 0;
                            foreach($penjualan_by_jenis->result_array() as $row):
                            $totalbarangpenjualan = ++$totalbarangpenjualan;
                        ?>
                        <?php endforeach;?>
                        <span class="info-box-number"><?php echo htmlentities($totalbarangpenjualan , ENT_QUOTES, 'UTF-8');?> jenis</span><span></span>

                        <?php 
                            $totaldetailbarangpenjualan = 0;
                            foreach($penjualan_by_item->result_array() as $row):
                            $totaldetailbarangpenjualan = ++$totaldetailbarangpenjualan;
                        ?>
                        <?php endforeach;?>
                        <span class="info-box-number"><?php echo htmlentities($totaldetailbarangpenjualan , ENT_QUOTES, 'UTF-8');?> item</span>

                        <?php 
                            foreach($penjualan_by_jml->result_array() as $row):
                            $totalpenjualan = $row['total_penjualan'];
                        ?>
                            <span class="info-box-number"><?php echo htmlentities($totalpenjualan , ENT_QUOTES, 'UTF-8');?> unit</span>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('layout/v_footer'); ?>