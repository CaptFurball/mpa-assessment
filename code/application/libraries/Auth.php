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

    public function register ()
    {
        echo "user registered";
    }

    public function login ()
    {
        echo "user logged in";
    }
}