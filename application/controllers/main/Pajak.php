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

    public function rekap_pajak($id_wajib_pajak)
    {
        $role = $this->db->get_where('tbl_role', array('id_role' => $this->session->userdata('id_role'), 'data_status' => '1'))->row();

        $where = array(
                        'data_status' => '1',
                        'id_wajib_pajak' => $id_wajib_pajak,
                    );

        $data['title'] = 'Data Pajak - '.$role->name_role;
        $data['code'] = $this->CodeModels->create_code_pajak();
        $data['tbl_wajib_pajak'] = $this->DataModels->get_where_table($where, 'tbl_wajib_pajak');
        $data['tbl_pajak'] = $this->DataModels->get_where_table($where, 'tbl_pajak');
        
        $this->load->view('main/pajak/v_pajak', $data);
    }

    public function create_pajak(){
        $id_pajak = $this->input->post('id_pajak');
        $id_wajib_pajak = $this->input->post('id_wajib_pajak');
        $npbp_swh_bumi = $this->input->post('npbp_swh_bumi');
        $kls_desa_swh_bumi = $this->input->post('kls_desa_swh_bumi');
        $kls_nasional_swh_bumi = $this->input->post('kls_nasional_swh_bumi');
        $luas_swh_bumi = $this->input->post('luas_swh_bumi');
        $pajak_swh_bumi = $this->input->post('pajak_swh_bumi');
        $npbp_drt_bumi = $this->input->post('npbp_drt_bumi');
        $kls_desa_drt_bumi = $this->input->post('kls_desa_drt_bumi');
        $kls_nasional_drt_bumi = $this->input->post('kls_nasional_drt_bumi');
        $luas_drt_bumi = $this->input->post('luas_drt_bumi');
        $pajak_drt_bumi = $this->input->post('pajak_drt_bumi');
        $dbpn_bgn = $this->input->post('dbpn_bgn');
        $gol_kelas_bgn = $this->input->post('gol_kelas_bgn');
        $luas_bgn = $this->input->post('luas_bgn');
        $pajak_bgn = $this->input->post('pajak_bgn');
        $mutasi = $this->input->post('mutasi');
        $log_user = $this->session->userdata('id_user');

        if(empty($npbp_swh_bumi) && empty($kls_desa_swh_bumi) && empty($kls_nasional_swh_bumi) && empty($luas_swh_bumi) && empty($pajak_swh_bumi) && empty($npbp_drt_bumi) && empty($kls_desa_drt_bumi) && empty($kls_nasional_drt_bumi) && empty($luas_drt_bumi) && empty($pajak_drt_bumi) && empty($dbpn_bgn) && empty($gol_kelas_bgn) && empty($luas_bgn) && empty($pajak_bgn) && empty($mutasi)){
            $this->session->set_flashdata('msguniq','Data Pajak gagal ditambahkan, karena form inputan masih kosong!');
        }
        else{
            $data = array(
                'id_pajak' => $id_pajak,
                'id_wajib_pajak' => $id_wajib_pajak,
                'npbp_swh_bumi' => $npbp_swh_bumi,
                'kls_desa_swh_bumi' => $kls_desa_swh_bumi,
                'kls_nasional_swh_bumi' => $kls_nasional_swh_bumi,
                'luas_swh_bumi' => $luas_swh_bumi,
                'pajak_swh_bumi' => $pajak_swh_bumi,
                'npbp_drt_bumi' => $npbp_drt_bumi,
                'kls_desa_drt_bumi' => $kls_desa_drt_bumi,
                'kls_nasional_drt_bumi' => $kls_nasional_drt_bumi,
                'luas_drt_bumi' => $luas_drt_bumi,
                'pajak_drt_bumi' => $pajak_drt_bumi,
                'dbpn_bgn' => $dbpn_bgn,
                'gol_kelas_bgn' => $gol_kelas_bgn,
                'luas_bgn' => $luas_bgn,
                'pajak_bgn' => $pajak_bgn,
                'mutasi' => $mutasi,
                'log_user' => $log_user
            );
            $this->DataModels->create($data, 'tbl_pajak');
            $this->session->set_flashdata('create', 'Data Pajak Berhasil Ditambahkan!');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_pajak(){
        $id_pajak = $this->input->post('id_pajak');
        $id_wajib_pajak = $this->input->post('id_wajib_pajak');
        $npbp_swh_bumi = $this->input->post('npbp_swh_bumi');
        $kls_desa_swh_bumi = $this->input->post('kls_desa_swh_bumi');
        $kls_nasional_swh_bumi = $this->input->post('kls_nasional_swh_bumi');
        $luas_swh_bumi = $this->input->post('luas_swh_bumi');
        $pajak_swh_bumi = $this->input->post('pajak_swh_bumi');
        $npbp_drt_bumi = $this->input->post('npbp_drt_bumi');
        $kls_desa_drt_bumi = $this->input->post('kls_desa_drt_bumi');
        $kls_nasional_drt_bumi = $this->input->post('kls_nasional_drt_bumi');
        $luas_drt_bumi = $this->input->post('luas_drt_bumi');
        $pajak_drt_bumi = $this->input->post('pajak_drt_bumi');
        $dbpn_bgn = $this->input->post('dbpn_bgn');
        $gol_kelas_bgn = $this->input->post('gol_kelas_bgn');
        $luas_bgn = $this->input->post('luas_bgn');
        $pajak_bgn = $this->input->post('pajak_bgn');
        $mutasi = $this->input->post('mutasi');
        $log_user = $this->session->userdata('id_user');

        if(empty($npbp_swh_bumi) && empty($kls_desa_swh_bumi) && empty($kls_nasional_swh_bumi) && empty($luas_swh_bumi) && empty($pajak_swh_bumi) && empty($npbp_drt_bumi) && empty($kls_desa_drt_bumi) && empty($kls_nasional_drt_bumi) && empty($luas_drt_bumi) && empty($pajak_drt_bumi) && empty($dbpn_bgn) && empty($gol_kelas_bgn) && empty($luas_bgn) && empty($pajak_bgn) && empty($mutasi)){
            $this->session->set_flashdata('msguniq','Data Pajak gagal diupdate, karena form inputan masih kosong!');
        }
        else{
            $where = array('id_pajak' => $id_pajak);

            $data = array(
                'id_wajib_pajak' => $id_wajib_pajak,
                'npbp_swh_bumi' => $npbp_swh_bumi,
                'kls_desa_swh_bumi' => $kls_desa_swh_bumi,
                'kls_nasional_swh_bumi' => $kls_nasional_swh_bumi,
                'luas_swh_bumi' => $luas_swh_bumi,
                'pajak_swh_bumi' => $pajak_swh_bumi,
                'npbp_drt_bumi' => $npbp_drt_bumi,
                'kls_desa_drt_bumi' => $kls_desa_drt_bumi,
                'kls_nasional_drt_bumi' => $kls_nasional_drt_bumi,
                'luas_drt_bumi' => $luas_drt_bumi,
                'pajak_drt_bumi' => $pajak_drt_bumi,
                'dbpn_bgn' => $dbpn_bgn,
                'gol_kelas_bgn' => $gol_kelas_bgn,
                'luas_bgn' => $luas_bgn,
                'pajak_bgn' => $pajak_bgn,
                'mutasi' => $mutasi,
                'log_user' => $log_user
            );

            $this->DataModels->update($where, $data, 'tbl_pajak');
            $this->session->set_flashdata('update', 'Data Pajak Berhasil Diperbarui!');
        }
            redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_pajak($id_pajak){
        $where = array('id_pajak' => $id_pajak);
        $data = array('data_status' => '0');
        $this->DataModels->update($where, $data, 'tbl_pajak');
        $this->session->set_flashdata('delete', 'Data Pajak Berhasil Dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
}