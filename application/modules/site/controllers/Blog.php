<?php
class Blog extends Public_Controller {
    function __construct() {
        parent:: __construct();
        
        $this->load->model('site/site_post_model');
        $this->load->model('site/site_category_model');
        $this->load->model('site/site_home_model');
        $this->load->model('site/site_blog_model');
    }
    function index(){
        
    }
    
    function detail(){
        
        $this->load->model('site/site_comment_model');
        
        $str = $this->uri->segment(1);
        
        $str_arr = explode('-', $str);
        $last = end($str_arr);
        $str_last = explode('.',$last);
        
        $post_id = $str_last[0];
        $del = array_pop($str_arr);
        $post_slug = implode("-", $str_arr);
        
        //echo $post_slug;
        
        //$now_user_id = $this->data['id'];
        
        
        $my_id = $this->my_id;
        
        $info_post = $this->site_post_model->get_info($post_id);
        if(!$info_post) {
            $this->session->set_flashdata('message','Không tồn tại thông tin bài viết');
            redirect(base_url('site/home'));
            //echo '1';
        }
        else {
            
            $this->data['info_post'] = $info_post;
            
            if($info_post->slug != $post_slug){
                $this->session->set_flashdata('message','Không tồn tại thông tin bài viết');
                redirect(base_url('site/home'));
                //echo'2';
            }
            else {
                $this->load->model('common_model');
                if($my_id==0){
                    if($info_post->access > 0) {
                        $this->session->set_flashdata('message','Không có quyền xem bài viết');

                        $this->data['temp'] = 'login_model';
                        $this->load->view('site/site-layout/main', $this->data);
                        //redirect(base_url('site/home'));
                    }
                    else {
                        $this->add_count($post_id);
                        
                        //pre($info_post);
                        
                        $category_name = $this->common_model->get_category_name_by_id($info_post->category);
                        $user_name = $this->common_model->get_user_name_by_id($info_post->created_by);
                        //pre($user_name);
                        
                        $this->data['category_name'] = $category_name;
                        $this->data['user_name'] = $user_name;
                        $list_comments = null;
                        $list_comments = $this->site_comment_model->get_blog_comments($post_id);
                        //pre($list_comments);
                        $this->data['list_comments'] = $list_comments;
                    
                        $list_id = explode(",", $info_post->relate_posts);
                        $list_relate_posts = array();
                        if(count($list_id) > 0){
                            foreach ($list_id as $key => $value){
                                $info_p = $this->site_post_model->get_info($value);
                                if($info_p){
                                    $list_relate_posts[$key]['id'] = $info_p->id;
                                    $list_relate_posts[$key]['name'] = $info_p->name;
                                    $list_relate_posts[$key]['slug'] = $info_p->slug;
                                    
                                }
                            }
                        }
                        //pre($list_relate_posts);
                        $this->data['list_relate_posts'] = $list_relate_posts;

                        $this->data['temp'] = 'blog_detail';
                        $this->load->view('site/site-layout/main', $this->data);
                    }

                }
                else{
                    $this->add_count($post_id);
                    
                    //pre($info_post);
                    
                    $category_name = $this->common_model->get_category_name_by_id($info_post->category);
                    $user_name = $this->common_model->get_user_name_by_id($info_post->created_by);
                    //pre($user_name);
                    
                    $this->data['category_name'] = $category_name;
                    $this->data['user_name'] = $user_name;
                    $list_comments = null;
                    $list_comments = $this->site_comment_model->get_blog_comments($post_id);
                    //pre($list_comments);
                    $this->data['list_comments'] = $list_comments;
                    
                    $list_id = explode(",", $info_post->relate_posts);
                    $list_relate_posts = array();
                    if(count($list_id) > 0){
                        foreach ($list_id as $key => $value){
                            $info_p = $this->site_post_model->get_info($value);
                            if($info_p){
                                $list_relate_posts[$key]['id'] = $info_p->id;
                                $list_relate_posts[$key]['name'] = $info_p->name;
                                $list_relate_posts[$key]['slug'] = $info_p->slug;
                                
                            }
                        }
                    }
                    $this->data['list_relate_posts'] = $list_relate_posts;

                    $this->data['temp'] = 'blog_detail';
                    $this->load->view('site/site-layout/main', $this->data);

                }

            }
            
            
        }
        
    }

    function modal_login(){
        $errors = array(
            'error' => 0
        );
        $username     = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password     = isset($_POST['password']) ? trim($_POST['password']) : '';

        // if (isset($_POST['username'])) {
        //     $username = strip_tags($_POST['username']);
        //     $password = strip_tags($_POST['password']);
        //     echo $username;
        //     //echo "<div class=\"alert alert-success\"><strong>Success!</strong> This Is Success Thanks Message. If everything go exactly as Planned.</div>";
        // }
        
        if (empty($username)){
            $errors['username'] = 'Bạn chưa nhập tên đăng nhập';
        }
        if (empty($password)){
            $errors['password'] = 'Xin nhập password';
        }
        if (count($errors) > 1){
            $errors['error'] = 1;
            die (json_encode($errors));
        }

        $this->load->model('login_model');
        $result = $this->login_model->login($username, $password);
        //echo $username . ' - ' . $password;

        if($result)
        {

            $sess_array = array();
            foreach($result as $row)
            {
            //pre($row);
            $sess_array = array(
                'id' => $row->id,
                'user_name' => $row->user_name,
                'role' => $row->role

            );
            $this->session->set_userdata('logged_in', $sess_array);
            }
        }
        else
        {
            $errors['error'] = 1;
            $errors['e'] = 'Sai tên đăng nhập hoặc mật khẩu';
            die (json_encode($errors));
        }
        die (json_encode($errors));
    }
    
    function add_blog_comment() {
        
        $this->load->model('site/site_comment_model');
        
        
        if (isset($_POST) && isset($_POST['comment_text'])) {
            
            $name = $_POST['comment_name'];
            $post_id = $_POST['content_id'];
            $parent_id = $_POST['reply_id'];
            $comment_text = $_POST['comment_text'];
            $email = $_POST['comment_email'];
            
            $data = array(
                'comment' => $comment_text,
                'parent_id' => $parent_id,
                'ip_address' => $this->input->ip_address(),
                'email' => $email,
                'comment_time' => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                'name' => $name,
                'post_id' => $post_id
            );
            $resp = $this->site_comment_model->add_blog_comment($data);
            $this->data['resp'] = $resp;
            
            $this->data['temp'] = 'new_comment';
            $this->load->view('new_comment', $this->data);
            //pre($resp);
        }
    }
    
    
    // This is the counter function..
    function add_count($post_id){
        // load cookie helper
        $this->load->helper('cookie');
        // this line will return the cookie which has slug name
        $check_visitor = $this->input->cookie(urldecode($post_id), FALSE);
        // this line will return the visitor ip address
        $ip = $this->input->ip_address();
        // if the visitor visit this article for first time then //
        //set new cookie and update article_views column  ..
        //you might be notice we used slug for cookie name and ip
        //address for value to distinguish between articles  views
        if ($check_visitor == false) {
            $cookie = array(
                "name"   => urldecode($post_id),
                "value"  => "$ip",
                "expire" =>  time() + 7200,
                "secure" => false
            );
            $this->input->set_cookie($cookie);
            $this->site_blog_model->update_counter(urldecode($post_id));
        }
    }
}
?>