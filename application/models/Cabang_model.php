<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cabang_model extends CI_Model
{
    public function get_list()
    {
        $this->db->select('kantor_cabang.*, count(divisi.id_ai_divisi) as jumlah_divisi');
        $this->db->from('kantor_cabang');
        $this->db->join('divisi', 'divisi.id_cabang = kantor_cabang.id_cabang');
        $this->db->group_by('kantor_cabang.id_cabang');

        return $this->db->get()->result_array();
    }

    public function delete($id)
    {
        $this->db->delete('kantor_cabang', array('id_ai_cabang' => $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}