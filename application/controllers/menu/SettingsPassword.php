<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsPassword extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();
    }
    
    public function index()
    {
        $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim', [
            'required' => 'Password Lama Harap diisi!'
        ]);

        $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[8]|matches[repeat_password]', [
            'required' => 'Password Baru Harap diisi!',
            'matches' => 'Password tidak cocok!',
            'min_length' => 'Password minimal 8 Karakter!'
        ]);

        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|trim|min_length[8]|matches[new_password]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password';

            $this->load->view('menu/settings/v_password', $data);
        } else {
            $this->_update();
        }
    }

    private function _update()
    {
        $id_user = $this->session->userdata('id_user');
        $_id = $this->db->get_where('tbl_user', ['id_user' => $id_user])->row();
        $old_password = $this->input->post('old_password');
        // $old_password = "123456789";
        $new_password = $this->input->post('new_password');

        if (!password_verify($old_password, $_id->password)) {
            $this->session->set_flashdata('error', 'Password Lama salah!');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            if ($old_password == $new_password) {
                $this->session->set_flashdata('error', 'Password Baru tidak boleh sama dengan Password Lama!');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $data = array(
                    'password' => $password_hash,
                );

                $where = array(
                    'id_user' => $id_user,
                );

                $this->DataModels->update($where, $data, 'tbl_user');
                $this->session->set_flashdata('update', 'Password Berhasil Diperbarui!');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } 
    }
}