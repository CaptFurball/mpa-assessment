<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model 
{
    public $username;
    public $email;
    public $password;

    public function create ($username, $email, $password_hash)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password_hash;

        if (!$this->db->insert('user', $this)) {
            return $this->db->error();
        }

        return true;
    }

    public function fetch_by_username ($username)
    {
        $result = $this->db
            ->limit(1)
            ->get_where('user', ['username' => $username])
            ->result_array();

        return reset($result);
    }

    public function exists ($email)
    {
        $count = $this->db
            ->from('user')
            ->where('email', $email)
            ->limit(1)
            ->count_all_results();

        return $count === 1;
    }

    public function update_password ($email, $new_password)
    {
        $query = $this->db
            ->set('password', $new_password)
            ->where('email', $email);
            
        if (!$query->update('user')) {
            return $this->db->error();
        }

        return true;
    }
}