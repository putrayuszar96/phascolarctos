<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
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

        $this->data['controller'] = "Barang";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Barang - ARIP System',
            'id_page' => 'barang_index',
            'name' => 'Daftar Barang'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'barang'), true);
        $this->data['body'] = $this->load->view('dashboard/barang/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function list()
    {
        $this->load->model('Barang_model');

        $filter = array(
            'cabang' => $this->input->post('cabang'));

        $raw_result = $this->Barang_model->get_barang($filter);
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama_barang' => $rr['nama_barang'],
                'nama_divisi' => $rr['nama_divisi'],
                'lokasi' => $rr['rak_posisi'],
                'uploader' => $rr['nama_uploader'],
                'status' => $rr['status_pinjam'],
                'action' => [
                    'id' => $rr['id_barang'],
                    'uuid' => $rr['uuid_barang'],
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

    public function add_barang_form()
    {
        $this->load->model('Divisi_model');
        $data = array();

        $data = array(
            'value' => $this->input->post('value'),
            'label' => $this->input->post('label'),
        );

        $data['divisi'] = $this->Divisi_model->get_divisi_with_rak($this->input->post('value'));

        $pages = $this->load->view('dashboard/barang/add', $data, true);

        echo json_encode(['body' => $pages]);
    }

    public function add_barang_form_get_rak_list()
    {
        $this->load->model('Rak_model');

        $id_divisi = $this->input->post('id_divisi');

        $list = $this->Rak_model->get_rak_milik_id($id_divisi);
        $list = explode('##', $list['rak_milik']);

        if(count($list) > 0){
            echo json_encode(['status' => 'ok','list' => $list]);
        }else{
            echo json_encode(['status' => 'null','list' => null]);
        }
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