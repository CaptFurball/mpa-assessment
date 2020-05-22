<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth 
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user');
        $this->CI->load->model('verify');
    }

    public function register ($username, $email, $password)
    {
        $res = $this->CI->user->create($username, $email, $this->hash($password));
        
        $code = md5(uniqid($email, true));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->CI->verify->create($email, $code, $expire, 'activate_account');

        return $res;
    }

    public function verify ($code)
    {
        $verification = $this->CI->verify->fetch_by_code($code);
        
        if (!empty($verification)) {

            $callback = $verification['callback'];
            $email = $verification['email'];

            if (is_callable([$this, $callback])) {
                $this->CI->verify->burn_code($code);
                return $this->$callback($email);
            }
        } else {
            return false;
        }
    }

    private function activate_account ($email)
    {
        return $this->CI->user->activate_user($email);
    }

    public function hash ($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function validate ($username, $password)
    {
        $user = $this->CI->user->fetch_by_username($username);

        if (!empty($user) && password_verify($password, $user['password'])) {
            $this->CI->user->update_retry($user['email'], 0);

            $data = array(
				'username' => $user['username'],
				'authenticated' => true,
            );
            
            $this->CI->session->set_userdata($data);
            
            return true;
        } else {
            $this->failed_login($user);
            return false;
        }
    }

    public function failed_login ($user)
    {
        $retry = $user['retry'] + 1;

        if ($retry >= 5) {
            $this->CI->user->deactivate_user($user['email']);
        } else {
            $this->CI->user->update_retry($user['email'], $retry);
        }
    }

    public function request_reset_password ($email)
    {
        $code = md5(uniqid($email, true));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->CI->verify->create($email, $code, $expire, 'reset_password');
    }

    public function reset_password ($email)
    {
        $new_password = md5(uniqid($email, true));
        
        if ($this->CI->user->exists($email)) {
            $this->CI->user->update_password($email, $this->hash($new_password));
        }

        return $new_password;
    }

    public function logout ()
    {
        session_destroy();
    }
}