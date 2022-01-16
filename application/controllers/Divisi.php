<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {
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

        $raw_result = $this->Divisi_model->get_divisi();
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama' => $rr['nama'],
                'jumlah_pegawai' => $rr['jumlah_pegawai'],
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

    public function add()
    {
        $this->data['meta'] = [
            'title' => 'Divisi - ARIP System',
            'id_page' => 'divisi_add',
            'name' => 'Tambah Divisi'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'gudang'), true);
        $this->data['body'] = $this->load->view('dashboard/gudang/add', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
    }

    public function add_divisi_process()
    {
        $this->load->model('Divisi_model');

        $nama_divisi = $this->input->Post('nama');

        $jumlah_divisi = $this->Divisi_model->get_divisi_raw();
        $jumlah_divisi = count($jumlah_divisi);

        $id_divisi = sprintf("%03d", ($jumlah_divisi+1));
        $id_divisi = "DIV" . $id_divisi;

        $data_post = array(
            'id_divisi' => $id_divisi,
            'nama' => $nama_divisi
        );
        
        $do_register = $this->Divisi_model->do_add($data_post);

        if($do_register){
            echo json_encode(['status' => 'ok']);
        }else{
            echo json_encode(['status' => 'error']);
        }
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        $this->load->model('Divisi_model');
        $hapus = $this->Divisi_model->delete($id);

        if($hapus == true){
            echo json_encode(['isConfirmed' => true, 'message' => 'Berhasil dihapus']);
        }else{
            echo json_encode(['isConfirmed' => false, 'message' => 'Gagal dihapus']);
        }
    }
}