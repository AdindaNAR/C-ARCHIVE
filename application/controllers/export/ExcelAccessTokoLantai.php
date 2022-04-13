<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExcelAccessTokoLantai extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();

        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index()
    {
		$where_access = array('tbl_access_toko_lantai.data_status' => '1');

		$tbl_access_toko_lantai = $this->DataModels->get_where_toko_lantai($where_access, 'tbl_access_toko_lantai');

		include_once APPPATH . '/third_party/xlsxwriter.class.php';
		ini_set('display_errors', 0);
		ini_set('log_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);

		$title = 'FORMAT ACCESS LANTAI DAN TOKO ' . '.xlsx';
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($title) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$styles = array('widths' => [15, 20, 15, 20], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');
		
		$title = array(
			'ID Toko' => 'string',
			'Nama Toko' => 'string',
			'ID Lantai' => 'string',
			'Nama Lantai' => 'string'
		);

		$writer = new XLSXWriter();
		$writer->setAuthor('MKI');

		$writer->writeSheetHeader('Sheet1', $title, $styles);
		foreach ($tbl_access_toko_lantai as $row) {
			$writer->writeSheetRow('Sheet1', [$row['id_toko'], $row['nama_toko'], $row['id_lantai'], $row['nama_lantai']]);
			$no++;
		}
		$writer->writeToStdOut();
    }
}