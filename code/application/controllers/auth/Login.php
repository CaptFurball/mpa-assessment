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

        $res = $this->auth->authenticate($username, $password);

        if ($res === true) {
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'username or password incorrect');
        }
    }

    public function reset ($code = null)
    {
        if ($code) {
            $this->_reset($code);
        }

        if ($this->input->method() == 'post' && $this->form_validation->run()) {
            $this->_request_reset();
        }

        $this->load->view('auth/reset');
    }

    public function _request_reset ()
    {
        $email = $this->input->post('email');
        $this->auth->request_reset_password($email);

        $this->session->set_flashdata('success', 'Password reset requested, please verify your email');
        redirect('auth/login');
    }

    public function _reset ($code)
    {
        $new_password = $this->auth->verify($code);
        $this->session->set_flashdata('success', 'New Password:' . $new_password);
        redirect('auth/login');
    }

    public function logout ()
    {
        $this->auth->logout();
        redirect('auth/login');
    }
}
