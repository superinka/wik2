<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->CI = & get_instance();
  }
}

class Admin_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();

    $session_data = $this->session->userdata('logged_in');
    //pre($session_data); 
		if(!$session_data['id']){
      redirect(base_url('login'), 'refresh');
    }
    else {
      $this->my_id = $session_data['id'];
      $this->my_user_name = $session_data['user_name'];
      $this->my_role = $session_data['role'];

      $this->session_data = $session_data;
    }
  }
}

class Public_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    $session_data = $this->session->userdata('logged_in');
    //pre($session_data); 
		if(!$session_data['id']){
      $this->my_id = 0;
      $this->my_user_name = 0;
      $this->my_role = 3;
    }
    else {
      $this->my_id = $session_data['id'];
      $this->my_user_name = $session_data['user_name'];
      $this->my_role = $session_data['role'];

      $this->session_data = $session_data;
    }
  }
}