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

    public function mail ()
    {
        $this->load->library('email');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_port' => 2525,
            'smtp_user' => '749602d6870fae',
            'smtp_pass' => '579e7db6ae7bd2',
            'crlf' => "\r\n",
            'newline' => "\r\n"
          );

        $this->email->initialize($config);

        $this->email->from('edwardlimyeesiangli@airasia.com', 'Edward Lim');
        $this->email->to('elys.1993a@gmail.com', 'Edward Lim');
        $this->email->subject('test');
        $this->email->message('Hello friend');

        if ($this->email->send()) {
            echo "success";
        } else {
            echo $this->email->print_debugger();
        }
    }
}
