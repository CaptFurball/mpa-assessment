<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('application/libraries/auth/Email_Verification.php');

class Auth
{
    use Email_Verification;

    private $CI;

    const RETRY_THRESHOLD = 5;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user');
        $this->CI->load->model('verify');
    }

    /**
     * Registers new user and creates a email verification request
     * 
     * @var string $username Username of the user
     * @var string $email Email of the user
     * @var string $password Raw password entered by the user
     * 
     * @return mixed Returns Boolean true if success or array 
     *               with keys 'error' and 'message' when error.
     */
    public function register ($username, $email, $password)
    {
        $res = $this->CI->user->create($username, $email, $this->hash($password));
        
        $this->request_account_activation($email);

        return $res;
    }

    /**
     * Request an account activation in case the first email was dropped
     * or the token was expired.
     * 
     * @var string $email Email of the user
     */
    public function request_account_activation ($email)
    {
        $code = md5(uniqid($email, true));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->CI->verify->create($email, $code, $expire, 'activate_account');
    }

    /**
     * Encrypt and generates password hash to be stored in database
     * 
     * @var string $password Raw password of the user
     * 
     * @return string Encrypted hashed password of the user
     */
    public function hash ($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Callback method for activating an account
     * 
     * @var string $email The email of the user
     * 
     * @return mixed Returns Boolean true if success or array 
     *               with keys 'error' and 'message' when error.
     */
    private function activate_account ($email)
    {
        return $this->CI->user->activate_user($email);
    }

    /**
     * Authenticates whether username and password is a valid combination.
     * Sets the user info into session upon success.
     * Increments retry count upon failure.
     * 
     * @var string $username Username of the user
     * @var string $password Raw password of the user
     * 
     * @return boolean Returns true if authenticated and false if failed
     */
    public function authenticate ($username, $password)
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

    /**
     * In the event of failed login, retries are recorded.
     * When retries are over the threshold set, user account is deactivated
     * 
     * @var array $user The user information retrieved from database
     */
    public function failed_login ($user)
    {
        $retry = $user['retry'] + 1;

        if ($retry >= self::RETRY_THRESHOLD) {
            $this->CI->user->deactivate_user($user['email']);
        } else {
            $this->CI->user->update_retry($user['email'], $retry);
        }
    }

    /**
     * Request to reset password, this generates an email verification request.
     * 
     * @var string $email The email of the user
     */
    public function request_reset_password ($email)
    {
        if ($this->CI->user->exists($email)) {
            $code = md5(uniqid($email, true));
            $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->CI->verify->create($email, $code, $expire, 'reset_password');
        }
    }

    /**
     * Callback method for resetting password in email account
     * 
     * @var string $email The email account to identify the user
     * 
     * @return string The new raw password of the user
     */
    private function reset_password ($email)
    {
        $new_password = md5(uniqid($email, true));
        
        $this->CI->user->update_password($email, $this->hash($new_password));

        return $new_password;
    }

    /**
     * Logout method to log the user out of the session
     */
    public function logout ()
    {
        session_destroy();
    }
}