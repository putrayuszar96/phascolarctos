<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller {
    public $data = array();

	public function __construct()
    {
        parent::__construct();
        
        if($_SESSION['login'] != TRUE || !isset($_SESSION['login'])){
            redirect('Auth');
        }

        $this->data['scripts'] = [
            'https://code.jquery.com/jquery-3.6.0.min.js',
            'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js',
            'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js',
            'https://cdn.jsdelivr.net/npm/jquery-easy-loading@1.3.0/dist/jquery.loading.min.js',
            'https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js'
        ];

        $this->data['controller'] = "Kantor Cabang";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Cabang - ARIP System',
            'id_page' => 'cabang_index',
            'name' => 'Daftar Kantor Cabang'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'cabang'), true);
        $this->data['body'] = $this->load->view('dashboard/cabang/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function list()
    {
        $this->load->model('Cabang_model');
        $raw_result = $this->Cabang_model->get_list();
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama' => $rr['nama'],
                'alamat' => $rr['alamat'],
                'jumlah_divisi' => $rr['jumlah_divisi'],
                'action' => [
                    'id_ai_cabang' => $rr['id_ai_cabang'],
                    'id_cabang' => $rr['id_cabang']
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

    public function add_cabang_form()
    {
        $pages = $this->load->view('dashboard/cabang/add', array(), true);

        echo json_encode(['body' => $pages]);
    }

    public function add_cabang_process()
    {
        $this->load->model('Cabang_model');
        $cabang_terakhir = $this->Cabang_model->get_latest_id();
        
        if($cabang_terakhir == NULL){
            $cabang_terakhir = 0;
        }

        $id_cabang = "CAB". sprintf("%03d", ($cabang_terakhir+1));
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');

        $data_post = array(
            'id_cabang' => $id_cabang,
            'nama' => $nama,
            'alamat' => $alamat
        );
        
        $do_add = $this->Cabang_model->do_add($data_post);

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

    public function delete()
    {
        $id = $this->uri->segment(3);

        $this->load->model('Cabang_model');
        $hapus = $this->Cabang_model->delete($id);

        if($hapus == true){
            echo json_encode(['isConfirmed' => true, 'message' => 'Berhasil dihapus']);
        }else{
            echo json_encode(['isConfirmed' => false, 'message' => 'Gagal dihapus']);
        }
    }
}