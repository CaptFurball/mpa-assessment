<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    'register/index' => [
        [
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|min_length[8]|alpha_numeric'
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[8]|differs[username]|alpha_numeric'
        ],
        [
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]'
        ]
    ],
    'login/index' => [
        [
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|min_length[8]|alpha_numeric'
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[8]|differs[username]|alpha_numeric'
        ]
    ],
    'login/reset' => [
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ]
    ]
];