<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminOffice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModels');

        is_logged_in();    
    }
    
    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view('main/admin_office/v_dashboard', $data);
    }
}