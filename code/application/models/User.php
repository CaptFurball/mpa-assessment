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
            $error = $this->db->error();

            if ($error['code'] == '1062') {
                throw new Exception('Username or email is already in used');
            } else {
                throw new Exception('Database error');
            }
        }
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