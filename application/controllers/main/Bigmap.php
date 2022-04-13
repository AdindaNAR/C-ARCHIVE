<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bigmap extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('cart');
        $this->load->helper('form');

        // Call Model
        $this->load->model('DataModels');
        $this->load->model('CodeModels');

        // Access Rights Limiter
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Stok Toko (Master Data)';

        $data['lantai_akses'] = $this->DataModels->get_one_table('tbl_lantai');
        $data['data_brand'] = $this->DataModels->get_all_brand();

        $id_role = $this->session->userdata('id_role');
        $id_toko = $this->session->userdata('id_toko');

        // if (empty($id_toko)) {
        //     $where = array('tbl_barang.data_status' => "1");
        //     $data['lantai'] = $this->DataModels->get_lantai_master_data($where, 'tbl_barang');
        // } else {
        //     $where = array('tbl_barang.id_toko' =>  $id_toko, 'tbl_barang.data_status' => "1");
        //     $data['lantai'] = $this->DataModels->get_lantai_master_data($where, 'tbl_barang');
        // }

        $data['toko'] = $this->DataModels->get_all_toko($id_toko);

        $data['bulan'] = $this->DataModels->get_bulan("ASC", $id_toko);
        $data['tahun'] = $this->DataModels->get_tahun("ASC", $id_toko);

        if ($id_role == 3) {
            $id_toko = $this->session->userdata('id_toko');
            $data['tbl_barang'] = $this->DataModels->get_table_barang($id_toko);
        } else {
            $data['tbl_barang'] = $this->DataModels->get_table_barang();
        }

        $data['tbl_diskon'] = $this->DataModels->get_table_diskon();
        $data['tbl_cashback'] = $this->DataModels->get_table_cashback();



        $this->load->view('main/admin/v_bigmap', $data);
    }

    public function data_stok()
    {


        $noPo = $this->input->post('noPo');
        $nabar = $this->input->post('nabar');
        $nabrand = $this->input->post('nabrand');
        $id_toko = $this->input->post('id_toko');

        $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : ' '; // Ambil data yang di ketik user pada textbox pencarian
        $limit = isset($_POST['length']) ? $_POST['length'] : ' '; // Ambil data limit per page
        $start = isset($_POST['start']) ? $_POST['start'] : ''; // Ambil data start
        $order_index = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : ' '; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = isset($_POST['columns'][$order_index]['data']) ? $_POST['columns'][$order_index]['data'] : ''; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->DataModels->count_all(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_master_data($search, $limit, $start, $order_field, $order_ascdesc, $id_toko, $id_lantai = null, $id_barang = null, $noPo, $nabar, $nabrand); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_master_data($search, $id_toko, $noPo, $nabar, $nabrand); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => isset($_POST['draw']) ? $_POST['draw'] : '', // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    // public function data_stok_master_data()
    // {

    //     $id_role = $this->session->userdata('id_role');

    //     $noPo = $this->input->post('noPo');
    //     $nabar = $this->input->post('nabar');
    //     $nabrand = $this->input->post('nabrand');

    //     if ($id_role == 3) {
    //         $id_toko = $this->session->userdata('id_toko');
    //     } else {
    //         $id_toko = $this->input->post('id_toko');
    //     }


    //     $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : ' '; // Ambil data yang di ketik user pada textbox pencarian
    //     $limit = isset($_POST['length']) ? $_POST['length'] : ' '; // Ambil data limit per page
    //     $start = isset($_POST['start']) ? $_POST['start'] : ''; // Ambil data start
    //     $order_index = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : ' '; // Untuk mengambil index yg menjadi acuan untuk sorting
    //     $order_field = isset($_POST['columns'][$order_index]['data']) ? $_POST['columns'][$order_index]['data'] : ''; // Untuk mengambil nama field yg menjadi acuan untuk sorting
    //     $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
    //     $sql_total = $this->DataModels->count_all(); // Panggil fungsi count_all  
    //     // ///////////////////
    //     $sql_data = $this->DataModels->filter_master_data($search, $limit, $start, $order_field, $order_ascdesc, $id_toko, $id_lantai = null, $id_barang = null, $noPo, $nabar, $nabrand); // Panggil fungsi filter
    //     $sql_filter = $this->DataModels->count_filter_master_data($search, $id_toko, $noPo, $nabar, $nabrand); // Panggil fungsi count_filter 
    //     // ////////////////////
    //     $callback = array(
    //         'draw' => isset($_POST['draw']) ? $_POST['draw'] : '', // Ini dari datatablenya
    //         'recordsTotal' => $sql_total,
    //         'recordsFiltered' => $sql_filter,
    //         'data' => $sql_data
    //     );
    //     header('Content-Type: application/json');
    //     echo json_encode($callback); // Convert array $callback ke json
    // }

    public function data_stok_master_data()
    {

        $id_role = $this->session->userdata('id_role');

        $noPo = $this->input->post('noPo');
        $nabar = $this->input->post('nabar');
        $nabrand = $this->input->post('nabrand');
        $id_toko = $this->input->post('id_toko');

        // if ($id_role == 3) {
        //     $id_toko = $this->session->userdata('id_toko');
        // } else {
        //     $id_toko = $this->input->post('id_toko');
        // }


        $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : ' '; // Ambil data yang di ketik user pada textbox pencarian
        $limit = isset($_POST['length']) ? $_POST['length'] : ' '; // Ambil data limit per page
        $start = isset($_POST['start']) ? $_POST['start'] : ''; // Ambil data start
        $order_index = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : ' '; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = isset($_POST['columns'][$order_index]['data']) ? $_POST['columns'][$order_index]['data'] : ''; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->DataModels->count_all(); // Panggil fungsi count_all  
        // ///////////////////
        $sql_data = $this->DataModels->filter_master_data($search, $limit, $start, $order_field, $order_ascdesc, $id_barang = null, $id_toko, $noPo, $nabar, $nabrand, $bulan = null, $tahun = null);

        $sql_filter = $this->DataModels->count_filter_master_data($search, $noPo, $nabar, $nabrand); // Panggil fungsi count_filter 
        // ////////////////////
        $callback = array(
            'draw' => isset($_POST['draw']) ? $_POST['draw'] : '', // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    function hapus_data_barang()
    {
        $id_barang = $this->input->post('id_barang');
        $data = array('data_status' => 0);
        $where = array('id_barang' => $id_barang);
        $data = $this->DataModels->update($where, $data, 'tbl_barang');
        echo $this->session->set_flashdata('berhasil_hapus', 'Data Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }

    function nonAktif()
    {
        $id_barang = $this->input->post('kode');
        $data = array('data_status' => 0);
        $where = array('id_barang' => $id_barang);
        $data = $this->DataModels->update($where, $data, 'tbl_barang');
        echo json_encode($data);
    }

    function nonAktifDet()
    {
        $kobar = $this->input->post('kode');
        $where = array('id_detail_barang' => $kobar);
        $data = $this->DataModels->delete($where, 'tbl_detail_barang');
        echo json_encode($data);
    }

    function nonAktifDetBarang()
    {
        $id = $this->input->post('kode');
        $where = array('id' => $id);
        $data = $this->DataModels->delete($where, 'tbl_detail_barang');
        echo json_encode($data);
    }

    function nonAktifPenjualanCustomer()
    {
        $jumlah = $this->input->post('jumlah');
        $idRiwayat = $this->input->post('idRiwayat');
        $id = $this->input->post('kode');
        $hsl = $this->db->query("select * from tbl_riwayat WHERE id = '$idRiwayat' ")->result_array();

        $sold = $hsl[0]['banyak'];
        $id_riwayat = $hsl[0]['id_riwayat'];
        $sold +=  $jumlah;

        $data2 = array(
            'banyak' => $sold
        );
        $where2 = array(
            'id_riwayat' => $id_riwayat
        );
        $this->DataModels->update($where2, $data2, 'tbl_riwayat');
        $where = array('id_penjualan' => $id);
        $data = $this->DataModels->delete($where, 'tbl_penjualan');
        echo json_encode($data);
    }

    function nonAktifPenjualan2()
    {


        $id = $this->input->post('kode');
        $idDetail = $this->input->post('idDetail');
        $qty =  $this->input->post('qty');
        $hsl = $this->db->query("select * from tbl_detail_barang WHERE id = '$idDetail' ")->result_array();


        $sold = $hsl[0]['stock_sold'];
        $id_detail_barang = $hsl[0]['id_detail_barang'];
        $sold = $sold - $qty;

        $data2 = array(
            'stock_sold' => $sold,

        );
        $where2 = array(
            'id_detail_barang' => $id_detail_barang


        );
        $this->DataModels->update($where2, $data2, 'tbl_detail_barang');

        $data = array('data_status' => 0);
        $where = array('id' => $id);
        $data = $this->DataModels->delete($where, 'tbl_riwayat');
        echo json_encode($data);
    }

    function nonAktifPo()
    {
        $kobar = $this->input->post('kode');
        $where = array('no_po' => $kobar);
        $data = $this->DataModels->delete($where, 'tbl_detail_barang');
        echo json_encode($data);
    }

    function nonAktifPenjualan()
    {

        $kobar = $this->input->post('kode');
        $banyak = $this->input->post('data2');
        $id_detail_barang = $this->input->post('data3');

        $hsl = $this->db->query("select * from tbl_detail_barang WHERE id_detail_barang = '$id_detail_barang' ")->result_array();
        $sold = $hsl[0]['stock_sold'];
        $sold -=  $banyak;

        $data2 = array('stock_sold' => $sold);
        $where = array('id_detail_barang' => $id_detail_barang);

        $this->DataModels->update($where, $data2, 'tbl_detail_barang');

        $data = array('data_status' => 0);
        $where = array('id_riwayat' => $kobar);
        $data = $this->DataModels->update($where, $data, 'tbl_riwayat');
        echo json_encode($data);
    }

    //   Selesaikan PO
    function pesananOK()
    {
        $this->db->trans_start(); // Bagian atas
        $id = $this->input->post('kode');
        $data = array('status_order' => 3);
        $where = array('id' => $id);
        $data = $this->DataModels->update($where, $data, 'tbl_detail_barang');
        echo json_encode($data);
        $this->db->trans_complete(); //Bagian bawah
    }

    public function get_toko_mirror()
    {
        $id_toko = $this->session->userdata('id_toko');
        redirect('main/Bigmap/get_toko/' . $id_toko . '/listPo');
    }

    public function get_toko()
    {
        $id = $this->uri->segment(4);
        $data['data_toko'] = $this->DataModels->get_data_toko($id);
        $data['data_brand'] = $this->DataModels->get_all_brand($id);
        $data['data_sp'] = $this->DataModels->get_all_sp();
        $data['data_sb'] = $this->DataModels->get_all_sb();

        $ceknamatoko = $this->db->get_where('tbl_toko', array('id_toko' => $id))->row();
        $data['title'] = $ceknamatoko->nama_toko;

        $data['lantai'] = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();
        $data['data_lantai_akses'] = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();

        $this->load->view('main/admin/v_data_toko', $data);
    }

    public function data_toko()
    {
        $id_toko = $this->input->post('id_toko');

        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting

        $order_ascdesc = 'DESC';
        $sql_total = $this->DataModels->count_all(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang($search, $limit, $start, $order_field, $order_ascdesc, $id_toko); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang($search, $id_toko); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function list_data_po_toko()
    {
        $id_toko = $this->input->post('id_toko');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        // $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->DataModels->count_all_po(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang_po($search, $limit, $start, $order_field, $order_ascdesc, $id_toko); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang_po($search, $id_toko); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function list_data_penjualan_toko()
    {
        $id_toko = $this->input->post('id_toko');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        // $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->DataModels->count_all_penjualan(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang_penjualan($search, $limit, $start, $order_field, $order_ascdesc, $id_toko); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang_penjualan($search, $id_toko); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function list_data_penjualan_toko2()
    {
        $id_barang = $this->input->post('id_barang');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        // $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->DataModels->count_all_penjualan(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang_penjualan2($search, $limit, $start, $order_field, $order_ascdesc, $id_barang); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang_penjualan2($search, $id_barang); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function list_data_penjualan_toko3()
    {
        $id_toko = $this->input->post('id_toko');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        // $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->DataModels->count_all_penjualan(); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_data_barang_penjualan3($search, $limit, $start, $order_field, $order_ascdesc, $id_toko); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_barang_penjualan3($search, $id_toko); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }


    public function get_lantai()
    {
        $id = $this->uri->segment(4);
        $id_lantai = $this->uri->segment(5);
        $ceknamatoko = $this->db->get_where('tbl_toko', array('id_toko' => $id))->row();
        $ceknamalantai = $this->db->get_where('tbl_lantai', array('id_lantai' => $id_lantai))->row();
        $data['title'] = $ceknamatoko->nama_toko . ' - ' . $ceknamalantai->nama_lantai;
        $data['data_lantai_akses'] = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();

        $this->load->view('main/admin/v_data_lantai', $data);
    }

    public function data_perlantai()
    {
        $id_toko = $this->input->post('id_toko');
        $id_lantai = $this->input->post('id_lantai');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where(array('data_status' => 1))->count_all_results("tbl_riwayat"); // Panggil 
        $sql_data = $this->DataModels->filter_data_lantai($search, $limit, $start, $order_field, $id_toko, $id_lantai); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_data_lantai($search, $limit, $start, $order_field, $id_toko, $id_lantai); // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function get_barang_detail()
    {
        // $id = $this->uri->segment(4);
        $id_barang = $this->uri->segment(4);
        // $id_lantai = $this->uri->segment(5);

        $data['tahun'] = $this->DataModels->get_periode_tahun_detail("ASC", date("Y"));
        $data['bulan'] = $this->DataModels->get_periode_bulan_detail("ASC", date("M"));

        // $data['data_lantai_akses'] = $this->db->query("SELECT * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();
        // $data['tbl_barang'] = $this->db->query("SELECT a.id, a.id_barang, a.id_brand, a.id_toko, a.id_lantai, a.nama_barang, a.deskripsi_barang, b.nama_brand, c.nama_toko FROM tbl_barang as a INNER JOIN tbl_brand as b ON a.id_brand = b.id_brand INNER JOIN tbl_toko as c ON a.id_toko = c.id_toko WHERE a.id_barang = '$id_barang' AND a.data_status = '1' ")->result();
        $data['tbl_barang'] = $this->db->query("SELECT a.id, a.id_barang, a.id_brand, a.nama_barang, a.deskripsi_barang, b.nama_brand FROM tbl_barang AS a INNER JOIN tbl_brand AS b ON a.id_brand = b.id_brand WHERE a.id_barang = '$id_barang' AND a.data_status = '1' ")->result();

        $data['total_stock'] = $this->db->query("SELECT sum(banyak) AS total_stock  FROM tbl_riwayat as a INNER JOIN tbl_detail_barang as b on a.id_detail_barang = b.id_detail_barang WHERE b.id_barang = '$id_barang'  AND a.data_status = '1'")->result();

        $data['tbl_brand'] = $this->db->query("SELECT * FROM tbl_brand WHERE data_status = '1'")->result();
        $data['data_list_stock'] = $this->DataModels->query_stock($id_barang)->result();
        // $data['tbl_toko'] = $this->db->query("SELECT * FROM tbl_toko WHERE data_status = '1'")->result();

        $ceknamabarang = $this->db->get_where('tbl_barang', array('id_barang' => $id_barang))->row();
        $data['title'] = $ceknamabarang->nama_barang;

        $data['DataPO'] = $this->DataModels->get_data_po();
        $data['code_po'] = $this->CodeModels->create_code_po(); // Call & Check Code from Model
        $this->load->view('main/admin/v_detail_barang', $data);
    }

    public function data_detail_barang()
    {
        // $id_toko = $this->input->post('id_toko');
        // $id_lantai = $this->input->post('id_lantai');
        $id_barang = $this->input->post('id_barang');

        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_detail_barang"); // Panggil fungsi count_all  
        // $sql_data = $this->DataModels->filter_detail($search, $limit, $start, $order_field, $order_ascdesc, $id_toko, $id_lantai, $id_barang); // Panggil fungsi filter
        $sql_data = $this->DataModels->filter_detail($search, $limit, $start, $order_field, $order_ascdesc, $id_barang); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_detail($search, $id_barang);
        // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    // public function dataPenjualan()
    // {
    //     $id_toko = $this->input->post('id_toko');
    //     $id_lantai = $this->input->post('id_lantai');
    //     $id_barang = $this->input->post('id_barang');
    //     $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
    //     $limit = $_POST['length']; // Ambil data limit per page
    //     $start = $_POST['start']; // Ambil data start
    //     $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
    //     $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
    //     $order_ascdesc = 'DESC';
    //     //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
    //     $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_riwayat"); // Panggil fungsi count_all  
    //     $sql_data = $this->DataModels->filter_penjualan($search, $limit, $start, $order_field, $order_ascdesc, $id_toko, $id_lantai, $id_barang); // Panggil fungsi filter
    //     $sql_filter = $this->DataModels->count_filter_penjualan($search, $id_toko, $id_lantai, $id_barang);
    //     // Panggil fungsi count_filter 
    //     $callback = array(
    //         'draw' => $_POST['draw'], // Ini dari datatablenya
    //         'recordsTotal' => $sql_total,
    //         'recordsFiltered' => $sql_filter,
    //         'data' => $sql_data
    //     );
    //     header('Content-Type: application/json');
    //     echo json_encode($callback); // Convert array $callback ke json
    // }

    public function dataPenjualan()
    {
        // $id_toko = $this->input->post('id_toko');
        // $id_lantai = $this->input->post('id_lantai');
        $id_barang = $this->input->post('id_barang');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_riwayat"); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_penjualan($search, $limit, $start, $order_field, $order_ascdesc, $id_barang); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_penjualan($search, $id_barang);
        // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function dataPenjualan2()
    {
        $no_po = $this->input->post('no_po');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_riwayat"); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_penjualan2($search, $limit, $start, $order_field, $order_ascdesc, $no_po); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_penjualan2($search, $no_po);
        // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function dataPenjualan3()
    {
        $id_toko = $this->input->post('id_toko');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_riwayat"); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_penjualan3($search, $limit, $start, $order_field, $order_ascdesc, $id_toko); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_penjualan3($search, $id_toko);
        // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function dataToko()
    {
        $no_po = $this->input->post('no_po');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_riwayat"); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->dataToko($search, $limit, $start, $order_field, $order_ascdesc, $no_po); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_dataToko($search, $no_po);
        // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }
    public function detail_barang()
    {
        $id_toko = $this->input->post('id_toko');
        $id_lantai = $this->input->post('id_lantai');
        $id_barang = $this->input->post('id_barang');

        $sql_data = $this->DataModels->filter($id_toko, $id_lantai, $id_barang); // Panggil fungsi filter

        $callback = array(

            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    public function get_po_detail()
    {
        $id = $this->uri->segment(5);
        $data['title'] = 'Detail PO';
        $data['lantai'] = $this->db->query("Select * from tbl_access_toko_lantai a JOIN tbl_lantai b ON a.id_lantai=b.id_lantai  where a.id_toko = '$id' AND a.data_status = '1' ")->result();
        $data['tahun'] = $this->DataModels->get_periode_tahun_detail("ASC", date("Y"));
        $data['bulan'] = $this->DataModels->get_periode_bulan_detail("ASC", date("M"));

        $this->load->view('main/admin/v_po_detail', $data);
    }

    public function data_detail_po()
    {
        $no_po = $this->input->post('no_po');
        $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
        $limit = $_POST['length']; // Ambil data limit per page
        $start = $_POST['start']; // Ambil data start
        $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
        $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_ascdesc = 'DESC';
        //$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
        $sql_total = $this->db->where('data_status', 1)->count_all_results("tbl_detail_barang"); // Panggil fungsi count_all  
        $sql_data = $this->DataModels->filter_po($search, $limit, $start, $order_field, $order_ascdesc, $no_po); // Panggil fungsi filter
        $sql_filter = $this->DataModels->count_filter_po($search, $no_po);
        // Panggil fungsi count_filter 
        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        );
        header('Content-Type: application/json');
        echo json_encode($callback); // Convert array $callback ke json
    }

    function simpan_barang()
    {


        $kobar = $this->input->post('kobar');
        $id_brand = $this->input->post('id_brand');
        $nama_barang = $this->input->post('nama_barang');
        $desc = $this->input->post('desc');
        $harga_barang = $this->input->post('harga_barang');
        $id_harga = $this->CodeModels->create_code_harga();




        // $id_lantai = $this->input->post('id_lantai');
        $cek = $this->DataModels->cek_data("tbl_barang", array('id_barang' => $kobar, 'data_status' => 1))->num_rows();


        if ($cek > 0) {
            $data = 'notfound';
        } else {
            $data_barang  = [
                'id_barang' => $kobar,
                'id_brand' => $id_brand,
                'nama_barang' => $nama_barang,
                'deskripsi_barang' => $desc,
                'id_harga' => $id_harga,
                'harga_akhir' => $harga_barang

                // 'id_lantai' => $id_lantai,
            ];
            $data = $this->DataModels->create($data_barang, 'tbl_barang');

            $data_harga = [
                'id_barang' => $kobar,
                'id_harga' => $id_harga,
                'harga_lama' => 0,
                'harga_baru' => $harga_barang
            ];
            $this->DataModels->create($data_harga, 'tbl_harga');

            $tokoid = $this->input->post('id_toko');

            if (empty($tokoid)) {
                $where = array('data_status' => '1');
                $toko = $this->DataModels->get_where_table($where, 'tbl_toko');
                foreach ($toko as $u) {
                    $data_toko[] = array(
                        'id_barang' => $kobar,
                        'id_toko' => $u->id_toko
                    );
                }
                $this->DataModels->insertbarang($data_toko);
            } else {
                $id_toko = $this->input->post('id_toko');
                $listoko = explode(',', $id_toko);

                $result = array();
                foreach ($listoko as $key => $val) {
                    $result[] = array(
                        'id_barang'      => $kobar,
                        'id_toko'      => $listoko[$key]
                    );
                }
                $this->db->insert_batch('tbl_access_barang_toko', $result);
            }
        }

        echo json_encode($data);
    }

    function get_barang_by_toko()
    {
        $id_barang = $this->input->post('id_barang');
        $data = $this->DataModels->get_barang_by_toko($id_barang)->result();
        foreach ($data as $result) {
            $value[] = (float) $result->id_toko;
        }
        echo json_encode($value);
    }

    function updateBarang()
    {

        $idBrarang = $this->input->post('idBrarang');
        $nabrand = $this->input->post('nabrand');
        // $nalantai = $this->input->post('nalantai');
        $nabar = $this->input->post('nabar'); //ini nama barang
        $desc = $this->input->post('desc');
        $harga_barang = $this->input->post('harga_barang_edit');
        $id_harga = $this->CodeModels->create_code_harga();
        $listToko =  $this->input->post('listToko');

        $this->db->select('a.id_barang,b.harga_baru,a.id_harga');
        $this->db->from('tbl_barang a');
        $this->db->join('tbl_harga b ', 'a.id_harga = b.id_harga');
        $this->db->where('a.id_barang', $idBrarang);
        $query = $this->db->get()->row_array();

        if ($harga_barang !==  $query['harga_baru']) {
            $data_harga  = [
                'id_harga' => $id_harga,
                'harga_baru' => $harga_barang,
                'harga_lama' => $query['harga_baru'],
                'id_barang' => $idBrarang
            ];
            $this->DataModels->create($data_harga, 'tbl_harga');

            $data_barang  = [
                'id_harga' => $id_harga
            ];

            $where = array(
                'id_barang' => $idBrarang
            );
            $this->DataModels->update($where, $data_barang, 'tbl_barang');
        }


        if ($harga_barang === $query['harga_baru']) {
            $id_harga =  $query['id_harga'];
        }


        $data_barang  = [
            'id_brand' => $nabrand,
            // 'id_lantai' => $nalantai,
            'nama_barang' => $nabar,
            'harga_akhir' => $harga_barang,
            'deskripsi_barang' => $desc
        ];

        $where = array(
            'id_barang' => $idBrarang
        );

        $data = $this->DataModels->update($where, $data_barang, 'tbl_barang');

        $this->DataModels->update_listToko($idBrarang, $listToko);

        echo json_encode($data);
    }

    function updateDiskon()
    {
        $id_diskon = $this->CodeModels->create_code_diskon();
        $id_barang = $this->input->post('idBrarang');


        $where = array(
            'id_barang' => $id_barang,
            'data_status' => 1
        );

        $cek_barang = $this->db->get_where('tbl_barang', $where)->row();
        $cek_harga = $this->db->get_where('tbl_harga', array('id_harga' => $cek_barang->id_harga, 'data_status' => '1'))->row();
        $cek_cashback = $this->db->query("select sum(nominal) as cashback from tbl_cashback where id_barang = '$id_barang' AND id_cashback = '$cek_barang->id_cashback' AND data_status = 1 ")->row();

        $harga_barang = $cek_harga->harga_baru;
        if (empty($cek_barang->id_cashback)) {
            $cashback = 0;
        } else {
            $cashback = $cek_cashback->cashback;
        }

        $result = array();
        foreach ($_POST['persentase_edit'] as $key => $val) {
            $result[] = array(
                'id_barang' => $id_barang,
                'persentase' => $_POST['persentase_edit'][$key],
                'order_data' => $key + 1,
                'id_diskon' => $id_diskon,
            );
        }

        $diskon = 1;
        foreach ($_POST['persentase_edit'] as $key => $val) {
            $disc = $_POST['persentase_edit'][$key];
            $diskon = ($diskon * (1 - ($disc / 100)));
        }

        $harga_akhir = ($harga_barang * $diskon) - $cashback; // perhitungan diskon

        $data_barang  = [
            'id_diskon' => $id_diskon,
            'harga_akhir' => $harga_akhir
        ];


        $ddiskon = "";
        foreach ($_POST['persentase_edit'] as $key => $val) {
            if (empty($_POST['persentase_edit'][$key])) {
                $_POST['persentase_edit'][$key] = '-';
            } else {
                $_POST['persentase_edit'][$key] = $_POST['persentase_edit'][$key] . '%+';
            }

            $ddiskon .= $_POST['persentase_edit'][$key];
        }

        $data_desc_diskon = array(
            'id_barang' => $id_barang,
            'diskon' => $ddiskon
        );
        $data = $this->db->insert_batch('tbl_diskon', $result);

        // CEK APAKAH SUDAH ADA ATAU BELUM ID_BARANG PADA TBL DESC DISKON
        $cek_desc = $this->DataModels->cek_data("tbl_desc_diskon", $where)->num_rows();
        if ($cek_desc == 1) {
            $this->DataModels->update($where, $data_desc_diskon, 'tbl_desc_diskon');
        } else {
            $this->DataModels->create($data_desc_diskon, 'tbl_desc_diskon');
        }

        $this->DataModels->update($where, $data_barang, 'tbl_barang');
        echo json_encode($data);
    }

    function updateCahback()
    {
        $id_cashback = $this->CodeModels->create_code_cashback();
        $id_barang = $this->input->post('idBrarang');

        $where = array(
            'id_barang' => $id_barang,
            'data_status' => 1,
        );

        $cek_barang = $this->db->get_where('tbl_barang', $where)->row();
        $cek_harga = $this->db->get_where('tbl_harga', array('id_harga' => $cek_barang->id_harga, 'data_status' => '1'))->row();
        $cek_diskon = $this->db->query("select persentase from tbl_diskon where id_barang = '$id_barang' AND id_diskon = '$cek_barang->id_diskon' AND data_status = 1 ")->result();

        $harga_barang = $cek_harga->harga_baru;
        if (empty($cek_barang->id_diskon)) {
            $diskon = 0;
        } else {
            $diskon = 1;
            foreach ($cek_diskon as $u) {
                $disc = $u->persentase;
                $diskon = ($diskon * (1 - ($disc / 100)));
            }
        }

        // print_r($cek_barang);
        // print_r($cek_harga);
        // print_r($cek_diskon);
        // print_r($diskon);
        // exit();

        $result = array();
        foreach ($_POST['cashback'] as $key => $val) {
            $result[] = array(
                'id_barang' => $id_barang,
                'nominal' => $_POST['cashback'][$key],
                'order_data' => $key + 1,
                'id_cashback' => $id_cashback,
            );
        }

        $cashback = 0;
        foreach ($_POST['cashback'] as $key => $val) {
            $cashback += $_POST['cashback'][$key];
        }

        $harga_akhir = ($harga_barang * $diskon) - $cashback; // perhitungan cashback

        $data_barang  = [
            'id_cashback' => $id_cashback,
            'harga_akhir' => $harga_akhir
        ];

        $ccashback = "";
        foreach ($_POST['cashback'] as $key => $val) {
            if (empty($_POST['cashback'][$key])) {
                $_POST['cashback'][$key] = '-';
            } else {
                $_POST['cashback'][$key] = 'Rp. ' . number_format($_POST['cashback'][$key]) . ' + ';
            }

            $ccashback .= $_POST['cashback'][$key];
        }

        $data_desc_cashback = array(
            'id_barang' => $id_barang,
            'cashback' => $ccashback
        );


        $data = $this->db->insert_batch('tbl_cashback', $result);

        // CEK APAKAH SUDAH ADA ATAU BELUM ID_BARANG PADA TBL DESC CASHBACK
        $cek_cash = $this->DataModels->cek_data("tbl_desc_cashback", $where)->num_rows();
        if ($cek_cash == 1) {
            $this->DataModels->update($where, $data_desc_cashback, 'tbl_desc_cashback');
        } else {
            $this->DataModels->create($data_desc_cashback, 'tbl_desc_cashback');
        }

        $this->DataModels->update($where, $data_barang, 'tbl_barang');
        echo json_encode($data);
    }

    function simpan_detail()
    {
        $noPo = $this->input->post('noPo');
        $banyak = $this->input->post('banyak');
        $ukuran = $this->input->post('ukuran');
        $warna = $this->input->post('warna');
        $tanggalMasuk = $this->input->post('tanggalMasuk');
        $id_barang = $this->input->post('id_barang');
        $idDetail = $this->CodeModels->create_code_det_barang();

        $data  = [
            'id_detail_barang' => $idDetail,
            'id_barang' => $id_barang,
            'no_po' => $noPo,
            'ukuran' => $ukuran,
            'warna' => $warna,
            'stock_quantity' => $banyak,
            'tanggal_masuk' => fdate_ind_to_eng($tanggalMasuk)
        ];

        $data = $this->DataModels->create($data, 'tbl_detail_barang');
        echo json_encode($data);
    }

    function edit_barang()
    {
        $id_barang = $this->input->post('id_barang');
        $id_brand = $this->input->post('id_brand');
        $nama_barang = $this->input->post('nama_barang');
        $deskripsi_barang = $this->input->post('deskripsi_barang');
        $id_toko = $this->input->post('id_toko');

        $data = array(
            'id_barang' => $id_barang,
            'id_brand' => $id_brand,
            'nama_barang' => $nama_barang,
            'deskripsi_barang' => $deskripsi_barang,
            'id_toko' => $id_toko
        );

        $where = array(
            'id_barang' => $id_barang
        );

        $this->DataModels->update($where, $data, 'tbl_barang');
        $this->session->set_flashdata('berhasil_update', 'Data Barang Berhasil Diupdate!');
        redirect($_SERVER['HTTP_REFERER']); //LINK UNTUK KEMBALI KE HALAMAN SEBELUMNYA SEBELUM USER AKSES CONTROLLER
    }

    function simpan_penjualan()
    {


        $suratJalan = $this->input->post('suratJalan');
        $noPo = $this->input->post('noPo');
        $idLantai = $this->input->post('idLantai');
        $id_riwayat = $this->input->post('idRiwayat');
        $id_detail_barang = $this->input->post('idDetailBarang');

        $keterangan = $this->input->post('keterangan');
        $banyak_keluar = $this->input->post('banyak_keluar');
        $tanggal_keluar = $this->input->post('tanggal_keluar');

        $hsl = $this->db->query("select * from tbl_detail_barang WHERE id = '$id_detail_barang' ")->result_array();

        $sold = $hsl[0]['stock_sold'];
        $id_detail_barang = $hsl[0]['id_detail_barang'];
        $sold +=  $banyak_keluar;

        $data2 = array(
            'status_order' => 2,
            'stock_sold' => $sold
        );

        $where = array(
            'id_detail_barang' => $id_detail_barang
        );
        $data = $this->DataModels->update($where, $data2, 'tbl_detail_barang');

        $data  = [
            'no_surat_jalan' => $suratJalan,
            'id_riwayat' => $id_riwayat,
            // 'id_db_ai'=>$id_db_ai,
            'id_detail_barang' => $id_detail_barang,
            'id_lantai' => $idLantai,
            'keterangan' => $keterangan,
            'tanggal_terima' => date('Y-m-d'),
            'banyak' => $banyak_keluar
        ];

        $data = $this->DataModels->create($data, 'tbl_riwayat');
        echo json_encode($data);
    }

    function simpan_penjualan_customer()
    {

        $id_penjualan = $this->CodeModels->create_code_penjualan();
        $id_riwayat = $this->input->post('idRiwayat');
        $keterangan = $this->input->post('keterangan');
        $banyak_keluar = $this->input->post('banyak_keluar');


        $hsl = $this->db->query("select * from tbl_riwayat WHERE id_riwayat = '$id_riwayat' ")->result_array();

        $sold = $hsl[0]['banyak'];
        $id_riwayat = $hsl[0]['id_riwayat'];
        $sold -=  $banyak_keluar;

        $data2 = array(

            'banyak' => $sold
        );

        $where = array(

            'id_riwayat' => $id_riwayat
        );
        $this->DataModels->update($where, $data2, 'tbl_riwayat');

        $data  = [

            'id_riwayat' => $id_riwayat,
            // 'id_db_ai'=>$id_db_ai,
            'id_penjualan' => $id_penjualan,
            'keterangan' => $keterangan,
            'tanggal_penjualan' => date('Y-m-d'),
            'qty' => $banyak_keluar
        ];

        $data = $this->DataModels->create($data, 'tbl_penjualan');
        echo json_encode($data);
    }

    function updateDetBarang()
    {
        $id_detail_barang = $this->input->post('idDetail');
        $noPo = $this->input->post('nopo');
        $banyak = $this->input->post('banyak');
        $ukuran = $this->input->post('ukuran');
        $warna = $this->input->post('warna');
        $tanggalMasuk = $this->input->post('tanggalMasuk');
        $id_barang = $this->input->post('id_barang');

        $data  = [
            'no_po' => $noPo,
            'ukuran' => $ukuran,
            'warna' => $warna,
            'stock_quantity' => $banyak,
            'tanggal_masuk' => fdate_ind_to_eng($tanggalMasuk)
        ];

        $where = array(
            'id_detail_barang' => $id_detail_barang
        );

        $data = $this->DataModels->update($where, $data, 'tbl_detail_barang');
        echo json_encode($data);
    }

    function update_detail_barang()
    {
        $id = $this->input->post('id');
        $id_detail_barang = $this->input->post('idDetail');
        $noPo = $this->input->post('nopo');
        $banyak = $this->input->post('banyak');
        $ukuran = $this->input->post('ukuran');
        $warna = $this->input->post('warna');
        $tanggalMasuk = $this->input->post('tanggalMasuk');
        $id_barang = $this->input->post('id_barang');

        $data  = [
            'no_po' => $noPo,
            'ukuran' => $ukuran,
            'warna' => $warna,
            'stock_quantity' => $banyak,
            'tanggal_masuk' => fdate_ind_to_eng($tanggalMasuk)
        ];

        $where = array(
            'id' => $id
        );

        $data = $this->DataModels->update($where, $data, 'tbl_detail_barang');
        echo json_encode($data);
    }

    function updatepenjualan()
    {
        $idRiwayat = $this->input->post('idRiwayat');
        $idDetailBarang = $this->input->post('idDetailBarang');
        $banyak = $this->input->post('banyak');
        $tanggalKeluar = $this->input->post('tanggalKeluar');

        $keterangan = $this->input->post('keterangan');

        $data  = [
            'id_detail_barang' => $idDetailBarang,
            'banyak' => $banyak,


            'tanggal_keluar' => fdate_ind_to_eng($tanggalKeluar),
            'keterangan' => $keterangan
        ];

        $where = array(
            'id_riwayat' => $idRiwayat
        );

        $data = $this->DataModels->update($where, $data, 'tbl_riwayat');
        echo json_encode($data);
    }

    function get_code_po()
    {
        $code = $this->CodeModels->create_code_po();
        echo json_encode($code);
    }

    function get_code_riwayat()
    {
        $code = $this->CodeModels->create_code_riwayat();
        echo json_encode($code);
    }

    function get_code_faktur()
    {
        $code = $this->CodeModels->create_code_faktur();
        echo json_encode($code);
    }

    function get_code_barang()
    {
        $code = $this->CodeModels->create_code_barang();
        echo json_encode($code);
    }

    function get_barang()
    {
        $kobar = $this->input->get('id');
        $data = $this->DataModels->get_barang_by_kode($kobar);

        echo json_encode($data);
    }
    function get_toko_by_barang()
    {
        $kobar = $this->input->get('id');

        $data = $this->DataModels->get_toko_by_produk($kobar)->result();

        if (!empty($data)) {
            foreach ($data as $result) {
                $value[] = $result->id_toko;
            }

            echo json_encode($value);
        }
    }
    function get_detail()
    {
        $kobar = $this->input->get('id');
        $data = $this->DataModels->get_detbarang_by_kode($kobar);
        echo json_encode($data);
    }

    function get_detail2()
    {
        $id = $this->input->get('id');
        $data = $this->DataModels->get_detbarang_by_kode2($id);
        echo json_encode($data);
    }

    function get_penjualan()
    {
        $kobar = $this->input->get('id');
        $data = $this->DataModels->get_penjualan_by_kode($kobar);
        echo json_encode($data);
    }

    function add_to_cart()
    {
        $kobar = $this->input->post('kode_brg');

        $produk = $this->DataModels->get_barang($kobar);
        $i = $produk->row_array();

        $data = array(
            'id' => $kobar,
            'name' => $i['nama_barang'],
            'nama_brand' => $this->input->post('nama_brandpo'),
            'tanggal' => $this->input->post('tanggalpo'),
            'qty' => $this->input->post('qyt'),
            'id_harga'    => $i['id_harga'],
            'price'    => $i['harga_baru'],
            'options' => array(
                'ket' => $this->input->post('keteranganpo'),
                'ukuran' => strtoupper($this->input->post('ukuranpo')),
                'warna' => strtoupper($this->input->post('warnapo'))
            )
        );


        if (!empty($this->cart->total_items())) {
            foreach ($this->cart->contents() as $items) {
                $id = $items['id'];
                $qtylama = $items['qty'];
                $warna = $this->input->post('warnapo');
                $ukuran = $this->input->post('ukuranpo');

                $rowid = $items['rowid'];
                $kobar = $this->input->post('kode_brg');
                $qty = $this->input->post('qyt');
                $qty = $this->input->post('qyt');
                $ukuran2 = $items['options']['ukuran'];
                $warna2 = $items['options']['warna'];
                if ($id == $kobar && $ukuran == $ukuran2 && $warna == $warna2) {
                    $newqyt = $qtylama + $qty;
                    $up = array(
                        'rowid' => $rowid,
                        'qty' => $newqyt
                    );

                    $this->cart->update($up);
                } else {
                    $this->cart->insert($data);
                }
            }
        } else {
            $this->cart->insert($data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    function remove()
    {
        $row_id = $this->uri->segment(4);
        $this->cart->update(array(
            'rowid'      => $row_id,
            'qty'     => 0
        ));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function destroy()
    {
        $this->cart->destroy();
        redirect($_SERVER['HTTP_REFERER']);
    }
    function simpan_po()
    {
        $this->form_validation->set_rules('nopo', 'Nopo', 'required|trim|xss_clean|is_unique[tbl_detail_barang.no_po]|max_length[40]');

        if ($this->form_validation->run() == false) {
            echo $this->session->set_flashdata('msguniq', '<label class="label label-danger">No Po sudah di gunakan sebelumnya!</label>');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $nopo = $this->input->post('nopo');
            $id_toko =  $this->input->post('id_toko');
            $sp = $this->input->post('sp');
            $manual_sp = $this->input->post('manual_sp');
            $sb = $this->input->post('sb');
            $manual_sb = $this->input->post('manual_sb');

            if ($sp == 'manual') {
                $sp = $manual_sp;
            }
            if ($sb == 'manual') {
                $sb = $manual_sb;
            }
            if (!empty($nopo)) {
                $simpanpo = $this->DataModels->simpan_po($nopo, $sp, $sb, $id_toko);

                if (!empty($manual_sp)) {
                    $data_sp = array('nama_sp' => $manual_sp); //simpan status pengiriman yang baru di inputkan
                    $this->DataModels->create($data_sp, 'tbl_status_pengiriman');
                }
                if (!empty($manual_sb)) {
                    $data_sb = array('nama_sb' => $manual_sb); //simpan status barang yang baru di inputkan
                    $this->DataModels->create($data_sb, 'tbl_status_barang');
                }

                if ($simpanpo) {
                    $this->cart->destroy();
                    echo $this->session->set_flashdata('msgsuccess', '<label class="label label-succes">PO Sudah tersimpan</label>');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo $this->session->set_flashdata('msgfiled', '<label class="label label-danger">Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                echo $this->session->set_flashdata('msgfiled', '<label class="label label-danger">Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
