<?php
class Categories extends Admin_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_category_model');
        
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }
    
    function index(){
        $this->load->library("pagination");
        
        $total = $this->admin_category_model->get_total();
        $this->data['total'] = $total;
        
        // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->admin_category_model->get_total();
        $list_category = array();
        
        if ($total_records > 0)
        {
            // get current page records
            $list_category = $this->admin_category_model->get_current_page_records($limit_per_page, $start_index,'id');
            
            $config['base_url'] = base_url()."admin/categories";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            //$config['use_page_numbers'] = true;
            $config['first_url'] = base_url('admin/categories');
            $config['first_link'] = 'Trang đầu';
            $config['first_tag_close'] = '</span>';
            $config['last_link'] = 'Trang cuối';
            $config['next_link'] = 'Trang tiếp';
            $config['prev_link'] = 'Trang trước';
            
            
            $this->pagination->initialize($config);
            
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        
        $this->data['list_category'] = $list_category;
        
        $this->data['temp'] = 'category';
        $this->load->view('admin/admin-layout/main', $this->data);
    }
    
    function add(){
        
        $list_category = $this->admin_category_model->get_list([
            'where' => ['parent_id'=>0]
        ]);
        $this->data['list_category'] = $list_category;
        
        //pre($list_category);
        
        if($this->input->post()){
            $this->form_validation->set_rules('category-name', 'Tên danh mục', 'trim');
            $this->form_validation->set_rules('description', 'description', 'trim');
            $this->form_validation->set_rules('slug', 'viết tắt', 'trim|callback_check_slug');
            
            if($this->form_validation->run()){
                $category_name = $this->input->post('category-name');
                $description = $this->input->post('description');
                $slug = $this->input->post('slug');
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
                    'parent_id' => $category,
                    'slug'        => $slug,
                    'status'      => $status
                );
                
                //pre($data_category);
                if($this->admin_category_model->create($data_category)){
                    $this->session->set_flashdata('message','Thêm dữ liệu thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm dữ liệu không thành công');
                }
                redirect(base_url('admin/categories'));
            }
        }
        
        $this->data['temp'] = 'add_category';
        $this->load->view('admin-layout/main', $this->data);
    }
    
    function edit(){
        $list_category = $this->admin_category_model->get_list([
            'where' => ['parent_id'=>0]
        ]);
        $this->data['list_category'] = $list_category;
        
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $slug = $_POST['slug'];
            //pre($slug);
            $category_info = $this->admin_category_model->get_info($id);
            //pre($category_info);
            
            $this->data['category_info'] = $category_info;
            $this->data['category_slug'] = $slug;
        }
        
        
        $this->data['temp'] = 'edit_category';
        $this->load->view('edit_category', $this->data);
    }
    
    function update(){
        // Biến trả kết quả về cho người dùng
        // dựa vào key error để nhận biết có lỗi hay không
        $errors = array(
            'error' => 0
        );
        
        $category_name     = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
        $description     = isset($_POST['description']) ? trim($_POST['description']) : '';
        $category   = isset($_POST['category']) ? trim($_POST['category']) : '';
        $slug     = isset($_POST['slug']) ? trim($_POST['slug']) : '';
        $id            = isset($_POST['id']) ? trim($_POST['id']) : '';
        
        //pre($cate_name);
        
        $category_info = $this->admin_category_model->get_info($id);
        
        //pre($category_info);
        
        $old_cate_name = $category_info->name;
        
        if(true){
            //pre($cate_name);
            // BƯỚC 2: VALIATE THÔNG TIN ĐƠN GIẢN
            if (empty($category_name)){
                $errors['cate_name'] = 'Bạn chưa nhập tên danh mục';
            }
            if (empty($slug)){
                $errors['cate_slug'] = 'Slug không được trống';
            }
            
            // BƯỚC 3: KIỂM TRA CÓ LỖI KHÔNG, NẾU CÓ LỖI THÌ TRẢ VỀ LUÔN, CÒN KHÔNG THÌ TIẾP TỤC KIỂM TRA
            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            $info_cate_slug = $this->admin_category_model->get_list([
                'where' => ['slug'=>$slug]
            ]);
            
            //pre($info_cate_slug);
            
            $info_cate_name = $this->admin_category_model->get_list([
                'where' => ['name'=>$category_name]
            ]);
            
            //pre($info_cate_name);
            
            if($info_cate_name!=null){
                if($info_cate_name[0]->name == $category_name && $info_cate_name[0]->id!=$id){
                    $errors['name'] = 'Tên danh mục đã tồn tại';
                }
            }
            
            if($info_cate_slug!=null){
                if($info_cate_slug[0]->slug == $slug && $info_cate_slug[0]->id!=$id){
                    $errors['slug'] = 'Tên slug đã tồn tại';
                }
            }
            
            if (count($errors) > 1){
                $errors['error'] = 1;
                die (json_encode($errors));
            }
            
            $data_category = array(
                'name'   => $category_name,
                'description'   => $description,
                'parent_id' => $category,
                'slug'        => $slug
            );
            //pre($data_category);
            
            if($this->admin_category_model->update($id, $data_category)){
                $this->session->set_flashdata('message','Sửa dữ liệu thành công');
            }
            else{
                $errors['error'] = 1;
                $errors['sql_db'] = 'Lỗi câu truy vấn SQL';
            }
        }
        
        
        
        // Trả kết quả cuối cùng
        die (json_encode($errors));
        
        $this->data['errors'] = $errors;
        $this->data['id'] = $id;
        
        $this->data['temp'] = 'update_category';
        $this->load->view('update_category', $this->data);
    }
    
    
    function delete(){
        $response = array();
        
        if ($_POST['delete']) {
            
            $pid = intval($_POST['delete']);
            $info_category = $this->admin_category_model->get_info($pid);
            
            
            if(!$info_category) {
                $this->session->set_flashdata('message','Không tồn tại thông tin danh mục');
                redirect(base_url('admin/categories'));
            }
            else {
                $this->admin_category_model->del_rule($where=array('parent_id'=>$pid));
                
                if($this->admin_category_model->delete($pid)){
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
        $this->data['temp'] = 'category_delete';
        $this->load->view('category_delete', $this->data);
    }
    
    
    function slug_check(){
        
        $this->CI = & get_instance();
        
        if (isset($_POST['slug'])) {
            //pre($_POST['slug']);
            $slug = $_POST['slug'];
            //pre($slug);
            $check = $this->CI->check_slug($slug);
            //pre($check);
            $this->data['check'] = $check;
            
            $this->data['temp'] = 'slug_check';
            $this->load->view('slug_check', $this->data);
        }
        if (!isset($_POST['slug'])) {
            
        }
    }
    
    function check_slug($slug){
        $slug = $this->input->post('slug');
        $where = array('slug' => $slug, );
        if($this->admin_category_model->check_exists($where)) {
            $this->form_validation->set_message('check_slug', 'Tên viết tắt này đã tồn tại !');
            return false;
        }
        else return TRUE;
    }
}
