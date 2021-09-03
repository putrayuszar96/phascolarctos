<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {
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

        $this->data['controller'] = "Divisi";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Divisi - ARIP System',
            'id_page' => 'divisi_index',
            'name' => 'Daftar Divisi'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'divisi'), true);
        $this->data['body'] = $this->load->view('dashboard/divisi/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function list()
    {
        $this->load->model('Divisi_model');

        $cabang = $this->input->post('cabang');

        $raw_result = $this->Divisi_model->get_divisi($cabang);
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama' => $rr['nama'],
                'jumlah_pegawai' => $rr['jumlah_pegawai'],
                'nama_cabang' => $rr['nama_cabang'],
                'action' => [
                    'id_ai_divisi' => $rr['id_ai_divisi'],
                    'id_divisi' => $rr['id_divisi']
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

    public function add_divisi_form()
    {
        $data = array(
            'value' => $this->input->post('value'),
            'label' => $this->input->post('label'),
        );

        $pages = $this->load->view('dashboard/divisi/add', $data, true);

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