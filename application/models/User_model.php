<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_model extends MY_Model
{
    public function login($username, $password)
    {
        $condition = [
            'user_name' => $username,
            'pass_word' => md5($password),
        ];

        $user = $this->db
            ->get_where('tb_users', $condition)
            ->row();
        return $user;
    }
}
