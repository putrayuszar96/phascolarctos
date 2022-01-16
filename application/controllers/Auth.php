<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public $data = array();

	public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        if(isset($_SESSION['login'])){
            redirect('Barang');
        }
        $this->data['title'] = 'ARIP System';
        $this->load->view('auth/index', $this->data);
	}

    public function do_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->model('User_model');

        $cek_login = $this->User_model->cek_login($email, $password);

        if($cek_login['status'] == 'ok'){
            $session_data = [
                'login' => true,
                'id' => $cek_login['data']['id'],
                'username' => $cek_login['data']['username'],
                'divisi' => $cek_login['data']['id_divisi'],
                'nama_lengkap' => $cek_login['data']['nama_lengkap'],
            ];

            $this->session->set_userdata($session_data);

            echo json_encode(['status' => 'ok', 'data' => $cek_login, 'message' => 'Login berhasil!']);
        }else{
            echo json_encode(['status' => 'error', 'data' => $cek_login, 'message' => $cek_login['data']]);
        }
    }

    public function do_logout()
    {
        $this->session->sess_destroy();

        redirect('Auth');
    }

    public function seed(){
        $email = $this->input->get('email');
        $username = $this->input->get('username');
        $password = $this->input->get('password');

        $data_post = array(
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        );

        $this->load->model('User_model');
        
        $do_register = $this->User_model->do_register($data_post);

        if($do_register){
            echo $email . " " . $username . " berhasil ditambahkan";
        }else{
            echo "Gagal ditambahkan!";
        }
    }
}
