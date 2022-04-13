<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExcelDetailStock extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('DataModels');

		is_logged_in();
	}

	public function index()
	{
		$no_po = $this->input->post('no_po');
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');

		$tbl_detail_stock = $this->DataModels->filter_po($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $no_po, $bulan = null, $tahun = null);

		include_once APPPATH . '/third_party/xlsxwriter.class.php';
		ini_set('display_errors', 0);
		ini_set('log_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);

		$title = 'LAPORAN DATA DETAIL STOCK ' . ' - ' . bulan($tbl_detail_stock[0]['bulan']) . ' - ' . $tbl_detail_stock[0]['tahun'] . '.xlsx';
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($title) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$styles = array('widths' => [20, 20, 20, 20, 20, 20, 25, 25], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');

		$title = array(
			'Kode Barang' => 'string',
			'Nama Barang' => 'string',
			'Banyak Barang' => 'string',
			'Ukuran' => 'string',
			'Warna' => 'warna',
			'Tanggal Masuk' => 'string',
			'Status Pengiriman' => 'string',
			'Status Barang' => 'string'
		);

		$writer = new XLSXWriter();
		$writer->setAuthor('MKI');

		$writer->writeSheetHeader('Sheet1', $title, $styles);
		foreach ($tbl_detail_stock as $row) {
			$writer->writeSheetRow('Sheet1', [$row['id'], $row['nama_barang'], $row['stock_quantity'], $row['ukuran'], $row['warna'], $row['tanggal_masuk'], $row['nama_sb'], $row['nama_sp']]);
			$no++;
		}
		$writer->writeToStdOut();
	}
}
