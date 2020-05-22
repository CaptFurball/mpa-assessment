<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth 
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user');
    }

    public function register ($username, $email, $password)
    {
        try {
            $this->CI->user->create($username, $email, $this->hash($password));
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    public function hash ($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function validate ($username, $password)
    {
        $user = $this->CI->user->fetchByUsername($username);

        return !empty($user) && password_verify($password, $user['password']);
    }
}