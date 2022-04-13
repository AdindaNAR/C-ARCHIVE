<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModels');
    }

    public function index()
    {
        // Form Validation Email
        $this->form_validation->set_rules('email', 'Email', 'trim|required', [
            'required' => 'Email harap diisi!'
        ]);

        // Form Validation Password
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password harap diisi!'
        ]);

        // If the Form Validation is executed
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login C-Archive';

            $this->load->view('auth/v_login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        // Input Data
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('tbl_user', ['email LIKE binary' => $email, 'data_status' => '1'])->row_array();

        // Check User Account
        if ($user) {
            $login_user = $this->db->get_where('tbl_user', array('email' => $email, 'data_status' => '1'))->row();

            // Check if the User is Active
            if ($user['status_active'] == '1') {

                // Check Password
                if (password_verify($password, $login_user->password)) {
                    $data = array(
                        'id_user' => $login_user->id_user,
                        'status' => 'Login'
                    );

                    $this->LoginModels->input($data, 'log_history');
                    $last_insert_id = $this->db->insert_id();

                    $data_session = [
                        'id_user' => $login_user->id_user,
                        'nama' => $login_user->nama,
                        'email' => $login_user->email,
                        'password' => $login_user->password,
                        'id_role' => $login_user->id_role,
                        'id_log' => $last_insert_id
                    ];

                    $this->session->set_userdata($data_session);

                    $this->db->update('tbl_user', array('login_attempt' => '0'));

                    // Check what the User Role is .....
                    if ($login_user->id_role == 1) { // SUPERADMIN APP
                        redirect('main/Admin');
                    } elseif ($login_user->id_role == 2) { // MASTER ADMIN DESA
                        redirect('main/AdminOffice');
                    } elseif ($login_user->id_role == 3) { // PENGAWAS
                        redirect('main/AdminOffice');
                    } else { // OPERATOR DESA
                        redirect('main/AdminToko');
                    }
                } else {
                    // Check if the User Login attempts are more than 3
                    if ($login_user->login_attempt >= 3) {
                        $data = array(
                            'status_active' => '0'
                        );

                        $where = array(
                            'id_user' => $login_user->id_user
                        );

                        $this->LoginModels->update($where, $data, 'tbl_user');
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Login Failed! Your account has been blocked, please contact the admin to reactivate it!</div>');
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $data = array(
                            'login_attempt' => $login_user->login_attempt + 1
                        );

                        $where = array(
                            'id_user' => $login_user->id_user
                        );

                        $this->LoginModels->update($where, $data, 'tbl_user');
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password</div>');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Your account is not yet active</div>');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Your account is not registered yet</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function logout()
    {
        $id_user = $this->session->userdata('id_user');
        $id_log = $this->session->userdata('id_log');

        $data = array(
            'id_user' => $id_user,
            'status' => 'Logout'
        );

        $where = array(
            'id_log' => $id_log
        );

        $this->LoginModels->update($where, $data, 'log_history');

        $this->session->sess_destroy();
        redirect('Auth');
    }

    function ping()
    {
        $host = '156.67.209.12';
        $port = 80;
        $timeout = 10;
        $tB = microtime(true);
        $fP = (bool)@fSockOpen($host, $port, $errno, $errstr, $timeout);
        if (!$fP) {
            return "down";
        }
        $tA = microtime(true);
        $hsl = round((($tA - $tB) * 1000), 0) . " Ms";
        if ($hsl > 14) {
            $ping = $hsl;
            $ic   = '<i class="fa fa-wifi" style="color:red;"></i>';
        } else {
            $ping = $hsl;
            $ic   = '<i class="fa fa-wifi" style="color:green;"></i>';
        }
        echo json_encode(array('ping' => $ping, 'ic' => $ic));
    }
}