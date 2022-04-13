<!DOCTYPE html>
<html>

<head>
    <title>Cetak PDF</title>

    <link href="<?php echo base_url('assets/vendor/bootstrap-4.6.0-dist/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <h6 class="text-center"><b>Access Toko dan Lantai</b></h6>
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Kode Toko</th>
                <th style="text-align: center;">Nama Toko</th>
                <th style="text-align: center;">Kode Lantai</th>
                <th style="text-align: center;">Nama Lantai</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($tbl_access2 as $r) :
            ?>
                <tr>
                    <th style="text-align: center;"><?php echo $no++; ?></th>
                    <th style="text-align: center;"><?php echo $r->id_toko; ?></th>
                    <th style="text-align: center;"><?php echo $r->nama_toko; ?></th>
                    <th style="text-align: center;">
                        <?php foreach ($tbl_access as $s) : ?>
                            <?php if($r->id_toko == $s->id_toko):?> 
                                <?php echo $s->id_lantai; ?> <br>
                            <?php endif?>
                        <?php endforeach; ?>
                    </th>
                    <th style="text-align: center;">
                        <?php foreach ($tbl_access as $s) : ?>
                            <?php if($r->id_toko == $s->id_toko):?> 
                                <?php echo $s->nama_lantai; ?> <br>
                            <?php endif?>
                        <?php endforeach; ?>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>