<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lantai extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('DataModels');
        $this->load->model('CodeModels');

        is_logged_in();
    }

    public function index(){
        $data['title'] = 'Management Lantai';
        $data['code'] = $this->CodeModels->create_code_lantai();

        $where = array('data_status' => '1');
        $data['lantai'] = $this->DataModels->get_where_table($where, 'tbl_lantai');

        $this->load->view('menu/lantai/v_lantai', $data);
    }

    public function create(){     
        $id_lantai = $this->input->post('id_lantai');
        $nama_lantai = $this->input->post('nama_lantai');
        $cek_jml_data = $this->db->get_where('tbl_lantai', ['nama_lantai' => $nama_lantai, 'data_status' => '1'])->num_rows();

        if($cek_jml_data > 0){
            $this->session->set_flashdata('msguniq','Nama Lantai sudah ada sebelumnya!');
        }
        else{
            $data = array(
                'id_lantai' => $id_lantai,
                'nama_lantai' => $nama_lantai
            );
            $this->DataModels->create($data, 'tbl_lantai');
            $this->session->set_flashdata('create', 'Data Lantai Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update(){        
        $id_lantai = $this->input->post('id_lantai');
        $nama_lantai = $this->input->post('nama_lantai');

        $cek_jml_data = $this->db->get_where('tbl_lantai', ['nama_lantai' => $nama_lantai, 'data_status' => '1'])->num_rows();
        $cek_data = $this->db->get_where('tbl_lantai', ['nama_lantai' => $nama_lantai, 'data_status' => '1'])->row();

        if(($cek_jml_data > 0) && ($cek_data->id_lantai != $id_lantai)){
            $this->session->set_flashdata('msguniq','Nama Status sudah ada sebelumnya!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $where = array('id_lantai' => $id_lantai);

            $data = array(
                'nama_lantai' => $nama_lantai,
            );

            $this->DataModels->update($where, $data, 'tbl_lantai');
            $this->session->set_flashdata('update', 'Data Lantai Berhasil Diperbarui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id_lantai){
        $where = array('id_lantai' => $id_lantai);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_lantai');
        $this->session->set_flashdata('delete', 'Data Lantai Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
    
}