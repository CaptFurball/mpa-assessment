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

        $res = $this->auth->register($username, $email, $password);
        
        if ($res !== true) {
            if ($res['code'] === 1062) {
                $this->session->set_flashdata('error', 'Username or email is in used');
            } else {
                $this->session->set_flashdata('error', 'Something unexpected has happened');
            }
        } else {
            $this->session->set_flashdata('success', 'Your account is successfully created, please check your email');
        }

        redirect('auth/register');
    }

    public function verify ($code = null)
    {
        if ($code && $this->auth->verify($code)) {
            $this->session->set_flashdata('success', 'Your account is successfully activated');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Your code is not valid');
            redirect('auth/register');
        }
    }
}
