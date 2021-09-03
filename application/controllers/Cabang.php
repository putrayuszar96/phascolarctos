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
            'https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js',
            'https://cdn.jsdelivr.net/npm/jquery-easy-loading@1.3.0/dist/jquery.loading.min.js'
        ];

        $this->data['controller'] = "User";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Cabang - ARIP System',
            'id_page' => 'cabang_index',
            'name' => 'Kantor Cabang'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'cabang'), true);
        $this->data['body'] = $this->load->view('dashboard/cabang/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function list()
    {
        $this->load->model('User_model');
        $raw_result = $this->User_model->get_data();
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama_lengkap' => $rr['nama_lengkap'],
                'nama_cabang' => $rr['nama_cabang'],
                'nama_divisi' => $rr['nama_divisi'],
                'status' => $rr['status'],
                'action' => [
                    'id' => $rr['id'],
                    'username' => $rr['username']
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

    public function add_user_form()
    {
        $this->load->model('Config_model');
        $data = array(
            'cabang' => $this->Config_model->get_cabang(),
            'divisi' => $this->Config_model->get_divisi()
        );

        $pages = $this->load->view('dashboard/user/add', $data, true);

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