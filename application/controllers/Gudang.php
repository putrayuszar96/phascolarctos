<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends CI_Controller {
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
                'nama_gudang' => $rr['nama'],
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

        $data = array(
            'value' => $this->input->post('value'),
            'label' => $this->input->post('label'),
        );

        $this->load->model('Rak_model');

        $get_id = $this->Rak_model->ambil_id_terakhir($this->input->post('value'));

        if($get_id != null){
            $id_terakhir = $get_id['id_rak'];
            $id_terakhir = substr($id_terakhir, -1);
        }else{
            $id_terakhir = 0;
        }
        
        $data['id_terakhir'] = $id_terakhir;

        $pages = $this->load->view('dashboard/gudang/add', $data, true);

        echo json_encode(['body' => $pages]);
    }

    public function add_gudang_process()
    {
        $id_cabang = $this->input->post('id_cabang');
        $nama_gudang = $this->input->post('nama_gudang');

        $jumlah_level = $this->input->post('jumlah_rak');
        $jumlah_sublevel = $this->input->post('level_rak');

        $list = '';

        for($i=1;$i<=$jumlah_level;$i++){
            for($j=1;$j<=$jumlah_sublevel;$j++){
                $list .= sprintf("%03d", $i).".".sprintf("%03d", $j);

                if($i == $jumlah_level && $j == $jumlah_sublevel){
                    $list .= "";
                }else{
                    $list .= "##";
                }
            }
        }

        $id_rak = sprintf("%03d", ($this->input->post('id_terakhir')+1));
        $id_rak = $id_cabang . "RAK" . $id_rak;

        $data_post = array(
            'id_rak' => $id_rak,
            'id_cabang' => $id_cabang,
            'nama' => $nama_gudang,
            'jumlah_level' => $jumlah_level,
            'jumlah_sublevel' => $jumlah_sublevel,
            'list' => $list
        );

        $this->load->model('Rak_model');
        
        $do_add_rak = $this->Rak_model->do_add_rak($data_post);

        if($do_add_rak){
            echo json_encode(['status' => 'ok']);
        }else{
            echo json_encode(['status' => 'error']);
        }
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        $this->load->model('Rak_model');
        $hapus = $this->Rak_model->delete_rak($id);

        if($hapus == true){
            echo json_encode(['isConfirmed' => true, 'message' => 'Berhasil dihapus']);
        }else{
            echo json_encode(['isConfirmed' => false, 'message' => 'Gagal dihapus']);
        }
    }
}