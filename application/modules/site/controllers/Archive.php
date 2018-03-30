<?php 
class Archive extends Public_Controller {
    function __construct() {
        parent:: __construct();

        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
    }
    function index(){

        //lay slug post can sua
        $archive = $this->uri->segment(3);
        $this->data['archive'] = $archive;
        
        //echo $archive;

        if($archive==null){
            redirect(base_url('site/home'));
        }
        else {
            $this->load->model('common_model');
            //pre($category_slug);

            //lay thong tin category
            //$list_category = $this->site_category_model->get_columns('tb_categories',$where=array('Slug'=>$category_slug));
            $list_archive = $this->common_model->get_last_archives(0);
            //pre($list_archive);

            if (in_array($archive, $list_archive) == false){
                redirect(base_url('site/home'));
            }
            else {

                $arr = explode('-', $archive);
                //pre($arr);
                $year = $arr[1];
                $month = $arr[0];

                $input = array();
                $input['where']['publish_year'] = $year;
                $input['where']['publish_month'] = $month;

                $list_arc = $this->site_post_model->get_list($input);
                //pre($list_arc);
    
                //pre($info_category);
                
                if(!$list_arc) {
                    $this->session->set_flashdata('message','Không tồn tại thông tin thư mục');
                    redirect(base_url('site/fof'));
                }
                else {
    
                    $this->data['list_arc'] = $list_arc;
                    $my_id = $this->my_id;
            
                    $new_list_posts = $this->common_model->get_list_post_i_can_see($list_arc, $my_id);
            
                    $this->data['new_list_posts'] = $new_list_posts;
                    //pre($list_category);  
                }
            }
                
            $this->data['temp'] = 'archive';
            $this->load->view('site/site-layout/main', $this->data);
        }     
    }

    function full(){
        $this->load->model('common_model');

        $list_archive = $this->common_model->get_last_archives(0);
        $this->data['list_archive'] = $list_archive;

        $this->data['temp'] = 'archive_full';
        $this->load->view('site/site-layout/main', $this->data);

    }
}
?>