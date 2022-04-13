<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('DataModels');
        $this->load->model('CodeModels');

        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Manajemen Toko';
        $data['code'] = $this->CodeModels->create_code_toko();
        $where = array('data_status' => '1');
        $data['toko'] = $this->DataModels->get_where_table($where, 'tbl_toko');
        $this->load->view('menu/toko/v_toko', $data);
    }

    public function create()
    {
        $id_toko = $this->input->post('id_toko');
        $nama_toko = $this->input->post('nama_toko');
        $alamat_toko = $this->input->post('alamat_toko');

        // print_r($_POST);
        // exit();

        $cek_jml_data = $this->db->get_where('tbl_toko', ['nama_toko' => $nama_toko, 'data_status' => '1'])->num_rows();

        if($cek_jml_data > 0){
            $this->session->set_flashdata('msguniq','Nama Toko sudah ada sebelumnya!');
        }
        else{
            $data = array(
                'id_toko' => $id_toko,
                'nama_toko' => $nama_toko,
                'alamat_toko' => $alamat_toko
            );
            
            $where = array(
                'data_status' => 1
            );

            $cek_jml_toko = $this->db->get_where('tbl_toko', ['data_status' => '1'])->num_rows();
            $list_barang = $this->db->query("SELECT id_barang from tbl_access_barang_toko WHERE data_status=1 GROUP BY id_barang HAVING COUNT(id_barang)='$cek_jml_toko'")->result();

            foreach($list_barang as $u){
                $data_toko[] = array(             
                    'id_barang' => $u->id_barang,
                    'id_toko' => $id_toko
                );
            }

            $this->DataModels->create($data, 'tbl_toko');
            $this->DataModels->inserttoko($data_toko);
            $this->session->set_flashdata('create', 'Data Toko Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        $id_toko = $this->input->post('id_toko');
        $nama_toko = $this->input->post('nama_toko');
        $alamat_toko = $this->input->post('alamat_toko');

        $cek_jml_data = $this->db->get_where('tbl_toko', ['nama_toko' => $nama_toko, 'data_status' => '1'])->num_rows();
        $cek_data = $this->db->get_where('tbl_toko', ['nama_toko' => $nama_toko, 'data_status' => '1'])->row();

        if(($cek_jml_data > 0) && ($cek_data->id_toko != $id_toko)){
            $this->session->set_flashdata('msguniq','Nama Toko sudah ada sebelumnya!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $where = array('id_toko' => $id_toko);

            $data = array(
                'nama_toko' => $nama_toko,
                'alamat_toko' => $alamat_toko
            );

            $this->DataModels->update($where, $data, 'tbl_toko');
            $this->session->set_flashdata('update', 'Data Toko Berhasil Diperbarui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id_toko)
    {
        $where = array('id_toko' => $id_toko);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_toko');
        $this->session->set_flashdata('delete', 'Data Toko Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
    
}