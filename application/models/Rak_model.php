<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rak_model extends CI_Model
{
    public function get_rak($cabang)
    {
        $this->db->select('rak.*, kantor_cabang.nama as nama_cabang');
        $this->db->from('rak');
        $this->db->join('kantor_cabang', 'kantor_cabang.id_cabang = rak.id_cabang');
        $this->db->where('rak.id_cabang', $cabang);

        return $this->db->get()->result_array();
    }

    public function get_rak_milik($cabang)
    {
        $this->db->select('kepemilikan.*, divisi.nama as nama_divisi, kantor_cabang.nama as nama_cabang');
        $this->db->from('kepemilikan');
        $this->db->join('kantor_cabang', 'kantor_cabang.id_cabang = kepemilikan.id_cabang');
        $this->db->join('divisi', 'divisi.id_divisi = kepemilikan.id_divisi');
        $this->db->where('kepemilikan.id_cabang', $cabang);

        return $this->db->get()->result_array();
    }
}