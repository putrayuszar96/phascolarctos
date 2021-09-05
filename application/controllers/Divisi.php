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
        $this->load->model('Divisi_model');

        $data = array(
            'value' => $this->input->post('value'),
            'label' => $this->input->post('label'),
        );

        $get_id = $this->Divisi_model->ambil_id_terakhir($this->input->post('value'));

        if($get_id != null){
            $id_terakhir = $get_id['id_divisi'];
            $id_terakhir = substr($id_terakhir, -1);
        }else{
            $id_terakhir = 0;
        }
        
        $data['id_terakhir'] = $id_terakhir;

        $pages = $this->load->view('dashboard/divisi/add', $data, true);

        echo json_encode(['body' => $pages]);
    }

    public function add_divisi_process()
    {
        $id_cabang = $this->input->post('id_cabang');
        $nama_divisi = $this->input->Post('nama');

        $id_divisi = sprintf("%03d", ($this->input->post('id_terakhir')+1));
        $id_divisi = $id_cabang . "DIV" . $id_divisi;

        $data_post = array(
            'id_cabang' => $id_cabang,
            'id_divisi' => $id_divisi,
            'nama' => $nama_divisi
        );

        $this->load->model('Divisi_model');
        
        $do_register = $this->Divisi_model->do_add($data_post);

        if($do_register){
            echo json_encode(['status' => 'ok']);
        }else{
            echo json_encode(['status' => 'error']);
        }
    }
}