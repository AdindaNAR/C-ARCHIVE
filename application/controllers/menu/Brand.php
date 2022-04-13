<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{
    public function __construct(){
        parent::__construct();

        $this->load->model('DataModels');
        $this->load->model('CodeModels');

        is_logged_in();
    }

    public function index(){
        $data['title'] = 'Management Brand';
        $data['code'] = $this->CodeModels->create_code_brand();

        $where = array('data_status' => '1');
        $data['brand'] = $this->DataModels->get_where_table($where, 'tbl_brand');

        $this->load->view('menu/brand/v_brand', $data);
    }

    public function create(){
        $id_brand = $this->input->post('id_brand');
        $nama_brand = $this->input->post('nama_brand');
        $cek_jml_data = $this->db->get_where('tbl_brand', ['nama_brand' => $nama_brand, 'data_status' => '1'])->num_rows();

        if($cek_jml_data > 0){
            $this->session->set_flashdata('msguniq','Nama Brand sudah ada sebelumnya!');
        }
        else{
            $data = array(
                'id_brand' => $id_brand,
                'nama_brand' => $nama_brand
            );
            $this->DataModels->create($data, 'tbl_brand');
            $this->session->set_flashdata('create', 'Data Brand Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update(){
        $id_brand = $this->input->post('id_brand');
        $nama_brand = $this->input->post('nama_brand');

        $cek_jml_data = $this->db->get_where('tbl_brand', ['nama_brand' => $nama_brand, 'data_status' => '1'])->num_rows();
        $cek_data = $this->db->get_where('tbl_brand', ['nama_brand' => $nama_brand, 'data_status' => '1'])->row();

        if(($cek_jml_data > 0) && ($cek_data->id_brand != $id_brand)){
            $this->session->set_flashdata('msguniq','Nama Brand sudah ada sebelumnya!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $where = array('id_brand' => $id_brand);

            $data = array(
                'nama_brand' => $nama_brand,
            );

            $this->DataModels->update($where, $data, 'tbl_brand');
            $this->session->set_flashdata('update', 'Data Brand Berhasil Diperbarui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id_brand){
        $where = array('id_brand' => $id_brand);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_brand');
        $this->session->set_flashdata('delete', 'Data Brand Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
    
}