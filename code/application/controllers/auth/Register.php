<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index () 
    {
        $this->load->library('form_validation');

        if ($this->input->method() == 'post' && $this->form_validation->run()) {
            $this->_register();
        }

        $this->load->view('auth/register');
    }

    public function _register ()
    {
        $username = $this->input->post('username');
        $email    = $this->input->post('email');
        $password = $this->input->post('password');

        $this->auth->register($username, $email, $password);
    }
}
