<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExcelBrand extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('DataModels');

		is_logged_in();
	}

	public function index()
	{
		$tbl_brand = $this->DataModels->get_where_brand();

		include_once APPPATH . '/third_party/xlsxwriter.class.php';
		ini_set('display_errors', 0);
		ini_set('log_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);

		$title = 'FORMAT BRAND' . '.xlsx';
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($title) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$styles = array('widths' => [15, 20], 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'border' => 'left,right,top,bottom');

		$title = array(
			'ID Brand' => 'string',
			'Nama Brand' => 'string'
		);

		$writer = new XLSXWriter();
		$writer->setAuthor('MKI');

		$writer->writeSheetHeader('Sheet1', $title, $styles);
		foreach ($tbl_brand as $row) {
			$writer->writeSheetRow('Sheet1', [$row['id_brand'], $row['nama_brand']]);
		}


		$writer->writeToStdOut();
	}
}
