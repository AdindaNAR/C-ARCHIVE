<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PDFBrand extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index()
    {
        $where = array('data_status' => '1');

        $data['tbl_brand'] = $this->DataModels->get_where_table($where, 'tbl_brand');

        $this->load->library('pdfgenerator');

        $html = $this->load->view('menu/report/v_pdf_brand', $data, true);
        $filename = 'Kode Brand - ' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
    }
}
