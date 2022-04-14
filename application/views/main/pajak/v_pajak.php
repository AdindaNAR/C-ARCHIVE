<?php $this->load->view('layout/v_header'); ?>
<?php $this->load->view('layout/v_topbar'); ?>
<?php $this->load->view('layout/v_sidebar'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Daftar Pajak
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('main/Dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pajak</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
        	<div class="col-xs-12">
        		<?php if (($this->session->flashdata('create')) or ($this->session->flashdata('update')) or ($this->session->flashdata('delete'))) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo $this->session->flashdata('create'); ?>
                        <?php echo $this->session->flashdata('update'); ?>
                        <?php echo $this->session->flashdata('delete'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('msguniq')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-times"></i>
                        <?php echo $this->session->flashdata('msguniq'); ?>
                    </div>
                <?php endif ?>
        	</div>

        	<div class="col-md-6">        		
                <div class="box" id="detail_barang">
                    <div class="box-body">
                        <?php foreach ($tbl_wajib_pajak as $a) : ?>
                            <table class="table table-condensed">
                                <tr>
                                    <th style="width: 50px">Nama</th>
                                    <th style="width: 25px">:</th>
                                    <th><?php echo $a->nama_wajib_pajak; ?></th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th><?php echo $a->alamat; ?></th>
                                </tr>   
	                                <tr>
                                	<?php if ($this->session->userdata('id_role') != 3): ?>                             
	                                    <td>
	                                        <a class="btn btn-warning btn-sm" title="Ubah Detail" data-toggle="modal" data-target="#ModalaEditWajibPajak<?php echo $a->id_wajib_pajak; ?>" data-backdrop="static"><span class="fa fa-pencil"></span>&nbsp; Edit</a>
	                                    </td>
                                	<?php endif ?>
	                                    <td></td>
	                                    <td></td>
	                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="box box-primary">
                	<?php if ($this->session->userdata('id_role') != 3): ?>
	                    <div class="box-header">
	                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
	                    </div>
                    <?php endif ?>

                    <div class="box-body">
                        <div class="table-responsive">
                            <div class="container-fluid">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="text-align: center;" rowspan="4">No</th>
                                            <th style="text-align: center;" colspan="12">BUMI</th>
                                            <th style="text-align: center;" colspan="4" rowspan="2">BANGUNAN</th>
                                            <th style="text-align: center;" rowspan="4">MUTASI</th>
                                            <?php if ($this->session->userdata('id_role') != 3): ?>
                                            	<th style="text-align: center;" rowspan="4">Opsi</th>
                                            <?php endif ?>
                                        </tr>
                                        <tr class="text-center">
                                            <th style="text-align: center;" colspan="7">SAWAH</th>
                                            <th style="text-align: center;" colspan="5">DARAT</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th style="text-align: center;" rowspan="2">ID Pajak</th>
                                            <th style="text-align: center;" rowspan="2">ID Wajib Pajak</th>
                                            <th style="text-align: center;" rowspan="2">No. Persil dan Bag. Persil</th>
                                            <th style="text-align: center;" colspan="2">Kelas</th>
                                            <th style="text-align: center;" rowspan="2">Luas(m2)</th>
                                            <th style="text-align: center;" rowspan="2">Pajak (Rp)</th>
                                            <th style="text-align: center;" rowspan="2">No. Persil dan Bag. Persil</th>
                                            <th style="text-align: center;" colspan="2">Kelas</th>
                                            <th style="text-align: center;" rowspan="2">Luas(m2)</th>
                                            <th style="text-align: center;" rowspan="2">Pajak (Rp)</th>
                                            <th style="text-align: center;" rowspan="2">Dipersil & Bagian Persil Nomor</th>
                                            <th style="text-align: center;" rowspan="2">Gol/Kelas</th>
                                            <th style="text-align: center;" rowspan="2">Luas(m2)</th>
                                            <th style="text-align: center;" rowspan="2">Pajak</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th style="text-align: center;">Desa</th>
                                            <th style="text-align: center;">Nasional</th>
                                            <th style="text-align: center;">Desa</th>
                                            <th style="text-align: center;">Nasional</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($tbl_pajak as $r) :
                                        ?>
                                            <tr>
                                                <th style="text-align: center;" width="50px"><?php echo $no++; ?></th>
                                                <th style="text-align: center;"><?php echo $r->id_pajak; ?></th>
                                                <th style="text-align: center;"><?php echo $r->id_wajib_pajak; ?></th>
                                                <th style="text-align: center;"><?php echo $r->npbp_swh_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->kls_desa_swh_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->kls_nasional_swh_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->luas_swh_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->pajak_swh_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->npbp_drt_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->kls_desa_drt_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->kls_nasional_drt_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->luas_drt_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->pajak_drt_bumi; ?></th>
                                                <th style="text-align: center;"><?php echo $r->dbpn_bgn; ?></th>
                                                <th style="text-align: center;"><?php echo $r->gol_kelas_bgn; ?></th>
                                                <th style="text-align: center;"><?php echo $r->luas_bgn; ?></th>
                                                <th style="text-align: center;"><?php echo $r->pajak_bgn; ?></th>
                                                <th style="text-align: center;"><?php echo $r->mutasi; ?></th>
                                                <?php if ($this->session->userdata('id_role') != 3): ?>
	                                                <th style="text-align: center;" width="250px">
		                                                    <a href="" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#update<?php echo $r->id_pajak; ?>"><i class="fa fa-edit"></i>&nbsp; Update</a>
		                                                    <a href="<?php echo base_url('main/Pajak/delete_pajak/' . $r->id_pajak); ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i>&nbsp; Delete</a>
	                                                </th>
	                                            <?php endif ?>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <form method="post" action="<?php echo base_url('main/Pajak/create_pajak'); ?>">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h3 class="modal-title font-weight-bold">Tambah <?php echo $title ?></h3>
                </div>
                <div class="modal-body">
                	<div class="container-fluid">
    					<div class="row">
		                    <input type="hidden" id="id_pajak" name="id_pajak" value="<?php echo $code ?>">
		                    <input type="hidden" id="id_wajib_pajak" name="id_wajib_pajak" value="<?php echo $this->uri->segment(4); ?>">
		                    
	                   		<center><p><b>BUMI</b></p></center>	
		                   	<div class="col-md-6"> 
		                   		<center><p><b>SAWAH</b></p></center>
			                    <div class="form-group">
			                        <label for="npbp_swh_bumi" class="col-form-label">No. Persil dan Bag. Persil</label>
			                        <input type="text" id="npbp_swh_bumi" name="npbp_swh_bumi" class="form-control">
			                    </div>

			                    <div class="row">	
			                    	<center><p><b>KELAS</b></p></center>
			                    	<div class="col-md-6">
					                    <div class="form-group">
					                        <label for="kls_desa_swh_bumi" class="col-form-label">Desa</label>
					                        <input type="text" id="kls_desa_swh_bumi" name="kls_desa_swh_bumi" class="form-control">
					                    </div>
				                	</div>

				                	<div class="col-md-6">
					                    <div class="form-group">
					                        <label for="kls_nasional_swh_bumi" class="col-form-label">Nasional</label>
					                        <input type="text" id="kls_nasional_swh_bumi" name="kls_nasional_swh_bumi" class="form-control">
					                    </div>
					                </div>
			                    </div>

			                    <div class="form-group">
			                        <label for="luas_swh_bumi" class="col-form-label">Luas(m2)</label>
			                        <input type="text" id="luas_swh_bumi" name="luas_swh_bumi" class="form-control">
			                    </div>

			                    <div class="form-group">
			                        <label for="pajak_swh_bumi" class="col-form-label">Pajak (Rp)</label>
			                        <input type="text" id="pajak_swh_bumi" name="pajak_swh_bumi" class="form-control">
			                    </div>
			                </div>

			                <div class="col-md-6">
			                	<center><p><b>DARAT</b></p></center>
			                    <div class="form-group">
			                        <label for="npbp_drt_bumi" class="col-form-label">No. Persil dan Bag. Persil</label>
			                        <input type="text" id="npbp_drt_bumi" name="npbp_drt_bumi" class="form-control">
			                    </div>

			                    <div class="row">	
			                    	<center><p><b>KELAS</b></p></center>
			                    	<div class="col-md-6">
					                    <div class="form-group">
					                        <label for="kls_desa_drt_bumi" class="col-form-label">Desa</label>
					                        <input type="text" id="kls_desa_drt_bumi" name="kls_desa_drt_bumi" class="form-control">
					                    </div>
				                	</div>

				                	<div class="col-md-6">
					                    <div class="form-group">
					                        <label for="kls_nasional_drt_bumi" class="col-form-label">Nasional</label>
					                        <input type="text" id="kls_nasional_drt_bumi" name="kls_nasional_drt_bumi" class="form-control">
					                    </div>
					                </div>
			                    </div>

			                    <div class="form-group">
			                        <label for="luas_drt_bumi" class="col-form-label">Luas(m2)</label>
			                        <input type="text" id="luas_drt_bumi" name="luas_drt_bumi" class="form-control">
			                    </div>

			                    <div class="form-group">
			                        <label for="pajak_drt_bumi" class="col-form-label">Pajak (Rp)</label>
			                        <input type="text" id="pajak_drt_bumi" name="pajak_drt_bumi" class="form-control">
			                    </div>
			                </div>

		                </div>

		                <br>
		                	<center><p><b>BANGUNAN</b></p></center>
		                    <div class="form-group">
		                        <label for="dbpn_bgn" class="col-form-label">Dipersil & Bagian Persil Nomor</label>
		                        <input type="text" id="dbpn_bgn" name="dbpn_bgn" class="form-control">
		                    </div>

		                    <div class="form-group">
		                        <label for="gol_kelas_bgn" class="col-form-label">Gol/Kel</label>
		                        <input type="text" id="gol_kelas_bgn" name="gol_kelas_bgn" class="form-control">
		                    </div>

		                    <div class="form-group">
		                        <label for="luas_bgn" class="col-form-label">Luas(m2)</label>
		                        <input type="text" id="luas_bgn" name="luas_bgn" class="form-control">
		                    </div>

		                    <div class="form-group">
		                        <label for="pajak_bgn" class="col-form-label">Pajak</label>
		                        <input type="text" id="pajak_bgn" name="pajak_bgn" class="form-control">
		                    </div>

		                    <br>
		                    <div class="form-group">
		                        <label for="mutasi" class="col-form-label">Mutasi</label>
		                        <input type="text" id="mutasi" name="mutasi" class="form-control">
		                    </div>

		            </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End of Modal Create -->

<!-- Modal Update -->
<?php foreach ($tbl_pajak as $r) : ?>
    <div class="modal fade" id="update<?php echo $r->id_pajak; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form method="post" action="<?php echo base_url('main/Pajak/update_pajak'); ?>">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                        <h3 class="modal-title font-weight-bold">Edit <?php echo $title ?></h3>
                    </div>
                    
                    <div class="modal-body">
	                	<div class="container-fluid">
	    					<div class="row">
			                    <input type="hidden" id="id_pajak" name="id_pajak" value="<?php echo $r->id_pajak ?>">
			                    <input type="hidden" id="id_wajib_pajak" name="id_wajib_pajak" value="<?php echo $r->id_wajib_pajak ?>">
			                    
		                   		<center><p><b>BUMI</b></p></center>	
			                   	<div class="col-md-6"> 
			                   		<center><p><b>SAWAH</b></p></center>
				                    <div class="form-group">
				                        <label for="npbp_swh_bumi" class="col-form-label">No. Persil dan Bag. Persil</label>
				                        <input type="text" id="npbp_swh_bumi" name="npbp_swh_bumi" value="<?php echo $r->npbp_swh_bumi ?>" class="form-control">
				                    </div>

				                    <div class="row">	
				                    	<center><p><b>KELAS</b></p></center>
				                    	<div class="col-md-6">
						                    <div class="form-group">
						                        <label for="kls_desa_swh_bumi" class="col-form-label">Desa</label>
						                        <input type="text" id="kls_desa_swh_bumi" name="kls_desa_swh_bumi" value="<?php echo $r->kls_desa_swh_bumi ?>" class="form-control">
						                    </div>
					                	</div>

					                	<div class="col-md-6">
						                    <div class="form-group">
						                        <label for="kls_nasional_swh_bumi" class="col-form-label">Nasional</label>
						                        <input type="text" id="kls_nasional_swh_bumi" name="kls_nasional_swh_bumi" value="<?php echo $r->kls_nasional_swh_bumi ?>" class="form-control">
						                    </div>
						                </div>
				                    </div>

				                    <div class="form-group">
				                        <label for="luas_swh_bumi" class="col-form-label">Luas(m2)</label>
				                        <input type="text" id="luas_swh_bumi" name="luas_swh_bumi" value="<?php echo $r->luas_swh_bumi ?>" class="form-control">
				                    </div>

				                    <div class="form-group">
				                        <label for="pajak_swh_bumi" class="col-form-label">Pajak (Rp)</label>
				                        <input type="text" id="pajak_swh_bumi" name="pajak_swh_bumi" value="<?php echo $r->pajak_swh_bumi ?>" class="form-control">
				                    </div>
				                </div>

				                <div class="col-md-6">
				                	<center><p><b>DARAT</b></p></center>
				                    <div class="form-group">
				                        <label for="npbp_drt_bumi" class="col-form-label">No. Persil dan Bag. Persil</label>
				                        <input type="text" id="npbp_drt_bumi" name="npbp_drt_bumi" value="<?php echo $r->npbp_drt_bumi ?>" class="form-control">
				                    </div>

				                    <div class="row">	
				                    	<center><p><b>KELAS</b></p></center>
				                    	<div class="col-md-6">
						                    <div class="form-group">
						                        <label for="kls_desa_drt_bumi" class="col-form-label">Desa</label>
						                        <input type="text" id="kls_desa_drt_bumi" name="kls_desa_drt_bumi" value="<?php echo $r->kls_desa_drt_bumi ?>" class="form-control">
						                    </div>
					                	</div>

					                	<div class="col-md-6">
						                    <div class="form-group">
						                        <label for="kls_nasional_drt_bumi" class="col-form-label">Nasional</label>
						                        <input type="text" id="kls_nasional_drt_bumi" name="kls_nasional_drt_bumi" value="<?php echo $r->kls_nasional_drt_bumi ?>" class="form-control">
						                    </div>
						                </div>
				                    </div>

				                    <div class="form-group">
				                        <label for="luas_drt_bumi" class="col-form-label">Luas(m2)</label>
				                        <input type="text" id="luas_drt_bumi" name="luas_drt_bumi" value="<?php echo $r->luas_drt_bumi ?>" class="form-control">
				                    </div>

				                    <div class="form-group">
				                        <label for="pajak_drt_bumi" class="col-form-label">Pajak (Rp)</label>
				                        <input type="text" id="pajak_drt_bumi" name="pajak_drt_bumi" value="<?php echo $r->pajak_drt_bumi ?>" class="form-control">
				                    </div>
				                </div>

			                </div>
			                
			                <br>
			                	<center><p><b>BANGUNAN</b></p></center>
			                    <div class="form-group">
			                        <label for="dbpn_bgn" class="col-form-label">Dipersil & Bagian Persil Nomor</label>
			                        <input type="text" id="dbpn_bgn" name="dbpn_bgn" value="<?php echo $r->dbpn_bgn ?>" class="form-control">
			                    </div>

			                    <div class="form-group">
			                        <label for="gol_kelas_bgn" class="col-form-label">Gol/Kel</label>
			                        <input type="text" id="gol_kelas_bgn" name="gol_kelas_bgn" value="<?php echo $r->gol_kelas_bgn ?>" class="form-control">
			                    </div>

			                    <div class="form-group">
			                        <label for="luas_bgn" class="col-form-label">Luas(m2)</label>
			                        <input type="text" id="luas_bgn" name="luas_bgn" value="<?php echo $r->luas_bgn ?>" class="form-control">
			                    </div>

			                    <div class="form-group">
			                        <label for="pajak_bgn" class="col-form-label">Pajak</label>
			                        <input type="text" id="pajak_bgn" name="pajak_bgn" value="<?php echo $r->pajak_bgn ?>" class="form-control">
			                    </div>

			                    <br>
			                    <div class="form-group">
			                        <label for="mutasi" class="col-form-label">Mutasi</label>
			                        <input type="text" id="mutasi" name="mutasi" value="<?php echo $r->mutasi ?>" class="form-control">
			                    </div>

			            </div>
	                    
	                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<!-- Modal Update Wajib pajak -->
<?php foreach ($tbl_wajib_pajak as $u) : ?>
    <div class="modal fade" id="ModalaEditWajibPajak<?php echo $u->id_wajib_pajak; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form method="post" action="<?php echo base_url('main/Pajak/update_wajib_pajak'); ?>">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                        <h3 class="modal-title font-weight-bold">Edit Wajib Pajak</h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_wajib_pajak" name="id_wajib_pajak" value="<?php echo $u->id_wajib_pajak ?>">
                        <div class="form-group">
                            <label for="nama_wajib_pajak" class="col-form-label">Nama</label>
                            <input type="text" id="nama_wajib_pajak" name="nama_wajib_pajak" class="form-control" placeholder="Example : Suherman" value="<?php echo $u->nama_wajib_pajak ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-form-label">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Example : Rajapolah" value="<?php echo $u->alamat ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<?php $this->load->view('layout/v_footer'); ?>