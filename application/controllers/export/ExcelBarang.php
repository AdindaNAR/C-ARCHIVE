<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExcelBarang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('DataModels');

		is_logged_in();
	}

	public function index()
	{
		$id_toko = $this->session->userdata('id_toko');
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');

		$tbl_barang = $this->DataModels->export_master_data($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null, $id_toko, $noPo = null, $nabar = null, $nabrand = null, $bulan, $tahun);

		include_once APPPATH . '/third_party/xlsxwriter.class.php';
		ini_set('display_errors', 0);
		ini_set('log_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);

		$title = 'LAPORAN DATA BARANG ' . ' - ' . bulan($tbl_barang[0]['bulan']) . ' - ' . $tbl_barang[0]['tahun'] . '.xlsx';
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($title) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$styles = array('widths' => [20, 20, 30, 50], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');

		$title = array(
			'Nama Barang' => 'string',
			'Nama Brand' => 'string',
			'Banyak Stock' => 'string',
			'Deskripsi Barang' => 'string'
		);

		$writer = new XLSXWriter();
		$writer->setAuthor('MKI');

		$writer->writeSheetHeader('Sheet1', $title, $styles);
		foreach ($tbl_barang as $row) {
			$writer->writeSheetRow('Sheet1', [$row['nama_barang'], $row['nama_brand'], $row['total_stock'], $row['deskripsi_barang']]);
			$no++;
		}

		$writer->writeToStdOut();
	}
}
