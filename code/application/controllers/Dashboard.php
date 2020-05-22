<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller 
{
	public function index()
	{
        $data = [
            'username' => $this->session->userdata('username')
        ];

		$this->load->view('welcome_message', $data);
	}
}
