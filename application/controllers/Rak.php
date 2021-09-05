<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rak extends CI_Controller {
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
            'https://cdn.jsdelivr.net/npm/jquery-easy-loading@1.3.0/dist/jquery.loading.min.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
        ];

        $this->data['controller'] = "Rak";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Rak - ARIP System',
            'id_page' => 'rak_index',
            'name' => 'Daftar Rak'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'rak'), true);
        $this->data['body'] = $this->load->view('dashboard/rak/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function list()
    {
        $this->load->model('Rak_model');

        $cabang = $this->input->post('cabang');

        $raw_result = $this->Rak_model->get_rak_milik($cabang);
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama_divisi' => $rr['nama_divisi'],
                'jumlah_rak' => $rr['jumlah_rak'],
                'rak' => $rr['rak_milik'],
                'action' => [
                    'id_rak' => $rr['id'],
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

    public function add_rak_form()
    {
        $this->load->model('Divisi_model');
        $this->load->model('Rak_model');
        $data = array();

        $data = array(
            'value' => $this->input->post('value'),
            'label' => $this->input->post('label'),
        );

        $data['divisi'] = $this->Divisi_model->get_divisi_no_rak($this->input->post('value'));
        $data['gudang'] = $this->Rak_model->get_rak($this->input->post('value'));

        $pages = $this->load->view('dashboard/rak/add', $data, true);

        echo json_encode(['body' => $pages]);
    }

    public function add_rak_form_get_list()
    {
        $this->load->model('Rak_model');

        $id_rak = $this->input->post('id_rak');

        $list = $this->Rak_model->get_rak_id($id_rak);
        $list = explode('##', $list['list']);

        if(count($list) > 0){
            echo json_encode(['status' => 'ok','list' => $list]);
        }else{
            echo json_encode(['status' => 'null','list' => null]);
        }
    }

    public function add_rak_milik_process()
    {
        // die(var_dump($this->input->post()));

        $id_divisi = $this->input->post('id_divisi');
        $id_cabang = $this->input->post('id_cabang');
        $jumlah_rak = count($this->input->post('rak_milik'));
        
        $rak_milik = "";
        $c = 1;

        foreach($this->input->post('rak_milik') as $rak){
            $rak_milik .= $rak;
            
            if($c != $jumlah_rak){
                $rak_milik .= "##";
            }

            $c++;
        }

        $data_post = array(
            'id_divisi' => $id_divisi,
            'id_cabang' => $id_cabang,
            'jumlah_rak' => $jumlah_rak,
            'rak_milik' => $rak_milik
        );

        $this->load->model('Rak_model');
        
        $do_add = $this->Rak_model->do_add_pemilik($data_post);

        if($do_add){
            echo json_encode(['status' => 'ok']);
        }else{
            echo json_encode(['status' => 'error']);
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