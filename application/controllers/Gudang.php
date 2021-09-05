<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends CI_Controller {
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
            'https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js',
            'https://cdn.jsdelivr.net/npm/jquery-easy-loading@1.3.0/dist/jquery.loading.min.js'
        ];

        $this->data['controller'] = "Gudang";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Gudang - ARIP System',
            'id_page' => 'gudang_index',
            'name' => 'Daftar Gudang'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'gudang'), true);
        $this->data['body'] = $this->load->view('dashboard/gudang/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function list()
    {
        $this->load->model('Rak_model');

        $cabang = $this->input->post('cabang');

        $raw_result = $this->Rak_model->get_rak($cabang);
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama_gudang' => $rr['nama_gudang'],
                'jumlah' => [
                    'level' => $rr['jumlah_level'],
                    'sublevel' => $rr['jumlah_sublevel']
                ],
                'daftar' => $rr['list'],
                'action' => [
                    'id_rak' => $rr['id_rak'],
                ]
            );

            $return_result[] = $return;
        }

        if(count($return_result) > 0){
            echo json_encode(['status' => 'ok', 'data' => $return_result]);
        }else{
            echo json_encode(['status' => 'nodata', 'data' => null]);
        }
    }

    public function add_gudang_form()
    {
        $data = array();

        $pages = $this->load->view('dashboard/gudang/add', $data, true);

        echo json_encode(['body' => $pages]);
    }

    public function add_user_process()
    {
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $cabang = $this->input->post('cabang');
        $divisi = $this->input->post('divisi');
        $status = 1;
        $password = 'kcplangsa123';

        $data_post = array(
            'email' => $email,
            'username' => $username,
            'nama_lengkap' => $nama_lengkap,
            'cabang' => $cabang,
            'divisi' => $divisi,
            'status' => $status,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        );

        $this->load->model('User_model');
        
        $do_register = $this->User_model->do_register($data_post);

        if($do_register){
            echo json_encode(['status' => 'ok']);
        }else{
            echo json_encode(['status' => 'error']);
        }
    }
}