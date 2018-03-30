<?php
class Home extends Admin_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_home_model');
    }

    function index(){

        $total_members = $this->admin_home_model->get_total();
        $this->data['total_members'] = $total_members;

        $this->load->model('admin/admin_post_model');
        $total_posts = $this->admin_post_model->get_total();
        $this->data['total_posts'] = $total_posts;

        $this->data['temp'] = 'index';
        $this->load->view('admin/admin-layout/main', $this->data);
    }
}