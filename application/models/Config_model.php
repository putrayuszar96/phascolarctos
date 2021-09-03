<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model
{
    public function get_cabang($id = null)
    {
        if($id != null){

        }else{
            return $this->db->get('kantor_cabang')->result_array();
        }
    }

    public function get_divisi($id = null, $id_cabang = null)
    {
        if($id != null){

        }else{
            return $this->db->get('divisi')->result_array();
        }
    }
}