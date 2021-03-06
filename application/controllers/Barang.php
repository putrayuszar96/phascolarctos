<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
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

        $this->data['controller'] = "Berkas";
    }

	public function index()
	{
        $this->data['meta'] = [
            'title' => 'Berkas - ARIP System',
            'id_page' => 'barang_index',
            'name' => 'Daftar Berkas'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'barang'), true);
        $this->data['body'] = $this->load->view('dashboard/barang/index', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
	}

    public function add()
    {
        $this->load->model('Divisi_model');
        
        $this->data['meta'] = [
            'title' => 'Tambah Berkas - ARIP System',
            'id_page' => 'barang_add',
            'name' => 'Tambah Berkas'
        ];

        $this->data['divisi'] = $this->Divisi_model->get_divisi_raw();

        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'barang'), true);
        $this->data['body'] = $this->load->view('dashboard/barang/add', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
    }

    public function edit()
    {
        $this->data['meta'] = [
            'title' => 'Ubah Berkas - ARIP System',
            'id_page' => 'barang_edit',
            'name' => 'Ubah Berkas'
        ];
        $this->data['sidebar'] = $this->load->view('components/sidebar', array('active' => 'barang'), true);
        $this->data['body'] = $this->load->view('dashboard/barang/edit', $this->data, true);
        $this->load->view('dashboard/index', $this->data);
    }

    public function list()
    {
        $this->load->model('Barang_model');

        $raw_result = $this->Barang_model->get_barang();
        $return_result = array();

        foreach($raw_result as $rr){
            $return = array(
                'nama_barang' => $rr['nama_barang'],
                'nama_divisi' => $rr['nama_divisi'],
                'lokasi' => $rr['rak_posisi'],
                'uploader' => $rr['nama_uploader'],
                'action' => [
                    'status' => $rr['status_pinjam'],
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

    public function add_barang_process()
    {
        // die(var_dump($this->input->post()));
        
        $uuid = $this->gen_uuid();
        $nama_barang = $this->input->post('nama_barang');
        $id_divisi = $this->input->post('id_divisi');
        $uploader = $this->input->post('uploader');
        $status_pinjam = $this->input->post('status_pinjam');
        $rak_posisi = $this->input->post('rak_posisi');

        $data_post = array(
            'uuid_barang' => $uuid,
            'nama_barang' => $nama_barang,
            'id_divisi' => $id_divisi,
            'uploader' => $uploader,
            'status_pinjam' => $status_pinjam,
            'rak_posisi' => $rak_posisi
        );

        $this->load->model('Barang_model');
        
        $do_add = $this->Barang_model->do_add($data_post);

        if($do_add){
            echo json_encode(['status' => 'ok']);
        }else{
            echo json_encode(['status' => 'error']);
        }
    }

    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function pinjam_barang()
    {
        $this->load->model('Barang_model');

        $id = $this->uri->segment('3');

        $do_pinjam = $this->Barang_model->do_pinjam($id);

        $data_post = array(
            'uuid_barang' => $id,
            'peminjam' => $_SESSION['id'],
            'tanggal_pinjam' => strtotime(date('Y-m-d H:i:s'))
        );

        $this->load->model('Peminjaman_model');
        $do_log = $this->Peminjaman_model->insert($data_post);

        if($do_pinjam && $do_log){
            echo json_encode(['isConfirmed' => true, 'message' => 'Berhasil dipinjam']);
        }else{
            echo json_encode(['isConfirmed' => false, 'message' => 'Gagal dipinjam']);
        }
    }

    public function kembali_barang()
    {
        $this->load->model('Barang_model');

        $id = $this->uri->segment('3');

        $do_kembali = $this->Barang_model->do_kembali($id);

        $date = strtotime(date('Y-m-d H:i'));

        $this->load->model('Peminjaman_model');
        $do_log = $this->Peminjaman_model->kembali($id, $date);

        if($do_kembali && $do_log){
            echo json_encode(['isConfirmed' => true, 'message' => 'Berhasil dikembalikan']);
        }else{
            echo json_encode(['isConfirmed' => false, 'message' => 'Gagal dikembalikan']);
        }
    }

    public function show_status_log()
    {
        $data = array();
        $uuid_barang = $this->input->post('uuid');

        $this->load->model('Barang_model');
        $data_barang = $this->Barang_model->get_by_uuid($uuid_barang);

        $data['status'] = $data_barang['status_pinjam'];

        $this->load->model('Peminjaman_model');
        $data['log'] = $this->Peminjaman_model->get_by_uuid($uuid_barang);

        $pages = $this->load->view('dashboard/barang/log', $data, true);

        echo json_encode(['body' => $pages]);
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        $this->load->model('Barang_model');
        $hapus = $this->Barang_model->delete($id);

        if($hapus == true){
            echo json_encode(['isConfirmed' => true, 'message' => 'Berhasil dihapus']);
        }else{
            echo json_encode(['isConfirmed' => false, 'message' => 'Gagal dihapus']);
        }
    }
}