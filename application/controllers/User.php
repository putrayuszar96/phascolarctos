<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public $data = array();

	public function __construct()
    {
        parent::__construct();
        
        // if(!isset($_SESSION['login'])){
        //     redirect('Auth');
        // }

        $this->data['scripts'] = [
            'https://code.jquery.com/jquery-3.6.0.min.js',
            'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js',
            'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js'
        ];

        $this->data['controller'] = "User";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'User - ARIP System',
            'id_page' => 'user_index',
            'name' => 'Daftar Pegawai'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'user'), true);
        $this->data['body'] = $this->load->view('dashboard/user/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}
}