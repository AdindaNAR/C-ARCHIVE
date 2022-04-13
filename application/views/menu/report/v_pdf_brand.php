<!DOCTYPE html>
<html>

<head>
    <title>Cetak PDF</title>

    <link href="<?php echo base_url('assets/vendor/bootstrap-4.6.0-dist/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <h6 class="text-center"><b>Brand</b></h6>
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">ID Brand</th>
                <th style="text-align: center;">Nama Brand</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($tbl_brand as $r) :
            ?>
                <tr>
                    <th style="text-align: center;"><?php echo $no++; ?></th>
                    <th style="text-align: center;"><?php echo $r->id_brand; ?></th>
                    <th style="text-align: center;"><?php echo $r->nama_brand; ?></th>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</body>

</html>