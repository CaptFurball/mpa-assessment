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
        return $this->CI->user->create($username, $email, $this->hash($password));
    }

    public function hash ($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function validate ($username, $password)
    {
        $user = $this->CI->user->fetch_by_username($username);

        return !empty($user) && password_verify($password, $user['password']);
    }

    public function reset_password ($email)
    {
        $new_password = md5(uniqid($email, true));
        
        if ($this->CI->user->exists($email)) {
            $this->CI->user->update_password($email, $this->hash($new_password));
        }

        return $new_password;
    }
}