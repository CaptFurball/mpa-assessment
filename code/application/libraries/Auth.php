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
        $this->CI->user->createUser($username, $email, $this->hash($password));
    }

    public function hash ($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function login ()
    {
        echo "user logged in";
    }
}