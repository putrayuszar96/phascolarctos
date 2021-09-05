<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Divisi_model extends CI_Model
{
    public function get_divisi($cabang)
    {
        $this->db->select('divisi.*, count(users.id) as jumlah_pegawai, kantor_cabang.nama as nama_cabang');
        $this->db->from('divisi');
        $this->db->join('users', 'users.divisi = divisi.id_divisi', 'left');
        $this->db->join('kantor_cabang', 'kantor_cabang.id_cabang = divisi.id_cabang');
        $this->db->group_by('divisi.id_divisi');
        $this->db->where('divisi.id_cabang', $cabang);

        return $this->db->get()->result_array();
    }

    public function ambil_id_terakhir($cabang)
    {
        return $this->db->order_by('id_ai_divisi', 'DESC')->get_where('divisi', array('id_cabang' => $cabang), 1)->row_array();
    }

    public function do_add($data_post)
    {
        $query = $this->db->insert('divisi', $data_post);

        if($this->db->affected_rows() > 0){
            return ['status' => 'ok', 'data' => $data_post];
        }else{
            return ['status' => 'error', 'data' => null];
        }
    }
}