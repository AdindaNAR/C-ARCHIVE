<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExcelRiwayatStock extends CI_Controller
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

		$tbl_riwayat_stock = $this->DataModels->filter_penjualan2($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $no_po, $bulan = null, $tahun = null);

		include_once APPPATH . '/third_party/xlsxwriter.class.php';
		ini_set('display_errors', 0);
		ini_set('log_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);

		$title = 'LAPORAN DATA RIWAYAT STOCK ' . ' - ' . bulan($tbl_riwayat_stock[0]['bulan']) . ' - ' . $tbl_riwayat_stock[0]['tahun'] . '.xlsx';
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($title) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$styles = array('widths' => [20], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');

		$title = array(
			'Ukuran' => 'string',
			'Harga Awal/Jual' => 'string',
			'Harga Netto/Akhir' => 'string',
			'Margin' => 'string',
			'Banyak' => 'string',
			'Tanggal Masuk' => 'string',
			'Tanggal Keluar' => 'string',
			'No Faktur' => 'string',
			'Keterangan' => 'string'
		);

		$writer = new XLSXWriter();
		$writer->setAuthor('MKI');

		$writer->writeSheetHeader('Sheet1', $title, $styles);
		foreach ($tbl_riwayat_stock as $row) {
			$writer->writeSheetRow('Sheet1', [$row['ukuran'], $row['harga_baru'], $row['harga_akhir'], $row['margin'], $row['banyak'], $row['tanggal_masuk'], $row['tanggal_terima'], $row['no_po'], $row['keterangan']]);

			$no++;
		}
		$writer->writeToStdOut();
	}
}
