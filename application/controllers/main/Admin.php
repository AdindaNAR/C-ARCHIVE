<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();
    }
    
    public function index()
    {
        $data['title'] = 'Dashboard';

        $data['toko'] = $this->DataModels->tampil_toko();
        $data['brand'] = $this->DataModels->tampil_brand();
        $data['user'] = $this->DataModels->tampil_user();
        $data['lantai'] = $this->DataModels->tampil_lantai();
        
        $data['barang'] = $this->DataModels->tampil_barang();

        $data['detail_barang_by_jenis'] = $this->DataModels->tampil_detail_barang_by_jenis();
        $data['detail_barang_by_item'] = $this->DataModels->tampil_detail_barang_by_item();
        $data['detail_barang_by_jml'] = $this->DataModels->tampil_detail_barang_by_jml();

        $data['terima_toko_by_jenis'] = $this->DataModels->tampil_terima_barang_toko_by_jenis();
        $data['terima_toko_by_item'] = $this->DataModels->tampil_terima_barang_toko_by_item();
        $data['terima_toko_by_jml'] = $this->DataModels->tampil_terima_barang_toko_by_jml();

        $data['penjualan_by_jenis'] = $this->DataModels->tampil_penjualan_by_jenis();
        $data['penjualan_by_item'] = $this->DataModels->tampil_penjualan_by_item();
        $data['penjualan_by_jml'] = $this->DataModels->tampil_penjualan_by_jml();


        $this->load->view('main/admin/v_dashboard', $data);
    }
}