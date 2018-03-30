<?php 
class Category extends Public_Controller {
    function __construct() {
        parent:: __construct();

        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
        
    }
    function index(){

        $this->load->library("pagination");

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //lay id post can sua
        $category_slug = $this->uri->segment(3);
        $this->data['category_slug'] = $category_slug;

        if($category_slug==null){
            redirect(base_url('portal/home'));
        }
        else {

            $input = array();
            $input['where']['slug'] = $category_slug;
            $info_category = $this->site_category_model->get_list($input);
            
            if(!$info_category) {
                $this->session->set_flashdata('message','Không tồn tại thông tin thư mục');
                redirect(base_url('portal/fof'));
            }
            else {

                $this->data['info_category'] = $info_category;

                $category_id = $info_category[0]->id;

                $list_posts = $this->site_post_model->get_list([
                    'order' => ['id', 'DESC'],
                    'where' => ['category' => $category_id]
                ]);
                // $input = array();
                // $input['order'] = array('id','DESC');
                // $input['where']['category'] = $category_id;
                // $list_posts = $this->site_post_model->get_list($input);

                //pre($list_posts);


                $this->data['list_posts'] = $list_posts;
                // init params
                $params = array();
                $limit_per_page = 30;
                $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $total_records = count($list_posts);
                //echo $total_records;
                $new_list = array();
                $my_id = $this->my_id;
                $this->load->model('common_model');
            
                if ($total_records > 0) 
                {
                    // get current page records
                    $list = $this->site_post_model->get_current_page_records_by_category($limit_per_page, $start_index,'id',$category_id);
                    
                    $new_list = $this->common_model->get_list_post_i_can_see($list, $my_id);

                    //echo count($new_list);
                        
                    $config['base_url'] = base_url()."portal/category/".$category_slug;
                    $config['total_rows'] = $total_records;
                    $config['per_page'] = $limit_per_page;
                    $config["uri_segment"] = 4;
                    $config['use_page_numbers'] = FALSE;     
                    $config['first_url'] = base_url('portal/category/'.$category_slug);

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
                
                //pre($list_posts);  
            }
            
            $this->data['temp'] = 'pages/category';
            $this->load->view('portal/portal-layout/main', $this->data);
        }     
    }
}
?>