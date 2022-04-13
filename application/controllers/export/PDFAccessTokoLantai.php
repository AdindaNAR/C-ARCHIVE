<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PDFAccessTokoLantai extends CI_Controller
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

        $data['tbl_access'] = $this->DataModels->get_where_toko_lantai($where_access, 'tbl_access_toko_lantai');
        $data['tbl_access2'] = $this->DataModels->get_where_toko_lantai_pdf_2($where_access, 'tbl_access_toko_lantai');


        $this->load->library('pdfgenerator');

        $html = $this->load->view('menu/report/v_pdf_accesstokolantai', $data, true);
        // $filename = 'Export Access Toko dan lantai - ' . time();
        $filename = 'Kode Toko dan lantai - ' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
    }
}
