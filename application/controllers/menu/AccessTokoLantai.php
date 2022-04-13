<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AccessTokoLantai extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();
    }

    public function index(){
        $data['title'] = 'Access Toko & Lantai';
        $where_access = array('tbl_access_toko_lantai.data_status' => '1');
        $data['toko_lantai'] = $this->DataModels->get_where_toko_lantai($where_access, 'tbl_access_toko_lantai');
        $where = array('data_status' => '1');
        $data['toko'] = $this->DataModels->get_where_table($where, 'tbl_toko');
        $data['lantai'] = $this->DataModels->get_where_table($where, 'tbl_lantai');
        $this->load->view('menu/access/v_toko_lantai', $data);
    }

    public function create(){
        $id_toko = $this->input->post('id_toko');
        $id_lantai = $this->input->post('id_lantai');

        $data = array(
            'id_toko' => $id_toko,
            'id_lantai' => $id_lantai
        );

        $where = array(
            'id_toko' => $id_toko,
            'id_lantai' => $id_lantai,
            'data_status' => '1'
        );

        $cekdata = $this->db->get_where("tbl_access_toko_lantai", $where)->num_rows();
        
        if ($cekdata == 0) {
            $this->DataModels->create($data, 'tbl_access_toko_lantai');
            $this->session->set_flashdata('create', 'Data Access Toko & Lantai Berhasil Ditambahkan!');
        }
        else{
            $this->session->set_flashdata('failed', 'Data Access Toko & Lantai Sudah Ada!');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update(){
        $id_access_toko = $this->input->post('id_access_toko');
        $id_toko = $this->input->post('id_toko');
        $id_lantai = $this->input->post('id_lantai');

        $where = array('id_access_toko' => $id_access_toko);
        
        $data = array(
            'id_toko' => $id_toko,
            'id_lantai' => $id_lantai
        );

        $where2 = array(
            'id_toko' => $id_toko,
            'id_lantai' => $id_lantai,
            'data_status' => '1'
        );

        $where3 = array(
            'id_access_toko' => $id_access_toko,
            'data_status' => '1'
        );

        $cekdata = $this->DataModels->cek_data("tbl_access_toko_lantai", $where2)->num_rows();

        if ($cekdata == 0) {
            $this->DataModels->update($where, $data, 'tbl_access_toko_lantai');
            $this->session->set_flashdata('update', 'Data Access Toko & Lantai Berhasil Diperbarui!');
        }
        else{
            $cekdata2 = $this->DataModels->cek_data("tbl_access_toko_lantai", $where2)->row();
            $cekdata3 = $this->DataModels->cek_data("tbl_access_toko_lantai", $where3)->row();

            if (($cekdata3->id_toko == $cekdata2->id_toko) && ($cekdata3->id_lantai == $cekdata2->id_lantai)) {
                $this->session->set_flashdata('update', 'Data Access Toko & Lantai tidak diubah !');
            }
            else{
                $this->session->set_flashdata('failed', 'Data Access Toko & Lantai Sudah Ada!');
            }
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id_access_toko)
    {
        $where = array('id_access_toko' => $id_access_toko);
        
        $data = array('data_status' => '0');

        $this->DataModels->update($where, $data, 'tbl_access_toko_lantai');
        $this->session->set_flashdata('delete', 'Data Access Toko & Lantai Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
}