<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StatusBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Status Barang';

        $where = array('data_status' => '1');
        $data['status_barang'] = $this->DataModels->get_where_table($where, 'tbl_status_barang');

        $this->load->view('menu/status/barang/v_barang', $data);
    }

    public function create()
    {
        $nama_sb = $this->input->post('nama_sb');
        $cek_jml_data = $this->db->get_where('tbl_status_barang', ['nama_sb' => $nama_sb, 'data_status' => '1'])->num_rows();

        if($cek_jml_data > 0){
            $this->session->set_flashdata('msguniq','Nama Status Barang sudah ada sebelumnya!');
        }
        else{
            $data = array('nama_sb' => $nama_sb);
            $this->DataModels->create($data, 'tbl_status_barang');
            $this->session->set_flashdata('create', 'Data Status Barang Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        $id_sb = $this->input->post('id_sb');
        $nama_sb = $this->input->post('nama_sb');

        $cek_jml_data = $this->db->get_where('tbl_status_barang', ['nama_sb' => $nama_sb, 'data_status' => '1'])->num_rows();
        $cek_data = $this->db->get_where('tbl_status_barang', ['nama_sb' => $nama_sb, 'data_status' => '1'])->row();

        if(($cek_jml_data > 0) && ($cek_data->id_sb != $id_sb)){
            $this->session->set_flashdata('msguniq','Nama Status sudah ada sebelumnya!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $data = array(
                'nama_sb' => $nama_sb,
            );
            $where = array('id_sb' => $id_sb); 
            $this->DataModels->update($where, $data, 'tbl_status_barang');
            $this->session->set_flashdata('update', 'Data Status barang Berhasil Diperbarui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id_sb)
    {
        $where = array('id_sb' => $id_sb);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_status_barang');
        $this->session->set_flashdata('delete', 'Data Status Barang Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
    
}