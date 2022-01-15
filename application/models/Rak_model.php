<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rak_model extends CI_Model
{
    public function get_rak_raw()
    {
        return $this->db->get('rak')->result_array();
    }

    public function get_rak()
    {
        $this->db->select('rak.*, kantor_cabang.nama as nama_cabang');
        $this->db->from('rak');
        $this->db->join('kantor_cabang', 'kantor_cabang.id_cabang = rak.id_cabang');

        return $this->db->get()->result_array();
    }

    public function get_rak_id($id)
    {
        return $this->db->get_where('rak', array('id_rak' => $id))->row_array();
    }

    public function get_rak_milik()
    {
        $this->db->select('kepemilikan.*, divisi.nama as nama_divisi');
        $this->db->from('kepemilikan');
        $this->db->join('divisi', 'divisi.id_divisi = kepemilikan.id_divisi');

        return $this->db->get()->result_array();
    }

    public function get_rak_milik_id($id)
    {
        return $this->db->get_where('kepemilikan', array('id_divisi' => $id))->row_array();
    }

    public function get_check_kode_gudang($kode_gudang)
    {
        return $this->db->get_where('rak', array('kode_gudang' => $kode_gudang))->result_array();
    }

    public function ambil_id_terakhir($cabang)
    {
        return $this->db->order_by('id_rak', 'DESC')->get_where('rak', array('id_cabang' => $cabang), 1)->row_array();
    }

    public function do_add_pemilik($data_post)
    {
        $query = $this->db->insert('kepemilikan', $data_post);

        if($this->db->affected_rows() > 0){
            return ['status' => 'ok', 'data' => $data_post];
        }else{
            return ['status' => 'error', 'data' => null];
        }
    }

    public function do_add_rak($data_post)
    {
        $query = $this->db->insert('rak', $data_post);

        if($this->db->affected_rows() > 0){
            return ['status' => 'ok', 'data' => $data_post];
        }else{
            return ['status' => 'error', 'data' => null];
        }
    }

    public function delete_rak($id)
    {
        $this->db->delete('rak', array('id_rak' => $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function delete_kepemilikan($id)
    {
        $this->db->delete('kepemilikan', array('id' => $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}