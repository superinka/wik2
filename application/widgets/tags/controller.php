<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Tags_widget extends MY_Widget 
{
    function index(){
        
        $this->load->model('admin/admin_tag_model');
        $this->load->model('admin/admin_post_tag_model');

        $list_tags = $this->admin_tag_model->get_list([
            'order' => ['frequency', 'DESC'],
            'limit' => [10, 0]
        ]);
       // truyền qua view
        $this->load->view('view');
    }
}