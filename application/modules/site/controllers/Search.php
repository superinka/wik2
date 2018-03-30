<?php
class Search extends Public_Controller {
    function __construct() {
        parent:: __construct();
        
        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
    }
    function index(){
        
        $total = $this->site_post_model->get_total();
        $this->data['total'] = $total;
        $my_id = $this->my_id;
        $this->data['my_id'] = $my_id;
        
        $this->load->model('common_model');
        if ($_GET['search_term']) {
            $search_term = $_GET['search_term'];
            $this->data['search_term'] = $search_term;
            
            $list_p = $this->site_post_model->get_search($search_term);
            $this->data['list_p'] = $list_p;
            
            $new_list = $this->common_model->get_list_post_i_can_see($list_p, $my_id);
            
            $this->data['new_list'] = $new_list;
            
            //pre($list_p);
        }
        
        $this->data['temp'] = 'search_result';
        $this->load->view('site/site-layout/main', $this->data);
        
    }
    
    function advance_search(){
        
        
        $this->load->model('common_model');
        $list_root_category = $this->common_model->get_list_root_category();
        $this->data['list_root_category'] = $list_root_category;
        
        $list_member = $this->common_model->get_list_author();
        $this->data['list_member'] = $list_member;
        
        
        $this->data['temp'] = 'advance_search';
        $this->load->view('site/site-layout/main', $this->data);
        
    }
    
    function filter(){
        $search_term     = isset($_POST['search_term']) ? trim($_POST['search_term']) : '';
        $search_category     = isset($_POST['search_category']) ? trim($_POST['search_category']) : '';
        $framework   = $_POST['framework'];
        $access     = $_POST['access'];
        
        $data_search = array(
            'search_term'   => $search_term,
            'search_category'   => $search_category,
            'framework' => $framework,
            'access'        => $access
        );
        
        $this->load->model('site/site_post_model');
        $result = $this->site_post_model->get_filter($data_search);
        //pre($result);
        $this->load->model('common_model');
        $my_id = $this->my_id;
        
        $new_list = $this->common_model->get_list_post_i_can_see($result, $my_id);
        $html ='';
        if($new_list==null){
            echo 'Không tìm thấy kết quả';
        }
        else {
            echo '<section class="tab wow fadeInLeft animated" data-wow-animation-name="fadeInLeft" style="visibility: visible; animation-name: fadeInLeft;">';
            echo "<header class='panel-heading tab-bg-dark-navy-blue'><ul class='nav nav-tabs nav-justified'><li class='active'><a data-toggle='tab' href='#news'>Kết quả lọc: ".count($new_list)."</a></li></ul></header><div class='panel-body'><div class='tab-content tasi-tab'><div id='news' class='tab-pane fade active in'>";
            foreach ($new_list as $key => $value) {
                $category_name = $this->common_model->get_category_name_by_id($value->category);
                $user_name = $this->common_model->get_user_name_by_id($value->created_by);
                $list_year = $this->common_model->get_last_archives(0);
                $my_id = $this->my_id;
                $comment_count = $this->common_model->get_count_comment_by_post_id($value->id);
                //thumbnail
                if($value->thumbnail == 'no-thumbnail.jpg') {
                    $link_thumb = public_url('img/no-thumbnail_thumb.jpg');
                }
                else {
                    $link_img = public_url('upload/thumbnail/'.$value->thumbnail);
                    $link_thumb = get_thumb($link_img);
                }
                echo '<article class="media">';
                echo "<a href='".base_url($value->slug.'-'.$value->id.'.html')."' style='padding-top: 10px;' class='pull-left thumb p-thumb'>";
                echo "<img src='".$link_thumb."' alt=''>";
                echo "</a>";
                echo "<div class='media-body b-btm'>";
                echo "<a href='".base_url($value->slug.'-'.$value->id.'.html')."' class='p-head'><h4><b>";
                echo $value->name;
                echo "</b></h4></a>";
                echo "<p class='about-testimonial-company'>";
                echo $value->description;
                echo "</p>";
                echo '<div class="meta" style="border-bottom: 1px solid #eee;">';
                echo '<ul style="float: left; padding-left:10px;">';
                echo '<li><a href="javascript:;"><i class="fa fa-user-circle" aria-hidden="true"></i>'.$user_name.'</a></li>';
                echo '<li><a href="javascript:;"><i class="fa fa-folder" aria-hidden="true"></i>'.$category_name.'</a></li>';
                echo '<li><a href="javascript:;"><i class="fa fa-calendar" aria-hidden="true"></i>'.date_create($value->publish_time)->format("d/m/Y").'</a></li>';
                echo '</ul>';
                echo '<div class="clearfix"></div>';
                echo '<div style="float: right;">';
                echo '<ul>';
                echo '<li><a href="javascript:;"><i class="fa fa-eye" aria-hidden="true"></i>'.$value->views_count.'</a></li>';
                echo '<li><a href="javascript:;"><i class="fa fa-commenting-o" aria-hidden="true"></i>'.$comment_count.'</a></li>';
                echo '</ul>';
                echo '</div>';
                echo '<div class="clearfix"></div>';
                echo '</div>';
                echo "</div>";
                echo '</article>';
                
            }
            echo '</section>';
            //die (json_encode($html));
        }
        
        
        //pre($data_search);
        
        $this->data['temp'] = 'filter';
        $this->load->view('filter', $this->data);
    }
    
    
}
?>
