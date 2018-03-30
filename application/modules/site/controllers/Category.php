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
            redirect(base_url('site/home'));
        }
        else {

            $input = array();
            $input['where']['slug'] = $category_slug;
            $info_category = $this->site_category_model->get_list($input);
            
            if(!$info_category) {
                $this->session->set_flashdata('message','Không tồn tại thông tin thư mục');
                redirect(base_url('site/fof'));
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
                $limit_per_page = 5;
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
                        
                    $config['base_url'] = base_url()."site/category/".$category_slug;
                    $config['total_rows'] = $total_records;
                    $config['per_page'] = $limit_per_page;
                    $config["uri_segment"] = 4;
                    $config['use_page_numbers'] = FALSE;     
                    $config['first_url'] = base_url('site/category/'.$category_slug);
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
                
                //pre($list_posts);  
            }
            
            $this->data['temp'] = 'category';
            $this->load->view('site/site-layout/main', $this->data);
        }     
    }
}
?>