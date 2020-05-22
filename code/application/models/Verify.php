<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Model 
{
    public $email;
    public $code;
    public $expire;
    public $callback;

    public function create ($email, $code, $expire, $callback)
    {
        $this->email = $email;
        $this->code = $code;
        $this->expire = $expire;
        $this->callback = $callback;

        if (!$this->db->insert('verify', $this)) {
            return $this->db->error();
        }

        return true;
    }

    public function fetch_by_code ($code)
    {
        $result = $this->db
            ->from('verify')
            ->where('code', $code)
            ->where('expire >', date('Y-m-d'))
            ->where('active', true)
            ->limit(1)
            ->get()
            ->result_array();

        return reset($result);
    }

    public function burn_code ($code)
    {
        $query = $this->db
            ->set('active', false)
            ->where('code', $code);
        
        if (!$query->update('verify')) {
            return $this->db->error();
        }

        return true;
    }
}