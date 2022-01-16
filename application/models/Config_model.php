<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model
{
    public function get_divisi($id = null)
    {
        if($id != null){

        }else{
            return $this->db->get('divisi')->result_array();
        }
    }
}