<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function cek_login($email, $password){
        $this->db->where('username', $email);
        $this->db->or_where('email', $email);
        
        $user = $this->db->get('users')->row_array();

        if($user != null){
            if(password_verify($password, $user['password'])){
                return ['status' => 'ok', 'data' => $user];
            }else{
                return ['status' => 'error', 'data' => 'Password salah!'];
            }
        }else{
            return ['status' => 'error', 'data' => 'User tidak ditemukan!'];
        }
    }

    public function do_register($data_post){
        $query = $this->db->insert('users', $data_post);

        if($this->db->affected_rows() > 0){
            return ['status' => 'ok', 'data' => $data_post];
        }else{
            return ['status' => 'error', 'data' => null];
        }
    }

    public function get_data()
    {
        $this->db->select('users.id, users.username, users.nama_lengkap, divisi.nama AS nama_divisi, users.status');
        $this->db->from('users');
        $this->db->join('divisi', 'users.divisi = divisi.id_divisi');

        return $this->db->get()->result_array();
    }
}