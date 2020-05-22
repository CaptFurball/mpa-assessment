<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait Email_Verification
{
    private $CI;

    /**
     * Perform code verification which was sent to email upon issuance.
     * Upon success verification, a callback is called which was stored
     * in the table column 'callback'
     * 
     * @var string $code A randomly generated token code sent to user's email
     *                   to verify if an email account belongs to the user
     * 
     * @return mixed Returns Boolean false if verification fails, otherwise
     *               depends on the callback method.
     */
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
}