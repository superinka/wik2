<?php 

class Home extends Public_Controller {
    function __construct() {
        parent:: __construct();
        $this->load->model('site/site_home_model');
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }
    function index(){

        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
        $this->load->library("pagination");
        
        $total = $this->site_post_model->get_total();
        $this->data['total'] = $total;
        
        
        $list_posts = $this->site_post_model->get_list([
            'order' => ['id', 'DESC']
        ]);
        $this->data['list_posts'] = $list_posts;
        //pre($list_posts);

        $list_category = $this->site_category_model->get_list([
            'where' => ['parent_id'=> 0]
        ]);
        $this->data['list_category'] = $list_category;

        $this->load->model('common_model');
        $my_id = $this->my_id;

        $new_list_posts = $this->common_model->get_list_post_i_can_see($list_posts, $my_id);
        // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = count($new_list_posts);
        
        $new_list =array();
        //echo $total_records;
    
        if ($total_records > 0) 
        {
            // get current page records
            $list = $this->site_post_model->get_current_page_records($limit_per_page, $start_index,'id');

            //echo count($list);
            $new_list = $this->common_model->get_list_post_i_can_see($list, $my_id);
            //echo count($new_list);
            //pre($new_list);
                
            $config['base_url'] = base_url()."site/home";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            $config['use_page_numbers'] = false;     
            $config['first_url'] = base_url('site/home');
            $config['first_link'] = 'Trang đầu';
            $config['first_tag_close'] = '</span>';      
            $config['last_link'] = 'Trang cuối';
            $config['next_link'] = 'Trang tiếp';
            $config['prev_link'] = 'Trang trước';
            
            
            $this->pagination->initialize($config);
                
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        $this->data['new_list'] = $new_list;
            
        $this->data['temp'] = 'index';
        $this->load->view('site/site-layout/main', $this->data);

    }

    
}
?>