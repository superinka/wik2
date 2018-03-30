<?php
require_once APPPATH."/third_party/pusher/Pusher.php";
class Posts extends Admin_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_post_model');
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }
    
    function index(){
        
        $this->load->model('admin/admin_post_model');
        $total_posts = $this->admin_post_model->get_total();
        $this->data['total_posts'] = $total_posts;
        
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
        $this->load->model('common_model');
        
        $list_category = $this->common_model->get_list_root_category_with_children();
        $this->data['list_category'] = $list_category;
        
        //pre($list_category);
        
        $list_member = $this->common_model->get_list_author();
        $this->data['list_member'] = $list_member;

        
        $this->data['list_posts'] = $list_posts;
        
        $total = count($list_posts);
        $this->data['total'] = $total;
        
        $this->data['temp'] = 'post';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    public function trigger_event($data)
	{
        $options = array(
			'cluster' => 'ap1',
			'encrypted' => true
		  );
		  $pusher = new Pusher\Pusher(
			'871d2a6dc4aa9c3ef60d',
			'b55af006e90fe83953a5',
			'480825',
			$options
		  );

		// Set message
		//$data['message'] = 'This message was sent at ' . date('Y-m-d H:i:s');

		// Send message
		$event = $pusher->trigger('my-channel', 'my-event', $data);

		if ($event === TRUE)
		{
			echo 'Event triggered successfully!';
		}
		else
		{
			echo 'Ouch, something happend. Could not trigger event.';
		}
	}
    
    function filter(){
        
        $search_term     = isset($_POST['search_term']) ? trim($_POST['search_term']) : '';
        $search_category     = isset($_POST['search_category']) ? trim($_POST['search_category']) : '';
        $author   = $_POST['author'];
        $access     = $_POST['access'];
        
        $data_search = array(
            'search_term'   => $search_term,
            'search_category'   => $search_category,
            'author' => $author,
            'access'        => $access
        );
        //pre($data_search);
        $result = array();
        $this->load->model('admin/admin_post_model');
        $result = $this->admin_post_model->get_filter($data_search);
        //pre($result);
        
        $this->load->model('common_model');
        $my_id = $this->my_id;
      
        $new_list = array();
        //pre(count($result));
        if(count($result)>0){
            $new_list = $this->common_model->get_list_post_i_can_see($result, $my_id);
            //pre($new_list);
        }
        
        $this->data['new_list'] = $new_list;
        
        $this->data['temp'] = 'filter';
        $this->load->view('filter', $this->data);
    }
    
    function add(){
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->model('common_model');
        
        $this->load->model('admin/admin_post_relate_model');
        $this->load->model('admin/admin_category_model');
        
        
        $list_category = $this->common_model->get_list_root_category_with_children();
        $this->data['list_category'] = $list_category;
        
        $my_id = $this->my_id;
        
        $list_post_relate = $this->common_model->get_list_post_relate();
        $this->data['list_post_relate'] = $list_post_relate;
        //pre($list_post_relate);
        
        if($this->input->post()){
            $this->form_validation->set_rules('post-name', 'Tên bài viết', 'trim|max_length[100]|min_length[5]',
            array(
                'min_length'      => 'Tên quá ngắn.Giới hạn : 5 kí tự',
                'max_length'      => 'Tên quá dài.Giới hạn : 100 kí tự'
            ));
            $this->form_validation->set_rules('description', 'description', 'trim');
            $this->form_validation->set_rules('slug', 'viết tắt', 'trim');
            
            $this->form_validation->set_rules('image', 'Ảnh', 'callback_file_check');
            
            if($this->form_validation->run()){
                $post_name = $this->input->post('post-name');
                $description = $this->input->post('description');
                $slug = $this->input->post('slug');
                $category = $this->input->post('category');
                $process = $this->input->post('process');
                $comment_permit = $this->input->post('comment_permit');
                $content = $this->input->post('txt_content');

                $content = htmlspecialchars($content);
                
                $list_relate = $this->input->post('relate');
                $access = $this->input->post('access');
                
                $relate_post = $this->input->post('relate_post');
                $tags = $this->input->post('tags');
                
                if($relate_post !=null){
                    $relate_post = implode(",",$relate_post);
                }
                //pre($relate_post);
                
                //pre($list_relate);
                if($comment_permit=='on') {$comment_permit = 1;}
                else {$comment_permit = 0;}
                
                $this->load->library('upload_library');
                $upload_path = './public/upload/thumbnail/';
                $data_upload = array();
                
                //pre($_FILES['image']);
                
                if (empty($_FILES['image']['name'])) {
                    $data_upload['file_name'] = 'no-thumbnail.jpg';
                    $data_post = array(
                        'name'   => $post_name,
                        'content' => $content,
                        'slug'        => $slug,
                        'process'      => $process,
                        'category'     => $category,
                        'created_by'     => $my_id,
                        'is_comment_enabled' => $comment_permit,
                        'relate_posts'       => $relate_post,
                        'thumbnail' =>    $data_upload['file_name']
                    );
                }
                else {
                    
                    //pre($this->upload_library->validate_upload_path($upload_path));
                    
                    $data_upload = $this->upload_library->upload($upload_path, 'image');
                    //pre($data_upload);
                    
                    $data_post = array(
                        'name'   => $post_name,
                        'content' => $content,
                        'slug'        => $slug,
                        'process'      => $process,
                        'category'     => $category,
                        'created_by'     => $my_id,
                        'is_comment_enabled' => $comment_permit,
                        'relate_posts'       => $relate_post,
                        'thumbnail'   => $data_upload['file_name']
                    );
                    
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = './public/upload/thumbnail/'.$data_upload['file_name'];
                    //$config['new_image'] = 'C:\xampp\htdocs\miblog\public\upload\thumbnail\new_resize_img.jpg';
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width']         = '640';
                    $config['height']       = '395';
                    
                    
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    
                    if ( ! $this->image_lib->resize())
                    {
                        echo $this->image_lib->display_errors();
                    }else{
                        echo "<strong>Your image has been resize successfully..!!</strong>";
                    }
                }
                
                
                
                
                $data_post['description'] = $description;
                
                $data_post['publish_time'] = date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s');
                $data_post['last_edit'] = date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s');
                $data_post['publish_year'] = intval(date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y'));
                $data_post['publish_month'] = intval(date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('m'));
                
                $post_key =  $data_post['publish_time'].$slug.$my_id;
                $post_key = md5($post_key);
                
                $post_key = generate_uuid($post_key);
                //pre($post_key);
                
                $data_post['post_key'] = $post_key;
                $data_post['access'] =$access;
                
                $this->load->model('admin_tag_model');
                $this->load->model('admin_post_tag_model');
                
                //pre($data_post);
                //pre($tags);
                $my_user_name = $this->my_user_name;
                $tags = explode(',', $tags);
                //pre($tags);
                if($this->admin_post_model->create($data_post)){
                    $this->session->set_flashdata('message','Thêm dữ liệu thành công');

                    $data['title'] = $my_user_name;    
                    $data['message'] = 'Vừa viết bài mới : '.$post_name;
                    $this->trigger_event($data);

                    $new_post = $this->admin_post_model->get_column('tb_posts','id',$where=array('post_key'=>$post_key));
                    $new_post_id = $new_post[0]->id;
                    
                    // add relate members
                    
                    if($list_relate!=null){
                        foreach ($list_relate as $x => $y) {
                            $data = array(
                                'user_id' => $y,
                                'post_id'    => $new_post_id,
                                'update_time'   => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                            );
                            
                            $this->admin_post_relate_model->create($data);
                        }
                    }
                    
                    // add post tags
                    if($tags!=null){
                        foreach ($tags as $x => $y) {
                            $y = trim($y);
                            //pre($y);
                            $where = array('title' => $y);

                            if($this->admin_tag_model->check_exists($where) == false){
                                $data_tag = array(
                                    'title' => $y,
                                    'frequency' => 1
                                );
                                //pre($y);
                                $this->admin_tag_model->create($data_tag);
                            }
                            else {
                                // dem so lan xuat hien
                                $a = $this->admin_tag_model->get_column('tb_tags','id',$where=array('title'=>$y));
                                $b = $a[0]->id;
                                $sum = $this->admin_post_tag_model->get_column('tb_posts_tags','post_id',$where=array('tag_id'=>$b));
                                $sum = count($sum);
                                //pre($b);
                                $d = array(
                                    'frequency' => $sum
                                );
                                $this->admin_tag_model->update($b, $d);
                            }
                            
                            $new_tag = $this->admin_tag_model->get_column('tb_tags','id',$where=array('title'=>$y));
                            $new_tag_id = $new_tag[0]->id;
                            
                            //pre($new_tag_id);
                            
                            $data_post_tag = array(
                                'post_id' => $new_post_id,
                                'tag_id'  => $new_tag_id
                            );
                            
                            //pre($data_post_tag);
                            $this->admin_post_tag_model->create($data_post_tag);
                        }
                    }
                    
                    
                }
                else{
                    $this->session->set_flashdata('message','Thêm dữ liệu không thành công');
                }
                redirect(base_url('admin/posts'));
            }
        }
        
        $this->data['temp'] = 'add_post';
        $this->load->view('admin-layout/main', $this->data);
    }
    
    function edit(){
        
        //load model
        
        $this->load->model('admin_category_model');
        $this->load->model('admin_post_relate_model');
        $this->load->model('admin_tag_model');
        $this->load->model('admin_post_tag_model');
        
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->model('common_model');
        
        
        //lay id post can sua
        $post_id = $this->uri->segment(4);
        $post_id = intval($post_id);
        
        $this->data['post_id'] = $post_id;
        
        //$now_user_id = $this->data['id'];
        
        
        //lay thong tin post
        
        $info_post = $this->admin_post_model->get_info($post_id);
        if(!$info_post) {
            $this->session->set_flashdata('message','Không tồn tại thông tin bài viết');
            redirect(base_url('admin/posts'));
        }
        else {
            
            $this->data['info_post'] = $info_post;
            $input = array();
            //$input['where']['Parent_Cate'] = 0;
            $list_category = $this->common_model->get_list_root_category_with_children();
            $this->data['list_category'] = $list_category;
            
            $list_members_relate = $this->admin_post_relate_model->get_column('tb_posts_relate','user_id',$where=array('post_id'=>$post_id));
            $list_new = array();
            foreach ($list_members_relate as $key => $value) {
                $list_new[] = $value->user_id;
            }
            $this->data['list_new'] = $list_new;
            

            
            //pre($list_new);
            
            $list_tags = $this->admin_post_tag_model->get_column('tb_posts_tags','tag_id',$where=array('post_id'=>$post_id));
            
            $arr_tag = array();
            
            foreach ($list_tags as $key => $value) {
                $tag_id = $value->tag_id;
                $info_tag = $this->admin_tag_model->get_info($tag_id);
                $arr_tag[] = $info_tag->title;
            }
            
            //pre($arr_tag);
            
            $string_tag = implode(',', $arr_tag);
            $this->data['string_tag'] = $string_tag;
            
            $my_id = $this->my_id;
            
            $list_post_relate = $this->common_model->get_list_post_relate();
            
            
            
            foreach ($list_post_relate as $key => $value){
                if($value['id'] == $info_post->id){
                    unset($list_post_relate[$key]);
                }
            }
            $this->data['list_post_relate'] = $list_post_relate;
            //pre($list_post_relate);
            
            //list id tất cả bài viết
            $list_id = array();
            if($info_post->relate_posts != null) {
                $list_id = explode(",", $info_post->relate_posts);
            }
            $this->data['list_id'] = $list_id;
            //pre($string_tag);
            
            if($this->input->post()){
                $this->form_validation->set_rules('post-name', 'Tên bài viết', 'trim|max_length[100]|min_length[5]',
                array(
                    'min_length'      => 'Tên quá ngắn.Giới hạn : 5 kí tự',
                    'max_length'      => 'Tên quá dài.Giới hạn : 100 kí tự'
                ));
                $this->form_validation->set_rules('description', 'description', 'trim');
                $this->form_validation->set_rules('slug', 'viết tắt', 'trim');
                
                $this->form_validation->set_rules('image', 'Ảnh', 'callback_file_check');
                
                if($this->form_validation->run()){
                    $post_name = $this->input->post('post-name');
                    $description = $this->input->post('description');
                    $slug = $this->input->post('slug');
                    $category = $this->input->post('category');
                    $process = $this->input->post('process');
                    $comment_permit = $this->input->post('comment_permit');
                    $content = $this->input->post('txt_content');
                    $relate_post = $this->input->post('relate_post');
                    $list_relate = $this->input->post('relate');
                    $access = $this->input->post('access');

                    $content = htmlspecialchars($content);
                    
                    $tags = $this->input->post('tags');
                    if($relate_post !=null){
                        $relate_post = implode(",",$relate_post);
                    }
                    
                    
                    //pre($list_relate);
                    if($comment_permit=='on') {$comment_permit = 1;}
                    else {$comment_permit = 0;}
                    
                    $this->load->library('upload_library');
                    $upload_path = './public/upload/thumbnail/';
                    $data_upload = array();
                    
                    //pre($_FILES['image']['name']);
                    
                    if (empty($_FILES['image']['name'])) {
                        $data_upload['file_name'] = 'no-thumbnail.jpg';
                        $data_post = array(
                            'name'   => $post_name,
                            'content' => $content,
                            'slug'        => $slug,
                            'process'      => $process,
                            'category'     => $category,
                            'is_comment_enabled' => $comment_permit,
                            'relate_posts'       => $relate_post
                        );
                    }
                    else {
                        
                        
                        $data_upload = $this->upload_library->upload($upload_path, 'image');
                        //pre($data_upload);
                        $data_post = array(
                            'name'   => $post_name,
                            'content' => $content,
                            'slug'        => $slug,
                            'process'      => $process,
                            'category'     => $category,
                            'is_comment_enabled' => $comment_permit,
                            'relate_posts'       => $relate_post,
                            'thumbnail'   => $data_upload['file_name']
                        );
                    }
                    
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = './public/upload/thumbnail/'.$data_upload['file_name'];
                    //$config['new_image'] = 'C:\xampp\htdocs\miblog\public\upload\thumbnail\new_resize_img.jpg';
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width']         = '640';
                    $config['height']       = '395';
                    
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    
                    if ( ! $this->image_lib->resize())
                    {
                        echo $this->image_lib->display_errors();
                    }else{
                        echo "<strong>Your image has been resize successfully..!!</strong>";
                    }
                    
                    $data_post['description'] = $description;
                    
                    
                    $data_post['last_edit'] = date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s');
                    $data_post['access'] =$access;
                    //pre($data_post);
                    
                    if($access!=2){
                        $this->admin_post_relate_model->del_rule($where=array('post_id'=>$post_id));
                    }
                    if($access==2){
                        $this->admin_post_relate_model->del_rule($where=array('post_id'=>$post_id));
                    }
                    $my_user_name = $this->my_user_name;
                    if($this->admin_post_model->update($post_id, $data_post)){
                        $this->session->set_flashdata('message','Sửa dữ liệu thành công');

                        $data['title'] = $my_user_name;    
                        $data['message'] = 'Vừa sửa bài : '.$post_name;
                        $this->trigger_event($data);
                        //pre($list_relate);
                        
                        if($list_relate!=null){
                            foreach ($list_relate as $x => $y) {
                                $data = array(
                                    'user_id' => $y,
                                    'post_id'    => $post_id,
                                    'update_time'   => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                                );
                                
                                $this->admin_post_relate_model->create($data);
                            }
                        }
                        
                        
                        
                        //pre($tags);
                        $this->admin_post_tag_model->del_rule($where=array('post_id'=>$post_id));
                        if($tags !=null){
                            $tags = explode(',', $tags);
                            foreach ($tags as $x => $y) {
                                $y = trim($y);
                                //pre($y);
                                $where = array('title' => $y);
                                
                                if($this->admin_tag_model->check_exists($where) == false){
                                    
                                    $data_tag = array(
                                        'title' => $y,
                                        'frequency' => 1
                                    );
                                    //pre($y);
                                    $this->admin_tag_model->create($data_tag);
                                    $a = $this->admin_tag_model->get_column('tb_tags','id',$where=array('title'=>$y));
                                    $b = $a[0]->id;
                                    $data_post_tag = array(
                                        'post_id' => $post_id,
                                        'tag_id'  => $b
                                    );
                                    $this->admin_post_tag_model->create($data_post_tag);
                                    
                                    $sum = $this->admin_post_tag_model->get_column('tb_posts_tags','post_id',$where=array('tag_id'=>$b));
                                    $sum = count($sum);
                                    //pre($b);
                                    $d = array(
                                        'frequency' => $sum
                                    );
                                    $this->admin_tag_model->update($b, $d);
                                }
                                else {
                                    
                                    $a = $this->admin_tag_model->get_column('tb_tags','id',$where=array('title'=>$y));
                                    $b = $a[0]->id;
                                    $data_post_tag = array(
                                        'post_id' => $post_id,
                                        'tag_id'  => $b
                                    );
                                    $this->admin_post_tag_model->create($data_post_tag);
                                    
                                    $sum = $this->admin_post_tag_model->get_column('tb_posts_tags','post_id',$where=array('tag_id'=>$b));
                                    $sum = count($sum);
                                    //pre($b);
                                    $d = array(
                                        'frequency' => $sum
                                    );
                                    $this->admin_tag_model->update($b, $d);
                                    
                                }
                            }
                        }
                        
                        
                        
                    }
                    else{
                        $this->session->set_flashdata('message','Thêm dữ liệu không thành công');
                    }
                    redirect(base_url('admin/posts'));
                }
            }
            
        }
        
        $this->data['temp'] = 'edit_post';
        $this->load->view('admin-layout/main', $this->data);
    }
    
    function delete(){
        $response = array();
        $this->load->model('admin/admin_post_relate_model');
        $this->load->model('admin/admin_post_tag_model');
        
        if ($_POST['delete']) {
            
            
            $pid = intval($_POST['delete']);
            $info_post = $this->admin_post_model->get_info($pid);
            
            
            if(!$info_post) {
                $this->session->set_flashdata('message','Không tồn tại thông tin danh mục');
                redirect(base_url('admin/posts'));
            }
            else {
                if($this->admin_post_model->delete($pid)){
                    
                    $this->admin_post_relate_model->del_rule($where=array('post_id'=>$pid));
                    $this->admin_post_tag_model->del_rule($where=array('post_id'=>$pid));
                    
                    $this->session->set_flashdata('message','Xóa dữ liệu thành công ');
                    $response['status']  = 'success';
                    $response['message'] = 'Danh mục đã được xóa thành công ...';
                }
                else {
                    $response['status']  = 'success';
                    $response['message'] = 'Danh mục đã được xóa không thành công ...';
                }
            }
            
            die (json_encode($response));
            $this->data['response'] = $response;
        }
        $this->data['temp'] = 'post_delete';
        $this->load->view('post_delete', $this->data);
    }
    
    function remote_source(){
        $response = array();
        
        //pre($_GET['q']);
        
        if ($_GET['q']) {
            
            $phase = $_GET['q'];
            $this->db->select('*');
            $this->db->from('tb_tags');
            $this->db->like('title', $phase);
            $arr = $this->db->get()->result_array();
            //pre($arr);
            foreach ($arr as $key => $value) {
                $response[] = $value['title'];
            }
            
            //pre($response);
            
            die (json_encode($response));
            $this->data['response'] = $response;
        }
        
        $this->data['temp'] = 'remote_source';
        $this->load->view('remote_source', $this->data);
        
    }

    public function autocomplete()
    {
            $search_data = $this->input->post('search_data');

            $result = $this->admin_post_model->get_autocomplete($search_data);

            if (!empty($result))
            {
                foreach ($result as $row):
                    $link = base_url($row->slug.'-'.$row->id.'.html');
                    echo '<li><a target="_blank" href="'.$link.'">' . $row->name . '</a></li>';
                endforeach;
            }
            else
            {
                echo "<li> <em> Not found ... </em> </li>";
            }

    }
    
    
    public function file_check($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['image']['name']);
        if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=""){
            
            if($_FILES['image']['size'] > 500000 || $_FILES['image']['size'] == 0){
                $this->form_validation->set_message('file_check', '<strong style="color:red">File quá lớn </strong>');
                return false;
            }
            
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', '<strong style="color:red">Xin chọn đúng định dạng gif/jpg/png.</strong>');
                return false;
            }
        }
    }
}
