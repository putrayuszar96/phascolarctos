<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang_model extends CI_Model
{
    public function get_barang($filter = [])
    {
        $this->db->select('barang.*, divisi.nama as nama_divisi, users.nama_lengkap as nama_uploader');
        $this->db->from('barang');
        $this->db->join('divisi', 'divisi.id_divisi = barang.id_divisi');
        $this->db->join('users', 'users.id = barang.uploader');

        return $this->db->get()->result_array();
    }

    public function get_by_uuid($uuid)
    {
        return $this->db->get_where('barang', array('uuid_barang' => $uuid))->row_array();
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

    public function do_pinjam($id)
    {
        $this->db->set('status_pinjam', 0);
        $this->db->where('uuid_barang', $id);
        $this->db->update('barang');

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function do_kembali($id)
    {
        $this->db->set('status_pinjam', 1);
        $this->db->where('uuid_barang', $id);
        $this->db->update('barang');

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->delete('barang', array('uuid_barang' => $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}