<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pajak extends CI_Controller
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
        $role = $this->db->get_where('tbl_role', array('id_role' => $this->session->userdata('id_role'), 'data_status' => '1'))->row();

        $where = array('data_status' => '1');

        $data['title'] = 'Wajib Pajak - '.$role->name_role;
        // $data['code'] = $this->CodeModels->create_code_brand();
        $data['code'] = $this->CodeModels->create_code_wajib_pajak();
        $data['tbl_wajib_pajak'] = $this->DataModels->get_where_table($where, 'tbl_wajib_pajak');
        
        $this->load->view('main/pajak/v_wajib_pajak', $data);
    }

    public function create_wajib_pajak(){
        $id_wajib_pajak = $this->input->post('id_wajib_pajak');
        $nama_wajib_pajak = $this->input->post('nama_wajib_pajak');
        $alamat = $this->input->post('alamat');

        $cek_jml_data = $this->db->get_where('tbl_wajib_pajak', ['nama_wajib_pajak' => $nama_wajib_pajak, 'alamat' => $alamat, 'data_status' => '1'])->num_rows();

        if($cek_jml_data > 0){
            $this->session->set_flashdata('msguniq','Nama Wajib Pajak dengan alamat yang sama sudah ada sebelumnya!');
        }
        else{
            $data = array(
                'id_wajib_pajak' => $id_wajib_pajak,
                'nama_wajib_pajak' => $nama_wajib_pajak,
                'alamat' => $alamat
            );
            $this->DataModels->create($data, 'tbl_wajib_pajak');
            $this->session->set_flashdata('create', 'Data Wajib Pajak Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_wajib_pajak(){
        $id_wajib_pajak = $this->input->post('id_wajib_pajak');
        $nama_wajib_pajak = $this->input->post('nama_wajib_pajak');
        $alamat = $this->input->post('alamat');

        $cek_jml_data = $this->db->get_where('tbl_wajib_pajak', ['nama_wajib_pajak' => $nama_wajib_pajak, 'alamat' => $alamat, 'data_status' => '1'])->num_rows();
        $cek_data = $this->db->get_where('tbl_wajib_pajak', ['nama_wajib_pajak' => $nama_wajib_pajak, 'alamat' => $alamat, 'data_status' => '1'])->row();

        if(($cek_jml_data > 0) && ($cek_data->id_wajib_pajak != $id_wajib_pajak)){
            $this->session->set_flashdata('msguniq','Nama Wajib Pajak dengan alamat yang sama sudah ada sebelumnya!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $where = array('id_wajib_pajak' => $id_wajib_pajak);

            $data = array(
                'nama_wajib_pajak' => $nama_wajib_pajak,
                'alamat' => $alamat
            );

            $this->DataModels->update($where, $data, 'tbl_wajib_pajak');
            $this->session->set_flashdata('update', 'Data Wajib Pajak Berhasil Diperbarui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete_wajib_pajak($id_wajib_pajak){
        $where = array('id_wajib_pajak' => $id_wajib_pajak);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_wajib_pajak');
        $this->session->set_flashdata('delete', 'Data Wajib Pajak Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
}