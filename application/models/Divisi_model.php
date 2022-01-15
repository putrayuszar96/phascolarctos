<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Divisi_model extends CI_Model
{
    public function get_divisi_raw()
    {
        return $this->db->get('divisi')->result_array();
    }

    public function get_divisi($cabang = NULL)
    {
        $this->db->select('divisi.*, count(users.id) as jumlah_pegawai, kantor_cabang.nama as nama_cabang');
        $this->db->from('divisi');
        $this->db->join('users', 'users.divisi = divisi.id_divisi', 'left');
        $this->db->join('kantor_cabang', 'kantor_cabang.id_cabang = divisi.id_cabang');
        $this->db->group_by('divisi.id_divisi');

        if($cabang != null){
            $this->db->where('divisi.id_cabang', $cabang);   
        }

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

    public function get_divisi_no_rak($cabang){
        return $this->db->query('SELECT divisi.* FROM divisi NATURAL LEFT JOIN kepemilikan WHERE kepemilikan.id_divisi IS NULL')->result_array();
    }

    public function get_divisi_with_rak($cabang){
        $this->db->select('kepemilikan.*, divisi.nama as nama_divisi');
        $this->db->from('kepemilikan');
        $this->db->join('divisi', 'divisi.id_divisi = kepemilikan.id_divisi');
        $this->db->where('kepemilikan.id_cabang', $cabang);

        return $this->db->get()->result_array();
    }

    public function delete($id)
    {
        $this->db->delete('divisi', array('id_ai_divisi' => $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}