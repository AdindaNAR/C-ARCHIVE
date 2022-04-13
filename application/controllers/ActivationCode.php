<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivationCode extends CI_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->model('LoginModels');
    }

	public function index()
	{
		$id_user = 'P00001';
        $status_active = '1';
        $login_attempt = '0';

        $where = array('id_user' => $id_user);

        $data = array(
            'status_active' => $status_active,
            'login_attempt' => $login_attempt
        );

        $this->LoginModels->update($where, $data, 'tbl_user');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation is successful</div>');
        redirect($_SERVER['HTTP_REFERER']);
	}
}
