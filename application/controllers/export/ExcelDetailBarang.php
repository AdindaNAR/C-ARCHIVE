<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExcelDetailBarang extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();

        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index()
    {
		$id_barang = $this->input->post('id_barang');
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');

		$tbl_detail_barang = $this->DataModels->filter_detail($search=null, $limit=null, $start=null, $order_field=null, $order_ascdesc=null, $id_toko=null, $id_lantai=null, $id_barang , $bulan, $tahun);
		
		include_once APPPATH . '/third_party/xlsxwriter.class.php';
		ini_set('display_errors', 0);
		ini_set('log_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);

		$title = 'Laporan Data Barang ' . ' - ' . $tbl_detail_barang[0]['nama_toko'] . ' - ' .$tbl_detail_barang[0]['nama_barang'] . ' - ' .bulan($tbl_detail_barang[0]['bulan']) .' - '.$tbl_detail_barang[0]['tahun']. '.xlsx';
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($title) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$styles = array('widths' => [20, 20, 10, 20, 50], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');
		$styles_detail_barang = array('widths' => [10, 10, 10, 25, 25, 10, 30], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');
		
		$title = array(
			'Nama Barang' => 'string',
			'Nama Brand' => 'string',
			'Lantai' => 'string',
			'Nama Toko' => 'string',
			'Deskripsi Barang' => 'string'
		);

		$title_detail_barang = array(
			'Nomor PO' => 'Nomor PO',
			'Ukuran' => 'Ukuran',
			'Banyak' => 'Banyak',
			'Tanggal Masuk' => 'Tanggal Masuk',
			'Yang Sudah Terjual' => 'Yang Sudah Terjual'
		);

		$g = array(
			'' => '',
		);

		$writer = new XLSXWriter();
		$writer->setAuthor('MKI');

		$writer->writeSheetHeader('Sheet1', $title, $styles);
		foreach ($tbl_detail_barang as $row) {
			$writer->writeSheetRow('Sheet1', [$row['nama_barang'], $row['nama_brand'], $row['nama_lantai'], $row['nama_toko'], $row['deskripsi_barang']]);
			$no++;
		}
		$writer->writeSheetRow('Sheet1', $g); 
		$writer->writeSheetRow('Sheet1', $title_detail_barang, $styles_detail_barang);
		foreach ($tbl_detail_barang as $row) {
			$writer->writeSheetRow('Sheet1', [$row['no_po'], $row['ukuran'], $row['stock_quantity'], $row['tanggal_masuk'], $row['stock_sold']]);
			$no++;
		}
		$writer->writeToStdOut();
    }
}