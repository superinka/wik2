<?php
class Quizs extends Admin_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_question_model');
        $this->load->model('admin/admin_question_cate_model');

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }

    function index(){


        $this->data['temp'] = 'quiz';
        $this->load->view('admin/admin-layout/main', $this->data);


    }

    function questions_group(){

        $this->load->library('nested_set');

        $tree = $this->nested_set;
        //$tree->insertNewChild(0);

        //$tree->setControlParams($table_name ='tb_question_cate', $left_column_name = 'lft', $right_column_name = 'rgt', $primary_key_column_name = 'id', $parent_column_name = 'parent_id', $text_column_name = 'name');
        //$tree->initialiseRoot();
        //$tree = $this->initialiseRoot();

        //pre($tree->getTreeAsHTML()) ;

        //pre($tree);

        
        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');

        $html = $this->nested_set->getTreeAsHTMLQuestionGroup($fields=array('name'));
        //pre($html);
        $this->data['html'] = $html;

        $this->load->library("pagination");
        
        $total = $this->admin_question_cate_model->get_total();
        $this->data['total'] = $total;
        
        // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->admin_question_cate_model->get_total();
        $list_question_cate = array();
        
        if ($total_records > 0)
        {
            // get current page records
            $list_question_cate = $this->admin_question_cate_model->get_current_page_records($limit_per_page, $start_index,'id');
            
            $config['base_url'] = base_url()."admin/quizs/questions_group";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            //$config['use_page_numbers'] = true;
            $config['first_url'] = base_url('admin/quizs/questions_group');
            $config['first_link'] = 'Trang đầu';
            $config['first_tag_close'] = '</span>';
            $config['last_link'] = 'Trang cuối';
            $config['next_link'] = 'Trang tiếp';
            $config['prev_link'] = 'Trang trước';
            
            
            $this->pagination->initialize($config);
            
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        
        $this->data['list_question_cate'] = $list_question_cate;

        $this->data['temp'] = 'quiz/questions/questions_group';
        $this->load->view('admin/admin-layout/main', $this->data);
    }
    function add_questions_group(){
        $my_id = $this->my_id;

        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');

        $html = $this->nested_set->getTreeAsHTMLDropDown($fields=array('name'));
        //pre($html);

        if($this->input->post()){
            $this->form_validation->set_rules('category-name', 'Tên danh mục', 'trim');
            $this->form_validation->set_rules('description', 'description', 'trim');
            
            if($this->form_validation->run()){
                $category_name = $this->input->post('category-name');
                $description = $this->input->post('description');

                $category = $this->input->post('category');
                $status = $this->input->post('status');
                
                
                if($status=='on') {
                    $status = 1;
                }
                else {
                    $status = 0;
                }
                
                $data_category = array(
                    'name'   => $category_name,
                    'description'   => $description,
                    'parent_id'  => $category,
                    'valid'      => $status,
                    'creator_id' => $my_id,
                    'created_at' => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                    'updated_at' => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                );

                
                if($category==1){
                    //$data_category['parent_id'] =0;
                    $parentNode = $this->nested_set->getNodeFromId(1);
                    $this->nested_set->appendNewChild($parentNode, $data_category);
                    $this->session->set_flashdata('message','Thêm dữ liệu thành công');
                }
                else{
                    $parentNode = $this->nested_set->getNodeFromId($category);
                    $this->nested_set->insertNewChild($parentNode,$data_category);
                    $this->session->set_flashdata('message','Thêm dữ liệu thành công');

                }
                redirect(base_url('admin/quizs/questions_group'));
            }
        }

        $this->data['html'] = $html;
        $this->data['temp'] = 'quiz/questions/add_questions_group';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function edit_questions_group(){
        
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            //pre($id);

            if($id==1){
                $this->session->set_flashdata('message','Không thể sửa danh mục gốc');
                print_r("KHÔNG THỂ SỬA DANH MỤC GỐC");
                //redirect(base_url('admin/quizs/questions_group'));
            }
            else{
                $question_cate_info = $this->admin_question_cate_model->get_info($id);
                $this->data['question_cate_info'] = $question_cate_info;
    
                $this->load->library('nested_set');
    
                $this->nested_set = new Nested_set();
                $this->nested_set->setControlParams('tb_question_cate');
        
                $html = $this->nested_set->getTreeAsHTMLDropDown2($id,$fields=array('name'));
                $this->data['html'] = $html;
                        
                $this->data['temp'] = 'quiz/questions/edit_questions_group_modal';
                $this->load->view('quiz/questions/edit_questions_group_modal', $this->data);
            }
        }
        

    }

    function update_questions_group(){

        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');

        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $errors = array(
            'error' => 0
        );
        
        $category_name      = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
        $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
        $category           = isset($_POST['category']) ? trim($_POST['category']) : '';
        $status             = isset($_POST['status']) ? trim($_POST['status']) : '';
        $id                 = isset($_POST['id']) ? trim($_POST['id']) : '';

        $id = intval($id);

        $data_question_cate = array(
            'name'   => $category_name,
            'description'   => $description,
            'parent_id' => $category,
            'valid'        => $status,
            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
        );

        if($id==1) {
            //$data_question_cate['parent_id'] == 0;
        }

        //pre($data_question);

            if (empty($category_name)){ $errors['category_name'] = 'Bạn chưa nhập tên câu hỏi';}
            if ($id==1){ $errors['id'] = 'Không thể sửa danh mục gốc';}

            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            if($category==1){

                $categoria = $this->nested_set->getNodeFromId($id);

                $categoriaPadre = $this->nested_set->getNodeFromId(1);
                $this->nested_set->setNodeAsFirstChild($categoria,$categoriaPadre);
                $this->session->set_flashdata('message','Sửa dữ liệu thành công');
            }
            else{
                $categoria = $this->nested_set->getNodeFromId($id);

                $categoriaPadre = $this->nested_set->getNodeFromId($category);

                $this->nested_set->setNodeAsLastChild($categoria,$categoriaPadre);
           
                $this->session->set_flashdata('message','Sửa dữ liệu thành công');

            }
                  
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'quiz/questions/update_questions_group';
        $this->load->view('quiz/questions/update_questions_group', $this->data);
    }

    function delete_questions_group(){
        $response = array();
        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');
        
        if ($_POST['delete']) {
            
            $id = intval($_POST['delete']);

            $question_cate_info = $this->admin_question_cate_model->get_info($id);

            if(!$question_cate_info) {
                $this->session->set_flashdata('message','Không tồn tại thông tin danh mục');
                redirect(base_url('admin/quiz/questions'));
            }
            else {
                $node = $this->nested_set->getNodeFromId($id);
                $this->nested_set->deleteNode($node);
            }
            
            die (json_encode($response));
            $this->data['response'] = $response;
        }
        $this->data['temp'] = 'delete_questions_group';
        $this->load->view('delete_questions_group', $this->data);
    }

    function questions(){

        $this->load->library("pagination");
        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $total = $this->admin_question_model->get_total();
        $this->data['total'] = $total;

        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');

        $html = $this->nested_set->getTreeAsHTMLDropDown($fields=array('name'));
        $this->data['html'] = $html;
        //pre($html);
        
        // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $total_records = $this->admin_question_model->get_total();
        $list_question = array();
        $list_question_cate = array();
        $list_question_cate = $this->admin_question_cate_model->get_list();
        $this->data['list_question_cate'] = $list_question_cate;
        
        if ($total_records > 0)
        {
            // get current page records
            $list_question = $this->admin_question_model->get_current_page_records($limit_per_page, $start_index,'id');
            
            $config['base_url'] = base_url()."admin/quizs/questions";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
            //$config['use_page_numbers'] = true;
            $config['first_url'] = base_url('admin/quizs/questions');
            $config['first_link'] = 'Trang đầu';
            $config['first_tag_close'] = '</span>';
            $config['last_link'] = 'Trang cuối';
            $config['next_link'] = 'Trang tiếp';
            $config['prev_link'] = 'Trang trước';
            
            
            $this->pagination->initialize($config);
            
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        
        $this->data['list_question'] = $list_question;

        $this->data['temp'] = 'quiz/questions/question';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function question_add(){
        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $errors = array(
            'error' => 0
        );
        
        $question_name      = isset($_POST['question_name']) ? trim($_POST['question_name']) : '';
        $title              = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
        $category           = isset($_POST['category']) ? trim($_POST['category']) : '';
        $point              = isset($_POST['point']) ? trim($_POST['point']) : '';
        $status             = isset($_POST['status']) ? trim($_POST['status']) : '';
        $point              = intval($point);

        $title = htmlspecialchars($title);

        $data_question = array(
            'name'   => $question_name,
            'description'   => $description,
            'title'   => $title,
            'cate_id' => $category,
            'point'        => $point,
            'valid'        => $status,
            'creator_id'        => $my_id,
            'created_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
        );

            if (empty($question_name)){ $errors['question_name'] = 'Bạn chưa nhập tên câu hỏi';}
            if (empty($title)){ $errors['title'] = 'Bạn chưa nhập nội dung câu hỏi';}
            if($point > 10 || $point < 1){$errors['point'] = 'Điểm số không hợp lệ';}

            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            
            if($this->admin_question_model->create($data_question)){
                $this->session->set_flashdata('message','Thêm dữ liệu thành công');
            }
            else{
                $errors['error'] = 1;
                $errors['sql_db'] = 'Lỗi câu truy vấn SQL';
            }
        
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'question_add';
        $this->load->view('question_add', $this->data);
    }

    function add_many_question(){
        $this->load->model('admin_answer_model');

        $my_id = $this->my_id;
        $this->load->library('nested_set');

        $this->nested_set = new Nested_set();
        $this->nested_set->setControlParams('tb_question_cate');

        $html = $this->nested_set->getTreeAsHTMLDropDown($fields=array('name'));
        $this->data['html'] = $html;

        if($this->input->post()){
            for ($i=1; $i <=10 ; $i++) { 
                $this->form_validation->set_rules('point'.$i, 'Điểm', 'trim|numeric');
            }

            if($this->form_validation->run()){
                $category = $this->input->post('category');
                $array_final = [];
                for ($i=1; $i <=10 ; $i++) { 
                    if($this->input->post('code'.$i)){
                        $question_name      = $this->input->post('code'.$i);
                        $title              = $this->input->post('q'.$i);
                        $point              = $this->input->post('point'.$i);
                        $point              = intval($point);

                        $title = htmlspecialchars($title);

                        $data_question = array(
                            'name'   => $question_name,
                            'title'   => $title,
                            'cate_id' => $category,
                            'point'        => $point,
                            'creator_id'        => $my_id,
                            'created_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
                        );

                        $this->admin_question_model->create($data_question);
                        //pre($this->db->insert_id());
                        $question_id = $this->db->insert_id();
                        for ($j=1; $j <=4 ; $j++) { 
                            if($this->input->post('a'.$i.$j)){
                                $answer_title            = $this->input->post('a'.$i.$j);
                                $is_correct              = $this->input->post('c'.$i.$j);
                                $is_correct = ($is_correct == 'on') ? '1' : '0';
                        
                                $answer_title = htmlspecialchars($answer_title);

                                $data_answer = array(
                                    'title'             => $answer_title,
                                    'question_id'       => $question_id,
                                    'is_correct'        => $is_correct,
                                    'creator_id'        => $my_id,
                                    'created_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                                    'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
                                );
                                $this->admin_answer_model->create($data_answer);
                            }
                        }
                    }                    
                }
                $this->session->set_flashdata('message','Thêm dữ liệu thành công');
                redirect(base_url('admin/quizs/questions'));
            }
        }

        $this->data['temp'] = 'quiz/questions/add_many_question';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function question_edit(){
        $list_question_cate = array();
        $list_question_cate = $this->admin_question_cate_model->get_list();
        $this->data['list_question_cate'] = $list_question_cate;
        $this->load->library('nested_set');



        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $question_info = $this->admin_question_model->get_info($id);
            $this->data['question_info'] = $question_info;

            $cate_id = $question_info->cate_id; 

            $this->nested_set = new Nested_set();
            $this->nested_set->setControlParams('tb_question_cate');
    
            $html = $this->nested_set->getTreeAsHTMLDropDown2($cate_id,$fields=array('name'));
            $this->data['html'] = $html;
        }
        $this->data['temp'] = 'quiz/questions/edit_question_modal';
        $this->load->view('quiz/questions/edit_question_modal', $this->data);
    }

    function question_update(){
        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $errors = array(
            'error' => 0
        );
        
        $question_name      = isset($_POST['question_name']) ? trim($_POST['question_name']) : '';
        $title              = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
        $category           = isset($_POST['category']) ? trim($_POST['category']) : '';
        $point              = isset($_POST['point']) ? trim($_POST['point']) : '';
        $status             = isset($_POST['status']) ? trim($_POST['status']) : '';
        $id                 = isset($_POST['id']) ? trim($_POST['id']) : '';
        $point              = intval($point);

        $title = htmlspecialchars($title);

        //pre($category);

        $data_question = array(
            'name'   => $question_name,
            'description'   => $description,
            'title'   => $title,
            'cate_id' => $category,
            'point'        => $point,
            'valid'        => $status,
            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
        );

        //pre($data_question);

            if (empty($question_name)){ $errors['question_name'] = 'Bạn chưa nhập tên câu hỏi';}
            if (empty($title)){ $errors['title'] = 'Bạn chưa nhập nội dung câu hỏi';}
            if($point > 10 || $point < 1){$errors['point'] = 'Điểm số không hợp lệ';}

            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            
            if($this->admin_question_model->update($id,$data_question)){
                $this->session->set_flashdata('message','Sửa dữ liệu thành công');
            }
            else{
                $errors['error'] = 1;
                $errors['sql_db'] = 'Lỗi câu truy vấn SQL';
            }
        
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'question_update';
        $this->load->view('question_update', $this->data);
    }

    function question_delete(){
        $response = array();
        
        if ($_POST['delete']) {
            
            $id = intval($_POST['delete']);

            $question_info = $this->admin_question_model->get_info($id);

            if(!$question_info) {
                $this->session->set_flashdata('message','Không tồn tại thông tin danh mục');
                redirect(base_url('admin/quiz/questions'));
            }
            else {
                if($this->admin_question_model->delete($id)){
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
        $this->data['temp'] = 'question_delete';
        $this->load->view('question_delete', $this->data);
    }

    function answer(){

        $this->load->model('admin_answer_model');

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $list_answers = $this->admin_answer_model->list_answers($id);
            $this->data['list_answers'] = $list_answers;
            $this->data['question_id'] = $id;
            //pre($list_answers);
        }
        $this->data['temp'] = 'quiz/questions/add_answer_modal';
        $this->load->view('quiz/questions/add_answer_modal', $this->data);
    }



    function question_info(){
        $this->load->model('admin_answer_model');
             
        //lay id post can sua
        $question_id = $this->uri->segment(4);
        $question_id = intval($question_id);
        
        $this->data['question_id'] = $question_id;

        $question_info = $this->admin_question_model->get_info($question_id);
        if(!$question_info) {
            $this->session->set_flashdata('message','Không tồn tại thông tin câu hỏi');
            redirect(base_url('admin/quizs/questions'));
        }
        else {

            
            $info = $this->admin_question_cate_model->get_info($question_info->cate_id);
            if($info){
                $question_cate = $info->name;
            }
            else {
                $question_cate = 'Không xác định';
            }

            $this->load->model('common_model');
            $creator_name = $this->common_model->get_user_name_by_id($question_info->creator_id);

            // get list answer

            $list_answers = array();
            $list_answers = $this->admin_answer_model->get_list([
                'where' => ['question_id'=>$question_info->id]
            ]);

            $this->data['question_info'] = $question_info;
            $this->data['question_cate'] = $question_cate;
            $this->data['creator_name'] = $creator_name;
            $this->data['list_answers'] = $list_answers;
        }

        $this->data['temp'] = 'quiz/questions/question_info';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function answer_add(){
        $this->load->model('admin_answer_model');
        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $errors = array(
            'error' => 0
        );
        
        $answer_title            = isset($_POST['answer_title']) ? trim($_POST['answer_title']) : '';
        $is_correct              = isset($_POST['is_correct']) ? trim($_POST['is_correct']) : '';
        $question_id             = isset($_POST['question_id']) ? trim($_POST['question_id']) : '';

        $answer_title = htmlspecialchars($answer_title);

        $data_answer = array(
            'title'             => $answer_title,
            'question_id'       => $question_id,
            'is_correct'        => $is_correct,
            'creator_id'        => $my_id,
            'created_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
        );

            if (empty($answer_title)){ $errors['answer_title'] = 'Bạn chưa nhập đáp án';}

            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            
            if($this->admin_answer_model->create($data_answer)){
                $this->session->set_flashdata('message','Thêm dữ liệu thành công');
            }
            else{
                $errors['error'] = 1;
                $errors['sql_db'] = 'Lỗi câu truy vấn SQL';
            }
        
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'answer_add';
        $this->load->view('answer_add', $this->data);
    }

    function answer_edit(){
        $this->load->model('admin_answer_model');
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $answer_info = $this->admin_answer_model->get_info($id);
            $this->data['answer_info'] = $answer_info;
        }
        $this->data['temp'] = 'quiz/answers/edit_answer_modal';
        $this->load->view('quiz/answers/edit_answer_modal', $this->data);
    }

    function answer_update(){
        $this->load->model('admin_answer_model');
        $my_role = $this->my_role;
        $my_id = $this->my_id;

        $errors = array(
            'error' => 0
        );
        $id                 = isset($_POST['id']) ? trim($_POST['id']) : '';
        $answer_title            = isset($_POST['answer_title']) ? trim($_POST['answer_title']) : '';
        $is_correct              = isset($_POST['is_correct']) ? trim($_POST['is_correct']) : '';
        
        $answer_title = htmlspecialchars($answer_title);
        

        $data_answer = array(
            'title'             => $answer_title,
            'is_correct'        => $is_correct,
            'creator_id'        => $my_id,
            'updated_at'        => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')
        );

        //pre($data_question);

            if (empty($answer_title)){ $errors['answer_title'] = 'Bạn chưa nhập đáp án';}

            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            
            if($this->admin_answer_model->update($id,$data_answer)){
                $this->session->set_flashdata('message','Thêm dữ liệu thành công');
            }
            else{
                $errors['error'] = 1;
                $errors['sql_db'] = 'Lỗi câu truy vấn SQL';
            }
        
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;

        $this->data['temp'] = 'answer_update';
        $this->load->view('answer_update', $this->data);
    }

    function answer_delete(){
        $this->load->model('admin_answer_model');
        $response = array();
        
        if ($_POST['delete']) {
            
            $id = intval($_POST['delete']);

            $answer_info = $this->admin_answer_model->get_info($id);

            if(!$answer_info) {
                $this->session->set_flashdata('message','Không tồn tại thông tin danh mục');
                //redirect(base_url('admin/quiz/questions'));
            }
            else {
                if($this->admin_answer_model->delete($id)){
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
        $this->data['temp'] = 'answer_delete';
        $this->load->view('answer_delete', $this->data);
    }

}