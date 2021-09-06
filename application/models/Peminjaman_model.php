<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    public function get_by_uuid($uuid)
    {
        return $this->db->get_where('peminjaman', array('uuid_barang' => $uuid))->row_array();
    }
}