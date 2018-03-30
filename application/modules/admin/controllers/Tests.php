<?php
class Tests extends Admin_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_test_model');
        $this->load->model('admin/admin_test_question_model');
        $this->load->model('admin/admin_question_model');
        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_test_user_model');

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }

    function index(){

        $total_tests = $this->admin_test_model->get_total();
        $this->data['total_tests'] = $total_tests;

        $this->load->library("pagination");
        
        // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->admin_test_model->get_total();
        $list_test = array();
        
        if ($total_records > 0)
        {
            // get current page records
            $list_test = $this->admin_test_model->get_current_page_records($limit_per_page, $start_index,'id');
            
            $config['base_url'] = base_url()."admin/tests";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            //$config['use_page_numbers'] = true;
            $config['first_url'] = base_url('admin/tests');
            $config['first_link'] = 'Trang đầu';
            $config['first_tag_close'] = '</span>';
            $config['last_link'] = 'Trang cuối';
            $config['next_link'] = 'Trang tiếp';
            $config['prev_link'] = 'Trang trước';
            
            
            $this->pagination->initialize($config);
            
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        
        $this->data['list_test'] = $list_test;

        $this->data['temp'] = 'test/index';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function add_test(){

        if($this->input->post()){
            $this->form_validation->set_rules('duration', 'Thời lượng', 'numeric',
                array('numeric' => '<b style="color:red">%s Phải là số</b>')
            );
            $this->form_validation->set_rules('description', 'Description', 'trim|required',
                array('required' => '<b style="color:red">%s Không được trống</b>')
            );
            $this->form_validation->set_rules('start_time', 'Thời gian bắt đầu', 'trim');
            $this->form_validation->set_rules('end_time', 'Thời gian kết thúc', 'callback_time_check');
            
            
            if($this->form_validation->run()){
                
                $description = $this->input->post('description');
                $duration = $this->input->post('duration');
                $category = $this->input->post('category');
                $valid = $this->input->post('valid');
                $type = $this->input->post('type');
                $start_time = $this->input->post('start_time');
                $end_time = $this->input->post('end_time');


                
                $start_time = convert_time($start_time);
                $end_time = convert_time($end_time);
                
                if($valid=='on') {
                    $valid = 1;
                }
                else {
                    $valid = 0;
                }
                
                $data_test = array(
                    'description' => $description,
                    'duration'    => $duration,
                    'test_type'   => $type,
                    'valid'       => $valid,
                    'start_date'  => $start_time,
                    'end_date'    => $end_time,
                    'creator_id'  => $this->my_id,
                    'created_at'  => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                    'updated_at'  => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
                );

                if($this->admin_test_model->create($data_test)){
                    $this->session->set_flashdata('message','Thêm dữ liệu thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm dữ liệu không thành công');
                }
                redirect(base_url('admin/tests'));

                //pre($data_test);
                
            }
        }


        $this->data['temp'] = 'test/add_test';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function info(){
        $this->load->model('admin_answer_model');
        $this->load->model('admin_home_model');
             
        //lay id post can sua
        $test_id = $this->uri->segment(4);
        $test_id = intval($test_id);
        
        $this->data['test_id'] = $test_id;

        $test_info = $this->admin_test_model->get_info($test_id);
        if(!$test_info) {
            $this->session->set_flashdata('message','Không tồn tại thông tin bài viết');
            redirect(base_url('admin/tests'));
        }
        else {

            
            $this->data['test_info'] = $test_info;

            // get all questions
            $all_questions = array();
            $all_questions = $this->admin_question_model->get_list();
            $this->data['all_questions'] = $all_questions;

            // get list added questions
            $list_added_questions = array();
            $list_added_questions = $this->admin_test_question_model->get_list([
                'where' => ['test_id'=>$test_info->id]
            ]);
            $dem =0;
            foreach ($list_added_questions as $key => $value) {
                $question_id = $value->question_id;
                $info_question = $this->admin_question_model->get_info($question_id);
                if($info_question) {
                    $value->info_question = $info_question;
                    $list_answer = array();
                    $list_answers = $this->admin_answer_model->get_list([
                        'where' => ['question_id'=>$info_question->id]
                    ]);
    
                    if(count($list_answers)==0){
                        $dem++;
                    }
    
                    $value->list_answer = $list_answers;
                }
            }
            $total_point = 0;
            foreach ($list_added_questions as $key => $value) {
                $point = $value->info_question->point;
                $total_point = $point + $total_point;
            }
            $this->data['total_point'] = $total_point;
            
            $this->data['dem'] = $dem;

            //get question cate

            $this->load->library('nested_set');

            $this->nested_set = new Nested_set();
            $this->nested_set->setControlParams('tb_question_cate');
    
            $html = $this->nested_set->getTreeAsHTMLDropDown3($fields=array('name'));
            
            $this->data['html'] = $html;

            // get all members
            $all_members = array();
            $all_members = $this->admin_home_model->get_list();
            $this->data['all_members'] = $all_members;

            // get list added member
            $list_added_members = array();
            $list_added_members = $this->admin_test_user_model->get_list([
                'where' => ['test_id'=>$test_info->id]
            ]);

            foreach ($list_added_members as $key => $value) {
                $user_id = $value->user_id;
                $info_member = $this->admin_home_model->get_info($user_id);
                if($info_member) {
                    $value->info_member = $info_member;
                }
            }

            //pre($list_added_members);

            $this->data['list_added_questions'] = $list_added_questions;
            $this->data['list_added_members'] = $list_added_members;
            
        }

        $this->data['temp'] = 'test/info';
        $this->load->view('admin/admin-layout/main', $this->data);
    }


    function add_question_to_test(){
        $errors = array(
            'error' => 0
        );
        
        $test_id            = $_POST['test_id'];
        $picked_question    = $_POST['picked_question'];

        foreach ($picked_question as $key => $value) {

            $where = array(
                'test_id' => $test_id,
                'question_id' => $value
            );
            if($this->admin_test_question_model->check_exists($where) == FALSE){
                $this->admin_test_question_model->create($data_test_question = array('test_id'=>$test_id, 'question_id'=>$value));
            }
        }

       
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'add_question_to_test';
        $this->load->view('add_question_to_test', $this->data);
    }
    function add_random_question_to_test(){
        $errors = array(
            'error' => 0
        );
        $test_id            = $_POST['test_id'];
        $picked_question_cate    = isset($_POST['picked_question_cate']) ? ($_POST['picked_question_cate']) : '0';
        $amount            = $_POST['amount'];

        $this->load->model('common_model');
        $question_array = array();

        //get mang cau hoi random

        if($picked_question_cate == 0){
            $array = $this->common_model->get_random_question_by_category_id(0,$amount);
            foreach ($array as $k => $v) {
                $question_array[] = $v['id'];
            }
        }else{
            if(in_array(1, $picked_question_cate)){
                $array = $this->common_model->get_random_question_by_category_id(1,$amount);
                foreach ($array as $k => $v) {
                    $question_array[] = $v['id'];
                }
                //pre($question_array);
            }
            else{
                
                $question_cate_array = $this->common_model->get_question_array($picked_question_cate);
                //pre($this->common_model->get_list_child_of_question_cate(2));
                $question_cate_amount = $this->common_model->get_random_amount($question_cate_array,$amount);
                //pre($question_cate_amount);
                $dem = 0;
                foreach ($question_cate_array as $key => $value) {
                    $temp = array();
                    $temp = $this->common_model->get_random_question_by_category_id($value, $question_cate_amount[$key]);
                    //pre($temp);
                    foreach ($temp as $k => $v) {
                        $question_array[] = $v['id'];
                        $dem++;
                    }
                }
            }
        }

        //pre($question_array);
     
        // chen mang cau hoi random
        foreach ($question_array as $key => $value) {

            $where = array(
                'test_id' => $test_id,
                'question_id' => $value
            );
            if($this->admin_test_question_model->check_exists($where) == FALSE){
                $this->admin_test_question_model->create($data_test_question = array('test_id'=>$test_id, 'question_id'=>$value));
            }
        }


        die (json_encode($errors));
        
        $this->data['errors'] = $errors;



        $this->data['temp'] = 'add_random_question_to_test';
        $this->load->view('add_random_question_to_test', $this->data);
    }


    function add_member_to_test(){
        $errors = array(
            'error' => 0
        );
        
        $test_id            = $_POST['test_id'];
        $picked_member    = $_POST['picked_member'];

        foreach ($picked_member as $key => $value) {

            $where = array(
                'test_id' => $test_id,
                'user_id' => $value
            );
            if($this->admin_test_user_model->check_exists($where) == FALSE){
                $this->admin_test_user_model->create($data_test_user = array('test_id'=>$test_id, 'user_id'=>$value));
                $update_test_type = array('test_type'=>0, 'updated_at'=>date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'));
                $this->admin_test_model->update($test_id, $update_test_type);
            }
        }

       
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'add_member_to_test';
        $this->load->view('add_member_to_test', $this->data);
    }

    function view_test(){
        $this->load->model('admin_answer_model');

        $test_id            = $_POST['test_id'];
        $test_info = $this->admin_test_model->get_info($test_id);
        $this->data['test_info'] = $test_info;

        $list_added_questions = array();
        $list_added_questions = $this->admin_test_question_model->get_list([
            'where' => ['test_id'=>$test_info->id]
        ]);
        $dem =0;
        foreach ($list_added_questions as $key => $value) {
            $question_id = $value->question_id;
            $info_question = $this->admin_question_model->get_info($question_id);
            if($info_question) {
                $value->info_question = $info_question;

                $list_answer = array();
                $list_answers = $this->admin_answer_model->get_list([
                    'where' => ['question_id'=>$info_question->id]
                ]);

                if(count($list_answers)==0){
                    $dem++;
                }

                $value->list_answer = $list_answers;
    
            }
        }
        $this->data['dem'] = $dem;

        $this->data['list_added_questions'] = $list_added_questions;


        $this->data['temp'] = 'test/view_test_modal';
        $this->load->view('test/view_test_modal', $this->data);
    }

    function edit_test(){

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $test_info = $this->admin_test_model->get_info($id);
            $this->data['test_info'] = $test_info;
        }
        $this->data['temp'] = 'test/edit_test_modal';
        $this->load->view('test/edit_test_modal', $this->data);
    }

    function update_test(){
        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $errors = array(
            'error' => 0
        );
        
        $duration           = $_POST['duration'];
        $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
        $valid              = isset($_POST['valid']) ? trim($_POST['valid']) : '';
        $type               = isset($_POST['type']) ? trim($_POST['type']) : '';
        $start_time         = $_POST['start_time'];
        $end_time           = $_POST['end_time'];
        $id                 = isset($_POST['id']) ? trim($_POST['id']) : '';

        $start_time = convert_time($start_time);
        $end_time = convert_time($end_time);

        $start = strtotime($start_time);
        $end = strtotime($end_time);
        if($start >= $end) {
            $errors['time'] = 'Thời gian chưa hợp lệ';
        }


        $data_test = array(
            'duration'   => $duration,
            'description'   => $description,
            'valid'   => $valid,
            'test_type' => $type,
            'start_date' => $start_time,
            'end_date'   => $end_time,
            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
        );

        //pre($duration);

            if ($duration < 0 ){ $errors['duration'] = 'Thời lượng chưa hợp lệ';}
            if (empty($description)){ $errors['description'] = 'Bạn chưa nhập tiêu đề cho bài test';}

            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }

            if($this->admin_test_model->update($id,$data_test)){
                $this->session->set_flashdata('message','Sửa dữ liệu thành công');
            }
            else{
                $errors['error'] = 1;
                $errors['sql_db'] = 'Lỗi câu truy vấn SQL';
            }

            die (json_encode($errors));
        
            $this->data['errors'] = $errors;
            $this->data['id'] = $id;
    
            $this->data['temp'] = 'update_test';
            $this->load->view('update_test', $this->data);
        

    }
    
    function delete_test(){
        $response = array();
        
        if ($_POST['delete']) {
            
            $pid = intval($_POST['delete']);
            $info_test = $this->admin_test_model->get_info($pid);
            
            
            if(!$info_test) {
                $this->session->set_flashdata('message','Không tồn tại thông tin danh mục');
                redirect(base_url('admin/tests'));
            }
            else {
                $this->admin_test_question_model->del_rule($where=array('test_id'=>$pid));
                
                if($this->admin_test_model->delete($pid)){
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
        $this->data['temp'] = 'delete_test';
        $this->load->view('delete_test', $this->data);
    }

    function delete_question_from_test(){
        $response = array();
        
        if ($_POST['delete']) {
            
            $id = intval($_POST['delete']);

            $info = $this->admin_test_question_model->get_info($id);
            
            
            if(!$info) {
                $this->session->set_flashdata('message','Không tồn tại thông tin');
                //redirect(base_url('admin/tests'));
            }
            else {
                //$this->admin_test_question_model->del_rule($where=array('test_id'=>$pid));
                
                if($this->admin_test_question_model->delete($id)){
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
        $this->data['temp'] = 'delete_question_from_test';
        $this->load->view('delete_question_from_test', $this->data);
    }

    function delete_member_from_test(){
        $response = array();
        
        if ($_POST['delete']) {
            
            $id = intval($_POST['delete']);

            $info = $this->admin_test_user_model->get_info($id);

           
            if(!$info) {
                $this->session->set_flashdata('message','Không tồn tại thông tin');
                //redirect(base_url('admin/tests'));
            }
            else {
                //$this->admin_test_question_model->del_rule($where=array('test_id'=>$pid));

              
                
                if($this->admin_test_user_model->delete($id)){
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
        $this->data['temp'] = 'delete_member_from_test';
        $this->load->view('delete_member_from_test', $this->data);
    }

    public function time_check($str)
    {
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $start_time = convert_time($start_time);
        $end_time = convert_time($end_time);

        $start = strtotime($start_time);
        $end = strtotime($end_time);

        if($start >= $end) {
            $this->form_validation->set_message('time_check', '<b style="color:red">Ngày tháng chưa hợp lệ</b>');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
}