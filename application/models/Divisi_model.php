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
}