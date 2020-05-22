<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index () 
    {
        if ($this->input->method() == 'post' && $this->form_validation->run()) {
            $this->_login();
        }

        $this->load->view('auth/login');
    }

    public function _login ()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $res = $this->auth->validate($username, $password);

        if ($res === true) {
            echo "password correct";
        } else {
            $this->session->set_flashdata('error', 'email or password incorrect');
        }
    }

    public function reset ()
    {
        $this->load->view('auth/reset');
    }
}
