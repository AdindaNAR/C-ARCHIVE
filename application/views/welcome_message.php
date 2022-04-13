
<!-- Left side column. contains the logo and sidebar -->
<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

</section>

<section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

          <p>
            .
           Halaman atau url yang anda tuju Salah! <a href="<?php echo base_url('main/Bigmap');?>">Kembali ke dashboard</a>
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('layout/v_footer'); ?>




<!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
     
 </div>



</body>
</html>
