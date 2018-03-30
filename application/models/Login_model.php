<?php
class Login_model extends MY_Model {
    var $table ='tb_users';
    var $key = 'User_ID';
    
    function login($username, $password)
	{
		$this -> db -> select('*');
		$this -> db -> from('tb_users');
		$this -> db -> where('user_name', $username);
		$this -> db -> where('pass_word', MD5($password));
		$this -> db -> limit(1);
	
		$query = $this -> db -> get();
	
		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
}