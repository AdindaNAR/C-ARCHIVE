<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $data['title'] = 'Manajemen User';
        $data['code'] = $this->CodeModels->create_code_user();

        $where_user = array('tbl_user.data_status' => '1', 'tbl_user.id_role !=' => '1');
        $data['tbl_user'] = $this->DataModels->get_where_user($where_user, 'tbl_user');

        $data['role'] = $this->DataModels->get_where_role('tbl_role');

        // $where = array('data_status' => '1');
        // $data['tbl_user'] = $this->DataModels->get_where_table($where, 'tbl_user');

        $this->load->view('menu/user/v_user', $data);
    }

    public function create()
    {
        $id_user = $this->input->post('id_user');
        $id_role = $this->input->post('id_role');

        $nama = htmlspecialchars($this->input->post('nama'));
        $email = htmlspecialchars($this->input->post('email'));
        $password = password_hash('123456789', PASSWORD_DEFAULT);
        $file_gambar = $_FILES['image']['name'];

        $cekdata = $this->DataModels->cek_data("tbl_user", ['email' => $email, 'data_status' => '1'])->num_rows();

        if ($cekdata == 0) {
            // if ($file_gambar) {
            //     $config['file_name'] = $id_user;
            //     $config['allowed_types'] = 'jpg|jpeg|png';
            //     $config['max_size']     = 5120;
            //     $config['upload_path'] = './assets/images/profile/';

            //     $this->load->library('upload', $config);

            //     if ($this->upload->do_upload('image')) {
            //         $image = $this->upload->data();

            //         $config['image_library'] = 'gd2';
            //         $config['source_image'] = './assets/images/profile/' . $image['file_name'];
            //         $config['create_thumb'] = FALSE;
            //         $config['maintain_ratio'] = FALSE;
            //         $config['quality'] = '100%';
            //         $config['width'] = 512;
            //         $config['height'] = 512;
            //         $config['new_image'] = './assets/images/profile/' . $image['file_name'];
            //         $this->load->library('image_lib', $config);
            //         $this->image_lib->resize();

            //         $file_gambar = $image['file_name'];

            $data = array(
                'id_user' => $id_user,
                'id_role' => $id_role,
                'nama' => $nama,
                'email' => $email,
                'password' => $password,
                'status_active' => '1',
                'file_gambar' => "assets/images/default/default.png"
            );

            $this->DataModels->create($data, 'tbl_user');
            $this->session->set_flashdata('create', 'Data Pengguna berhasil ditambahkan!');
            redirect($_SERVER['HTTP_REFERER']);
            // } else {
            //     $msg_errornya = $this->upload->display_errors();
            //     $this->session->set_flashdata('failed', $msg_errornya);
            //     redirect($_SERVER['HTTP_REFERER']);
            // }
            // }
        } else {
            $this->session->set_flashdata('failed', 'Email Sudah Terdaftar!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function update()
    {
        $id_user = $this->input->post('id_user');
        $id_role = $this->input->post('id_role');

        $nama = htmlspecialchars($this->input->post('nama'));
        $email = htmlspecialchars($this->input->post('email'));

        $where = array(
            'id_user' => $id_user
        );

        $data = array(
            'id_role' => $id_role,
            'nama' => $nama,
            'email' => $email,
        );

        $where2 = array(
            'email' => $email,
            'data_status' => '1'
        );

        $where3 = array(
            'id_user' => $id_user,
            'data_status' => '1'
        );

        $cekdata = $this->DataModels->cek_data("tbl_user", $where2)->num_rows();

        if ($cekdata == 0) {
            $query = $this->DataModels->update($where, $data, 'tbl_user');
            $this->session->set_flashdata('update', 'Data Pengguna berhasil diperbarui');
        } else {
            $cekdata2 = $this->DataModels->cek_data("tbl_user", $where2)->row();
            $cekdata3 = $this->DataModels->cek_data("tbl_user", $where3)->row();

            if ($cekdata3->email == $cekdata2->email) {
                $this->session->set_flashdata('update', 'Data Pengguna tidak diubah !');
            } else {
                $this->session->set_flashdata('failed', 'Email Sudah Terdaftar!');
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_password()
    {
        $id_user = $this->input->post('id_user');
        $new_password = $this->input->post('new_password');
        $repeat_password = $this->input->post('repeat_password');

        if ($new_password == $repeat_password) {
            $data = array(
                'password' => password_hash($new_password, PASSWORD_DEFAULT)
            );

            $test = $this->DataModels->update(array('id_user' => $id_user), $data, 'tbl_user');

            $this->session->set_flashdata('update', 'Password Pengguna berhasil diperbarui');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('failed', 'Password Pengguna gagal diperbarui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function update_status($id_user, $status_active)
    {
        if ($status_active == '0') {
            $status_active = '1';
        } else {
            $status_active = '0';
        }

        $where = array(
            'id_user' => $id_user
        );

        $data = array(
            'status_active' => $status_active
        );

        $query = $this->DataModels->update($where, $data, 'tbl_user');
        $this->session->set_flashdata('update', 'Status Pengguna berhasil diperbarui!');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id_user)
    {
        $where = array('id_user' => $id_user);

        $data = array('data_status' => '0');

        $this->DataModels->update($where, $data, 'tbl_user');
        $this->session->set_flashdata('delete', 'Data Pengguna berhasil dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
}
