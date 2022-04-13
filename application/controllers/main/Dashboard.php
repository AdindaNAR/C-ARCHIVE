<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();    
    }
    
    public function index()
    {
        $role = $this->db->get_where('tbl_role', array('id_role' => $this->session->userdata('id_role'), 'data_status' => '1'))->row();

        $data['title'] = 'Dashboard - '.$role->name_role;
        $this->load->view('main/v_dashboard', $data);
    }
}