<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
    public function index () 
    {
		$this->load->view('auth/login');
    }

    public function reset ()
    {
        $this->load->view('auth/reset');
    }
}
