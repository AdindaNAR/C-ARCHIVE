<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsProfile extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();
    }
    
    public function index()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim', [
            'required' => 'Nama Lengkap Harap diisi!'
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim', [
            'required' => 'Email Harap diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Profile';

            $this->load->view('menu/settings/v_profile', $data);
        } else {
            $this->_update();
        }
    }

    private function _update()
    {
        $id_user = $this->session->userdata('id_user');
        $_id = $this->db->get_where('tbl_user', ['id_user' => $id_user])->row();
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $image_files = $_FILES['image']['name'];

        if ($image_files) {
            $config['file_name'] = $id_user;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']     = 1024;
            $config['upload_path'] = './assets/images/profile/';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $gbr = $this->upload->data();

                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/images/profile/'.$gbr['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '100%';
                $config['width'] = 512;
                $config['height'] = 512;
                $config['new_image'] = './assets/images/profile/'.$gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $image_files = $gbr['file_name'];

                $where = array(
                    'id_user' => $id_user
                );

                $data = array(
                    'nama' => $nama,
                    'email' => $email,
                    'file_gambar' => "assets/images/profile/".$image_files
                );

                $query = $this->db->update('tbl_user', $data, $where);

                if ($query) {
                    unlink($_id->file_gambar);
                }

                $this->session->set_flashdata('update', 'Profile Berhasil diperbarui!');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                // $this->session->set_flashdata('error', $this->upload->display_errors());
                $this->session->set_flashdata('error', 'Format Gambar yang Anda unggah tidak diperbolehkan.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } elseif (empty($image_files)) {
            $where = array(
                'id_user' => $id_user
            );

            $data = array(
                'nama' => $nama,
                'email' => $email
            );

            $query = $this->DataModels->update($where, $data, 'tbl_user');

            $this->session->set_flashdata('update', 'Profile Berhasil Diupdate!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}