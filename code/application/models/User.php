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
            ->from('user')
            ->where('username', $username)
            ->where('active', true)
            ->limit(1)
            ->get()
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

    public function activate_user ($email)
    {
        $query = $this->db
            ->set('active', true)
            ->where('email', $email);
            
        if (!$query->update('user')) {
            return $this->db->error();
        }

        return true;
    }

    public function deactivate_user ($email)
    {
        $query = $this->db
            ->set('active', false)
            ->where('email', $email);
            
        if (!$query->update('user')) {
            return $this->db->error();
        }

        return true;
    }

    public function update_retry ($email, $retry)
    {
        $query = $this->db
            ->set('retry', $retry)
            ->where('email', $email);
            
        if (!$query->update('user')) {
            return $this->db->error();
        }

        return true;
    }
}