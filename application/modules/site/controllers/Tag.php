<?php 
class Tag extends Public_Controller {
    function __construct() {
        parent:: __construct();

        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
        $this->load->model('site/site_tag_model');
        $this->load->model('site/site_post_tag_model');
    }
    function index(){

        $this->load->library("pagination");

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //lay id post can sua
        $tag_slug = $this->uri->segment(3);
        $tag_slug = urldecode($tag_slug);
        //pre($tag_slug);

        $this->data['tag_slug'] = $tag_slug;
        //pre($tag_slug);

        if($tag_slug==null){
            redirect(base_url('site/home'));
        }
        else {

            $input = array();
            $input['where']['title'] = $tag_slug;
            $info_tag = $this->site_tag_model->get_list($input);
            
            if(!$info_tag) {
                $this->session->set_flashdata('message','Không tồn tại thông tin thư mục');
                redirect(base_url('site/fof'));
            }
            else {

                $this->data['info_slug'] = $info_tag;
                //pre($info_tag);

                $tag_id = $info_tag[0]->id;

                $list_post_id = $this->site_post_tag_model->get_list([
                    'order' => ['id', 'DESC'],
                    'where' => ['tag_id' => $tag_id]
                ]);

                $list_posts = array();

                foreach ($list_post_id as $key => $value) {
                    $list_posts[] = $this->site_post_model->get_info($value->post_id);
                }
                $my_id = $this->my_id;
                $this->load->model('common_model');

                $this->data['list_posts'] = $list_posts;
                $new_list = $this->common_model->get_list_post_i_can_see($list_posts, $my_id);
                // // init params
                // $params = array();
                // $limit_per_page = 5;
                // $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                // $total_records = count($list_posts);
                // //echo $total_records;
                // $new_list = array();
                // $my_id = $this->my_id;
                // $this->load->model('common_model');
            
                // if ($total_records > 0) 
                // {
                //     // get current page records
                //     $list = $this->site_post_model->get_current_page_records_by_category($limit_per_page, $start_index,'id',$category_id);
                    
                //     $new_list = $this->common_model->get_list_post_i_can_see($list, $my_id);

                //     //echo count($new_list);
                        
                //     $config['base_url'] = base_url()."site/category/".$category_slug;
                //     $config['total_rows'] = $total_records;
                //     $config['per_page'] = $limit_per_page;
                //     $config["uri_segment"] = 4;
                //     $config['use_page_numbers'] = FALSE;     
                //     $config['first_url'] = base_url('site/category/'.$category_slug);
                //     $config['first_link'] = 'Trang đầu';
                //     $config['first_tag_close'] = '</span>';      
                //     $config['last_link'] = 'Trang cuối';
                //     $config['next_link'] = 'Trang tiếp';
                //     $config['prev_link'] = 'Trang trước';
                    
                    
                //     $this->pagination->initialize($config);
                        
                //     // build paging links
                //     $this->data['links'] = $this->pagination->create_links();
                // }
                $this->data['new_list'] = $new_list;
                
                //pre($list_posts);  
            }
            
            $this->data['temp'] = 'tag';
            $this->load->view('site/site-layout/main', $this->data);
        }     
    }
}
?>