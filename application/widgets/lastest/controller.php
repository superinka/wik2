<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Lastest_widget extends MY_Widget 
{
    function index(){
        
        $this->load->model('site/site_post_model');

        $data = $this->site_post_model->get_list([
            'order' => ['Post_ID', 'DESC'],
            'limit' => [$amount, 0],
            'where' => ['access' => 0]
        ]);

        $this->load->view('view');
    }
}