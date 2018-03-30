<?php

class Common_model extends CI_Model {
    
    public function get_lastest_posts($amount){
        $this->load->model('site/site_post_model');
        
        $list =  $this->site_post_model->get_list([
            'order' => ['id', 'DESC'],
            'limit' => [$amount, 0],
        ]);
        $my_id = $this->my_id;
        $new_list = $this->get_list_post_i_can_see($list, $my_id);
        return $new_list;
    }
    
    public function get_category_name_by_id($id){
        if($id!=0){
            $this->load->model('admin/admin_category_model');
            $info_category = $this->admin_category_model->get_info($id);
            if($info_category){
                return $info_category->name;
            }
            else {
                return 'Không tồn tại';
            }
            
        }
        else {
            return 'Thư mục gốc';
        }
    }

    public function get_category_slug_by_id($id){
        if($id!=0){
            $this->load->model('admin/admin_category_model');
            $info_category = $this->admin_category_model->get_info($id);
            if($info_category){
                return $info_category->slug;
            }
            else {
                return '';
            }
            
        }
        else {
            return '';
        }
    }
    
    function get_list_member(){
        $this->load->model('admin/admin_home_model');
        $get_list_member = $this->admin_home_model->get_list($input=array());
        
        foreach ($get_list_member as $key => $value) {
            if($value->role==1){
                unset($get_list_member[$key]);
            }
        }
        return $get_list_member;
    }
    
    function get_list_post_i_can_see($list_posts,$my_id){
        $this->load->model('admin/admin_home_model');
        if($my_id==0){
            foreach ($list_posts as $key => $value) {
                if($value->access > 0){
                    unset($list_posts[$key]);
                }
            }
            return $list_posts;
        }
        
        if($my_id > 0){
            //pre($my_id);
            $my_info = array();
            $my_info = $this->admin_home_model->get_info($my_id);
            //pre($my_info);
            if($my_info){
                $my_level = $my_info->role;
                //pre($my_level);
                if($my_level==1){
                    return $list_posts;
                }
                if($my_level > 1){
                    foreach ($list_posts as $key => $value) {
                        if($my_id != $value->created_by){
                            
                            if($value->access == 1){
                                unset($list_posts[$key]);
                            }
                            
                            if($value->access == 2){
                                $post_id = $value->id;
                                $list_users = $this->get_list_id_post_relate($post_id);
                                if(in_array($my_id, $list_users) == false){
                                    unset($list_posts[$key]);
                                }
                            }
                            
                        }
                    }
                    
                    return $list_posts;
                    
                }
            }
        }
        
    }
    
    function get_last_archives($number ='0'){
        $this->load->model('site/site_post_model');
        $list_years = $this->site_post_model->get_column_distinct('tb_posts', 'publish_year');
        rsort($list_years);
        
        foreach ($list_years as $key => $value) {
            $year = $value->publish_year;
            $list_months = $this->site_post_model->get_column('tb_posts','publish_month',$where=array('publish_year'=>$year));
            rsort($list_months);
            $value->publish_month = $list_months;
        }
        
        //list_year
        
        foreach ($list_years as $key => $value) {
            $new = array();
            foreach ($value->publish_month as $k => $v) {
                //$v = $v->Publish_month;
                $new[$k] = $v->publish_month;
            }
            $value->publish_month = $new;
        }
        $newArr = array();
        foreach ($list_years as $key => $value) {
            
            foreach ($value->publish_month as $k => $v) {
                $str = $v.'-'.$value->publish_year;
                $newArr[] = $str;
            }
        }
        if($number==0){
            return $newArr;
        }
        if($number > 0){
            $newArray2 = array_slice($newArr, 0, $number, true);
            return $newArray2;
        }
        
    }
    
    function get_list_root_category(){
        
        $input = array();
        $input['where']['parent_id'] = 0;
        $this->load->model('site/site_category_model');
        $list_root_category = $this->site_category_model->get_list($input);
        return $list_root_category;
        
        
    }
    
    function get_list_root_category_with_children(){
        $list_root_category = $this->get_list_root_category();
        
        foreach ($list_root_category as $key => $value) {
            $list_root_category[$key]->children = $this->get_children_category($value->id);
        }
        
        
        return $list_root_category;
    }
    
    function get_children_category($category_id){
        $this->load->model('site/site_category_model');
        $this->load->model('site/site_post_model');
        $input = array();
        $input['where']['parent_id'] = $category_id;
        $list_children_category = array();
        $list_children_category = $this->site_category_model->get_list($input);
        foreach ($list_children_category as $key => $value) {
            $cate_id = $value->id;
            $i = array();
            $i['where']['category'] = $cate_id;
            $list = $this->site_post_model->get_list($i);
            if(count($list)==0){
                unset($list_children_category[$key]);
            }
        }
        return $list_children_category;
    }
    
    function get_user_name_by_id($id){
        if($id!=0){
            $this->load->model('site/site_home_model');
            $info_user = $this->site_home_model->get_info($id);
            if($info_user){
                return $info_user->user_name;
            }
            else {
                return 'Không tồn tại';
            }
            
        }
        else {
            return 'Không xác định';
        }
    }
    function get_user_email_by_id($id){
        if($id!=0){
            $this->load->model('site/site_home_model');
            $info_user = $this->site_home_model->get_info($id);
            if($info_user){
                return $info_user->email;
            }
            else {
                return 'Không tồn tại';
            }
            
        }
        else {
            return 'Không xác định';
        }
    }
    
    function get_list_tags($amount){
        $this->load->model('admin/admin_tag_model');
        
        $list_tags = $this->admin_tag_model->get_list([
            'order' => ['frequency', 'DESC'],
            'limit' => [$amount, 0]
        ]);
        
        foreach ($list_tags as $key => $value){
            if($value->title == null || $value->frequency ==0){
                unset($list_tags[$key]);
            }
        }
        
        return $list_tags;
    }
    
    function get_list_tags_by_post_id($post_id){
        $this->load->model('admin/admin_tag_model');
        $this->load->model('admin/admin_post_tag_model');
        
        $list_tags = array();
        $list = $this->admin_post_tag_model->get_list([
            'where' => ['post_id' => $post_id]
        ]);
        
        //pre($list);
        
        if($list!=null){
            foreach ($list as $key => $value){
                $tag_id = $value->tag_id;
                $info_tag = $this->admin_tag_model->get_info($tag_id);
                //pre($info_tag);
                if($info_tag){
                    $list_tags[] = $info_tag->title;
                }
            }
        }
        return $list_tags;
    }
    
    function get_list_post_in_same_category($post_id){
        $this->load->model('site/site_post_model');
        
        $list_posts = array();
        $info_post = $this->site_post_model->get_info($post_id);
        if($info_post){
            $category_id = $info_post->category;
            
            $list_posts = $this->site_post_model->get_list([
                'where' => ['category' => $category_id],
                'limit' => 11
            ]);
            if($list_posts!=null){
                foreach ($list_posts as $key => $value) {
                    if($value->id == $post_id){
                        unset($list_posts[$key]);
                    }
                }
            }
        }
        return $list_posts;
    }
    
    function get_count_comment_by_post_id($post_id){
        $this->load->model('site/site_post_model');
        $this->load->model('site/site_comment_model');
        $count =0;
        $list_comments = $this->site_comment_model->get_list([
            'where' => ['post_id' => $post_id]
        ]);
        if($list_comments){
            $count = count($list_comments);
        }
        
        
        return $count;
    }
    
    function get_list_author(){
        $this->load->model('admin/admin_home_model');
        $get_list_author = $this->admin_home_model->get_list($input=array());
        
        return $get_list_author;
    }
    
    function get_list_top_view_blog($amount){
        $this->load->model('site/site_post_model');
        
        $list =  $this->site_post_model->get_list([
            'order' => ['views_count', 'DESC'],
            'limit' => [$amount, 0],
        ]);
        $my_id = $this->my_id;
        $new_list = $this->get_list_post_i_can_see($list, $my_id);
        return $new_list;
    }
    
    function get_menu_top(){
        $this->load->model('site/site_menu_model');
        $list_menu = array();
        $list_menu = $this->site_menu_model->get_list([
            'order' => ['sort', 'ASC'],
            'where' => ['parent'=>0]
        ]);
        foreach ($list_menu as $key => $value) {
            $menu_id = $value->id;
            
            if(count($this->get_child_menu($menu_id) > 0)){
                $value->child = $this->get_child_menu($menu_id);
            }
            
        }
        return $list_menu;
        //pre($list_menu);
    }
    
    function get_child_menu($menu_id){
        $this->load->model('site/site_menu_model');
        
        $list_menu = $this->site_menu_model->get_list([
            'order' => ['sort', 'ASC'],
            'where' => ['parent'=> $menu_id]
        ]);
        
        if(count($list_menu) > 0){
            foreach ($list_menu as $key => $value) {
                $menu_id = $value->id;
                if(count($this->get_child_menu($menu_id) > 0)){
                    $value->child = $this->get_child_menu($menu_id);
                }
                
            }
        }
        
        
        return $list_menu;
    }
    
    function get_list_post_relate(){
        $this->load->model('admin/admin_post_model');
        $my_role = $this->my_role;
        $my_id = $this->my_id;
        $list_posts = array();
        
        if($my_role < 2){
            $list_posts = $this->admin_post_model->get_list([
                'order' => ['id', 'DESC']
            ]);
        }
        
        if($my_role == 2){
            $list_posts = $this->admin_post_model->get_list([
                'order' => ['id', 'DESC'],
                'where' => ['created_by'=>$my_id]
            ]);
        }
        
        $newlist = array();
        
        foreach ($list_posts as $key => $value){
            $newlist[$key]['id'] = $value->id;
            $newlist[$key]['name'] = $value->name;
        }
        
        return $newlist;
        
    }
    
    function get_list_id_post_relate(){
        $this->load->model('admin/admin_post_model');
        $my_role = $this->my_role;
        $my_id = $this->my_id;
        $list_posts = array();
        
        if($my_role < 2){
            $list_posts = $this->admin_post_model->get_list([
                'order' => ['id', 'DESC']
            ]);
        }
        
        if($my_role == 2){
            $list_posts = $this->admin_post_model->get_list([
                'order' => ['id', 'DESC'],
                'where' => ['created_by'=>$my_id]
            ]);
        }
        
        $newlist = array();
        
        foreach ($list_posts as $key => $value){
            $newlist[] = $value->id;
        }
        
        return $newlist;
        
    }
    
    function get_title_bc(){
        $title ='';
        if($this->uri->segment(2) == 'home' || $this->uri->segment(1) == null){
            $title = 'trang chủ';
        }
        if($this->uri->segment(2) == 'category'){
            $category_slug = $this->uri->segment(3);
            $this->load->model('admin/admin_category_model');
            $category = $this->admin_category_model->get_info_rule($where = array("slug"=>$category_slug));
            $title = $category->name;
        }
        if($this->uri->segment(2) == 'tag'){
            $tag_slug = $this->uri->segment(3);
            $tag_slug = urldecode($tag_slug);
            
            $title = $tag_slug;
        }
        if($this->uri->segment(2) == 'archive'){
            $title = 'ARCHIVE';
        }
        if($this->uri->segment(2) == 'search'){
            $title = 'Tìm kiếm';
        }
        if($this->uri->segment(1) != 'portal' && $this->uri->segment(1) != null){
            $post_slug = $this->uri->uri_string();
            $title = $post_slug;
            $arr = explode ("." , $title);
            array_pop($arr);
            $str = implode(".", $arr);
            $new_arr = explode("-", $str);
            $post_id = array_pop($new_arr);
            $post_id = intval($post_id);
            
            $title = $post_id;
            $this->load->model('admin/admin_post_model');
            $info_post = $this->admin_post_model->get_info($post_id);
            $post_name = $info_post->name;
            //pre($info_post->name);
            $title = $post_name;
        }
        return $title;
        
    }
    
    function get_link_bc(){
        $link = array(); $html = ''; $path = array();
        if($this->uri->segment(2) == 'home' || $this->uri->segment(1) == null){
            //array_push($link, "Home");
        }
        if($this->uri->segment(2) == 'category'){
            array_push($link, "Home","Danh mục");
            $home = base_url().'portal/home';
            $x = base_url() . $this->uri->uri_string();
            array_push($path, $home,$x);
        }
        if($this->uri->segment(2) == 'tag'){
            array_push($link, "Home","tag");
            $home = base_url().'portal/home';
            $x = base_url() . $this->uri->uri_string();
            array_push($path, $home,$x);
        }
        if($this->uri->segment(2) == 'archive'){
            array_push($link, "Home","archive");
            $home = base_url().'portal/home';
            $x = base_url() . $this->uri->uri_string();
            array_push($path, $home,$x);
        }
        if($this->uri->segment(2) == 'search'){
            array_push($link, "Home","search");
            $home = base_url().'portal/home';
            $x = base_url() . $this->uri->uri_string();
            array_push($path, $home,$x);
        }
        if($this->uri->segment(1) != 'portal' && $this->uri->segment(1) != null){
            $post_slug = $this->uri->uri_string();
            $title = $post_slug;
            $arr = explode ("." , $title);
            array_pop($arr);
            $str = implode(".", $arr);
            $new_arr = explode("-", $str);
            $post_id = array_pop($new_arr);
            $post_id = intval($post_id);
            
            $title = $post_id;
            $this->load->model('admin/admin_post_model');
            $this->load->model('admin/admin_category_model');
            
            $info_post = $this->admin_post_model->get_info($post_id);
            $category_name = $this->get_category_name_by_id($info_post->category);
            
            $info_category = $this->admin_category_model->get_info($info_post->category);
            

            if(!$info_category){
                $category_slug ='';
            }
            else {
                $category_slug = $info_category->slug;
            }
            
            array_push($link, "Home",$category_name,$info_post->name);
            $home = base_url().'portal/home';
            $x = base_url() . 'portal/category/' . $category_slug;
            $y = base_url() . $this->uri->uri_string();
            array_push($path, $home,$x,$y);
        }
        $count = count($link);
        for ($i = 0; $i < $count; $i++) {
            if($i+1 == $count){
                $html = $html. '<li class="active">'. $link[$i] .'</li>'; 
            }else {
                $html = $html. '<li><a href="'.$path[$i].'">'. $link[$i] .'</a></li>'; 
            }
            
        }
        
        return $html;
        
    }


    function get_today_testing($type){
        $list_today_testing = array();
        $list_today_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['valid'=>1]
        ]);
        foreach ($list_today_testing as $key => $value) {
            if($type=='today' || $type==null){
                if (date('Y-m-d') == date('Y-m-d', strtotime($value->start_at))) {
                
                    $user_id = $value->user_id;
                    $user_info=array();
                    $user_info = $this->admin_home_model->get_info($user_id);
                    $value->tester = $user_info->last_name . ' ' .$user_info->first_name;
    
                    $test_id = $value->test_id;
                    $test_info=array();
                    $test_info = $this->admin_test_model->get_info($test_id);
                    $value->test_info = $test_info;
                }
                else{
                    unset($list_today_testing[$key]);
                }
            }

            if($type=='thisweek'){
                $thisweek = this_week();
                if ( $thisweek == date("W", strtotime($value->start_at)) ) {
                
                    $user_id = $value->user_id;
                    $user_info=array();
                    $user_info = $this->admin_home_model->get_info($user_id);
                    $value->tester = $user_info->last_name . ' ' .$user_info->first_name;
    
                    $test_id = $value->test_id;
                    $test_info=array();
                    $test_info = $this->admin_test_model->get_info($test_id);
                    $value->test_info = $test_info;
                }
                else{
                    unset($list_today_testing[$key]);
                }
            }
            if($type=='thismonth'){
                $thismonth = this_month();
                if ( $thismonth == date("M", strtotime($value->start_at)) ) {
                
                    $user_id = $value->user_id;
                    $user_info=array();
                    $user_info = $this->admin_home_model->get_info($user_id);
                    $value->tester = $user_info->last_name . ' ' .$user_info->first_name;
    
                    $test_id = $value->test_id;
                    $test_info=array();
                    $test_info = $this->admin_test_model->get_info($test_id);
                    $value->test_info = $test_info;
                }
                else{
                    unset($list_today_testing[$key]);
                }
            }

        }

        return $list_today_testing;
    }

    function get_today_tester($type){
        $list_today_tester = $this->get_today_testing($type);
        $arr_tester = array();
        foreach ($list_today_tester as $key => $value) {
            if(in_array($value->user_id,$arr_tester) == false){
                $arr_tester[]= $value->user_id;
            }
        }
        return $arr_tester;
    }

    function get_list_test_today_by_user_id($user_id,$type){

        $list_test_today_by_user_id = array();
        $list_test_today_by_user_id = $this->get_today_testing($type);

        foreach ($list_test_today_by_user_id as $key => $value) {
            if($user_id != $value->user_id){
                unset($list_test_today_by_user_id[$key]);
            }
        }
        return $list_test_today_by_user_id;

    }

    function get_number_of_test_today_by_user_id($user_id,$type){
        return count($this->get_list_test_today_by_user_id($user_id,$type));
    }
    function get_total_of_point_today_by_user_id($user_id,$type){
        $total_of_point = 0; $list= array();
        $list = $this->get_list_test_today_by_user_id($user_id,$type);
        foreach ($list as $key => $value) {
            $total_of_point = $total_of_point + $value->total_point;
        }
        return $total_of_point;
    }

    function get_top_av_point_today($amount,$type){
        $this->load->model('admin/admin_home_model');

        $list_today_tester = array();
        $list = $this->get_today_tester($type);
        foreach ($list as $key => $value) {
            $list_today_tester[$key]['user_id'] = $value;
            $list_today_tester[$key]['fullname'] = $this->admin_home_model->get_info($value)->last_name . ' '. $this->admin_home_model->get_info($value)->first_name;
            $number_of_test = $this->get_number_of_test_today_by_user_id($value,$type);
            $total_of_point = $this->get_total_of_point_today_by_user_id($value,$type);
            $list_today_tester[$key]['number_of_test'] = $number_of_test;
            $list_today_tester[$key]['total_of_point'] = $total_of_point;

            $tb = round(($total_of_point / $number_of_test),2);
            $list_today_tester[$key]['av_point'] = $tb;
        }
        //pre($list_today_tester);
        $list_today_tester = my_sort($list_today_tester,'av_point');
        $newArray = array_slice($list_today_tester, 0, $amount, true);
        return $newArray;
         
    }

    function get_top_total_point_today($amount,$type){
        $this->load->model('admin/admin_home_model');

        $list_today_tester = array();
        $list = $this->get_today_tester($type);
        foreach ($list as $key => $value) {
            $list_today_tester[$key]['user_id'] = $value;
            $list_today_tester[$key]['fullname'] = $this->admin_home_model->get_info($value)->last_name . ' '. $this->admin_home_model->get_info($value)->first_name;
            $number_of_test = $this->get_number_of_test_today_by_user_id($value,$type);
            $total_of_point = $this->get_total_of_point_today_by_user_id($value,$type);
            $list_today_tester[$key]['number_of_test'] = $number_of_test;
            $list_today_tester[$key]['total_of_point'] = $total_of_point;

            $tb = round(($total_of_point / $number_of_test),2);
            $list_today_tester[$key]['av_point'] = $tb;
        }
        //pre($list_today_tester);
        $list_today_tester = my_sort($list_today_tester,'total_of_point');
        $newArray = array_slice($list_today_tester, 0, $amount, true);
        return $newArray;
         
    }
    
    function get_top_number_of_test_today($amount,$type){
        $this->load->model('admin/admin_home_model');

        $list_today_tester = array();
        $list = $this->get_today_tester($type);
        foreach ($list as $key => $value) {
            $list_today_tester[$key]['user_id'] = $value;
            $list_today_tester[$key]['fullname'] = $this->admin_home_model->get_info($value)->last_name . ' '. $this->admin_home_model->get_info($value)->first_name;
            $number_of_test = $this->get_number_of_test_today_by_user_id($value,$type);
            $total_of_point = $this->get_total_of_point_today_by_user_id($value,$type);
            $list_today_tester[$key]['number_of_test'] = $number_of_test;
            $list_today_tester[$key]['total_of_point'] = $total_of_point;

            $tb = round(($total_of_point / $number_of_test),2);
            $list_today_tester[$key]['av_point'] = $tb;
        }
        //pre($list_today_tester);
        $list_today_tester = my_sort($list_today_tester,'number_of_test');
        $newArray = array_slice($list_today_tester, 0, $amount, true);
        return $newArray;
         
    }

    function get_top_point_of_test($test_id, $amount){
        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_test_model');
        $this->load->model('admin/admin_test_user_model');


        $input = array();
        $input['where'] = array('test_id'=> $test_id,'status'=>2,'valid'=>1);
        $input['order'] = array('total_point','DESC');
        $input['limit'] = array($amount ,'0');

        $list = $this->admin_test_user_model->get_list($input);
        return $list;
    }

    function get_top_point_of_user($user_id, $amount){
        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_test_model');
        $this->load->model('admin/admin_test_user_model');


        $input = array();
        $input['where'] = array('user_id'=> $user_id,'status'=>2,'valid'=>1);
        $input['order'] = array('total_point','DESC');
        $input['limit'] = array($amount ,'0');

        $list = $this->admin_test_user_model->get_list($input);
        return $list;
    }
    function get_all_test_of_user($user_id){
        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_test_model');
        $this->load->model('admin/admin_test_user_model');


        $input = array();
        $input['where'] = array('user_id'=> $user_id,'status'=>2,'valid'=>1);
        $input['order'] = array('id','DESC');

        $list = $this->admin_test_user_model->get_list($input);
        return $list;
    }

	public function get_test($test_id=null){

        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_test_model');
        // Users from a data store e.g. database
        $tests = $this->admin_test_model->get_list([
            'where' => ['valid'=>1]
        ]);
        $result= array();
        foreach ($tests as $key => $value) {
            $data = array();
            $data['id'] = $value->id;

            $info_user = $this->admin_home_model->get_info($value->creator_id);
            if($info_user){
                $data['creator'] = $info_user->last_name .' '.$info_user->first_name;
            }
            else {
                $data['creator'] = 'Không tồn tại';
            }

            $data['duration'] = $value->duration;
            
            $start_time = strtotime($value->start_date);
            $end_time = strtotime($value->end_date);

            if($start_time == $end_time){
                $data['time'] = 0;
            }

            if($start_time != $end_time && $start_time < strtotime(date('Y-m-d h:i:s'))){
                $data['time'] = 1;
            }

            if($start_time != $end_time && $start_time < strtotime(date('Y-m-d h:i:s'))){
                $data['time'] = 2;
            }

            $this->load->model('admin/admin_test_question_model');
            $list_added_questions = array();
            $list_added_questions = $this->admin_test_question_model->get_list([
                'where' => ['test_id'=>$value->id]
            ]);
            $data['number_of_question'] = 0;
            $data['number_of_question'] = count($list_added_questions);
            $data['description'] = $value->description;
            $data['start_date'] = $value->start_date;
            $data['end_date'] = $value->end_date;
            $data['created_at'] = $value->created_at;


            $result[] = $data;
        }

        
        if ($test_id == NULL){ return $result;}
        $test_id = intval($test_id);
        if ($test_id <= 0){ return $result;}
        if(($test_id !=null) && ($test_id > 0)){
            foreach ($result as $key => $value)
            {
                //pre($value);
                if (isset($value['id']) && ($value['id'] == $test_id))
                {
                    $test = $value;
                    return $test;
                }
            }
        }

    }

    function get_point_result($result){
        $arr = explode(",", $result);
        $mark_arr = array();
        $this->load->model('admin/admin_answer_model');
        $this->load->model('admin/admin_question_model');

        foreach ($arr as $key => $value) {
            $temp =  explode("-", $value);
            $answer_id = $temp[1];
            if($answer_id == 0){
                $mark_arr[$key] =0;
            }
            else{
                $info_answer = $this->admin_answer_model->get_info($answer_id);
                if(!$info_answer){
                    $mark_arr[$key] =0;
                }
                else{
                    if($info_answer->is_correct == 1){
                        $question_id = $temp[0];
                        $info_question = $this->admin_question_model->get_info($question_id);
                        if(!$info_question){
                            $mark_arr[$key] =0;
                        }else{
                            $mark_arr[$key] = $info_question->point;
                        }
                    }else{
                        $mark_arr[$key] =0;
                    }
                }
            }


        }
        return $mark_arr;
    }

    function get_point_total($result){
        $arr = explode(",", $result);
        $mark_arr = array();
        $this->load->model('admin/admin_answer_model');
        $this->load->model('admin/admin_question_model');

        foreach ($arr as $key => $value) {
            $temp =  explode("-", $value);

            $question_id = $temp[0];
            $info_question = $this->admin_question_model->get_info($question_id);
            if(!$info_question){
                $mark_arr[$key] =0;
            }else{
                $mark_arr[$key] =$info_question->point;
            }

        }
        return $mark_arr;
    }

    function get_final_point($result){
        $my_mark = $this->get_point_result($result);
        $my_point =0; 
        foreach ($my_mark as $key => $value) {
            $my_point = $my_point + $value;
        }

        $mark_point =0;
        $mark = $this->get_point_total($result);
        foreach ($mark as $key => $value) {
            $mark_point = $mark_point + $value;
        }

        return round(($my_point / $mark_point * 100),2);
    }

    public function get_category_question_name_by_id($id){
        if($id!=0){
            $this->load->model('admin/admin_question_cate_model');
            $info = $this->admin_question_cate_model->get_info($id);
            if($info){
                return $info->name;
            }
            else {
                return 'Không tồn tại';
            }
            
        }
        else {
            return 'Thư mục gốc';
        }
    }

    function get_random_question_by_category_id($cate_id, $amount){
        $question_array = array();

        if(($cate_id==0) || ($cate_id==1)){
            $this->db->select('*');
            $this->db->order_by('rand()');
            $this->db->limit($amount);
            $query = $this->db->get('tb_questions'); //<table> is the db table name
            $result = $query->result_array();
            return $result;
        }
        if($cate_id > 1){
            $this->db->select('*');
            $this->db->order_by('rand()');
            $this->db->where('cate_id', $cate_id);
            $this->db->limit($amount);
            $query = $this->db->get('tb_questions'); //<table> is the db table name
            $result = $query->result_array();
            return $result;
        }
    }

    function get_one_random_question_by_category_id($cate_id){
        $this->load->model('admin/admin_question_model');
        if(($cate_id==0) || ($cate_id==1)){
            $this->db->select('*');
            $this->db->order_by('rand()');
            $this->db->limit(1);
            $query = $this->db->get('tb_questions'); //<table> is the db table name
            $result = $query->result_array();
            return $result[0]['id'];
        }

        if($cate_id > 1){
            $this->db->select('*');
            $this->db->order_by('rand()');
            $this->db->where('cate_id', $cate_id);
            $this->db->limit(3);
            $query = $this->db->get('tb_questions'); //<table> is the db table name
            $result = $query->result_array();
            return $result;
        }
    }

    function get_random_amount($picked_question_cate, $total){
        $numbers = [];
        $num_numbers = count($picked_question_cate);

        $loose_pcc = $total / $num_numbers;
    
        for($i = 1; $i < $num_numbers; $i++) {
            // Random number +/- 10%
            $ten_pcc = $loose_pcc * 0.1;
            $rand_num = mt_rand( ($loose_pcc - $ten_pcc), ($loose_pcc + $ten_pcc) );
    
            $numbers[] = $rand_num;
        }
    
        // $numbers now contains 1 less number than it should do, sum 
        // all the numbers and use the difference as final number.
        $numbers_total = array_sum($numbers);
    
        $numbers[] = $total - $numbers_total;
    
        return $numbers;
    }

    function get_list_child_of_question_cate($cate_id){
        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');

        $node = $this->nested_set->getNodeFromId($cate_id);
        $l = $this->nested_set->getSubTree($node);
        //array_shift($l['items']);
        return $l['items'];
    }

    function get_question_array($question_array){
        $result = array();
        foreach ($question_array as $key => $value) {
            $temp = array();
            $temp = $this->get_list_child_of_question_cate($value);
            foreach ($temp as $k => $v) {
                if(in_array(intval($v['id']), $result) == false){
                    $result[] = $v['id'];
                }
            }
        }
        return $result;
    }

    function get_result_test($result){

        if(!$result){

            return ' KHÔNG TỒN TẠI';
        }
        else{
            $result_array = explode(",",$result);
            $html = "";
            $html .= '<div class="col-xs-11"><div class="control-group">';
            foreach ($result_array as $key => $value) {
                $child_result = explode("-",$value);
                $question_id = $child_result[0];
                $chosen = $child_result[1];
                $question = array();
                $this->load->model('admin/admin_question_model');
                $question = $this->admin_question_model->get_info($question_id);

                $this->load->model('admin/admin_answer_model');
                $list_answers = array();
                $list_answers = $this->admin_answer_model->get_list([
                    'where' => ['question_id'=>$question_id]
                ]);
                $html2 = "";
                $html2 .= '<label class="control-label bolder blue">'.$question->title.'</label>';
                
                foreach ($list_answers as $k => $v) {
                    $color=""; $check ="";
                    if($chosen == $v->id){
                        if($v->is_correct == 1){
                            $color = "green";
                        }else {
                            $color = "red";
                        }
                    }
                    if($v->is_correct == 1){
                        $check = "checked";
                    }
                    $html2 .= '<div class="checkbox"><label><input name="form-field-checkbox" type="checkbox" class="ace" '.$check.' /><span class="lbl '.$color.'">'.$v->title.'</span></label></div>';
                }

                $html .= $html2;
            }

            return $html;
        }
    }
}
