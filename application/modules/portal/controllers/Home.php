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
        $limit_per_page = 14;
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
                
            $config['base_url'] = base_url()."portal/home";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            $config['use_page_numbers'] = false;     
            $config['first_url'] = base_url('portal/home');

            // $config['first_link'] = 'Trang đầu';
            // $config['first_tag_close'] = '</span>';      
            // $config['last_link'] = 'Trang cuối';
            // $config['next_link'] = 'Trang tiếp';
            // $config['prev_link'] = 'Trang trước';
            $config["full_tag_open"] = '<ul class="pagination">';
            $config["full_tag_close"] = '</ul>';	
            $config["first_link"] = 'Đầu';
            $config["first_tag_open"] = "<li>";
            $config["first_tag_close"] = "</li>";
            $config["last_link"] = 'Cuối';
            $config["last_tag_open"] = "<li>";
            $config["last_tag_close"] = "</li>";
            $config['next_link'] = '<i class="ion-ios-arrow-right"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '<li>';
            $config['prev_link'] = '<i class="ion-ios-arrow-left"></i>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '<li>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            
            
            $this->pagination->initialize($config);
                
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        $this->data['new_list'] = $new_list;
            
        $this->data['temp'] = 'pages/home';
        $this->load->view('portal/portal-layout/main', $this->data);

    }

    function getCountry(){
        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
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
        $limit_per_page = 14;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = count($new_list_posts);
        
        $new_list =array();

        $page =  $_GET['page'];
        $start_index = $page * $limit_per_page;
        $list = $this->site_post_model->get_current_page_records($limit_per_page, $start_index,'id');
        //echo count($list);
        $new_list = $this->common_model->get_list_post_i_can_see($list, $my_id);
        $this->data['new_list'] = $new_list;
        
        $this->data['page'] = $page;
        $this->data['limit_per_page'] = $limit_per_page;

        $this->data['temp'] = 'pages/home_post';
        $this->load->view('pages/home_post', $this->data);
    }

    
}
?>