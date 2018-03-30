<?php
class Login extends MY_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('login_model');
    }

    function index(){
        $this->load->view('login_page');
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        //$token = "<script>window.localStorage.removeItem('token');</script>";
        //pre($token);
        redirect(base_url('login'), 'refresh');
    }
}

