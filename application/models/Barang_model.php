<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang_model extends CI_Model
{
    public function get_barang($filter)
    {
        $this->db->select('barang.*, kantor_cabang.nama as nama_cabang, divisi.nama as nama_divisi, users.nama_lengkap as nama_uploader');
        $this->db->from('barang');
        $this->db->join('kantor_cabang', 'kantor_cabang.id_cabang = barang.id_cabang');
        $this->db->join('divisi', 'divisi.id_divisi = barang.id_divisi');
        $this->db->join('users', 'users.id = barang.uploader');
        $this->db->where('barang.id_cabang', $filter['cabang']);

        return $this->db->get()->result_array();
    }

    public function do_add($data_post)
    {
        $query = $this->db->insert('barang', $data_post);

        if($this->db->affected_rows() > 0){
            return ['status' => 'ok', 'data' => $data_post];
        }else{
            return ['status' => 'error', 'data' => null];
        }
    }
}