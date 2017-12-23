<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function register($data)
    {
        $arr_data = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => $this->hash_password($data['password'])
        );
        return $this->db->insert('users', $arr_data);
    }
    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function login($data)
    {
        $this->db->where('username', $data['username']);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            $userInfo = $query->row();
            if (!$this->verify_password_hash($data['password'], $userInfo->password)) {
                return false;
            }
            return $query->row(0)->id;
        } else {
            return false;
        }
    }

    private function verify_password_hash($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function check_username_exists($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));
        if (empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }
    public function check_email_exists($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        if (empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }
}