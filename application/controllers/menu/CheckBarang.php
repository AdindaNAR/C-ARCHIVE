<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CheckBarang extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index(){
        $data['title'] = 'Toko';
        $where = array('data_status' => '1');
        $data['toko'] = $this->DataModels->get_where_table($where, 'tbl_toko');
        $this->load->view('menu/check_barang/v_toko', $data);
    }

    public function barang(){
        $id = $this->uri->segment(4);
        $data['data_toko'] = $this->DataModels->get_data_toko($id);
        $data['data_brand'] = $this->DataModels->get_all_brand($id);

        $tampil_nama_toko = $this->db->get_where('tbl_toko',array('id_toko'=>$id))->row();
        $data['title'] = $tampil_nama_toko->nama_toko;
        
        $data['lantai'] = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();
         
        $this->load->view('menu/check_barang/v_barang', $data);
    }

    public function data_barang_pertoko(){
        $id_toko = $this->input->post('id_toko');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        $sql_total = $this->DataModels->count_all(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang($search, $limit, $start, $order_field, $order_ascdesc, $id_toko); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang($search,$id_toko); // Panggil fungsi count_filter 
        $callback = array(
            'draw'=>$_POST['draw'], // Ini dari datatablenya
            'recordsTotal'=>$sql_total,
            'recordsFiltered'=>$sql_filter,
            'data'=>$sql_data
        );

        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function lantai(){
        $id =$this->uri->segment(4);
        $id_lantai =$this->uri->segment(5);

        $tampil_nama_toko = $this->db->get_where('tbl_toko',array('id_toko'=>$id))->row();
        $tampil_nama_lantai = $this->db->get_where('tbl_lantai',array('id_lantai'=>$id_lantai))->row();
        $data['title'] = $tampil_nama_toko->nama_toko.' - '.$tampil_nama_lantai->nama_lantai;
        $data['lantai'] = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();  
        $this->load->view('menu/check_barang/v_lantai', $data);
    }

    public function data_barang_perlantai(){
        $id_toko = $this->input->post('id_toko');
        $id_lantai = $this->input->post('id_lantai');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        $sql_total = $this->DataModels->count_all(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang($search, $limit, $start, $order_field, $order_ascdesc, $id_toko, $id_lantai); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang($search, $id_toko, $id_lantai); // Panggil fungsi count_filter 
        $callback = array(
            'draw'=>$_POST['draw'], // Ini dari datatablenya
            'recordsTotal'=>$sql_total,
            'recordsFiltered'=>$sql_filter,
            'data'=>$sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }
}