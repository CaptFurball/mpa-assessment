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

        $this->db->insert('user', $this);
    }

    public function fetchByUsername ($username)
    {
        $result = $this->db
            ->limit(1)
            ->get_where('user', ['username' => $username])
            ->result_array();

        return reset($result);
    }
}