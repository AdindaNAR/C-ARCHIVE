<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importexcel_barang extends CI_Controller
{
    public $data;

    function __construct()
    {
        parent::__construct();

        $this->load->library('excel');
        $this->load->helper('form' );

        // Call Model
        $this->load->model('DataModels');
        $this->load->model('CodeModels');

        // Access Rights Limiter
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('vimport');
    }

    public function saveimport_multitoko()
    {
        if(isset($_FILES["file"]["name"]))
        {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $date_harga = 'HG'.date('Ymd').'-';
                $cek_kode_harga = $this->db->query("SELECT RIGHT(id_harga, 8) as id_harga FROM tbl_harga where id_harga like '%$date_harga%' ORDER BY id_harga DESC LIMIT 1")->row();
                if(empty($cek_kode_harga->id_harga)){
                    $id_harga_convert_int = 1;
                }
                else{
                    $id_harga_convert_int = intval($cek_kode_harga->id_harga+1);
                }


                $date_diskon = 'DC'.date('Ymd').'-';
                $cek_kode_diskon = $this->db->query("SELECT RIGHT(id_diskon, 8) as id_diskon FROM tbl_diskon where id_diskon like '%$date_diskon%' ORDER BY id_diskon DESC LIMIT 1")->row();
                if(empty($cek_kode_diskon->id_diskon)){
                    $id_diskon_convert_int = 1;
                }
                else{
                    $id_diskon_convert_int = intval($cek_kode_diskon->id_diskon+1);
                }


                $date_cashback = 'CB'.date('Ymd').'-';
                $cek_kode_cashback = $this->db->query("SELECT RIGHT(id_cashback, 8) as id_cashback FROM tbl_cashback where id_cashback like '%$date_cashback%' ORDER BY id_cashback DESC LIMIT 1")->row();
                if(empty($cek_kode_cashback->id_cashback)){
                    $id_cashback_convert_int = 1;
                }
                else{
                    $id_cashback_convert_int = intval($cek_kode_cashback->id_cashback+1);
                } 
                

                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                for($row=3; $row<=$highestRow; $row++) // diambil datanya mulai dari baris ke 3
                {   
                    $id_barang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $id_brand = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $nama_barang = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $deskripsi_barang = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $harga_barang = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $diskon1 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $diskon2 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $diskon3 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $diskon4 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $diskon5 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $diskon6 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $diskon7 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $diskon8 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $diskon9 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $diskon10 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    $cashback1 = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                    $cashback2 = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                    $cashback3 = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                    $cashback4 = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                    $cashback5 = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                    $cashback6 = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                    $cashback7 = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                    $cashback8 = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                    $cashback9 = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                    $cashback10 = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                    $harga_akhir = ($harga_barang*(1-$diskon1/100)*(1-$diskon2/100)*(1-$diskon3/100)*(1-$diskon4/100)*(1-$diskon5/100)*(1-$diskon6/100)*(1-$diskon7/100)*(1-$diskon8/100)*(1-$diskon9/100)*(1-$diskon10/100))-($cashback1+$cashback2+$cashback3+$cashback4+$cashback5+$cashback6+$cashback7+$cashback8+$cashback9+$cashback10); // OPERASI PERHITUNGAN DIKON DAN CASHBACK

                    $diskon = [$diskon1,$diskon2,$diskon3,$diskon4,$diskon5,$diskon6,$diskon7,$diskon8,$diskon9,$diskon10];                    
                    $cashback = [$cashback1,$cashback2,$cashback3,$cashback4,$cashback5,$cashback6,$cashback7,$cashback8,$cashback9,$cashback10];                               

                    $data[] = array(
                        'id_barang' => $id_barang,
                        'id_brand' => $id_brand,
                        'nama_barang' => $nama_barang,
                        'deskripsi_barang' => $deskripsi_barang,
                        'harga_akhir' => $harga_akhir
                    );

                    
                    $id_harga_baru = str_pad($id_harga_convert_int++, 8, "0", STR_PAD_LEFT);
                    $id_harga = $date_harga.$id_harga_baru;

                    $data_harga[] = array(
                        'id_harga' => $id_harga,
                        'id_barang' => $id_barang,
                        'harga_lama' => 0,
                        'harga_baru' => $harga_barang
                    );


                    $id_diskon_baru = str_pad($id_diskon_convert_int++, 8, "0", STR_PAD_LEFT);
                    $id_diskon = $date_diskon.$id_diskon_baru;

                    foreach ($diskon as $key => $val) {
                        if(!empty($diskon[$key])){
                            $data_diskon[] = array(             
                                'id_diskon' => $id_diskon,
                                'id_barang' => $id_barang,
                                'persentase' => $diskon[$key],
                                'order_data' => $key + 1,
                            );      
                        }
                    }

                    if(empty($diskon1)){
                        $diskon1 = '';
                    }
                    else{
                        $diskon1 = $diskon1.'%+';
                    }

                    if(empty($diskon2)){
                        $diskon2 = '';
                    }
                    else{
                        $diskon2 = $diskon2.'%+';
                    }

                    if(empty($diskon3)){
                        $diskon3 = '';
                    }
                    else{
                        $diskon3 = $diskon3.'%+';
                    }

                    if(empty($diskon4)){
                        $diskon4 = '';
                    }
                    else{
                        $diskon4 = $diskon4.'%+';
                    }

                    if(empty($diskon5)){
                        $diskon5 = '';
                    }
                    else{
                        $diskon5 = $diskon5.'%+';
                    }

                    if(empty($diskon6)){
                        $diskon6 = '';
                    }
                    else{
                        $diskon6 = $diskon6.'%+';
                    }

                    if(empty($diskon7)){
                        $diskon7 = '';
                    }
                    else{
                        $diskon7 = $diskon7.'%+';
                    }

                    if(empty($diskon8)){
                        $diskon8 = '';
                    }
                    else{
                        $diskon8 = $diskon8.'%+';
                    }

                    if(empty($diskon9)){
                        $diskon9 = '';
                    }
                    else{
                        $diskon9 = $diskon9.'%+';
                    }

                    if(empty($diskon10)){
                        $diskon10 = '';
                    }
                    else{
                        $diskon10 = $diskon10.'%+';
                    }

                    $ddiskon = $diskon1.$diskon2.$diskon3.$diskon4.$diskon5.$diskon6.$diskon7.$diskon8.$diskon9.$diskon10;

                    $data_desc_diskon[] = array(
                        'id_barang' => $id_barang,
                        'diskon' => $ddiskon
                    );


                    $id_cashback_baru = str_pad($id_cashback_convert_int++, 8, "0", STR_PAD_LEFT);    
                    $id_cashback = $date_cashback.$id_cashback_baru;

                    foreach ($cashback as $key_cb => $val) {
                        if(!empty($cashback[$key_cb])){
                            $data_cashback[] = array(             
                                'id_cashback' => $id_cashback,
                                'id_barang' => $id_barang,
                                'nominal' => $cashback[$key_cb],
                                'order_data' => $key_cb + 1,
                            );       
                        }
                    }

                    if(empty($cashback1)){
                        $cashback1 = '';
                    }
                    else{
                        $cashback1 = 'Rp. '.number_format($cashback1).' + ';
                    }

                    if(empty($cashback2)){
                        $cashback2 = '';
                    }
                    else{
                        $cashback2 = 'Rp. '.number_format($cashback2).' + ';
                    }

                    if(empty($cashback3)){
                        $cashback3 = '';
                    }
                    else{
                        $cashback3 = 'Rp. '.number_format($cashback3).' + ';
                    }

                    if(empty($cashback4)){
                        $cashback4 = '';
                    }
                    else{
                        $cashback4 = 'Rp. '.number_format($cashback4).' + ';
                    }

                    if(empty($cashback5)){
                        $cashback5 = '';
                    }
                    else{
                        $cashback5 = 'Rp. '.number_format($cashback5).' + ';
                    }

                    if(empty($cashback6)){
                        $cashback6 = '';
                    }
                    else{
                        $cashback6 = 'Rp. '.number_format($cashback6).' + ';
                    }

                    if(empty($cashback7)){
                        $cashback7 = '';
                    }
                    else{
                        $cashback7 = 'Rp. '.number_format($cashback7).' + ';
                    }

                    if(empty($cashback8)){
                        $cashback8 = '';
                    }
                    else{
                        $cashback8 = 'Rp. '.number_format($cashback8).' + ';
                    }

                    if(empty($cashback9)){
                        $cashback9 = '';
                    }
                    else{
                        $cashback9 = 'Rp. '.number_format($cashback9).' + ';
                    }

                    if(empty($cashback10)){
                        $cashback10 = '';
                    }
                    else{
                        $cashback10 = 'Rp. '.number_format($cashback10).' + ';
                    }

                    $ccashback = $cashback1.$cashback2.$cashback3.$cashback4.$cashback5.$cashback6.$cashback7.$cashback8.$cashback9.$cashback10;

                    $data_desc_cashback[] = array(
                        'id_barang' => $id_barang,
                        'cashback' => $ccashback
                    );

                    $where = array('data_status' => '1');
                    $toko = $this->DataModels->get_where_table($where, 'tbl_toko');
                    foreach($toko as $u){
                        $data_toko[] = array(             
                            'id_barang' => $id_barang,
                            'id_toko' => $u->id_toko
                        );
                    }

                    $data_barang_update[] = array(
                        'id_barang' => $id_barang,
                        'id_harga' => $id_harga,
                        'id_diskon' => $id_diskon,
                        'id_cashback' => $id_cashback
                    );
                    

                    $cek = $this->DataModels->cek_data("tbl_barang",array('id_barang' => $id_barang, 'data_status'=>1))->num_rows();
                
                    if($cek > 0){
                        $this->session->set_flashdata('gagal_tambah', 'Data Barang Gagal Ditambahkan! Duplikasi Data!');
                        redirect($_SERVER['HTTP_REFERER']); //LINK UNTUK KEMBALI KE HALAMAN SEBELUMNYA SEBELUM USER AKSES CONTROLLER
                    }
            
                }
            }


            $this->DataModels->insertimport($data,$data_harga,$data_diskon,$data_cashback,$data_toko,$data_barang_update, $data_desc_diskon,$data_desc_cashback);

            $this->session->set_flashdata('berhasil_tambah', 'Data Barang Berhasil Ditambahkan!');
            redirect($_SERVER['HTTP_REFERER']); //LINK UNTUK KEMBALI KE HALAMAN SEBELUMNYA SEBELUM USER AKSES CONTROLLER
        }                

    }
}