<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    public function get_by_uuid($uuid)
    {
        $this->db->select('peminjaman.*, users.nama_lengkap as nama_peminjam');
        $this->db->from('peminjaman');
        $this->db->join('users', 'users.id = peminjaman.peminjam');
        $this->db->where('peminjaman.uuid_barang', $uuid);
        $this->db->order_by('peminjaman.tanggal_pinjam', 'DESC');

        return $this->db->get()->result_array();
    }

    public function insert($data_post)
    {
        $query = $this->db->insert('peminjaman', $data_post);

        if($this->db->affected_rows() > 0){
            return ['status' => 'ok', 'data' => $data_post];
        }else{
            return ['status' => 'error', 'data' => null];
        }
    }

    public function kembali($uuid_barang, $date)
    {
        $this->db->where('uuid_barang', $uuid_barang);
        $this->db->where('tanggal_kembali IS NULL', null, false);
        $this->db->set('tanggal_kembali', $date);
        $this->db->update('peminjaman');

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}