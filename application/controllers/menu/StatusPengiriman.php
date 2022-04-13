<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StatusPengiriman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Status Pengiriman';
        $where = array('data_status' => '1');
        $data['status_pengiriman'] = $this->DataModels->get_where_table($where, 'tbl_status_pengiriman');

        $this->load->view('menu/status/pengiriman/v_pengiriman', $data);
    }

    public function create()
    {
        $nama_sp = $this->input->post('nama_sp');
        $cek_jml_data = $this->db->get_where('tbl_status_pengiriman', ['nama_sp' => $nama_sp, 'data_status' => '1'])->num_rows();

        if($cek_jml_data > 0){
            $this->session->set_flashdata('msguniq','Nama Status Pengiriman sudah ada sebelumnya!');
        }
        else{
            $data = array('nama_sp' => $nama_sp);
            $this->DataModels->create($data, 'tbl_status_pengiriman');
            $this->session->set_flashdata('create', 'Data Status Pengiriman Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        $id_sp = $this->input->post('id_sp');
        $nama_sp = $this->input->post('nama_sp');

        $cek_jml_data = $this->db->get_where('tbl_status_pengiriman', ['nama_sp' => $nama_sp, 'data_status' => '1'])->num_rows();
        $cek_data = $this->db->get_where('tbl_status_pengiriman', ['nama_sp' => $nama_sp, 'data_status' => '1'])->row();

        if(($cek_jml_data > 0) && ($cek_data->id_sp != $id_sp)){
            $this->session->set_flashdata('msguniq','Nama Status sudah ada sebelumnya!');
        }
        else{
            $data = array('nama_sp' => $nama_sp);
            $where = array('id_sp' => $id_sp); 
            $this->DataModels->update($where, $data, 'tbl_status_pengiriman');
            $this->session->set_flashdata('update', 'Data Status Pengiriman Berhasil Diperbarui!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id_sp)
    {
        $where = array('id_sp' => $id_sp);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_status_pengiriman');
        $this->session->set_flashdata('delete', 'Data Status Pengiriman Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
    
}