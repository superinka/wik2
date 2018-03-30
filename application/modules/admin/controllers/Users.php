<?php
class Users extends Admin_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_home_model');

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }

    function index(){

        $this->load->library("pagination");

        $params = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->admin_home_model->get_total();
        $this->data['total_records'] = $total_records;
        $list_members = array();
    
        if ($total_records > 0) 
        {
            // get current page records
            $list_members = $this->admin_home_model->get_current_page_records($limit_per_page, $start_index,'id');
                
            $config['base_url'] = base_url()."admin/users";
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            $config['use_page_numbers'] = false;     
            $config['first_url'] = base_url('admin/users');
            $config['first_link'] = 'Trang đầu';
            $config['first_tag_close'] = '</span>';      
            $config['last_link'] = 'Trang cuối';
            $config['next_link'] = 'Trang tiếp';
            $config['prev_link'] = 'Trang trước';
            
            
            $this->pagination->initialize($config);
                
            // build paging links
            $this->data['links'] = $this->pagination->create_links();
        }
        $this->data['list_members'] = $list_members;

        $this->data['temp'] = 'user';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function add(){
        
        if($this->input->post()){ 
            $this->form_validation->set_rules('hovatendem', 'Họ và tên đệm', 'trim');
            $this->form_validation->set_rules('ten', 'Tên', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tb_users.email]');
            $this->form_validation->set_rules('gioitinh');
            $this->form_validation->set_rules('user_name', 'Tên đăng nhập', 'trim|required|min_length[5]|max_length[30]|is_unique[tb_users.user_name]');
            $this->form_validation->set_rules('pass_word','Mật khẩu','trim|required|min_length[8]',
                                                array(
                                                    'min_length[8]' => 'Mật khẩu phải lớn hơn 8 ký tự'
                                                )
                                                );
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|is_numeric');
            $this->form_validation->set_rules('group','Nhóm','trim');


            if($this->form_validation->run()){
                $hovatendem = $this->input->post('hovatendem');
                $ten = $this->input->post('ten');
                $email = $this->input->post('email');
                $gioitinh = $this->input->post('gioitinh');
                $username = $this->input->post('user_name');
                $pass_word = $this->input->post('pass_word');
                $phone = $this->input->post('phone');
                $group = $this->input->post('group');
                $status = $this->input->post('status');
                

                $pass_word = md5($pass_word);


                if($status == 'on'){
                    $status = '1';
                }
                else {
                    $status ='0';
                }

                $data_user = array(
                    'last_name'       => $hovatendem,
                    'first_name'      => $ten,
                    'gender'          => $gioitinh,    
                    'email'           => $email,
                    'pass_word'       => $pass_word,
                    'role'            => $group,
                    'activation_date' => date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s'),
                    'user_name'       => $username,
                    'status'          => $status
                );

                //pre($data_user);
                if($this->admin_home_model->create($data_user)){
                    $this->session->set_flashdata('message','Thêm dữ liệu thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm dữ liệu không thành công');
                }
                redirect(base_url('admin/users'));
            }
        }

        
        $this->data_layout['temp'] = 'add_user';
        $this->load->view('admin-layout/main', $this->data_layout);
    }

    function delete(){     
        $response = array();
        
        if ($_POST['delete']) {
            $uid = intval($_POST['delete']);
            $info_user = $this->admin_home_model->get_info($uid);

            //pre($uid);

            if(!$info_user) {
				$this->session->set_flashdata('message','Không tồn tại thông tin thành viên');
				redirect(base_url('admin/users'));
			}
            else {

                if($this->admin_home_model->delete($uid)){
                    $this->session->set_flashdata('message','Xóa dữ liệu thành công ');
					$response['status']  = 'success';
			        $response['message'] = 'Thành viên đã được xóa thành công ...';
                }
                else {
                    $response['status']  = 'success';
			        $response['message'] = 'Thành viên đã được xóa không thành công ...';
                }
            }

            die (json_encode($response));
            $this->data_layout['response'] = $response;
        }
        $this->data_layout['temp'] = 'category_delete';
        $this->load->view('category_delete', $this->data_layout);   
    }

    function info(){
        $uid = $this->uri->segment(4);
        $uid = intval($uid);

        $info_user = $this->admin_home_model->get_info($uid);

        if(!$info_user) {
            $this->session->set_flashdata('message','Không tồn tại thông tin thành viên');
            redirect(base_url('admin/users'));
        }

        else {
            
            $my_role = $this->my_role;
            $my_id = $this->my_id;
            if($my_role == 2 && $my_id != $info_user->id ){
                $this->session->set_flashdata('message','Bạn không đủ quyền hạn');
                redirect(base_url('admin/users'));
            }
            else {
                
                $this->data['info_user'] = $info_user;
                if($this->input->post()){
                    $this->form_validation->set_rules('hovatendem', 'Họ và tên đệm', 'trim');
                    $this->form_validation->set_rules('ten', 'Tên', 'trim');
                    $this->form_validation->set_rules('gioitinh');
                    $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|is_numeric');
                    $this->form_validation->set_rules('group','Nhóm');
                    $this->form_validation->set_rules('image', 'Ảnh', 'callback_file_check');
                    
                    if($this->form_validation->run()){
                        $hovatendem = $this->input->post('hovatendem');
                        $ten = $this->input->post('ten');
                        $gioitinh = $this->input->post('gioitinh');
                        $phone = $this->input->post('phone');
                        $group = $this->input->post('group');
                        $status = $this->input->post('status');
                        
                        $pass_word = $this->input->post('pass_word');
                        
                        if($pass_word) {
                            $this->form_validation->set_rules('pass_word', 'Mật khẩu', 'trim|min_length[8]');
                        }
                        
                        $pass_word = md5($pass_word);
                        
                        
                        if($status == 'on'){
                            $status = '1';
                        }
                        else {
                            $status ='0';
                        }
                        
                        
                        //avatar
                        
                        $this->load->library('upload_library');
                        $upload_path = './public/upload/avatar/';
                        $data_upload = array();
                        
                        //pre($_FILES['image']['name']);
                        
                        if (empty($_FILES['image']['name'])) {
                            $data_upload['file_name'] = 'default_avatar_male.jpg';
                            $data_user = array(
                                'last_name'   => $hovatendem,
                                'first_name'   => $ten,
                                'gender' => $gioitinh,
                                'pass_word'      => $pass_word,
                                'role'     => $group,
                                'status'        => $status,
                                'phone'  => $phone
                            );
                        }
                        else {
                            
                            
                            $data_upload = $this->upload_library->upload($upload_path, 'image');
                            $data_user = array(
                                'last_name'   => $hovatendem,
                                'first_name'   => $ten,
                                'gender' => $gioitinh,
                                'pass_word'      => $pass_word,
                                'role'     => $group,
                                'status'        => $status,
                                'phone'  => $phone,
                                'avatar'   => $data_upload['file_name']
                            );
                        }
                        
                        
                        //pre($data_user);
                        if($this->admin_home_model->update($uid, $data_user)) {
                            $this->session->set_flashdata('message','Thay đổi dữ liệu thành công');
                        }
                        else{
                            $this->session->set_flashdata('message','Thay đổi liệu không thành công');
                        }
                        redirect(base_url('admin/users'));
                    }
                }
            }

        }
        
        $this->data_layout['temp'] = 'user_info';
        $this->load->view('admin-layout/main', $this->data_layout);   
        
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